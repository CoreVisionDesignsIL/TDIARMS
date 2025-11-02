<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('tdi-product-card', $product); ?>>
    <div class="tdi-product-inner">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');

        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action('woocommerce_before_shop_loop_item_title');

        /**
         * Hook: woocommerce_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action('woocommerce_shop_loop_item_title');

        /**
         * Hook: woocommerce_after_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title');

        /**
         * Hook: woocommerce_after_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action('woocommerce_after_shop_loop_item');
        ?>

        <!-- TDI Arms Custom Elements -->
        <div class="tdi-product-custom-fields">
            <?php if (tdi_arms_is_tactical_grade($product->get_id())) : ?>
                <span class="tdi-product-badge tdi-tactical-badge">
                    <i class="fas fa-shield-alt"></i>
                    <?php _e('Tactical Grade', 'tdi-arms'); ?>
                </span>
            <?php endif; ?>

            <?php if (get_post_meta($product->get_id(), '_tdi_military_use', true) === 'yes') : ?>
                <span class="tdi-product-badge tdi-military-badge">
                    <i class="fas fa-star"></i>
                    <?php _e('Military Use', 'tdi-arms'); ?>
                </span>
            <?php endif; ?>

            <?php
            $platform = get_post_meta($product->get_id(), '_tdi_platform', true);
            if ($platform) :
            ?>
                <span class="tdi-product-platform">
                    <i class="fas fa-cog"></i>
                    <?php echo esc_html($platform); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Quick View Button -->
        <div class="tdi-product-quick-view">
            <button class="tdi-quick-view-btn" data-product-id="<?php echo $product->get_id(); ?>">
                <i class="fas fa-eye"></i>
                <?php _e('Quick View', 'tdi-arms'); ?>
            </button>
        </div>

        <!-- Product Compatibility Info -->
        <?php
        $compatibility = tdi_arms_get_compatibility($product->get_id());
        if ($compatibility) :
        ?>
            <div class="tdi-product-compatibility">
                <i class="fas fa-check-circle"></i>
                <span><?php echo wp_trim_words(esc_html($compatibility), 5); ?></span>
            </div>
        <?php endif; ?>

        <!-- Wishlist Button -->
        <div class="tdi-product-wishlist">
            <button class="tdi-wishlist-btn" data-product-id="<?php echo $product->get_id(); ?>">
                <i class="far fa-heart"></i>
                <span class="tdi-wishlist-text"><?php _e('Add to Wishlist', 'tdi-arms'); ?></span>
            </button>
        </div>

        <!-- Compare Button -->
        <div class="tdi-product-compare">
            <button class="tdi-compare-btn" data-product-id="<?php echo $product->get_id(); ?>">
                <i class="fas fa-balance-scale"></i>
                <span class="tdi-compare-text"><?php _e('Compare', 'tdi-arms'); ?></span>
            </button>
        </div>
    </div>
</li>