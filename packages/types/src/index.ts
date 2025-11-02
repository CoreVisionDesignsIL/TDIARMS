// Core User Types
export interface User {
  id: string;
  email: string;
  firstName: string;
  lastName: string;
  phone?: string;
  role: UserRole;
  status: UserStatus;
  createdAt: Date;
  updatedAt: Date;
}

export enum UserRole {
  CUSTOMER = 'customer',
  DEALER = 'dealer',
  ADMIN = 'admin',
  SUPER_ADMIN = 'super_admin',
  LE_MIL = 'le_mil'
}

export enum UserStatus {
  ACTIVE = 'active',
  INACTIVE = 'inactive',
  PENDING = 'pending',
  SUSPENDED = 'suspended'
}

// Product Types
export interface Product {
  id: string;
  sku: string;
  name: string;
  description: string;
  shortDescription: string;
  price: number;
  compareAtPrice?: number;
  cost?: number;
  weight: number;
  dimensions: ProductDimensions;
  material: ProductMaterial;
  color: ProductColor;
  platform: FirearmPlatform;
  category: ProductCategory;
  images: ProductImage[];
  videos: ProductVideo[];
  features: string[];
  specifications: ProductSpecification[];
  compatibility: string[];
  availability: ProductAvailability;
  tags: string[];
  seo: ProductSEO;
  createdAt: Date;
  updatedAt: Date;
}

export interface ProductDimensions {
  length: number;
  width: number;
  height: number;
  weight: number;
  unit: 'in' | 'cm' | 'oz' | 'g';
}

export enum ProductMaterial {
  POLYMER = 'polymer',
  ALUMINUM = 'aluminum',
  STEEL = 'steel',
  COMPOSITE = 'composite',
  TITANIUM = 'titanium'
}

export enum ProductColor {
  BLACK = 'black',
  DESERT_TAN = 'desert_tan',
  OD_GREEN = 'od_green',
  GRAY = 'gray',
  MULTICAM = 'multicam',
  COYOTE = 'coyote'
}

export enum FirearmPlatform {
  AR_15 = 'ar_15',
  AK_47 = 'ak_47',
  TAVOR = 'tavor',
  PISTOL = 'pistol',
  UNIVERSAL = 'universal'
}

export enum ProductCategory {
  HANDGUARDS = 'handguards',
  STOCKS = 'stocks',
  GRIPS = 'grips',
  OPTIC_MOUNTS = 'optic_mounts',
  ACCESSORIES = 'accessories'
}

export interface ProductImage {
  id: string;
  url: string;
  alt: string;
  width: number;
  height: number;
  sort_order: number;
}

export interface ProductVideo {
  id: string;
  url: string;
  thumbnail: string;
  title: string;
  duration?: number;
  sort_order: number;
}

export interface ProductSpecification {
  name: string;
  value: string;
  unit?: string;
}

export enum ProductAvailability {
  IN_STOCK = 'in_stock',
  LOW_STOCK = 'low_stock',
  BACKORDER = 'backorder',
  OUT_OF_STOCK = 'out_of_stock',
  DISCONTINUED = 'discontinued'
}

export interface ProductSEO {
  title: string;
  description: string;
  keywords: string[];
  slug: string;
}

// Dealer Types
export interface Dealer {
  id: string;
  userId: string;
  companyName: string;
  dbaName?: string;
  businessType: BusinessType;
  fflNumber: string;
  fflExpiration: Date;
  address: Address;
  phone: string;
  email: string;
  website?: string;
  yearsInBusiness: number;
  annualPurchaseVolume?: number;
  pricingTier: PricingTier;
  creditLimit?: number;
  status: DealerStatus;
  documents: DealerDocument[];
  createdAt: Date;
  updatedAt: Date;
}

export enum BusinessType {
  RETAIL_STORE = 'retail_store',
  ONLINE_RETAILER = 'online_retailer',
  DISTRIBUTOR = 'distributor',
  LAW_ENFORCEMENT = 'law_enforcement'
}

export enum PricingTier {
  BRONZE = 'bronze',
  SILVER = 'silver',
  GOLD = 'gold',
  PLATINUM = 'platinum',
  STRATEGIC_PARTNER = 'strategic_partner'
}

export enum DealerStatus {
  PENDING = 'pending',
  APPROVED = 'approved',
  REJECTED = 'rejected',
  RESTRICTED = 'restricted',
  SUSPENDED = 'suspended'
}

