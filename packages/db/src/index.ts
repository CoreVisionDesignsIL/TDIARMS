import { PrismaClient } from '@prisma/client';
import bcrypt from 'bcryptjs';
import { securityConfig } from '@tdi-arms/config';

// Extend Prisma Client with custom methods
declare global {
  // Allow global `var` declarations
  // eslint-disable-next-line no-var
  var __prisma: PrismaClient | undefined;
}

// Create Prisma client with connection pooling and error handling
const prismaClientSingleton = () => {
  return new PrismaClient({
    log: process.env.NODE_ENV === 'development' ? ['query', 'error', 'warn'] : ['error'],
    errorFormat: 'pretty',
  });
};

const prisma = globalThis.__prisma ?? prismaClientSingleton();

if (process.env.NODE_ENV !== 'production') globalThis.__prisma = prisma;

// Custom database helper methods
export class DatabaseService {
  private client: PrismaClient;

  constructor() {
    this.client = prisma;
  }

  // User management
  async createUser(userData: {
    email: string;
    password: string;
    firstName: string;
    lastName: string;
    phone?: string;
    role?: any;
  }) {
    const hashedPassword = await bcrypt.hash(userData.password, securityConfig.bcryptRounds);

    return this.client.user.create({
      data: {
        ...userData,
        password: hashedPassword,
      },
      select: {
        id: true,
        email: true,
        firstName: true,
        lastName: true,
        phone: true,
        role: true,
        status: true,
        createdAt: true,
        updatedAt: true,
      },
    });
  }

  async findUserByEmail(email: string) {
    return this.client.user.findUnique({
      where: { email },
      include: {
        customer: true,
        dealer: true,
      },
    });
  }

  async findUserById(id: string) {
    return this.client.user.findUnique({
      where: { id },
      include: {
        customer: true,
        dealer: true,
      },
    });
  }

  async verifyPassword(email: string, password: string) {
    const user = await this.client.user.findUnique({
      where: { email },
    });

    if (!user) return null;

    const isValid = await bcrypt.compare(password, user.password);
    if (!isValid) return null;

    // Return user without password
    const { password: _, ...userWithoutPassword } = user;
    return userWithoutPassword;
  }

  // Product management
  async createProduct(productData: any) {
    return this.client.product.create({
      data: productData,
      include: {
        images: true,
        variants: true,
        features: true,
        specs: true,
      },
    });
  }

  async findProducts(filters: {
    category?: string;
    platform?: string;
    material?: string;
    color?: string;
    availability?: string;
    search?: string;
    page?: number;
    limit?: number;
    sortBy?: string;
    sortOrder?: 'asc' | 'desc';
  }) {
    const {
      category,
      platform,
      material,
      color,
      availability,
      search,
      page = 1,
      limit = 20,
      sortBy = 'createdAt',
      sortOrder = 'desc',
    } = filters;

    const where: any = {};

    if (category) where.category = category;
    if (platform) where.platform = platform;
    if (material) where.material = material;
    if (color) where.color = color;
    if (availability) where.availability = availability;

    if (search) {
      where.OR = [
        { name: { contains: search, mode: 'insensitive' } },
        { description: { contains: search, mode: 'insensitive' } },
        { shortDescription: { contains: search, mode: 'insensitive' } },
        { tags: { hasSome: [search] } },
      ];
    }

    const skip = (page - 1) * limit;

    const [products, total] = await Promise.all([
      this.client.product.findMany({
        where,
        include: {
          images: true,
          variants: true,
        },
        orderBy: { [sortBy]: sortOrder },
        skip,
        take: limit,
      }),
      this.client.product.count({ where }),
    ]);

    return {
      products,
      pagination: {
        page,
        limit,
        total,
        totalPages: Math.ceil(total / limit),
        hasNext: page * limit < total,
        hasPrev: page > 1,
      },
    };
  }

  async findProductBySlug(slug: string) {
    return this.client.product.findUnique({
      where: { seoSlug: slug },
      include: {
        images: true,
        videos: true,
        variants: true,
        features: true,
        specs: true,
        compatibilities: true,
        crossSells: {
          include: {
            productB: {
              include: {
                images: true,
              },
            },
          },
        },
      },
    });
  }

  // Order management
  async createOrder(orderData: {
    customerId?: string;
    dealerId?: string;
    items: Array<{
      productId: string;
      variantId?: string;
      quantity: number;
      unitPrice: number;
    }>;
    billingAddressId?: string;
    shippingAddressId?: string;
    subtotal: number;
    tax: number;
    shipping: number;
    discount: number;
    total: number;
    notes?: string;
  }) {
    const orderNumber = `TDI-${Date.now()}-${Math.random().toString(36).substr(2, 5).toUpperCase()}`;

    return this.client.$transaction(async (tx) => {
      const order = await tx.order.create({
        data: {
          orderNumber,
          ...orderData,
          items: {
            create: orderData.items.map(item => ({
              ...item,
              totalPrice: item.quantity * item.unitPrice,
              name: 'Product Name', // Would fetch from product
              sku: 'SKU', // Would fetch from product/variant
            })),
          },
        },
        include: {
          items: {
            include: {
              product: {
                include: {
                  images: true,
                },
              },
              variant: true,
            },
          },
          customer: {
            include: {
              user: true,
            },
          },
          dealer: {
            include: {
              user: true,
            },
          },
          billingAddress: true,
          shippingAddress: true,
        },
      });

      return order;
    });
  }

