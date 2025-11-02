<?php
/**
 * Header Template
 *
 * @package TDI_Arms_Child
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class('tdi-body'); ?>>
<?php wp_body_open(); ?>

<header class="tdi-header" role="banner">
    <div class="tdi-container">
        <div class="tdi-header-inner">
            <div class="tdi-header-branding">
                <?php
                if (function_exists('the_custom_logo') && has_custom_logo()) :
                    the_custom_logo();
                else :
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="tdi-logo-text" rel="home">
                        <h1 class="tdi-site-title"><?php bloginfo('name'); ?></h1>
                        <p class="tdi-site-description"><?php bloginfo('description'); ?></p>
                    </a>
                <?php endif; ?>
            </div>

            <nav class="tdi-primary-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'tdi-arms'); ?>">
                <button class="tdi-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="tdi-menu-toggle-icon"></span>
                    <span class="tdi-screen-reader-text"><?php _e('Menu', 'tdi-arms'); ?></span>
                </button>

                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'tdi-primary-menu',
                    'container'      => false,
                    'fallback_cb'    => 'tdi_arms_primary_menu_fallback',
                ));
                ?>
            </nav>

            <div class="tdi-header-actions">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="tdi-cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="tdi-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <span class="tdi-screen-reader-text"><?php _e('Shopping Cart', 'tdi-arms'); ?></span>
                    </a>
                <?php endif; ?>

                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="tdi-account-link">
                        <i class="fas fa-user"></i>
                        <span class="tdi-screen-reader-text"><?php _e('My Account', 'tdi-arms'); ?></span>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="tdi-login-link">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="tdi-screen-reader-text"><?php _e('Login / Register', 'tdi-arms'); ?></span>
                    </a>
                <?php endif; ?>

                <button class="tdi-search-toggle" aria-expanded="false">
                    <i class="fas fa-search"></i>
                    <span class="tdi-screen-reader-text"><?php _e('Search', 'tdi-arms'); ?></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="tdi-mobile-navigation" id="tdi-mobile-menu">
        <div class="tdi-mobile-menu-inner">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'mobile',
                'menu_id'        => 'mobile-menu',
                'menu_class'     => 'tdi-mobile-menu',
                'container'      => false,
                'fallback_cb'    => false,
            ));
            ?>

            <div class="tdi-mobile-menu-footer">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="tdi-mobile-cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <?php _e('Cart', 'tdi-arms'); ?>
                        <span class="tdi-mobile-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                <?php endif; ?>

                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="tdi-mobile-account-link">
                    <i class="fas fa-user"></i>
                    <?php is_user_logged_in() ? _e('My Account', 'tdi-arms') : _e('Login / Register', 'tdi-arms'); ?>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Search Modal -->
<div class="tdi-search-modal" id="tdi-search-modal" aria-hidden="true">
    <div class="tdi-search-modal-inner">
        <div class="tdi-search-modal-header">
            <h2 class="tdi-search-modal-title"><?php _e('Search TDI Arms', 'tdi-arms'); ?></h2>
            <button class="tdi-search-modal-close" aria-label="<?php esc_attr_e('Close search', 'tdi-arms'); ?>">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="tdi-search-modal-content">
            <?php get_search_form(array('echo' => true)); ?>
            <div class="tdi-search-suggestions">
                <h3><?php _e('Popular Searches', 'tdi-arms'); ?></h3>
                <ul class="tdi-search-suggestions-list">
                    <li><a href="<?php echo esc_url(home_url('/shop/?s=ak+handguard')); ?>">AK Handguard</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop/?s=ar+accessories')); ?>">AR Accessories</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop/?s=tactical+rails')); ?>">Tactical Rails</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop/?s=mounts')); ?>">Mounts</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if (!is_front_page() && !is_home()) : ?>
    <div class="tdi-page-header">
        <div class="tdi-container">
            <?php if (function_exists('woocommerce_breadcrumb') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) : ?>
                <?php woocommerce_breadcrumb(); ?>
            <?php elseif (function_exists('bcn_display')) : ?>
                <div class="tdi-breadcrumb"><?php bcn_display(); ?></div>
            <?php else : ?>
                <nav class="tdi-breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'tdi-arms'); ?>">
                    <ol class="tdi-breadcrumb-list">
                        <li class="tdi-breadcrumb-item">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'tdi-arms'); ?></a>
                        </li>
                        <li class="tdi-breadcrumb-item">
                            <span class="tdi-breadcrumb-current"><?php the_title(); ?></span>
                        </li>
                    </ol>
                </nav>
            <?php endif; ?>

            <?php if (is_single() || is_page()) : ?>
                <h1 class="tdi-page-title"><?php the_title(); ?></h1>
            <?php elseif (is_archive()) : ?>
                <h1 class="tdi-page-title">
                    <?php
                    if (is_post_type_archive('product')) {
                        _e('Shop', 'tdi-arms');
                    } elseif (is_tax('product_cat')) {
                        single_term_title();
                    } elseif (is_post_type_archive('case_study')) {
                        _e('Case Studies', 'tdi-arms');
                    } elseif (is_post_type_archive('field_story')) {
                        _e('Field Stories', 'tdi-arms');
                    } else {
                        the_archive_title();
                    }
                    ?>
                </h1>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php
/**
 * Fallback for primary menu
 */
function tdi_arms_primary_menu_fallback() {
    if (current_user_can('edit_theme_options')) {
        ?>
        <ul class="tdi-primary-menu">
            <li class="tdi-menu-item">
                <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>">
                    <?php _e('Please assign a menu to the Primary Navigation location', 'tdi-arms'); ?>
                </a>
            </li>
        </ul>
        <?php
    }
}
?>