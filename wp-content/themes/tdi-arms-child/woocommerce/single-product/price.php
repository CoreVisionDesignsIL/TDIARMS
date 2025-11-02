<?php
/**
 * Single product price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

?>
<div class="tdi-product-price-section">
    <div class="price <?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'tdi-product-price')); ?>">
        <?php echo $product->get_price_html(); ?>
    </div>

    <!-- TDI Arms Price Enhancements -->
    <div class="tdi-price-info">
        <?php if ($product->is_on_sale()) : ?>
            <div class="tdi-sale-amount">
                <?php
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $savings = $regular_price - $sale_price;
                $savings_percent = round(($savings / $regular_price) * 100);
                ?>
                <span class="tdi-savings-label"><?php _e('You save:', 'tdi-arms'); ?></span>
                <span class="tdi-savings-amount"><?php echo wc_price($savings); ?> (<?php echo $savings_percent; ?>%)</span>
            </div>
        <?php endif; ?>

        <?php if ($product->is_in_stock()) : ?>
            <div class="tdi-stock-status tdi-in-stock">
                <i class="fas fa-check-circle"></i>
                <span><?php _e('In Stock', 'tdi-arms'); ?></span>
                <?php
                $stock_quantity = $product->get_stock_quantity();
                if ($stock_quantity > 0 && $stock_quantity <= 5) :
                ?>
                    <span class="tdi-low-stock"><?php printf(__('Only %d left!', 'tdi-arms'), $stock_quantity); ?></span>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="tdi-stock-status tdi-out-of-stock">
                <i class="fas fa-times-circle"></i>
                <span><?php _e('Out of Stock', 'tdi-arms'); ?></span>
            </div>
        <?php endif; ?>

        <!-- Free Shipping Indicator -->
        <?php
        $free_shipping_threshold = 100; // Set your free shipping threshold
        if ($product->get_price() >= $free_shipping_threshold) :
        ?>
            <div class="tdi-free-shipping">
                <i class="fas fa-truck"></i>
                <span><?php _e('Free Shipping', 'tdi-arms'); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Dealer Pricing Notice -->
    <?php if (is_user_logged_in() && current_user_can('dealer')) : ?>
        <div class="tdi-dealer-pricing-notice">
            <i class="fas fa-user-tie"></i>
            <span><?php _e('Dealer pricing applied', 'tdi-arms'); ?></span>
        </div>
    <?php elseif (!is_user_logged_in()) : ?>
        <div class="tdi-dealer-pricing-prompt">
            <i class="fas fa-user-tie"></i>
            <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
                <?php _e('Become a dealer for special pricing', 'tdi-arms'); ?>
            </a>
        </div>
    <?php endif; ?>
</div>