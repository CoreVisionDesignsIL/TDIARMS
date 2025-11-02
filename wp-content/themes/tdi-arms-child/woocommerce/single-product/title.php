<?php
/**
 * Single product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

?>
<h1 class="product_title entry-title tdi-product-main-title">
    <?php the_title(); ?>

    <!-- TDI Arms Custom Badges -->
    <div class="tdi-product-title-badges">
        <?php if (tdi_arms_is_tactical_grade($product->get_id())) : ?>
            <span class="tdi-badge tdi-tactical-badge-small">
                <i class="fas fa-shield-alt"></i>
                <?php _e('Tactical Grade', 'tdi-arms'); ?>
            </span>
        <?php endif; ?>

        <?php if (get_post_meta($product->get_id(), '_tdi_military_use', true) === 'yes') : ?>
            <span class="tdi-badge tdi-military-badge-small">
                <i class="fas fa-star"></i>
                <?php _e('Military Use', 'tdi-arms'); ?>
            </span>
        <?php endif; ?>

        <?php if ($product->is_featured()) : ?>
            <span class="tdi-badge tdi-featured-badge-small">
                <i class="fas fa-star"></i>
                <?php _e('Featured', 'tdi-arms'); ?>
            </span>
        <?php endif; ?>
    </div>

    <!-- Product SKU -->
    <?php if ($product->get_sku()) : ?>
        <span class="tdi-product-sku">
            <?php _e('SKU:', 'tdi-arms'); ?> <span class="sku"><?php echo esc_html($product->get_sku()); ?></span>
        </span>
    <?php endif; ?>
</h1>

<!-- Platform Compatibility -->
<?php
$platform = get_post_meta($product->get_id(), '_tdi_platform', true);
if ($platform) :
?>
    <div class="tdi-product-platform-info">
        <i class="fas fa-cog"></i>
        <span><?php _e('Platform:', 'tdi-arms'); ?> <?php echo esc_html($platform); ?></span>
    </div>
<?php endif; ?>