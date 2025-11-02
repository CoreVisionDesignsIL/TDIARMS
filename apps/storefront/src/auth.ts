import NextAuth from 'next-auth';
import { NextAuthOptions } from 'next-auth';
import CredentialsProvider from 'next-auth/providers/credentials';
import { authService, loginSchema } from '@tdi-arms/auth-service';
import type { User, UserRole } from '@tdi-arms/types';

export const authOptions: NextAuthOptions = {
  providers: [
    CredentialsProvider({
      name: 'credentials',
      credentials: {
        email: { label: 'Email', type: 'email' },
        password: { label: 'Password', type: 'password' },
      },
      async authorize(credentials) {
        if (!credentials?.email || !credentials?.password) {
          return null;
        }

        try {
          // Validate input
          const validatedCredentials = loginSchema.parse(credentials);

          // Authenticate user
          const authResponse = await authService.login(validatedCredentials);

          // Return user data for NextAuth session
          return {
            id: authResponse.user.id,
            email: authResponse.user.email,
            name: `${authResponse.user.firstName} ${authResponse.user.lastName}`,
            firstName: authResponse.user.firstName,
            lastName: authResponse.user.lastName,
            phone: authResponse.user.phone,
            role: authResponse.user.role,
            status: authResponse.user.status,
            accessToken: authResponse.tokens.accessToken,
            refreshToken: authResponse.tokens.refreshToken,
          };
        } catch (error) {
          console.error('Auth error:', error);
          return null;
        }
      },
    }),
  ],

  session: {
    strategy: 'jwt',
    maxAge: 7 * 24 * 60 * 60, // 7 days
  },

  jwt: {
    maxAge: 7 * 24 * 60 * 60, // 7 days
  },

  callbacks: {
    async jwt({ token, user, account }) {
      // Initial sign in
      if (user && account) {
        token.accessToken = user.accessToken;
        token.refreshToken = user.refreshToken;
        token.role = user.role;
        token.status = user.status;
        token.firstName = user.firstName;
        token.lastName = user.lastName;
        token.phone = user.phone;
        return token;
      }

      // Return previous token if no user
      return token;
    },

    async session({ session, token }) {
      // Send properties to client
      if (token) {
        session.user.id = token.sub!;
        session.user.email = token.email!;
        session.user.name = token.name!;
        session.user.role = token.role as UserRole;
        session.user.status = token.status as string;
        session.user.firstName = token.firstName as string;
        session.user.lastName = token.lastName as string;
        session.user.phone = token.phone as string;
        session.accessToken = token.accessToken as string;
        session.error = token.error as string | undefined;
      }

      return session;
    },

    async redirect({ url, baseUrl }) {
      // Allows relative callback URLs
      if (url.startsWith('/')) return `${baseUrl}${url}`;
      // Allows callback URLs on the same origin
      else if (new URL(url).origin === baseUrl) return url;
      return baseUrl;
    },
  },

  pages: {
    signIn: '/auth/signin',
    signUp: '/auth/signup',
    error: '/auth/error',
    verifyRequest: '/auth/verify-request',
    newUser: '/auth/new-user',
  },

  debug: process.env.NODE_ENV === 'development',
  secret: process.env.NEXTAUTH_SECRET,
};

export default NextAuth(authOptions);