export interface DealerDocument {
  id: string;
  type: DocumentType;
  url: string;
  filename: string;
  uploadedAt: Date;
  expiresAt?: Date;
  status: DocumentStatus;
}

export enum DocumentType {
  FFL_LICENSE = 'ffl_license',
  BUSINESS_LICENSE = 'business_license',
  SALES_TAX_CERTIFICATE = 'sales_tax_certificate',
  CERTIFICATE_OF_INSURANCE = 'certificate_of_insurance',
  RESALE_CERTIFICATE = 'resale_certificate'
}

export enum DocumentStatus {
  PENDING = 'pending',
  APPROVED = 'approved',
  REJECTED = 'rejected',
  EXPIRED = 'expired'
}

// Order Types
export interface Order {
  id: string;
  orderNumber: string;
  customerId?: string;
  dealerId?: string;
  status: OrderStatus;
  paymentStatus: PaymentStatus;
  fulfillmentStatus: FulfillmentStatus;
  items: OrderItem[];
  subtotal: number;
  tax: number;
  shipping: number;
  discount: number;
  total: number;
  currency: string;
  shippingAddress: Address;
  billingAddress: Address;
  notes?: string;
  trackingNumbers: string[];
  createdAt: Date;
  updatedAt: Date;
  shippedAt?: Date;
  deliveredAt?: Date;
}

export enum OrderStatus {
  PENDING = 'pending',
  CONFIRMED = 'confirmed',
  PROCESSING = 'processing',
  SHIPPED = 'shipped',
  DELIVERED = 'delivered',
  CANCELLED = 'cancelled',
  REFUNDED = 'refunded'
}

export enum PaymentStatus {
  PENDING = 'pending',
  PAID = 'paid',
  PARTIALLY_PAID = 'partially_paid',
  REFUNDED = 'refunded',
  PARTIALLY_REFUNDED = 'partially_refunded',
  FAILED = 'failed'
}

export enum FulfillmentStatus {
  PENDING = 'pending',
  PARTIALLY_FULFILLED = 'partially_fulfilled',
  FULFILLED = 'fulfilled',
  CANCELLED = 'cancelled'
}

export interface OrderItem {
  id: string;
  productId: string;
  variantId?: string;
  sku: string;
  name: string;
  quantity: number;
  unitPrice: number;
  totalPrice: number;
  product?: Product;
}

// Address Types
export interface Address {
  id: string;
  street1: string;
  street2?: string;
  city: string;
  state: string;
  postalCode: string;
  country: string;
  type: AddressType;
  isDefault: boolean;
}

export enum AddressType {
  BILLING = 'billing',
  SHIPPING = 'shipping',
  BOTH = 'both'
}

// Cart Types
export interface Cart {
  id: string;
  customerId?: string;
  dealerId?: string;
  items: CartItem[];
  subtotal: number;
  tax: number;
  shipping: number;
  total: number;
  currency: string;
  expiresAt: Date;
  createdAt: Date;
  updatedAt: Date;
}

export interface CartItem {
  id: string;
  productId: string;
  variantId?: string;
  quantity: number;
  addedAt: Date;
}

// Content Types
export interface BlogPost {
  id: string;
  title: string;
  slug: string;
  excerpt: string;
  content: string;
  featuredImage: string;
  category: BlogCategory;
  tags: string[];
  author: string;
  publishedAt: Date;
  createdAt: Date;
  updatedAt: Date;
  seo: BlogSEO;
}

export enum BlogCategory {
  COMPANY_NEWS = 'company_news',
  PRODUCT_SPOTLIGHTS = 'product_spotlights',
  TACTICAL_GUIDES = 'tactical_guides',
  INSTALLATION_HOW_TOS = 'installation_how_tos'
}

export interface BlogSEO {
  title: string;
  description: string;
  keywords: string[];
  ogImage?: string;
}

// Review Types
export interface Review {
  id: string;
  productId: string;
  customerId?: string;
  rating: number;
  title: string;
  content: string;
  images: string[];
  verified: boolean;
  helpful: number;
  status: ReviewStatus;
  createdAt: Date;
  updatedAt: Date;
}

export enum ReviewStatus {
  PENDING = 'pending',
  APPROVED = 'approved',
  REJECTED = 'rejected'
}

// API Response Types
export interface ApiResponse<T> {
  success: boolean;
  data?: T;
  error?: string;
  message?: string;
  meta?: ResponseMeta;
}

