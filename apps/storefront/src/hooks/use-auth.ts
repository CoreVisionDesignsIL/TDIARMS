'use client';

import { useSession, signIn, signOut } from 'next-auth/react';
import type { UserRole } from '@tdi-arms/types';

export function useAuth() {
  const { data: session, status, update } = useSession();

  const user = session?.user;
  const isLoading = status === 'loading';
  const isAuthenticated = status === 'authenticated';

  const login = async (email: string, password: string) => {
    try {
      const result = await signIn('credentials', {
        email,
        password,
        redirect: false,
      });

      if (result?.error) {
        throw new Error(result.error);
      }

      return result;
    } catch (error) {
      console.error('Login error:', error);
      throw error;
    }
  };

  const logout = async () => {
    try {
      await signOut({ redirect: false });
    } catch (error) {
      console.error('Logout error:', error);
      throw error;
    }
  };

  const hasRole = (requiredRole: UserRole): boolean => {
    if (!user) return false;

    const roleHierarchy = {
      [UserRole.CUSTOMER]: 0,
      [UserRole.DEALER]: 1,
      [UserRole.LE_MIL]: 2,
      [UserRole.ADMIN]: 3,
      [UserRole.SUPER_ADMIN]: 4,
    };

    return roleHierarchy[user.role] >= roleHierarchy[requiredRole];
  };

  const isDealer = hasRole(UserRole.DEALER);
  const isAdmin = hasRole(UserRole.ADMIN);
  const isSuperAdmin = hasRole(UserRole.SUPER_ADMIN);
  const isLeMil = hasRole(UserRole.LE_MIL);

  return {
    user,
    isLoading,
    isAuthenticated,
    login,
    logout,
    update,
    hasRole,
    isDealer,
    isAdmin,
    isSuperAdmin,
    isLeMil,
  };
}