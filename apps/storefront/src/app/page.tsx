import { Button } from '@tdi-arms/ui';
import Link from 'next/link';

export default function HomePage() {
  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="hero-tactical relative h-screen flex items-center justify-center">
        <div className="absolute inset-0 z-10">
          <div className="container mx-auto px-4 text-center">
            <h1 className="hero-title text-4xl md:text-6xl lg:text-7xl font-bold mb-6">
              Precision Tactical
              <span className="text-safety-orange"> Innovation</span>
            </h1>
            <p className="hero-subtitle text-xl md:text-2xl mb-8 text-gray-300 max-w-3xl mx-auto">
              Premium firearm accessories engineered for excellence.
              Handguards, stocks, grips, and optic mounts for the modern tactical operator.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
              <Button variant="tactical-orange" size="xl" asChild>
                <Link href="/shop">
                  Shop All Products
                </Link>
              </Button>
              <Button variant="tactical" size="xl" asChild>
                <Link href="/dealers">
                  Dealer Portal
                </Link>
              </Button>
            </div>
          </div>
        </div>

        {/* Background placeholder for video */}
        <div className="absolute inset-0 bg-black/40 z-0">
          <div className="w-full h-full bg-gradient-to-r from-tactical-black via-gray-900 to-tactical-black"></div>
        </div>

        {/* Scroll indicator */}
        <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
        </div>
      </section>

      {/* Trust Indicators */}
      <section className="py-8 bg-gray-900 text-white">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
              <div className="text-2xl font-bold text-safety-orange mb-2">ISO 9001</div>
              <div className="text-sm text-gray-400">Certified Quality</div>
            </div>
            <div>
              <div className="text-2xl font-bold text-safety-orange mb-2">MOD/UN</div>
              <div className="text-sm text-gray-400">Approved Supplier</div>
            </div>
            <div>
              <div className="text-2xl font-bold text-safety-orange mb-2">Lifetime</div>
              <div className="text-sm text-gray-400">Warranty</div>
            </div>
            <div>
              <div className="text-2xl font-bold text-safety-orange mb-2">Made in</div>
              <div className="text-sm text-gray-400">USA</div>
            </div>
          </div>
        </div>
      </section>

      {/* Shop by Platform */}
      <section className="py-16 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Shop by Platform</h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              Find the perfect accessories for your firearm platform
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { name: 'AR Platform', icon: '🔫', count: '150+' },
              { name: 'AK Platform', icon: '🔫', count: '85+' },
              { name: 'Tavor', icon: '🔫', count: '45+' },
              { name: 'Pistols', icon: '🔫', count: '120+' },
            ].map((platform, index) => (
              <Link key={index} href={`/platform/${platform.name.toLowerCase().replace(' ', '-')}`}>
                <div className="platform-card p-8 text-center cursor-pointer">
                  <div className="text-6xl mb-4">{platform.icon}</div>
                  <h3 className="text-xl font-bold text-white mb-2">{platform.name}</h3>
                  <p className="text-gray-400">{platform.count} Products</p>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* Shop by Category */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Shop by Category</h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              Browse our extensive catalog of tactical accessories
            </p>
          </div>

          <div className="category-grid">
            {[
              { name: 'Handguards', icon: '🛡️', count: 75 },
              { name: 'Stocks', icon: '🔧', count: 45 },
              { name: 'Grips', icon: '✊', count: 60 },
              { name: 'Optic Mounts', icon: '🔭', count: 90 },
              { name: 'Accessories', icon: '⚙️', count: 120 },
            ].map((category, index) => (
              <Link key={index} href={`/category/${category.name.toLowerCase().replace(' ', '-')}`}>
                <div className="category-card">
                  <div className="category-icon text-4xl mb-3">{category.icon}</div>
                  <h3 className="font-semibold mb-1">{category.name}</h3>
                  <p className="text-sm text-gray-500">{category.count} Products</p>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* Featured Products */}
      <section className="py-16 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Featured Products</h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              Discover our most popular and innovative tactical accessories
            </p>
          </div>

          {/* Placeholder for product carousel */}
          <div className="bg-white p-8 rounded-lg shadow-lg text-center">
            <div className="text-gray-500 mb-4">
              <div className="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4"></div>
              <h3 className="text-xl font-semibold mb-2">Premium AR-15 Handguard</h3>
              <p className="text-gray-600 mb-4">Lightweight, durable, and precision machined</p>
              <p className="text-2xl font-bold text-safety-orange mb-4">$299.99</p>
              <Button variant="tactical-orange">View Details</Button>
            </div>
          </div>
        </div>
      </section>

      {/* Social Proof */}
      <section className="py-16 bg-tactical-black text-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Trusted by Professionals</h2>
            <p className="text-lg text-gray-300 max-w-2xl mx-auto">
              Join thousands of satisfied customers who trust TDI ARMS
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="text-center">
              <div className="text-4xl font-bold text-safety-orange mb-2">50,000+</div>
              <div className="text-gray-400">Happy Customers</div>
            </div>
            <div className="text-center">
              <div className="text-4xl font-bold text-safety-orange mb-2">4.9/5</div>
              <div className="text-gray-400">Average Rating</div>
            </div>
            <div className="text-center">
              <div className="text-4xl font-bold text-safety-orange mb-2">1000+</div>
              <div className="text-gray-400">5-Star Reviews</div>
            </div>
          </div>
        </div>
      </section>

      {/* Content Hub Preview */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Latest from the Blog</h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              Tips, guides, and insights from our tactical experts
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {[
              {
                title: 'Complete Guide to AR-15 Handguard Installation',
                excerpt: 'Learn how to properly install your new handguard with our step-by-step guide.',
                category: 'Installation How-To',
                date: 'Nov 15, 2024'
              },
              {
                title: 'Choosing the Right Optic Mount for Your Setup',
                excerpt: 'Discover the factors to consider when selecting the perfect optic mount.',
                category: 'Tactical Guides',
                date: 'Nov 12, 2024'
              },
              {
                title: 'New Product Release: M-LOK Compatible Handguards',
                excerpt: 'Check out our latest line of M-LOK compatible handguards.',
                category: 'Product Spotlights',
                date: 'Nov 8, 2024'
              }
            ].map((post, index) => (
              <div key={index} className="bg-white rounded-lg shadow-lg overflow-hidden">
                <div className="h-48 bg-gray-200"></div>
                <div className="p-6">
                  <div className="text-sm text-safety-orange font-semibold mb-2">{post.category}</div>
                  <h3 className="text-xl font-bold mb-2">{post.title}</h3>
                  <p className="text-gray-600 mb-4">{post.excerpt}</p>
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-500">{post.date}</span>
                    <Button variant="ghost">Read More</Button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="newsletter-section">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold mb-4">Stay Tactical</h2>
          <p className="text-lg mb-8 max-w-2xl mx-auto">
            Get the latest product releases, exclusive deals, and tactical tips delivered to your inbox.
          </p>
          <form className="newsletter-form max-w-lg mx-auto">
            <input
              type="email"
              placeholder="Enter your email address"
              className="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-safety-orange"
              required
            />
            <Button type="submit" variant="tactical-orange" className="rounded-l-none">
              Subscribe
            </Button>
          </form>
        </div>
      </section>
    </div>
  );
}