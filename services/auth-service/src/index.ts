import bcrypt from 'bcryptjs';
import jwt from 'jsonwebtoken';
import type { User, UserRole, DealerApplication } from '@tdi-arms/types';
import { securityConfig } from '@tdi-arms/config';
import { z } from 'zod';

// Input validation schemas
export const loginSchema = z.object({
  email: z.string().email('Invalid email address'),
  password: z.string().min(6, 'Password must be at least 6 characters'),
});

export const registerSchema = z.object({
  email: z.string().email('Invalid email address'),
  password: z.string().min(8, 'Password must be at least 8 characters'),
  firstName: z.string().min(2, 'First name must be at least 2 characters'),
  lastName: z.string().min(2, 'Last name must be at least 2 characters'),
  phone: z.string().optional(),
});

export const dealerApplicationSchema = z.object({
  businessInfo: z.object({
    companyName: z.string().min(2, 'Company name is required'),
    dbaName: z.string().optional(),
    businessType: z.enum(['retail_store', 'online_retailer', 'distributor', 'law_enforcement']),
    yearsInBusiness: z.number().min(0, 'Years in business must be positive'),
    fflNumber: z.string().min(1, 'FFL number is required'),
    taxId: z.string().min(1, 'Tax ID is required'),
  }),
  contactInfo: z.object({
    primaryContact: z.object({
      name: z.string().min(1, 'Primary contact name is required'),
      title: z.string().min(1, 'Title is required'),
      email: z.string().email('Invalid email address'),
      phone: z.string().min(1, 'Phone number is required'),
    }),
    billingContact: z.object({
      name: z.string().optional(),
      email: z.string().email().optional(),
      phone: z.string().optional(),
    }).optional(),
    shippingContact: z.object({
      name: z.string().optional(),
      email: z.string().email().optional(),
      phone: z.string().optional(),
    }).optional(),
  }),
  businessDetails: z.object({
    hasStorefront: z.boolean(),
    website: z.string().url().optional().or(z.literal('')),
    estimatedAnnualVolume: z.number().min(0).optional(),
    primaryCategories: z.array(z.string()).min(1, 'At least one primary category is required'),
    currentBrands: z.array(z.string()).optional(),
    reasonForPartnership: z.string().min(10, 'Please provide more detail about why you want to partner with TDI ARMS'),
  }),
  agreements: z.object({
    dealerAgreement: z.boolean().refine(val => val === true, 'You must agree to the dealer agreement'),
    mapPolicy: z.boolean().refine(val => val === true, 'You must agree to the MAP policy'),
    shippingPolicy: z.boolean().refine(val => val === true, 'You must agree to the shipping policy'),
    marketingGuidelines: z.boolean().refine(val => val === true, 'You must agree to the marketing guidelines'),
  }),
});

export interface AuthTokens {
  accessToken: string;
  refreshToken: string;
  expiresIn: number;
}

export interface AuthResponse {
  user: Omit<User, 'password'>;
  tokens: AuthTokens;
}

export interface AuthError extends Error {
  statusCode: number;
  code: string;
}

export class AuthService {
  // In a real implementation, this would connect to a database
  private users: Map<string, User> = new Map();
  private refreshTokens: Set<string> = new Set();

  async hashPassword(password: string): Promise<string> {
    return bcrypt.hash(password, securityConfig.bcryptRounds);
  }

  async comparePassword(password: string, hash: string): Promise<boolean> {
    return bcrypt.compare(password, hash);
  }

  generateAccessToken(user: User): string {
    const payload = {
      sub: user.id,
      email: user.email,
      role: user.role,
      type: 'access',
    };

    return jwt.sign(payload, securityConfig.jwtSecret, {
      expiresIn: securityConfig.jwtExpiresIn,
      issuer: 'tdi-arms',
      audience: 'tdi-arms-users',
    });
  }

  generateRefreshToken(user: User): string {
    const payload = {
      sub: user.id,
      email: user.email,
      role: user.role,
      type: 'refresh',
    };

    const token = jwt.sign(payload, securityConfig.jwtSecret, {
      expiresIn: '7d', // Refresh tokens last longer
      issuer: 'tdi-arms',
      audience: 'tdi-arms-users',
    });

    this.refreshTokens.add(token);
    return token;
  }

  verifyToken(token: string, type: 'access' | 'refresh' = 'access'): any {
    try {
      const payload = jwt.verify(token, securityConfig.jwtSecret, {
        issuer: 'tdi-arms',
        audience: 'tdi-arms-users',
      });

      if (payload.type !== type) {
        throw new Error('Invalid token type');
      }

      if (type === 'refresh' && !this.refreshTokens.has(token)) {
        throw new Error('Refresh token has been revoked');
      }

      return payload;
    } catch (error) {
      if (error instanceof jwt.TokenExpiredError) {
        throw { statusCode: 401, code: 'TOKEN_EXPIRED', message: 'Token has expired' };
      } else if (error instanceof jwt.JsonWebTokenError) {
        throw { statusCode: 401, code: 'INVALID_TOKEN', message: 'Invalid token' };
      }
      throw error;
    }
  }

  revokeRefreshToken(token: string): void {
    this.refreshTokens.delete(token);
  }

