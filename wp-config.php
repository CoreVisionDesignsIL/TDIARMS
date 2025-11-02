<?php
/**
 * TDI Arms WordPress Configuration
 *
 * This file contains the core configuration settings for the TDI Arms website.
 * Designed for tactical weapon accessories e-commerce platform.
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'tdi_arms_wp');

/** Database username */
define('DB_USER', 'tdi_arms_user');

/** Database password */
define('DB_PASSWORD', 'secure_password_here');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * WordPress Database Table prefix.
 */
$table_prefix = 'tdi_';

/**
 * For developers: WordPress debugging mode.
 */
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

/**
 * Security hardening for tactical weapons e-commerce
 */
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);
define('FORCE_SSL_ADMIN', true);
define('WP_AUTO_UPDATE_CORE', true);

/**
 * Performance optimizations
 */
define('WP_POST_REVISIONS', 3);
define('AUTOSAVE_INTERVAL', 300);
define('WP_MEMORY_LIMIT', '512M');

/**
 * WooCommerce specific settings
 */
define('WOOCOMMERCE_FORCE_SSL', true);
define('WC_REMOVE_ALL_DATA', false);

/**
 * Content Delivery Network settings
 */
define('WP_CONTENT_URL', 'https://cdn.tdiarms.com/wp-content');

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

/**#@-*/

/**
 * WordPress Absolute Path to the WordPress directory.
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/**
 * Sets up WordPress vars and included files.
 */
require_once ABSPATH . 'wp-settings.php';