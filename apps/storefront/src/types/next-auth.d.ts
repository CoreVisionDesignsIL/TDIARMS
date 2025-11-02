import NextAuth, { DefaultSession } from 'next-auth';
import { UserRole } from '@tdi-arms/types';

declare module 'next-auth' {
  interface Session {
    user: {
      id: string;
      role: UserRole;
      status: string;
      firstName: string;
      lastName: string;
      phone?: string;
      accessToken: string;
    } & DefaultSession['user'];
    error?: string;
  }

  interface User {
    id: string;
    email: string;
    name: string;
    firstName: string;
    lastName: string;
    phone?: string;
    role: UserRole;
    status: string;
    accessToken: string;
    refreshToken: string;
  }
}

declare module 'next-auth/jwt' {
  interface JWT {
    role: UserRole;
    status: string;
    firstName: string;
    lastName: string;
    phone?: string;
    accessToken: string;
    refreshToken: string;
    error?: string;
  }
}