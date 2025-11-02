import type { Metadata } from 'next';
import { Inter } from 'next/font/google';
import { cn } from '@/lib/utils';
import '@tdi-arms/ui/globals.css';
import './globals.css';

const inter = Inter({ subsets: ['latin'] });

export const metadata: Metadata = {
  title: {
    default: 'TDI ARMS - Precision Tactical Innovation',
    template: '%s | TDI ARMS'
  },
  description: 'TDI ARMS is a leading manufacturer of high-quality tactical firearm accessories including handguards, stocks, grips, and optic mounts for AR-15, AK-47, and other platforms.',
  keywords: [
    'tactical accessories',
    'firearm parts',
    'AR-15 accessories',
    'AK-47 accessories',
    'handguards',
    'stocks',
    'grips',
    'optic mounts',
    'tactical innovation'
  ],
  authors: [{ name: 'TDI ARMS' }],
  creator: 'TDI ARMS',
  publisher: 'TDI ARMS',
  formatDetection: {
    email: false,
    address: false,
    telephone: false,
  },
  metadataBase: new URL('https://tdiarms.com'),
  alternates: {
    canonical: '/',
  },
  openGraph: {
    type: 'website',
    locale: 'en_US',
    url: 'https://tdiarms.com',
    title: 'TDI ARMS - Precision Tactical Innovation',
    description: 'TDI ARMS is a leading manufacturer of high-quality tactical firearm accessories including handguards, stocks, grips, and optic mounts.',
    siteName: 'TDI ARMS',
    images: [
      {
        url: '/images/og-default.jpg',
        width: 1200,
        height: 630,
        alt: 'TDI ARMS - Precision Tactical Innovation',
      },
    ],
  },
  twitter: {
    card: 'summary_large_image',
    title: 'TDI ARMS - Precision Tactical Innovation',
    description: 'TDI ARMS is a leading manufacturer of high-quality tactical firearm accessories.',
    images: ['/images/og-default.jpg'],
    creator: '@tdiarms',
  },
  robots: {
    index: true,
    follow: true,
    googleBot: {
      index: true,
      follow: true,
      'max-video-preview': -1,
      'max-image-preview': 'large',
      'max-snippet': -1,
    },
  },
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en" className="scroll-smooth">
      <body className={cn(
        inter.className,
        'min-h-screen bg-background font-sans antialiased'
      )}>
        <div className="relative flex min-h-screen flex-col">
          <div className="flex-1">
            {children}
          </div>
        </div>
      </body>
    </html>
  );
}