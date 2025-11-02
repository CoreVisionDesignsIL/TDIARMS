<?php
/**
 * Front Page Template
 * Homepage for TDI Arms - Tactical Weapon Accessories
 *
 * @package TDI_Arms_Child
 */

get_header(); ?>

<div class="tdi-hero">
    <div class="tdi-hero-background">
        <video class="tdi-hero-video" autoplay muted loop playsinline>
            <source src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/videos/hero-background.mp4'); ?>" type="video/mp4">
            <source src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/videos/hero-background.webm'); ?>" type="video/webm">
        </video>
        <div class="tdi-hero-fallback"></div>
    </div>

    <div class="tdi-hero-content">
        <div class="tdi-container">
            <h1 class="tdi-hero-title tdi-animate-on-scroll">
                <?php echo esc_html(get_theme_mod('tdi_hero_title', 'Built to Fight. Made to Win.')); ?>
            </h1>
            <p class="tdi-hero-subtitle tdi-animate-on-scroll">
                <?php echo esc_html(get_theme_mod('tdi_hero_subtitle', 'Precision-engineered tactical weapon accessories for professionals who demand excellence. Battle-tested worldwide, trusted by elite units.')); ?>
            </p>

            <div class="tdi-hero-actions tdi-animate-on-scroll">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="tdi-btn tdi-btn-primary">
                    <?php _e('Shop Now', 'tdi-arms'); ?>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="<?php echo esc_url(home_url('/become-dealer')); ?>" class="tdi-btn tdi-btn-secondary">
                    <?php _e('Become a Dealer', 'tdi-arms'); ?>
                    <i class="fas fa-handshake"></i>
                </a>
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="tdi-btn tdi-btn-accent">
                    <?php _e('Explore Products', 'tdi-arms'); ?>
                    <i class="fas fa-th"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="tdi-hero-scroll">
        <div class="tdi-scroll-indicator">
            <span class="tdi-scroll-text"><?php _e('Scroll to Explore', 'tdi-arms'); ?></span>
            <div class="tdi-scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<section class="tdi-featured-products">
    <div class="tdi-container">
        <div class="tdi-section-header">
            <h2 class="tdi-section-title"><?php _e('Featured Tactical Equipment', 'tdi-arms'); ?></h2>
            <p class="tdi-section-subtitle"><?php _e('Professional-grade accessories trusted by military and law enforcement worldwide', 'tdi-arms'); ?></p>
        </div>

        <div class="tdi-product-categories">
            <div class="tdi-category-card tdi-animate-on-scroll">
                <div class="tdi-category-image">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/ak-accessories.jpg'); ?>" alt="AK Accessories">
                    <div class="tdi-category-overlay">
                        <h3><?php _e('AK Accessories', 'tdi-arms'); ?></h3>
                        <p><?php _e('Premium AK platform upgrades', 'tdi-arms'); ?></p>
                        <a href="<?php echo esc_url(home_url('/product-category/ak-accessories')); ?>" class="tdi-btn tdi-btn-small">
                            <?php _e('Explore AK', 'tdi-arms'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="tdi-category-card tdi-animate-on-scroll">
                <div class="tdi-category-image">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/ar-accessories.jpg'); ?>" alt="AR Accessories">
                    <div class="tdi-category-overlay">
                        <h3><?php _e('AR Accessories', 'tdi-arms'); ?></h3>
                        <p><?php _e('Advanced AR platform solutions', 'tdi-arms'); ?></p>
                        <a href="<?php echo esc_url(home_url('/product-category/ar-accessories')); ?>" class="tdi-btn tdi-btn-small">
                            <?php _e('Explore AR', 'tdi-arms'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="tdi-category-card tdi-animate-on-scroll">
                <div class="tdi-category-image">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/tactical-universal.jpg'); ?>" alt="Universal Accessories">
                    <div class="tdi-category-overlay">
                        <h3><?php _e('Universal Tactical', 'tdi-arms'); ?></h3>
                        <p><?php _e('Versatile multi-platform gear', 'tdi-arms'); ?></p>
                        <a href="<?php echo esc_url(home_url('/product-category/universal-tactical')); ?>" class="tdi-btn tdi-btn-small">
                            <?php _e('Explore Universal', 'tdi-arms'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // Featured products loop
        $featured_products = new WP_Query(array(
            'post_type' => 'product',
            'posts_per_page' => 8,
            'meta_query' => array(
                array(
                    'key' => '_featured',
                    'value' => 'yes'
                )
            ),
            'orderby' => 'rand',
        ));

        if ($featured_products->have_posts()) :
        ?>
            <div class="tdi-featured-products-grid">
                <?php while ($featured_products->have_posts()) : $featured_products->the_post(); ?>
                    <div class="tdi-product-card tdi-animate-on-scroll">
                        <?php do_action('woocommerce_before_shop_loop_item'); ?>

                        <div class="tdi-product-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('tdi-product-large'); ?>
                                <?php if (tdi_arms_is_tactical_grade(get_the_ID())) : ?>
                                    <span class="tdi-product-badge tdi-tactical-badge"><?php _e('Tactical Grade', 'tdi-arms'); ?></span>
                                <?php endif; ?>
                                <?php if (get_post_meta(get_the_ID(), '_tdi_military_use', true) === 'yes') : ?>
                                    <span class="tdi-product-badge tdi-military-badge"><?php _e('Military Use', 'tdi-arms'); ?></span>
                                <?php endif; ?>
                            </a>
                        </div>

                        <div class="tdi-product-content">
                            <h3 class="tdi-product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="tdi-product-meta">
                                <span class="tdi-product-platform"><?php echo esc_html(get_post_meta(get_the_ID(), '_tdi_platform', true)); ?></span>
                                <span class="tdi-product-material"><?php echo esc_html(get_post_meta(get_the_ID(), '_tdi_material', true)); ?></span>
                            </div>

                            <div class="tdi-product-price">
                                <?php woocommerce_template_loop_price(); ?>
                            </div>

                            <div class="tdi-product-actions">
                                <?php woocommerce_template_loop_add_to_cart(); ?>
                                <button class="tdi-quick-view-btn" data-product-id="<?php echo get_the_ID(); ?>">
                                    <?php _e('Quick View', 'tdi-arms'); ?>
                                </button>
                            </div>
                        </div>

                        <?php do_action('woocommerce_after_shop_loop_item'); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; wp_reset_postdata(); ?>

        <div class="tdi-section-footer">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="tdi-btn tdi-btn-primary">
                <?php _e('View All Products', 'tdi-arms'); ?>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Trust & Credibility Section -->
<section class="tdi-trust-section">
    <div class="tdi-container">
        <div class="tdi-trust-grid">
            <div class="tdi-trust-item tdi-animate-on-scroll">
                <div class="tdi-trust-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3><?php _e('ISO 9001:2015 Certified', 'tdi-arms'); ?></h3>
                <p><?php _e('International quality management standards for manufacturing excellence', 'tdi-arms'); ?></p>
            </div>

            <div class="tdi-trust-item tdi-animate-on-scroll">
                <div class="tdi-trust-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3><?php _e('Global Presence', 'tdi-arms'); ?></h3>
                <p><?php _e('Serving military and law enforcement agencies worldwide since 2002', 'tdi-arms'); ?></p>
            </div>

            <div class="tdi-trust-item tdi-animate-on-scroll">
                <div class="tdi-trust-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3><?php _e('Battle-Tested', 'tdi-arms'); ?></h3>
                <p><?php _e('Proven in the most demanding operational environments', 'tdi-arms'); ?></p>
            </div>

            <div class="tdi-trust-item tdi-animate-on-scroll">
                <div class="tdi-trust-icon">
                    <i class="fas fa-star-of-life"></i>
                </div>
                <h3><?php _e('Made in Israel & USA', 'tdi-arms'); ?></h3>
                <p><?php _e('Precision engineering from two of the world\'s most advanced manufacturing centers', 'tdi-arms'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Military & Law Enforcement Partners -->
<section class="tdi-partners-section">
    <div class="tdi-container">
        <div class="tdi-section-header">
            <h2 class="tdi-section-title"><?php _e('Trusted by Professionals', 'tdi-arms'); ?></h2>
            <p class="tdi-section-subtitle"><?php _e('Our equipment is trusted by elite units and agencies around the world', 'tdi-arms'); ?></p>
        </div>

        <div class="tdi-partners-logo-grid">
            <div class="tdi-partner-logo tdi-animate-on-scroll">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/partners/military-logo-1.png'); ?>" alt="Military Partner 1">
            </div>
            <div class="tdi-partner-logo tdi-animate-on-scroll">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/partners/military-logo-2.png'); ?>" alt="Military Partner 2">
            </div>
            <div class="tdi-partner-logo tdi-animate-on-scroll">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/partners/law-enforcement-1.png'); ?>" alt="Law Enforcement Partner 1">
            </div>
            <div class="tdi-partner-logo tdi-animate-on-scroll">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/partners/law-enforcement-2.png'); ?>" alt="Law Enforcement Partner 2">
            </div>
            <div class="tdi-partner-logo tdi-animate-on-scroll">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/partners/security-agency.png'); ?>" alt="Security Agency Partner">
            </div>
            <div class="tdi-partner-logo tdi-animate-on-scroll">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/partners/elite-unit.png'); ?>" alt="Elite Unit Partner">
            </div>
        </div>
    </div>
</section>

<!-- Customer Testimonials -->
<section class="tdi-testimonials-section">
    <div class="tdi-container">
        <div class="tdi-section-header">
            <h2 class="tdi-section-title"><?php _e('Professional Testimonials', 'tdi-arms'); ?></h2>
            <p class="tdi-section-subtitle"><?php _e('Real feedback from professionals who rely on our equipment in the field', 'tdi-arms'); ?></p>
        </div>

        <div class="tdi-testimonials-slider">
            <div class="tdi-testimonial tdi-animate-on-scroll">
                <div class="tdi-testimonial-content">
                    <blockquote>
                        "TDI Arms equipment has consistently performed under the most demanding conditions. The quality and reliability are unmatched in the field."
                    </blockquote>
                    <div class="tdi-testimonial-author">
                        <div class="tdi-author-info">
                            <h4>John Smith</h4>
                            <span class="tdi-author-title">Special Operations Unit Commander</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tdi-testimonial tdi-animate-on-scroll">
                <div class="tdi-testimonial-content">
                    <blockquote>
                        "The engineering precision and attention to detail in every TDI Arms product sets a new standard for tactical equipment. We trust their gear with our lives."
                    </blockquote>
                    <div class="tdi-testimonial-author">
                        <div class="tdi-author-info">
                            <h4>Sarah Johnson</h4>
                            <span class="tdi-author-title">SWAT Team Leader</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tdi-testimonial tdi-animate-on-scroll">
                <div class="tdi-testimonial-content">
                    <blockquote>
                        "From training operations to real-world deployments, TDI Arms accessories have never failed us. The durability and performance are exceptional."
                    </blockquote>
                    <div class="tdi-testimonial-author">
                        <div class="tdi-author-info">
                            <h4>Michael Chen</h4>
                            <span class="tdi-author-title">Military Contractor</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Brand Story Video -->
<section class="tdi-brand-story-section">
    <div class="tdi-container">
        <div class="tdi-section-header">
            <h2 class="tdi-section-title"><?php _e('Designed in the Field, Not the Boardroom', 'tdi-arms'); ?></h2>
            <p class="tdi-section-subtitle"><?php _e('Discover the TDI Arms story of innovation, precision, and reliability', 'tdi-arms'); ?></p>
        </div>

        <div class="tdi-brand-video tdi-animate-on-scroll">
            <div class="tdi-video-container">
                <div class="tdi-video-placeholder">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/brand-story-placeholder.jpg'); ?>" alt="TDI Arms Brand Story">
                    <div class="tdi-video-play-button">
                        <a href="#" class="tdi-play-btn" data-video-url="https://www.youtube.com/embed/your-video-id">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                    <div class="tdi-video-info">
                        <h3><?php _e('Watch Our Story', 'tdi-arms'); ?></h3>
                        <p><?php _e('3:45 min documentary', 'tdi-arms'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="tdi-brand-stats">
            <div class="tdi-stat-item tdi-animate-on-scroll">
                <div class="tdi-stat-number">22+</div>
                <div class="tdi-stat-label"><?php _e('Years in Operation', 'tdi-arms'); ?></div>
            </div>
            <div class="tdi-stat-item tdi-animate-on-scroll">
                <div class="tdi-stat-number">50K+</div>
                <div class="tdi-stat-label"><?php _e('Products Sold Worldwide', 'tdi-arms'); ?></div>
            </div>
            <div class="tdi-stat-item tdi-animate-on-scroll">
                <div class="tdi-stat-number">30+</div>
                <div class="tdi-stat-label"><?php _e('Countries Served', 'tdi-arms'); ?></div>
            </div>
            <div class="tdi-stat-item tdi-animate-on-scroll">
                <div class="tdi-stat-number">99.8%</div>
                <div class="tdi-stat-label"><?php _e('Customer Satisfaction', 'tdi-arms'); ?></div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Signup -->
<section class="tdi-newsletter-section">
    <div class="tdi-container">
        <div class="tdi-newsletter-content tdi-animate-on-scroll">
            <h2 class="tdi-newsletter-title"><?php _e('Join the TDI Arms Community', 'tdi-arms'); ?></h2>
            <p class="tdi-newsletter-subtitle"><?php _e('Get exclusive tactical insights, new product announcements, and special offers for professionals', 'tdi-arms'); ?></p>

            <form class="tdi-newsletter-form" action="#" method="post">
                <div class="tdi-form-row">
                    <input type="email" name="email" placeholder="<?php esc_attr_e('Enter your email address', 'tdi-arms'); ?>" required class="tdi-form-input">
                    <select name="interest" class="tdi-form-select">
                        <option value=""><?php _e('Select your interest', 'tdi-arms'); ?></option>
                        <option value="military"><?php _e('Military Professional', 'tdi-arms'); ?></option>
                        <option value="law-enforcement"><?php _e('Law Enforcement', 'tdi-arms'); ?></option>
                        <option value="civilian"><?php _e('Civilian Enthusiast', 'tdi-arms'); ?></option>
                        <option value="dealer"><?php _e('Dealer/Distributor', 'tdi-arms'); ?></option>
                    </select>
                    <button type="submit" class="tdi-btn tdi-btn-primary">
                        <?php _e('Subscribe', 'tdi-arms'); ?>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="tdi-form-terms">
                    <input type="checkbox" id="newsletter-terms" required>
                    <label for="newsletter-terms">
                        <?php _e('I agree to receive emails and accept the privacy policy', 'tdi-arms'); ?>
                    </label>
                </div>
            </form>

            <div class="tdi-newsletter-benefits">
                <div class="tdi-benefit-item">
                    <i class="fas fa-gift"></i>
                    <span><?php _e('10% off first order', 'tdi-arms'); ?></span>
                </div>
                <div class="tdi-benefit-item">
                    <i class="fas fa-lock"></i>
                    <span><?php _e('Secure & private', 'tdi-arms'); ?></span>
                </div>
                <div class="tdi-benefit-item">
                    <i class="fas fa-times-circle"></i>
                    <span><?php _e('Unsubscribe anytime', 'tdi-arms'); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();