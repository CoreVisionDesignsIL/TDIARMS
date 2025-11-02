<?php
/**
 * Footer Template
 *
 * @package TDI_Arms_Child
 */

?>

<footer class="tdi-footer" role="contentinfo">
    <div class="tdi-footer-top">
        <div class="tdi-container">
            <div class="tdi-footer-grid">

                <!-- Company Info -->
                <div class="tdi-footer-column tdi-footer-company">
                    <div class="tdi-footer-logo">
                        <?php
                        if (function_exists('the_custom_logo') && has_custom_logo()) :
                            the_custom_logo();
                        else :
                            ?>
                            <h3 class="tdi-footer-title"><?php bloginfo('name'); ?></h3>
                        <?php endif; ?>
                        <p class="tdi-footer-tagline"><?php _e('Built to Fight. Made to Win.', 'tdi-arms'); ?></p>
                    </div>
                    <div class="tdi-footer-description">
                        <p><?php _e('TDI Arms designs and manufactures premium tactical weapon accessories with precision engineering and battle-tested reliability. Made in Israel & USA.', 'tdi-arms'); ?></p>
                    </div>
                    <div class="tdi-footer-badges">
                        <span class="tdi-badge" title="ISO 9001:2015 Certified">
                            <i class="fas fa-certificate"></i>
                            <span class="tdi-badge-text">ISO 9001:2015</span>
                        </span>
                        <span class="tdi-badge" title="Made in Israel">
                            <i class="fas fa-star-of-life"></i>
                            <span class="tdi-badge-text">Made in Israel</span>
                        </span>
                        <span class="tdi-badge" title="Made in USA">
                            <i class="fas fa-flag-usa"></i>
                            <span class="tdi-badge-text">Made in USA</span>
                        </span>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="tdi-footer-column tdi-footer-links">
                    <h4 class="tdi-footer-heading"><?php _e('Quick Links', 'tdi-arms'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'tdi-footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <!-- Products -->
                <div class="tdi-footer-column tdi-footer-products">
                    <h4 class="tdi-footer-heading"><?php _e('Products', 'tdi-arms'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'products',
                        'menu_class'     => 'tdi-footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <!-- Contact -->
                <div class="tdi-footer-column tdi-footer-contact">
                    <h4 class="tdi-footer-heading"><?php _e('Contact', 'tdi-arms'); ?></h4>
                    <div class="tdi-contact-info">
                        <div class="tdi-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="tdi-contact-details">
                                <strong><?php _e('Headquarters', 'tdi-arms'); ?></strong>
                                <span><?php _e('Israel Office & Manufacturing', 'tdi-arms'); ?></span>
                            </div>
                        </div>
                        <div class="tdi-contact-item">
                            <i class="fas fa-phone"></i>
                            <div class="tdi-contact-details">
                                <span><?php _e('+972-3-123-4567', 'tdi-arms'); ?></span>
                            </div>
                        </div>
                        <div class="tdi-contact-item">
                            <i class="fas fa-envelope"></i>
                            <div class="tdi-contact-details">
                                <a href="mailto:info@tdiarms.com">info@tdiarms.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tdi-footer-bottom">
        <div class="tdi-container">
            <div class="tdi-footer-bottom-inner">
                <div class="tdi-footer-copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'tdi-arms'); ?></p>
                </div>

                <div class="tdi-footer-legal">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'legal',
                        'menu_class'     => 'tdi-legal-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <div class="tdi-footer-social">
                    <a href="#" class="tdi-social-link" aria-label="<?php esc_attr_e('Facebook', 'tdi-arms'); ?>">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="tdi-social-link" aria-label="<?php esc_attr_e('Instagram', 'tdi-arms'); ?>">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="tdi-social-link" aria-label="<?php esc_attr_e('YouTube', 'tdi-arms'); ?>">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="tdi-social-link" aria-label="<?php esc_attr_e('LinkedIn', 'tdi-arms'); ?>">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="tdi-back-to-top" id="tdi-back-to-top" aria-label="<?php esc_attr_e('Back to top', 'tdi-arms'); ?>">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Trust Badges Bar -->
<div class="tdi-trust-bar">
    <div class="tdi-container">
        <div class="tdi-trust-badges">
            <div class="tdi-trust-badge">
                <i class="fas fa-shield-alt"></i>
                <span><?php _e('Secure Shopping', 'tdi-arms'); ?></span>
            </div>
            <div class="tdi-trust-badge">
                <i class="fas fa-shipping-fast"></i>
                <span><?php _e('Fast Worldwide Shipping', 'tdi-arms'); ?></span>
            </div>
            <div class="tdi-trust-badge">
                <i class="fas fa-award"></i>
                <span><?php _e('Battle Tested', 'tdi-arms'); ?></span>
            </div>
            <div class="tdi-trust-badge">
                <i class="fas fa-headset"></i>
                <span><?php _e('Expert Support', 'tdi-arms'); ?></span>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>