  async findOrdersByUser(userId: string, userRole: string, page = 1, limit = 20) {
    const skip = (page - 1) * limit;

    let whereClause: any = {};

    if (userRole === 'CUSTOMER') {
      whereClause = { customerId: userId };
    } else if (userRole === 'DEALER') {
      whereClause = { dealerId: userId };
    } else if (userRole === 'ADMIN' || userRole === 'SUPER_ADMIN') {
      // Admins can see all orders
      whereClause = {};
    }

    const [orders, total] = await Promise.all([
      this.client.order.findMany({
        where: whereClause,
        include: {
          items: {
            include: {
              product: {
                include: {
                  images: true,
                },
              },
            },
          },
          billingAddress: true,
          shippingAddress: true,
        },
        orderBy: { createdAt: 'desc' },
        skip,
        take: limit,
      }),
      this.client.order.count({ where: whereClause }),
    ]);

    return {
      orders,
      pagination: {
        page,
        limit,
        total,
        totalPages: Math.ceil(total / limit),
        hasNext: page * limit < total,
        hasPrev: page > 1,
      },
    };
  }

  // Cart management
  async getOrCreateCart(userId?: string, sessionId?: string) {
    let cart;

    if (userId) {
      cart = await this.client.cart.findFirst({
        where: {
          customerId: userId,
          expiresAt: { gt: new Date() },
        },
        include: {
          items: {
            include: {
              product: {
                include: {
                  images: true,
                },
              },
              variant: true,
            },
          },
        },
      });
    } else if (sessionId) {
      cart = await this.client.cart.findFirst({
        where: {
          sessionId,
          expiresAt: { gt: new Date() },
        },
        include: {
          items: {
            include: {
              product: {
                include: {
                  images: true,
                },
              },
              variant: true,
            },
          },
        },
      });
    }

    if (!cart) {
      cart = await this.client.cart.create({
        data: {
          customerId: userId,
          sessionId,
          expiresAt: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000), // 7 days
        },
        include: {
          items: {
            include: {
              product: {
                include: {
                  images: true,
                },
              },
              variant: true,
            },
          },
        },
      });
    }

    return cart;
  }

  async addToCart(cartId: string, productId: string, variantId?: string, quantity = 1) {
    return this.client.cartItem.upsert({
      where: {
        cartId_productId_variantId: {
          cartId,
          productId,
          variantId,
        },
      },
      update: {
        quantity: { increment: quantity },
      },
      create: {
        cartId,
        productId,
        variantId,
        quantity,
      },
      include: {
        product: {
          include: {
            images: true,
          },
        },
        variant: true,
      },
    });
  }

  async updateCartItemQuantity(itemId: string, quantity: number) {
    if (quantity <= 0) {
      return this.client.cartItem.delete({
        where: { id: itemId },
      });
    }

    return this.client.cartItem.update({
      where: { id: itemId },
      data: { quantity },
      include: {
        product: {
          include: {
            images: true,
          },
        },
        variant: true,
      },
    });
  }

  async removeFromCart(itemId: string) {
    return this.client.cartItem.delete({
      where: { id: itemId },
    });
  }

  async clearCart(cartId: string) {
    return this.client.cartItem.deleteMany({
      where: { cartId },
    });
  }

  // Review management
  async createReview(reviewData: {
    productId: string;
    customerId?: string;
    rating: number;
    title: string;
    content: string;
    images?: string[];
  }) {
    return this.client.review.create({
      data: reviewData,
      include: {
        customer: {
          include: {
            user: true,
          },
        },
      },
    });
  }

  async findProductReviews(productId: string, page = 1, limit = 10) {
    const skip = (page - 1) * limit;

    const [reviews, total] = await Promise.all([
      this.client.review.findMany({
        where: {
          productId,
          status: 'APPROVED',
        },
        include: {
          customer: {
            include: {
              user: true,
            },
          },
        },
        orderBy: { createdAt: 'desc' },
        skip,
        take: limit,
      }),
      this.client.review.count({
        where: {
          productId,
          status: 'APPROVED',
        },
      }),
    ]);

    return {
      reviews,
      pagination: {
        page,
        limit,
        total,
        totalPages: Math.ceil(total / limit),
        hasNext: page * limit < total,
        hasPrev: page > 1,
      },
    };
  }

  // Dealer application management
  async createDealerApplication(applicationData: {
    userId: string;
    companyName: string;
    dbaName?: string;
    businessType: any;
    fflNumber: string;
    fflExpiration: Date;
    website?: string;
    yearsInBusiness: number;
    estimatedAnnualVolume?: number;
    primaryCategories: string[];
    currentBrands?: string[];
    reasonForPartnership: string;
  }) {
    return this.client.dealer.create({
      data: applicationData,
      include: {
        user: true,
      },
    });
  }

  // Health check
  async healthCheck() {
    try {
      await this.client.$queryRaw`SELECT 1`;
      return { status: 'healthy', timestamp: new Date().toISOString() };
    } catch (error) {
      return {
        status: 'unhealthy',
        error: error instanceof Error ? error.message : 'Unknown error',
        timestamp: new Date().toISOString()
      };
    }
  }

  // Expose the underlying Prisma client for advanced queries
  get prisma() {
    return this.client;
  }
}

// Export singleton instance
export const db = new DatabaseService();

// Export the Prisma client type
export type { PrismaClient } from '@prisma/client';

// Export default Prisma client for backward compatibility
export { prisma as default };