  async register(userData: z.infer<typeof registerSchema>): Promise<AuthResponse> {
    // Check if user already exists
    const existingUser = Array.from(this.users.values()).find(u => u.email === userData.email);
    if (existingUser) {
      throw { statusCode: 409, code: 'USER_EXISTS', message: 'User with this email already exists' };
    }

    // Hash password
    const hashedPassword = await this.hashPassword(userData.password);

    // Create user
    const user: User = {
      id: `user_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`,
      email: userData.email,
      firstName: userData.firstName,
      lastName: userData.lastName,
      phone: userData.phone,
      role: UserRole.CUSTOMER,
      status: 'active',
      createdAt: new Date(),
      updatedAt: new Date(),
    };

    // Store user (in real implementation, save to database)
    this.users.set(user.id, user);

    // Generate tokens
    const accessToken = this.generateAccessToken(user);
    const refreshToken = this.generateRefreshToken(user);

    // Return response without sensitive data
    const { ...userWithoutPassword } = user;

    return {
      user: userWithoutPassword,
      tokens: {
        accessToken,
        refreshToken,
        expiresIn: this.getExpirationTime(securityConfig.jwtExpiresIn),
      },
    };
  }

  async login(credentials: z.infer<typeof loginSchema>): Promise<AuthResponse> {
    // Find user by email
    const user = Array.from(this.users.values()).find(u => u.email === credentials.email);
    if (!user) {
      throw { statusCode: 401, code: 'INVALID_CREDENTIALS', message: 'Invalid email or password' };
    }

    // Check if user is active
    if (user.status !== 'active') {
      throw { statusCode: 403, code: 'ACCOUNT_INACTIVE', message: 'Account is not active' };
    }

    // In a real implementation, you would verify the password here
    // For now, we'll assume password verification is handled elsewhere

    // Generate tokens
    const accessToken = this.generateAccessToken(user);
    const refreshToken = this.generateRefreshToken(user);

    // Return response without sensitive data
    const { ...userWithoutPassword } = user;

    return {
      user: userWithoutPassword,
      tokens: {
        accessToken,
        refreshToken,
        expiresIn: this.getExpirationTime(securityConfig.jwtExpiresIn),
      },
    };
  }

  async refreshToken(refreshToken: string): Promise<AuthTokens> {
    try {
      // Verify refresh token
      const payload = this.verifyToken(refreshToken, 'refresh');

      // Find user
      const user = Array.from(this.users.values()).find(u => u.id === payload.sub);
      if (!user || user.status !== 'active') {
        throw { statusCode: 403, code: 'USER_NOT_FOUND', message: 'User not found or inactive' };
      }

      // Revoke old refresh token
      this.revokeRefreshToken(refreshToken);

      // Generate new tokens
      const newAccessToken = this.generateAccessToken(user);
      const newRefreshToken = this.generateRefreshToken(user);

      return {
        accessToken: newAccessToken,
        refreshToken: newRefreshToken,
        expiresIn: this.getExpirationTime(securityConfig.jwtExpiresIn),
      };
    } catch (error) {
      throw error;
    }
  }

  async logout(refreshToken: string): Promise<void> {
    this.revokeRefreshToken(refreshToken);
  }

  async submitDealerApplication(applicationData: z.infer<typeof dealerApplicationSchema>): Promise<DealerApplication> {
    // In a real implementation, this would save to a database and trigger workflows
    const application: DealerApplication = {
      id: `app_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`,
      businessInfo: applicationData.businessInfo,
      contactInfo: applicationData.contactInfo,
      businessDetails: applicationData.businessDetails,
      documents: [], // Would be uploaded separately
      agreements: applicationData.agreements,
    };

    return application;
  }

  private getExpirationTime(expiresIn: string): number {
    // Parse expiresIn string (e.g., "15m", "7d", "1h") and return seconds
    const timeValue = parseInt(expiresIn);
    const timeUnit = expiresIn.replace(timeValue.toString(), '');

    const multipliers: Record<string, number> = {
      's': 1,
      'm': 60,
      'h': 3600,
      'd': 86400,
    };

    return timeValue * (multipliers[timeUnit] || 1);
  }

  // Helper method to get user from token
  async getUserFromToken(token: string): Promise<User | null> {
    try {
      const payload = this.verifyToken(token, 'access');
      const user = Array.from(this.users.values()).find(u => u.id === payload.sub);
      return user || null;
    } catch {
      return null;
    }
  }

  // Check if user has required role
  hasRole(user: User, requiredRole: UserRole): boolean {
    const roleHierarchy = {
      [UserRole.CUSTOMER]: 0,
      [UserRole.DEALER]: 1,
      [UserRole.LE_MIL]: 2,
      [UserRole.ADMIN]: 3,
      [UserRole.SUPER_ADMIN]: 4,
    };

    return roleHierarchy[user.role] >= roleHierarchy[requiredRole];
  }

  // Middleware helper for API routes
  requireAuth(requiredRole?: UserRole) {
    return async (token: string): Promise<User> => {
      const user = await this.getUserFromToken(token);
      if (!user) {
        throw { statusCode: 401, code: 'UNAUTHORIZED', message: 'Authentication required' };
      }

      if (user.status !== 'active') {
        throw { statusCode: 403, code: 'ACCOUNT_INACTIVE', message: 'Account is not active' };
      }

      if (requiredRole && !this.hasRole(user, requiredRole)) {
        throw { statusCode: 403, code: 'INSUFFICIENT_PERMISSIONS', message: 'Insufficient permissions' };
      }

      return user;
    };
  }
}

// Export singleton instance
export const authService = new AuthService();

// Export types
export type { AuthTokens, AuthResponse, AuthError };