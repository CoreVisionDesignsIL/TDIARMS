<?php
/**
 * Product description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

?>
<div class="tdi-product-description woocommerce-product-details__short-description">
    <?php
    $short_description = $product->get_short_description();
    if ($short_description) {
        echo '<div class="tdi-short-description">';
        echo wpautop(wp_kses_post($short_description));
        echo '</div>';
    }
    ?>

    <!-- TDI Arms Why Choose Section -->
    <div class="tdi-why-choose-section">
        <h3><?php _e('Why Choose TDI Arms?', 'tdi-arms'); ?></h3>
        <div class="tdi-why-choose-grid">
            <div class="tdi-why-item">
                <i class="fas fa-shield-alt"></i>
                <h4><?php _e('Battle-Tested Reliability', 'tdi-arms'); ?></h4>
                <p><?php _e('Every TDI Arms product undergoes extensive field testing with military and law enforcement professionals worldwide.', 'tdi-arms'); ?></p>
            </div>
            <div class="tdi-why-item">
                <i class="fas fa-cogs"></i>
                <h4><?php _e('Precision Engineering', 'tdi-arms'); ?></h4>
                <p><?php _e('Manufactured to ISO 9001:2015 standards with tight tolerances for perfect fit and function.', 'tdi-arms'); ?></p>
            </div>
            <div class="tdi-why-item">
                <i class="fas fa-globe"></i>
                <h4><?php _e('Global Reputation', 'tdi-arms'); ?></h4>
                <p><?php _e('Trusted by elite units in over 30 countries for tactical operations and professional applications.', 'tdi-arms'); ?></p>
            </div>
            <div class="tdi-why-item">
                <i class="fas fa-star-of-life"></i>
                <h4><?php _e('Israeli & American Made', 'tdi-arms'); ?></h4>
                <p><?php _e('Combining Israeli tactical expertise with American manufacturing excellence.', 'tdi-arms'); ?></p>
            </div>
        </div>
    </div>

    <!-- Full Product Description -->
    <?php if ($product->get_description()) : ?>
        <div class="tdi-full-description">
            <h3><?php _e('Product Details', 'tdi-arms'); ?></h3>
            <div class="tdi-description-content">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Installation Video -->
    <?php
    $installation_video = get_post_meta($product->get_id(), '_tdi_installation_guide', true);
    if ($installation_video) :
    ?>
        <div class="tdi-installation-video">
            <h3><?php _e('Installation Guide', 'tdi-arms'); ?></h3>
            <div class="tdi-video-embed">
                <?php echo wp_oembed_get(esc_url($installation_video)); ?>
            </div>
            <p class="tdi-video-description">
                <?php _e('Follow our step-by-step installation guide for optimal performance and safety.', 'tdi-arms'); ?>
            </p>
        </div>
    <?php endif; ?>

    <!-- Technical Features -->
    <div class="tdi-technical-features">
        <h3><?php _e('Technical Features', 'tdi-arms'); ?></h3>
        <div class="tdi-features-grid">
            <?php
            $features = array(
                'iso_certified' => __('ISO 9001:2015 Certified', 'tdi-arms'),
                'lifetime_warranty' => __('Limited Lifetime Warranty', 'tdi-arms'),
                'precision_machined' => __('Precision CNC Machined', 'tdi-arms'),
                'military_grade' => __('Military Grade Materials', 'tdi-arms'),
                'weather_resistant' => __('Weather Resistant Finish', 'tdi-arms'),
                'easy_installation' => __('Easy Installation', 'tdi-arms'),
            );

            foreach ($features as $feature_key => $feature_label) :
                if (get_post_meta($product->get_id(), '_tdi_feature_' . $feature_key, true) === 'yes') :
            ?>
                    <div class="tdi-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo esc_html($feature_label); ?></span>
                    </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>

    <!-- Compatibility Information -->
    <?php
    $compatibility = tdi_arms_get_compatibility($product->get_id());
    if ($compatibility) :
    ?>
        <div class="tdi-compatibility-details">
            <h3><?php _e('Compatibility Information', 'tdi-arms'); ?></h3>
            <div class="tdi-compatibility-content">
                <?php echo wpautop(esc_html($compatibility)); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Usage Guidelines -->
    <div class="tdi-usage-guidelines">
        <h3><?php _e('Usage Guidelines', 'tdi-arms'); ?></h3>
        <div class="tdi-usage-content">
            <ul class="tdi-usage-list">
                <li><?php _e('Follow all local, state, and federal laws regarding weapon accessories', 'tdi-arms'); ?></li>
                <li><?php _e('Professional installation recommended for optimal performance', 'tdi-arms'); ?></li>
                <li><?php _e('Regular maintenance required for long-term reliability', 'tdi-arms'); ?></li>
                <li><?php _e('Read all included documentation before installation', 'tdi-arms'); ?></li>
                <li><?php _e('Contact support with any questions or concerns', 'tdi-arms'); ?></li>
            </ul>
        </div>
    </div>

    <!-- Warranty Information -->
    <div class="tdi-warranty-info">
        <h3><?php _e('Warranty & Support', 'tdi-arms'); ?></h3>
        <div class="tdi-warranty-content">
            <p><strong><?php _e('Limited Lifetime Warranty:', 'tdi-arms'); ?></strong> <?php _e('TDI Arms warrants this product to be free from defects in materials and workmanship for the life of the product under normal use.', 'tdi-arms'); ?></p>
            <p><strong><?php _e('Customer Support:', 'tdi-arms'); ?></strong> <?php _e('Our expert support team is available to assist with installation, technical questions, and warranty claims.', 'tdi-arms'); ?></p>
            <div class="tdi-warranty-actions">
                <a href="<?php echo esc_url(home_url('/warranty')); ?>" class="tdi-btn tdi-btn-small">
                    <?php _e('Full Warranty Details', 'tdi-arms'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="tdi-btn tdi-btn-small tdi-btn-secondary">
                    <?php _e('Contact Support', 'tdi-arms'); ?>
                </a>
            </div>
        </div>
    </div>
</div>