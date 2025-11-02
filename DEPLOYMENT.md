# TDI Arms Website Deployment Guide

## Overview
This document provides comprehensive deployment instructions for the TDI Arms tactical weapons accessories website built on WordPress with WooCommerce.

## Prerequisites

### Server Requirements
- **PHP**: 8.0 or higher (8.1+ recommended)
- **MySQL**: 5.7+ or MariaDB 10.2+
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **SSL Certificate**: Required (Let's Encrypt recommended)
- **Memory**: 512MB+ PHP memory limit
- **Disk Space**: 10GB+ for initial setup

### Required PHP Extensions
```ini
curl
dom
exif
fileinfo
gd
hash
iconv
imagick
intl
json
mbstring
mysqli
openssl
pcre
pdo_mysql
simplexml
xml
xmlreader
xmlwriter
zip
```

### WordPress Requirements
- WordPress 6.4+
- WooCommerce 8.0+
- Elementor Pro (for page building)
- Managed WordPress hosting recommended

## Installation Steps

### 1. Server Setup

#### Apache Configuration (.htaccess included)
```apache
# Enable required modules
a2enmod rewrite
a2enmod expires
a2enmod headers
a2enmod deflate

# VirtualHost example
<VirtualHost *:443>
    ServerName tdiarms.com
    DocumentRoot /var/www/tdiarms.com
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
</VirtualHost>
```

#### Nginx Configuration
```nginx
server {
    listen 443 ssl http2;
    server_name tdiarms.com;
    root /var/www/tdiarms.com;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    # WordPress Rules
    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 2. Database Setup

#### Create Database
```sql
CREATE DATABASE tdi_arms_wp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'tdi_arms_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON tdi_arms_wp.* TO 'tdi_arms_user'@'localhost';
FLUSH PRIVILEGES;
```

#### Database Configuration
Update `wp-config.php` with your database credentials:
```php
define('DB_NAME', 'tdi_arms_wp');
define('DB_USER', 'tdi_arms_user');
define('DB_PASSWORD', 'your_secure_password');
define('DB_HOST', 'localhost');
```

### 3. WordPress Installation

#### Download and Setup
```bash
# Clone repository
git clone https://github.com/tdi-arms/website.git /var/www/tdiarms.com
cd /var/www/tdiarms.com

# Set permissions
chown -R www-data:www-data .
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Copy environment file
cp .env.example .env
# Edit .env with your values
```

#### Generate WordPress Salts
```bash
curl -s https://api.wordpress.org/secret-key/1.1/salt/
```
Update `wp-config.php` with the generated salts.

### 4. Required Plugins Installation

#### Essential Plugins (install via WP-CLI)
```bash
wp plugin install \
  woocommerce \
  elementor \
  elementor-pro \
  wp-rocket \
  wordfence \
  wp-smushit \
  yoast-premium \
  gravity-forms \
  wp-mail-smtp \
  --activate
```

#### B2B/Dealer Plugins
```bash
wp plugin install \
  b2bking \
  wholesale-suite \
  --activate
```

#### CRM Integration
```bash
wp plugin install \
  zoho-crm \
  --activate
```

### 5. Theme Configuration

#### Activate Child Theme
```bash
wp theme activate tdi-arms-child
wp theme delete hello-elementor
```

#### Configure Theme Customizer
```bash
# Set logo, colors, and other theme options
wp option update blogname "TDI Arms"
wp option update blogdescription "Built to Fight. Made to Win."
```

### 6. WooCommerce Configuration

#### Basic Settings
```bash
# Store settings
wp option update woocommerce_store_address "123 Tactical Street"
wp option update woocommerce_store_city "Tel Aviv"
wp option update woocommerce_store_country "IL"
wp option update woocommerce_default_customer "guest"

# Currency settings
wp option update woocommerce_currency "USD"
wp option update woocommerce_currency_pos "left"
wp option update woocommerce_price_num_decimals "2"
```

#### Payment Gateways Setup
1. **Stripe**: Configure for credit card processing
2. **PayPal**: Setup for international payments
3. **Bank Transfer**: For dealer purchases

#### Shipping Configuration
1. **Free Shipping**: Orders over $100
2. **Flat Rate**: Standard shipping
3. **International**: Calculated rates

### 7. Security Configuration

#### Security Headers (.htaccess)
```apache
# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-XSS-Protection "1; mode=block"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
    Header set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' *.google-analytics.com *.googletagmanager.com; style-src 'self' 'unsafe-inline' *.googleapis.com"
</IfModule>
```

#### WordPress Security
```php
// wp-config.php security settings
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);
define('FORCE_SSL_ADMIN', true);
define('WP_AUTO_UPDATE_CORE', true);
```

### 8. Performance Optimization

#### Caching Configuration
- **WP Rocket**: Enable page caching and optimization
- **CDN**: Configure Cloudflare integration
- **Image Optimization**: Enable Smush Pro

#### Database Optimization
```bash
# Install and configure query monitor
wp plugin install query-monitor --activate
```

### 9. SEO Configuration

#### Yoast SEO Setup
1. Configure site titles and meta descriptions
2. Set up social media profiles
3. Configure XML sitemaps
4. Set up Google Search Console verification

#### Schema Markup
The theme includes automatic schema markup for:
- Products
- Organization
- Reviews
- FAQs

### 10. Analytics Setup

#### Google Analytics 4
```javascript
// Add to wp-config.php or theme functions
define('GA_TRACKING_ID', 'G-XXXXXXXXXX');
```

#### Tag Manager
```javascript
// Header script
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
<!-- End Google Tag Manager -->
```

### 11. Content Migration

#### Product Data Import
1. Prepare CSV file with product data
2. Use WooCommerce CSV Importer
3. Configure custom fields for tactical information

#### Category Structure
- AK Accessories
  - Handguards
  - Rails
  - Grips
  - Stocks
- AR Accessories
  - Rails
  - Mounts
  - Sights
- Universal Tactical
  - Optics
  - Lights
  - Lasers

### 12. Testing Checklist

#### Pre-Launch Testing
- [ ] All pages load without errors
- [ ] Product pages display correctly
- [ ] Add to cart functionality works
- [ ] Checkout process completes successfully
- [ ] Mobile responsive design verified
- [ ] SSL certificate working properly
- [ ] Contact forms submit correctly
- [ ] Search functionality working
- [ ] Payment gateways configured
- [ ] Shipping calculation working

#### Performance Testing
- [ ] Page load speed < 2 seconds
- [ ] Google PageSpeed Insights score 85+
- [ ] Core Web Vitals passing
- [ ] Mobile usability passing

#### Security Testing
- [ ] Malware scan clean
- [ ] SSL certificate valid
- [ ] Security headers configured
- [ ] File permissions correct
- [ ] Database backups configured

### 13. Launch Process

#### DNS Configuration
```bash
# Update DNS records
A Record: @ -> server_ip
AAAA Record: @ -> ipv6_address
CNAME Record: www -> tdiarms.com
MX Record: @ -> mail.tdiarms.com
TXT Record: @ -> "v=spf1 include:_spf.google.com ~all"
```

#### SSL Certificate
```bash
# Let's Encrypt certbot
certbot --apache -d tdiarms.com -d www.tdiarms.com
```

#### Final Configuration
1. Clear all caches
2. Test checkout process
3. Verify email notifications
4. Set up monitoring
5. Configure backups

### 14. Post-Launch Tasks

#### Monitoring Setup
- **Uptime Monitoring**: UptimeRobot or Pingdom
- **Performance Monitoring**: Google PageSpeed API
- **Error Logging**: Sentry or WP Logger
- **Security Monitoring**: Wordfence alerts

#### Maintenance Schedule
- **Daily**: Security scans, backup verification
- **Weekly**: Plugin updates, performance monitoring
- **Monthly**: Content updates, SEO optimization
- **Quarterly**: Security audit, performance review

### 15. Troubleshooting

#### Common Issues

**White Screen of Death**
```bash
# Check PHP errors
tail -f /var/log/php_errors.log

