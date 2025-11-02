<?php
/**
 * TDI Arms Child Theme Functions
 *
 * @package TDI_Arms_Child
 * @author TDI Arms Development Team
 * @version 1.0.0
 */

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function tdi_arms_child_theme_setup() {

    // Add theme support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Add theme support for title tag
    add_theme_support('title-tag');

    // Add theme support for HTML5 semantic markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add theme support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add theme support for align wide
    add_theme_support('align-wide');

    // Add custom image sizes for tactical products
    add_image_size('tdi-product-thumb', 300, 300, true);
    add_image_size('tdi-product-large', 600, 600, true);
    add_image_size('tdi-hero-image', 1920, 1080, true);
    add_image_size('tdi-category-thumb', 400, 300, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary'   => __('Primary Navigation', 'tdi-arms'),
        'mobile'    => __('Mobile Navigation', 'tdi-arms'),
        'footer'    => __('Footer Navigation', 'tdi-arms'),
        'products'  => __('Product Categories', 'tdi-arms'),
        'dealer'    => __('Dealer Portal Menu', 'tdi-arms'),
    ));

}
add_action('after_setup_theme', 'tdi_arms_child_theme_setup');

/**
 * Enqueue Styles and Scripts
 */
function tdi_arms_child_enqueue_scripts() {

    // Parent theme stylesheet
    wp_enqueue_style('hello-elementor-style', get_template_directory_uri() . '/style.css');

    // Child theme stylesheet
    wp_enqueue_style('tdi-arms-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('hello-elementor-style'),
        wp_get_theme()->get('Version')
    );

    // Google Fonts - Roboto Condensed and Roboto
    wp_enqueue_style('tdi-arms-google-fonts',
        'https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;600;700;900&family=Roboto:wght@300;400;500;700;900&family=Courier+New:wght@400;700&display=swap',
        array(),
        null
    );

    // Font Awesome for icons
    wp_enqueue_style('tdi-arms-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );

    // Swiper CSS for product sliders
    wp_enqueue_style('tdi-arms-swiper',
        'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css',
        array(),
        '10.3.1'
    );

    // Custom JavaScript
    wp_enqueue_script('tdi-arms-scripts',
        get_stylesheet_directory_uri() . '/assets/js/tdi-arms.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );

    // Swiper JS
    wp_enqueue_script('tdi-arms-swiper',
        'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js',
        array(),
        '10.3.1',
        true
    );

    // GSAP for animations
    wp_enqueue_script('tdi-arms-gsap',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
        array(),
        '3.12.2',
        true
    );

    // Localize script for AJAX
    wp_localize_script('tdi-arms-scripts', 'tdiArmsAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('tdi_arms_nonce'),
        'siteUrl' => home_url(),
        'isMobile' => wp_is_mobile(),
    ));

}
add_action('wp_enqueue_scripts', 'tdi_arms_child_enqueue_scripts');

/**
 * WooCommerce Customizations
 */

// Remove default WooCommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Custom WooCommerce wrapper
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'tdi_arms_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'tdi_arms_wrapper_end', 10);

function tdi_arms_wrapper_start() {
    echo '<div class="tdi-woocommerce-wrapper">';
}

function tdi_arms_wrapper_end() {
    echo '</div>';
}

// Custom breadcrumb
add_filter('woocommerce_breadcrumb_defaults', 'tdi_arms_breadcrumb_defaults');
function tdi_arms_breadcrumb_defaults() {
    return array(
        'delimiter'   => ' <span class="tdi-breadcrumb-separator">/</span> ',
        'wrap_before' => '<nav class="tdi-breadcrumb" aria-label="breadcrumb"><ol class="tdi-breadcrumb-list">',
        'wrap_after'  => '</ol></nav>',
        'before'      => '<li class="tdi-breadcrumb-item">',
        'after'       => '</li>',
        'home'        => _x('Home', 'breadcrumb', 'tdi-arms'),
    );
}

// Custom product tabs
add_filter('woocommerce_product_tabs', 'tdi_arms_product_tabs');
function tdi_arms_product_tabs($tabs) {

    // Remove reviews tab if not needed
    unset($tabs['reviews']);

    // Add specifications tab
    $tabs['specifications'] = array(
        'title'    => __('Technical Specifications', 'tdi-arms'),
        'priority' => 15,
        'callback' => 'tdi_arms_product_specifications_tab',
    );

    // Add compatibility tab
    $tabs['compatibility'] = array(
        'title'    => __('Compatibility', 'tdi-arms'),
        'priority' => 20,
        'callback' => 'tdi_arms_product_compatibility_tab',
    );

    // Add installation tab
    $tabs['installation'] = array(
        'title'    => __('Installation', 'tdi-arms'),
        'priority' => 25,
        'callback' => 'tdi_arms_product_installation_tab',
    );

    return $tabs;
}

function tdi_arms_product_specifications_tab() {
    global $product;

    // Get custom specifications from product meta
    $specs = get_post_meta($product->get_id(), '_tdi_specifications', true);

    if ($specs) {
        echo '<div class="tdi-product-specs">';
        echo '<h3>' . __('Technical Specifications', 'tdi-arms') . '</h3>';
        echo '<table class="tdi-specs-table">';
        foreach ($specs as $spec) {
            echo '<tr>';
            echo '<td class="spec-label">' . esc_html($spec['label']) . '</td>';
            echo '<td class="spec-value">' . esc_html($spec['value']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
    }
}

function tdi_arms_product_compatibility_tab() {
    global $product;

    $compatibility = get_post_meta($product->get_id(), '_tdi_compatibility', true);

    if ($compatibility) {
        echo '<div class="tdi-product-compatibility">';
        echo '<h3>' . __('Compatibility Information', 'tdi-arms') . '</h3>';
        echo '<div class="tdi-compatibility-list">';
        echo wpautop(esc_html($compatibility));
        echo '</div>';
        echo '</div>';
    }
}

function tdi_arms_product_installation_tab() {
    global $product;

    $installation_guide = get_post_meta($product->get_id(), '_tdi_installation_guide', true);
    $installation_video = get_post_meta($product->get_id(), '_tdi_installation_video', true);

    echo '<div class="tdi-product-installation">';
    echo '<h3>' . __('Installation Guide', 'tdi-arms') . '</h3>';

    if ($installation_guide) {
        echo '<div class="tdi-installation-text">';
        echo wpautop(esc_html($installation_guide));
        echo '</div>';
    }

    if ($installation_video) {
        echo '<div class="tdi-installation-video">';
        echo '<h4>' . __('Video Tutorial', 'tdi-arms') . '</h4>';
        echo '<div class="tdi-video-embed">';
        echo wp_oembed_get($installation_video);
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
}

// Custom Add to Cart button text
add_filter('woocommerce_product_single_add_to_cart_text', 'tdi_arms_custom_add_to_cart_text');
add_filter('woocommerce_product_add_to_cart_text', 'tdi_arms_custom_add_to_cart_text');

function tdi_arms_custom_add_to_cart_text() {
    return __('Add to Tactical Setup', 'tdi-arms');
}

// Custom sale flash
add_filter('woocommerce_sale_flash', 'tdi_arms_custom_sale_flash');
function tdi_arms_custom_sale_flash() {
    return '<span class="tdi-onsale">' . __('Tactical Deal', 'tdi-arms') . '</span>';
}

/**
 * Custom Post Types for TDI Arms
 */

// Case Studies Post Type
function tdi_arms_register_post_types() {

    // Case Studies
    register_post_type('case_study', array(
        'labels' => array(
            'name'          => __('Case Studies', 'tdi-arms'),
            'singular_name' => __('Case Study', 'tdi-arms'),
            'menu_name'     => __('Case Studies', 'tdi-arms'),
            'add_new'       => __('Add New Case Study', 'tdi-arms'),
            'add_new_item'  => __('Add New Case Study', 'tdi-arms'),
            'edit_item'     => __('Edit Case Study', 'tdi-arms'),
            'new_item'      => __('New Case Study', 'tdi-arms'),
            'view_item'     => __('View Case Study', 'tdi-arms'),
            'search_items'  => __('Search Case Studies', 'tdi-arms'),
        ),
        'public'      => true,
        'has_archive' => true,
        'supports'    => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'menu_icon'   => 'dashicons-clipboard',
        'show_in_rest' => true,
        'rewrite'     => array('slug' => 'case-studies'),
    ));

    // Field Stories
    register_post_type('field_story', array(
        'labels' => array(
            'name'          => __('Field Stories', 'tdi-arms'),
            'singular_name' => __('Field Story', 'tdi-arms'),
            'menu_name'     => __('Field Stories', 'tdi-arms'),
            'add_new'       => __('Add New Field Story', 'tdi-arms'),
            'add_new_item'  => __('Add New Field Story', 'tdi-arms'),
            'edit_item'     => __('Edit Field Story', 'tdi-arms'),
            'new_item'      => __('New Field Story', 'tdi-arms'),
            'view_item'     => __('View Field Story', 'tdi-arms'),
            'search_items'  => __('Search Field Stories', 'tdi-arms'),
        ),
        'public'      => true,
        'has_archive' => true,
        'supports'    => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'menu_icon'   => 'dashicons-megaphone',
        'show_in_rest' => true,
        'rewrite'     => array('slug' => 'field-stories'),
    ));

}
add_action('init', 'tdi_arms_register_post_types');

/**
 * Custom Widgets
 */
function tdi_arms_widgets_init() {

    register_sidebar(array(
        'name'          => __('Header Widget Area', 'tdi-arms'),
        'id'            => 'header-widgets',
        'description'   => __('Widgets in the header area', 'tdi-arms'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Product Filters', 'tdi-arms'),
        'id'            => 'product-filters',
        'description'   => __('Product filter widgets', 'tdi-arms'),
        'before_widget' => '<div id="%1$s" class="widget %2$s tdi-filter-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title tdi-filter-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widgets', 'tdi-arms'),
        'id'            => 'footer-widgets',
        'description'   => __('Widgets in the footer area', 'tdi-arms'),
        'before_widget' => '<div id="%1$s" class="widget %2$s tdi-footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title tdi-footer-title">',
        'after_title'   => '</h3>',
    ));

}
add_action('widgets_init', 'tdi_arms_widgets_init');

/**
 * AJAX Handlers
 */

// Load more products
add_action('wp_ajax_tdi_load_more_products', 'tdi_load_more_products');
add_action('wp_ajax_nopriv_tdi_load_more_products', 'tdi_load_more_products');

function tdi_load_more_products() {

    check_ajax_referer('tdi_arms_nonce', 'nonce');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 12,
        'paged'          => $page,
        'post_status'    => 'publish',
    );

    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }

    $products = new WP_Query($args);

    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template_part('content', 'product');
        }
    } else {
        echo '<p>' . __('No more products found.', 'tdi-arms') . '</p>';
    }

    wp_die();
}