export interface ResponseMeta {
  pagination?: PaginationMeta;
  timestamp: string;
  requestId: string;
}

export interface PaginationMeta {
  page: number;
  limit: number;
  total: number;
  totalPages: number;
  hasNext: boolean;
  hasPrev: boolean;
}

// Form Types
export interface DealerApplication {
  businessInfo: BusinessInfo;
  contactInfo: ContactInfo;
  businessDetails: BusinessDetails;
  documents: DocumentUpload[];
  agreements: Agreements;
}

export interface BusinessInfo {
  companyName: string;
  dbaName?: string;
  businessType: BusinessType;
  yearsInBusiness: number;
  fflNumber: string;
  taxId: string;
}

export interface ContactInfo {
  primaryContact: ContactPerson;
  billingContact?: ContactPerson;
  shippingContact?: ContactPerson;
  technicalContact?: ContactPerson;
}

export interface ContactPerson {
  name: string;
  title: string;
  email: string;
  phone: string;
}

export interface BusinessDetails {
  hasStorefront: boolean;
  website?: string;
  estimatedAnnualVolume?: number;
  primaryCategories: string[];
  currentBrands: string[];
  reasonForPartnership: string;
}

export interface DocumentUpload {
  type: DocumentType;
  file: File;
  url?: string;
}

export interface Agreements {
  dealerAgreement: boolean;
  mapPolicy: boolean;
  shippingPolicy: boolean;
  marketingGuidelines: boolean;
}

// Analytics Types
export interface AnalyticsEvent {
  event: string;
  properties: Record<string, any>;
  userId?: string;
  sessionId?: string;
  timestamp: Date;
}

export interface ProductViewEvent extends AnalyticsEvent {
  event: 'product_view';
  properties: {
    productId: string;
    sku: string;
    name: string;
    price: number;
    category: string;
    platform?: string;
  };
}

export interface AddToCartEvent extends AnalyticsEvent {
  event: 'add_to_cart';
  properties: {
    productId: string;
    sku: string;
    name: string;
    price: number;
    quantity: number;
    category: string;
  };
}

export interface PurchaseEvent extends AnalyticsEvent {
  event: 'purchase';
  properties: {
    orderId: string;
    total: number;
    currency: string;
    items: Array<{
      productId: string;
      sku: string;
      name: string;
      price: number;
      quantity: number;
    }>;
  };
}

// Error Types
export class AppError extends Error {
  public readonly statusCode: number;
  public readonly isOperational: boolean;

  constructor(message: string, statusCode: number = 500, isOperational: boolean = true) {
    super(message);
    this.statusCode = statusCode;
    this.isOperational = isOperational;

    Error.captureStackTrace(this, this.constructor);
  }
}

export class ValidationError extends AppError {
  constructor(message: string) {
    super(message, 400);
  }
}

export class NotFoundError extends AppError {
  constructor(message: string = 'Resource not found') {
    super(message, 404);
  }
}

export class UnauthorizedError extends AppError {
  constructor(message: string = 'Unauthorized') {
    super(message, 401);
  }
}

export class ForbiddenError extends AppError {
  constructor(message: string = 'Forbidden') {
    super(message, 403);
  }
}

// Configuration Types
export interface DatabaseConfig {
  url: string;
  ssl?: boolean;
  maxConnections?: number;
}

export interface RedisConfig {
  url: string;
  keyPrefix?: string;
}

export interface ShopifyConfig {
  storeDomain: string;
  accessToken: string;
  apiVersion: string;
}

export interface ContentfulConfig {
  space: string;
  accessToken: string;
  environment?: string;
}

export interface SendGridConfig {
  apiKey: string;
  fromEmail: string;
  fromName: string;
}

export interface KlaviyoConfig {
  apiKey: string;
  listId: string;
}

export interface AppConfiguration {
  database: DatabaseConfig;
  redis: RedisConfig;
  shopify: ShopifyConfig;
  contentful: ContentfulConfig;
  sendgrid: SendGridConfig;
  klaviyo: KlaviyoConfig;
  app: {
    name: string;
    version: string;
    environment: 'development' | 'staging' | 'production';
    port: number;
    corsOrigins: string[];
  };
  security: {
    jwtSecret: string;
    jwtExpiresIn: string;
    bcryptRounds: number;
    rateLimitWindow: number;
    rateLimitMax: number;
  };
}