import { z } from 'zod';
import type { AppConfiguration } from '@tdi-arms/types';

// Environment validation schemas
const envSchema = z.object({
  NODE_ENV: z.enum(['development', 'staging', 'production']).default('development'),
  PORT: z.string().transform(Number).default(3000),

  // Database
  DATABASE_URL: z.string(),

  // Redis
  REDIS_URL: z.string().optional(),

  // JWT
  JWT_SECRET: z.string(),
  JWT_EXPIRES_IN: z.string().default('7d'),

  // Shopify
  SHOPIFY_STORE_DOMAIN: z.string(),
  SHOPIFY_ACCESS_TOKEN: z.string(),
  SHOPIFY_API_VERSION: z.string().default('2024-01'),

  // Contentful
  CONTENTFUL_SPACE: z.string(),
  CONTENTFUL_ACCESS_TOKEN: z.string(),
  CONTENTFUL_ENVIRONMENT: z.string().default('master'),

  // SendGrid
  SENDGRID_API_KEY: z.string(),
  SENDGRID_FROM_EMAIL: z.string(),
  SENDGRID_FROM_NAME: z.string().default('TDI ARMS'),

  // Klaviyo
  KLAVIYO_API_KEY: z.string(),
  KLAVIYO_LIST_ID: z.string(),

  // CORS
  CORS_ORIGINS: z.string().transform(val => val.split(',')).default(['http://localhost:3000']),

  // Rate limiting
  RATE_LIMIT_WINDOW: z.string().transform(Number).default(900000), // 15 minutes
  RATE_LIMIT_MAX: z.string().transform(Number).default(100),

  // Security
  BCRYPT_ROUNDS: z.string().transform(Number).default(12),

  // File storage
  AWS_ACCESS_KEY_ID: z.string().optional(),
  AWS_SECRET_ACCESS_KEY: z.string().optional(),
  AWS_REGION: z.string().default('us-east-1'),
  AWS_S3_BUCKET: z.string().optional(),

  // Monitoring
  SENTRY_DSN: z.string().optional(),
  SENTRY_ENVIRONMENT: z.string().optional(),

  // Analytics
  GOOGLE_ANALYTICS_ID: z.string().optional(),
  GA_TRACKING_ID: z.string().optional(),
});

// Validate environment variables
export const env = envSchema.parse(process.env);

// Database configuration
export const databaseConfig = {
  url: env.DATABASE_URL,
  ssl: env.NODE_ENV === 'production',
  maxConnections: 20,
};

// Redis configuration
export const redisConfig = {
  url: env.REDIS_URL || 'redis://localhost:6379',
  keyPrefix: 'tdi-arms:',
};

// Shopify configuration
export const shopifyConfig = {
  storeDomain: env.SHOPIFY_STORE_DOMAIN,
  accessToken: env.SHOPIFY_ACCESS_TOKEN,
  apiVersion: env.SHOPIFY_API_VERSION,
};

// Contentful configuration
export const contentfulConfig = {
  space: env.CONTENTFUL_SPACE,
  accessToken: env.CONTENTFUL_ACCESS_TOKEN,
  environment: env.CONTENTFUL_ENVIRONMENT,
};

// SendGrid configuration
export const sendGridConfig = {
  apiKey: env.SENDGRID_API_KEY,
  fromEmail: env.SENDGRID_FROM_EMAIL,
  fromName: env.SENDGRID_FROM_NAME,
};

// Klaviyo configuration
export const klaviyoConfig = {
  apiKey: env.KLAVIYO_API_KEY,
  listId: env.KLAVIYO_LIST_ID,
};

// AWS S3 configuration
export const awsConfig = {
  accessKeyId: env.AWS_ACCESS_KEY_ID,
  secretAccessKey: env.AWS_SECRET_ACCESS_KEY,
  region: env.AWS_REGION,
  s3Bucket: env.AWS_S3_BUCKET,
};

// App configuration
export const appConfig = {
  name: 'TDI ARMS Digital Flagship',
  version: '1.0.0',
  environment: env.NODE_ENV,
  port: env.PORT,
  corsOrigins: env.CORS_ORIGINS,
};

// Security configuration
export const securityConfig = {
  jwtSecret: env.JWT_SECRET,
  jwtExpiresIn: env.JWT_EXPIRES_IN,
  bcryptRounds: env.BCRYPT_ROUNDS,
  rateLimitWindow: env.RATE_LIMIT_WINDOW,
  rateLimitMax: env.RATE_LIMIT_MAX,
};

// Monitoring configuration
export const monitoringConfig = {
  sentryDsn: env.SENTRY_DSN,
  sentryEnvironment: env.SENTRY_ENVIRONMENT || env.NODE_ENV,
};