/**
 * Performance Optimizations
 */

// Remove unnecessary WordPress features
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

// Defer JavaScript loading
function tdi_arms_defer_javascripts($url) {
    if (is_user_logged_in()) return $url;
    if (FALSE === strpos($url, '.js')) return $url;
    if (strpos($url, 'jquery.js')) return $url;
    return str_replace(' src', ' defer src', $url);
}
add_filter('clean_url', 'tdi_arms_defer_javascripts', 11, 1);

/**
 * Security Enhancements
 */

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Hide login errors
add_filter('login_errors', function() {
    return __('Invalid credentials', 'tdi-arms');
});

// Disable file editing in admin
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * Utility Functions
 */

/**
 * Get TDI Arms theme option
 */
function tdi_arms_get_option($option, $default = '') {
    $options = get_option('tdi_arms_options', array());
    return isset($options[$option]) ? $options[$option] : $default;
}

/**
 * Check if product is tactical grade
 */
function tdi_arms_is_tactical_grade($product_id) {
    return get_post_meta($product_id, '_tdi_tactical_grade', true) === 'yes';
}

/**
 * Get product compatibility information
 */
function tdi_arms_get_compatibility($product_id) {
    return get_post_meta($product_id, '_tdi_compatibility', true);
}

/**
 * Get technical specifications
 */
function tdi_arms_get_specifications($product_id) {
    return get_post_meta($product_id, '_tdi_specifications', true);
}