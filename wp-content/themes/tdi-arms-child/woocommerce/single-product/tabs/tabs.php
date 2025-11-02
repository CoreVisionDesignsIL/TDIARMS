<?php
/**
 * Single product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : ?>

    <div class="tdi-product-tabs woocommerce-tabs wc-tabs-wrapper">
        <ul class="tabs wc-tabs tdi-tab-nav" role="tablist">
            <?php foreach ($product_tabs as $key => $product_tab) : ?>
                <li class="<?php echo esc_attr($key); ?>_tab tdi-tab-item" id="tab-title-<?php echo esc_attr($key); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
                    <a href="#tab-<?php echo esc_attr($key); ?>">
                        <?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
                        <?php if ('description' === $key) : ?>
                            <i class="fas fa-info-circle"></i>
                        <?php elseif ('additional_information' === $key) : ?>
                            <i class="fas fa-list"></i>
                        <?php elseif ('reviews' === $key) : ?>
                            <i class="fas fa-star"></i>
                        <?php elseif (strpos($key, 'tdi_') === 0) : ?>
                            <?php if (strpos($key, 'tactical') !== false) : ?>
                                <i class="fas fa-shield-alt"></i>
                            <?php elseif (strpos($key, 'spec') !== false) : ?>
                                <i class="fas fa-cogs"></i>
                            <?php else : ?>
                                <i class="fas fa-tools"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php foreach ($product_tabs as $key => $product_tab) : ?>
            <div class="tdi-tab-content woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                <?php
                if (isset($product_tab['callback'])) {
                    call_user_func($product_tab['callback'], $key, $product_tab);
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>