// Analytics configuration
export const analyticsConfig = {
  googleAnalyticsId: env.GOOGLE_ANALYTICS_ID,
  gaTrackingId: env.GA_TRACKING_ID,
};

// Complete configuration object
export const config: AppConfiguration = {
  database: databaseConfig,
  redis: redisConfig,
  shopify: shopifyConfig,
  contentful: contentfulConfig,
  sendgrid: sendGridConfig,
  klaviyo: klaviyoConfig,
  app: appConfig,
  security: securityConfig,
};

// Pricing tiers configuration
export const pricingTiers = {
  [PricingTier.BRONZE]: {
    discount: 0.15, // 15% off MSRP
    minAnnualVolume: 0,
    maxAnnualVolume: 50000,
    benefits: ['Standard dealer pricing', 'Basic support'],
  },
  [PricingTier.SILVER]: {
    discount: 0.25, // 25% off MSRP
    minAnnualVolume: 50000,
    maxAnnualVolume: 250000,
    benefits: ['Enhanced dealer pricing', 'Priority support', 'Marketing materials'],
  },
  [PricingTier.GOLD]: {
    discount: 0.35, // 35% off MSRP
    minAnnualVolume: 250000,
    maxAnnualVolume: 1000000,
    benefits: ['Premium dealer pricing', 'Dedicated support', 'Exclusive products', 'Co-op marketing'],
  },
  [PricingTier.PLATINUM]: {
    discount: 0.45, // 45% off MSRP
    minAnnualVolume: 1000000,
    maxAnnualVolume: Infinity,
    benefits: ['Elite dealer pricing', 'White-glove support', 'First access to new products', 'Custom branding'],
  },
  [PricingTier.STRATEGIC_PARTNER]: {
    discount: 0.50, // 50% off MSRP
    minAnnualVolume: 0, // Case by case
    maxAnnualVolume: Infinity,
    benefits: ['Partner pricing', 'Strategic collaboration', 'Joint development'],
  },
};

// Product configuration
export const productConfig = {
  // Default pagination
  defaultPageSize: 20,
  maxPageSize: 100,

  // Image configuration
  imageSizes: {
    thumbnail: { width: 150, height: 150 },
    small: { width: 300, height: 300 },
    medium: { width: 600, height: 600 },
    large: { width: 1200, height: 1200 },
  },

  // Tax calculation
  tax: {
    defaultRate: 0.0875, // 8.75% default
    exemptStates: ['DE', 'OR', 'MT', 'NH'], // States with no sales tax
  },

  // Shipping configuration
  shipping: {
    freeShippingThreshold: 150, // Free shipping over $150
    defaultRates: {
      standard: { price: 9.99, estimatedDays: 5 },
      express: { price: 19.99, estimatedDays: 2 },
      overnight: { price: 39.99, estimatedDays: 1 },
    },
  },
};

// Email configuration
export const emailConfig = {
  templates: {
    orderConfirmation: 'order-confirmation',
    shippingConfirmation: 'shipping-confirmation',
    dealerApplicationReceived: 'dealer-application-received',
    dealerApplicationApproved: 'dealer-application-approved',
    passwordReset: 'password-reset',
    welcomeEmail: 'welcome-email',
  },

  automation: {
    abandonedCartDelay: 60 * 60 * 24, // 24 hours
    followUpDelay: 60 * 60 * 24 * 7, // 7 days
    reviewRequestDelay: 60 * 60 * 24 * 14, // 14 days
  },
};

// SEO configuration
export const seoConfig = {
  defaults: {
    title: 'TDI ARMS - Precision Tactical Innovation',
    description: 'TDI ARMS is a leading manufacturer of high-quality tactical firearm accessories including handguards, stocks, grips, and optic mounts.',
    keywords: ['tactical accessories', 'firearm parts', 'AR-15 accessories', 'handguards', 'stocks', 'grips'],
    ogImage: '/images/og-default.jpg',
  },

  characterLimits: {
    title: 60,
    description: 160,
  },

  schema: {
    organization: {
      name: 'TDI ARMS',
      url: 'https://tdiarms.com',
      logo: 'https://tdiarms.com/images/logo.png',
      description: 'Precision Tactical Innovation',
      address: {
        streetAddress: '123 Tactical Drive',
        addressLocality: 'Anytown',
        addressRegion: 'ST',
        postalCode: '12345',
        addressCountry: 'US',
      },
      contactPoint: {
        telephone: '+1-555-123-4567',
        contactType: 'customer service',
        availableLanguage: ['English'],
      },
      sameAs: [
        'https://www.facebook.com/tdiarms',
        'https://www.instagram.com/tdiarms',
        'https://www.youtube.com/tdiarms',
      ],
    },
  },
};

export default config;