# Increase memory limit
wp config set WP_MEMORY_LIMIT 512M --raw
```

**Slow Loading**
```bash
# Check database queries
wp db query "SHOW PROCESSLIST;"

# Clear caches
wp cache flush
wp rocket regenerate
```

**Payment Gateway Issues**
```bash
# Check webhook status
wp wc webkit list

# Test payment gateway
wp wc test payment_stripe
```

#### Support Resources
- WordPress.org: https://wordpress.org/support/
- WooCommerce: https://woocommerce.com/support/
- Elementor: https://elementor.com/help/
- Wordfence: https://www.wordfence.com/help/

## Security Considerations

### Access Control
```apache
# Protect sensitive files
<Files wp-config.php>
    order allow,deny
    deny from all
</Files>

# Protect uploads directory
<IfModule mod_authz_core.c>
    <Directory /var/www/tdiarms.com/wp-content/uploads>
        Require all granted
        <FilesMatch "\.(php)$">
            Require all denied
        </FilesMatch>
    </Directory>
</IfModule>
```

### Regular Security Tasks
- Update WordPress core, plugins, and themes weekly
- Perform security scans daily
- Monitor file integrity
- Review user access permissions monthly
- Test backup restoration quarterly

## Backup Strategy

### Automated Backups
```bash
# Database backup
mysqldump -u root -p tdi_arms_wp > backup_$(date +%Y%m%d).sql

# Files backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz /var/www/tdiarms.com
```

### Offsite Storage
- Store backups in multiple locations
- Retain backups for 30 days
- Test backup restoration monthly
- Document backup recovery process

This deployment guide provides a comprehensive foundation for launching the TDI Arms website with optimal performance, security, and reliability.