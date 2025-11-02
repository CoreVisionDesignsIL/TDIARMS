<?php
/**
 * Plugin Name: TDI Arms Configuration
 * Plugin URI: https://tdiarms.com
 * Description: Essential configuration plugin for TDI Arms website. Sets up WooCommerce, SEO, security, and performance optimizations.
 * Version: 1.0.0
 * Author: TDI Arms Development Team
 * License: Proprietary
 * Text Domain: tdi-arms
 */

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * TDI Arms Configuration Class
 */
class TDI_Arms_Config {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'init_plugin'));
        add_action('after_setup_theme', array($this, 'theme_setup'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));

        // WooCommerce integrations
        add_action('woocommerce_init', array($this, 'woocommerce_setup'));
        add_filter('woocommerce_product_data_tabs', array($this, 'product_tabs'));
        add_action('woocommerce_product_data_panels', array($this, 'product_panels'));
        add_action('woocommerce_process_product_meta', array($this, 'save_product_fields'));

        // Admin configurations
        add_action('admin_init', array($this, 'admin_settings'));
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_links'));
    }

    /**
     * Initialize Plugin
     */
    public function init_plugin() {
        // Load text domain
        load_plugin_textdomain('tdi-arms', false, dirname(plugin_basename(__FILE__)) . '/languages');

        // Flush rewrite rules if needed
        if (get_option('tdi_arms_flush_rules')) {
            flush_rewrite_rules();
            delete_option('tdi_arms_flush_rules');
        }
    }

    /**
     * Theme Setup
     */
    public function theme_setup() {
        // Custom image sizes
        add_image_size('tdi-product-gallery', 800, 800, true);
        add_image_size('tdi-product-thumb', 150, 150, true);
        add_image_size('tdi-category-banner', 1200, 400, true);
        add_image_size('tdi-blog-thumbnail', 400, 300, true);

        // Custom post types
        $this->register_post_types();

        // Taxonomies
        $this->register_taxonomies();
    }

    /**
     * Register Custom Post Types
     */
    private function register_post_types() {
        // Technical Specifications
        register_post_type('technical_spec', array(
            'label' => __('Technical Specifications', 'tdi-arms'),
            'public' => false,
            'show_ui' => true,
            'capability_type' => 'post',
            'supports' => array('title', 'editor'),
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-list-view',
        ));
    }

    /**
     * Register Custom Taxonomies
     */
    private function register_taxonomies() {
        // Product Platform (AK, AR, Universal)
        register_taxonomy('product_platform', 'product', array(
            'label' => __('Platform', 'tdi-arms'),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'platform'),
            'show_in_nav_menus' => true,
        ));

        // Tactical Use Case
        register_taxonomy('tactical_use', 'product', array(
            'label' => __('Tactical Use', 'tdi-arms'),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'use'),
            'show_in_nav_menus' => true,
        ));
    }

    /**
     * Enqueue Frontend Scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_style('tdi-arms-config-style', plugin_dir_url(__FILE__) . 'assets/css/tdi-arms-config.css', array(), '1.0.0');
        wp_enqueue_script('tdi-arms-config-script', plugin_dir_url(__FILE__) . 'assets/js/tdi-arms-config.js', array('jquery'), '1.0.0', true);

        wp_localize_script('tdi-arms-config-script', 'tdiConfig', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tdi_config_nonce'),
            'strings' => array(
                'adding_to_cart' => __('Adding to cart...', 'tdi-arms'),
                'added_to_cart' => __('Added to cart!', 'tdi-arms'),
                'error' => __('Error occurred. Please try again.', 'tdi-arms'),
            ),
        ));
    }

    /**
     * Enqueue Admin Scripts
     */
    public function admin_scripts() {
        $screen = get_current_screen();

        if ('product' === $screen->id) {
            wp_enqueue_style('tdi-arms-admin-style', plugin_dir_url(__FILE__) . 'assets/css/admin.css', array(), '1.0.0');
            wp_enqueue_script('tdi-arms-admin-script', plugin_dir_url(__FILE__) . 'assets/js/admin.js', array('jquery'), '1.0.0', true);
        }
    }

    /**
     * WooCommerce Setup
     */
    public function woocommerce_setup() {
        // Remove default WooCommerce styles
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');

        // Add custom theme support
        add_theme_support('woocommerce', array(
            'thumbnail_image_width' => 400,
            'gallery_thumbnail_image_width' => 150,
            'single_image_width' => 800,
            'product_grid' => array(
                'default_columns' => 3,
                'min_columns' => 2,
                'max_columns' => 4,
                'default_rows' => 4,
            ),
        ));

        // Custom shop columns
        add_filter('loop_shop_columns', function() {
            return 3;
        });

        // Products per page
        add_filter('loop_shop_per_page', function() {
            return 12;
        });

        // Custom add to cart text
        add_filter('woocommerce_product_single_add_to_cart_text', function() {
            return __('Add to Tactical Setup', 'tdi-arms');
        });

        add_filter('woocommerce_product_add_to_cart_text', function() {
            return __('Add to Tactical Setup', 'tdi-arms');
        });

        // Remove WooCommerce breadcrumbs (handled by theme)
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    }

    /**
     * Custom Product Data Tabs
     */
    public function product_tabs($tabs) {
        // Remove shipping tab if not needed
        unset($tabs['shipping']);

        // Add TDI specific tabs
        $tabs['tdi_tactical'] = array(
            'label' => __('Tactical Info', 'tdi-arms'),
            'target' => 'tdi_tactical_data',
            'class' => array('hide_if_virtual'),
            'priority' => 25,
        );

        $tabs['tdi_specifications'] = array(
            'label' => __('Specifications', 'tdi-arms'),
            'target' => 'tdi_specifications_data',
            'class' => array(),
            'priority' => 30,
        );

        return $tabs;
    }

    /**
     * Custom Product Data Panels
     */
    public function product_panels() {
        global $post;

        // Tactical Information Panel
        echo '<div id="tdi_tactical_data" class="panel woocommerce_options_panel hidden">';
        echo '<div class="options_group">';

        // Tactical Grade
        woocommerce_wp_checkbox(array(
            'id' => '_tdi_tactical_grade',
            'label' => __('Tactical Grade', 'tdi-arms'),
            'description' => __('Mark as professional tactical grade equipment', 'tdi-arms'),
            'desc_tip' => true,
        ));

        // Platform Compatibility
        woocommerce_wp_text_input(array(
            'id' => '_tdi_platform',
            'label' => __('Platform Compatibility', 'tdi-arms'),
            'placeholder' => 'AK-47, AR-15, Universal',
            'desc_tip' => true,
            'description' => __('Enter compatible platforms', 'tdi-arms'),
        ));

        // Military Use
        woocommerce_wp_checkbox(array(
            'id' => '_tdi_military_use',
            'label' => __('Military Use', 'tdi-arms'),
            'description' => __('Used by military/law enforcement', 'tdi-arms'),
            'desc_tip' => true,
        ));

        echo '</div>';
        echo '</div>';

        // Specifications Panel
        echo '<div id="tdi_specifications_data" class="panel woocommerce_options_panel hidden">';
        echo '<div class="options_group">';

        // Weight
        woocommerce_wp_text_input(array(
            'id' => '_tdi_weight',
            'label' => __('Weight (g)', 'tdi-arms'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => '0.1',
                'min' => '0',
            ),
        ));

        // Material
        woocommerce_wp_text_input(array(
            'id' => '_tdi_material',
            'label' => __('Material', 'tdi-arms'),
            'placeholder' => 'Aluminum 6061, Steel, Polymer',
        ));

        // Finish
        woocommerce_wp_text_input(array(
            'id' => '_tdi_finish',
            'label' => __('Finish', 'tdi-arms'),
            'placeholder' => 'Anodized Black, Cerakote, Park. coated',
        ));

        // Length
        woocommerce_wp_text_input(array(
            'id' => '_tdi_length',
            'label' => __('Length (mm)', 'tdi-arms'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => '0.1',
                'min' => '0',
            ),
        ));

        // Installation Guide URL
        woocommerce_wp_text_input(array(
            'id' => '_tdi_installation_guide',
            'label' => __('Installation Guide URL', 'tdi-arms'),
            'placeholder' => 'https://youtube.com/watch?v=...',
        ));

        echo '</div>';
        echo '</div>';
    }

    /**
     * Save Product Fields
     */
    public function save_product_fields($post_id) {
        // Tactical information
        update_post_meta($post_id, '_tdi_tactical_grade', isset($_POST['_tdi_tactical_grade']) ? 'yes' : 'no');
        update_post_meta($post_id, '_tdi_platform', sanitize_text_field($_POST['_tdi_platform']));
        update_post_meta($post_id, '_tdi_military_use', isset($_POST['_tdi_military_use']) ? 'yes' : 'no');

        // Specifications
        update_post_meta($post_id, '_tdi_weight', sanitize_text_field($_POST['_tdi_weight']));
        update_post_meta($post_id, '_tdi_material', sanitize_text_field($_POST['_tdi_material']));
        update_post_meta($post_id, '_tdi_finish', sanitize_text_field($_POST['_tdi_finish']));
        update_post_meta($post_id, '_tdi_length', sanitize_text_field($_POST['_tdi_length']));
        update_post_meta($post_id, '_tdi_installation_guide', esc_url_raw($_POST['_tdi_installation_guide']));
    }

    /**
     * Admin Settings
     */
    public function admin_settings() {
        register_setting('tdi_arms_options', 'tdi_arms_settings');

        add_settings_section(
            'tdi_arms_general',
            __('TDI Arms Settings', 'tdi-arms'),
            array($this, 'general_section_callback'),
            'tdi-arms-config'
        );

        add_settings_field(
            'enable_tactical_features',
            __('Enable Tactical Features', 'tdi-arms'),
            array($this, 'checkbox_field_callback'),
            'tdi-arms-config',
            'tdi_arms_general',
            array(
                'id' => 'enable_tactical_features',
                'description' => __('Enable tactical-specific features and styling', 'tdi-arms'),
            )
        );

        add_settings_field(
            'dealer_portal_enabled',
            __('Enable Dealer Portal', 'tdi-arms'),
            array($this, 'checkbox_field_callback'),
            'tdi-arms-config',
            'tdi_arms_general',
            array(
                'id' => 'dealer_portal_enabled',
                'description' => __('Enable B2B dealer functionality', 'tdi-arms'),
            )
        );
    }

    /**
     * Settings Section Callback
     */
    public function general_section_callback() {
        echo '<p>' . __('Configure TDI Arms website specific settings', 'tdi-arms') . '</p>';
    }

    /**
     * Checkbox Field Callback
     */
    public function checkbox_field_callback($args) {
        $options = get_option('tdi_arms_settings');
        $checked = isset($options[$args['id']]) && $options[$args['id']] ? 'checked' : '';

        echo '<input type="checkbox" id="' . esc_attr($args['id']) . '" name="tdi_arms_settings[' . esc_attr($args['id']) . ']" value="1" ' . $checked . ' />';
        echo '<label for="' . esc_attr($args['id']) . '">' . esc_html($args['description']) . '</label>';
    }

    /**
     * Plugin Links
     */
    public function plugin_links($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=tdi-arms-config') . '">' . __('Settings', 'tdi-arms') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * AJAX Handlers
     */
    public function ajax_handlers() {
        // Load more products
        add_action('wp_ajax_tdi_load_more', array($this, 'load_more_products'));
        add_action('wp_ajax_nopriv_tdi_load_more', array($this, 'load_more_products'));

        // Quick view
        add_action('wp_ajax_tdi_quick_view', array($this, 'quick_view'));
        add_action('wp_ajax_nopriv_tdi_quick_view', array($this, 'quick_view'));
    }

    /**
     * Load More Products
     */
    public function load_more_products() {
        check_ajax_referer('tdi_config_nonce', 'nonce');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 12,
            'paged' => $page,
            'post_status' => 'publish',
        );

        if ($category) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category,
                ),
            );
        }

        $products = new WP_Query($args);

        if ($products->have_posts()) {
            ob_start();
            while ($products->have_posts()) {
                $products->the_post();
                wc_get_template_part('content', 'product');
            }
            wp_reset_postdata();
            $response = ob_get_clean();
        } else {
            $response = '<p class="tdi-no-more-products">' . __('No more products found.', 'tdi-arms') . '</p>';
        }

        wp_send_json_success($response);
    }

    /**
     * Quick View
     */
    public function quick_view() {
        check_ajax_referer('tdi_config_nonce', 'nonce');

        $product_id = intval($_POST['product_id']);
        $product = wc_get_product($product_id);

        if (!$product) {
            wp_send_json_error(__('Product not found', 'tdi-arms'));
        }

        ob_start();
        wc_get_template_part('content', 'quick-view');
        $response = ob_get_clean();

        wp_send_json_success($response);
    }
}

// Initialize the plugin
TDI_Arms_Config::get_instance();

// Activation hook
register_activation_hook(__FILE__, function() {
    // Set default options
    $default_settings = array(
        'enable_tactical_features' => 1,
        'dealer_portal_enabled' => 1,
    );
    add_option('tdi_arms_settings', $default_settings);

    // Flush rewrite rules
    add_option('tdi_arms_flush_rules', 1);
});

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    // Clean up if needed
    flush_rewrite_rules();
});