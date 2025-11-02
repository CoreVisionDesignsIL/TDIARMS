/**
 * TDI Arms JavaScript
 * Main theme functionality for tactical weapons accessories website
 *
 * @package TDI_Arms_Child
 */

(function($) {
    'use strict';

    // TDI Arms Object
    window.TDI_Arms = {

        init: function() {
            this.mobileMenu();
            this.searchModal();
            this.backToTop();
            this.productGalleries();
            this.cartUpdates();
            this.formValidation();
            this.animations();
            this.lazyLoading();
            this.accessibility();
            this.performanceOptimizations();
        },

        /**
         * Mobile Menu Functionality
         */
        mobileMenu: function() {
            const menuToggle = $('.tdi-menu-toggle');
            const mobileMenu = $('#tdi-mobile-menu');
            const body = $('body');

            menuToggle.on('click', function(e) {
                e.preventDefault();
                const isOpen = mobileMenu.hasClass('tdi-mobile-menu-open');

                if (isOpen) {
                    TDI_Arms.closeMobileMenu();
                } else {
                    TDI_Arms.openMobileMenu();
                }
            });

            // Close menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.tdi-header, .tdi-mobile-navigation').length) {
                    TDI_Arms.closeMobileMenu();
                }
            });

            // Handle menu item clicks
            $('.tdi-mobile-menu .menu-item > a').on('click', function(e) {
                const $this = $(this);
                const $subMenu = $this.siblings('.sub-menu');

                if ($subMenu.length && !$this.parent().hasClass('menu-item-has-children')) {
                    e.preventDefault();
                    $subMenu.slideToggle(300);
                    $this.parent().toggleClass('sub-menu-open');
                }
            });
        },

        openMobileMenu: function() {
            const mobileMenu = $('#tdi-mobile-menu');
            const menuToggle = $('.tdi-menu-toggle');
            const body = $('body');

            mobileMenu.addClass('tdi-mobile-menu-open');
            menuToggle.addClass('tdi-menu-toggle-open');
            body.addClass('tdi-mobile-menu-active');

            // ARIA attributes
            menuToggle.attr('aria-expanded', 'true');
            mobileMenu.attr('aria-hidden', 'false');

            // Prevent body scroll
            body.css('overflow', 'hidden');
        },

        closeMobileMenu: function() {
            const mobileMenu = $('#tdi-mobile-menu');
            const menuToggle = $('.tdi-menu-toggle');
            const body = $('body');

            mobileMenu.removeClass('tdi-mobile-menu-open');
            menuToggle.removeClass('tdi-menu-toggle-open');
            body.removeClass('tdi-mobile-menu-active');

            // ARIA attributes
            menuToggle.attr('aria-expanded', 'false');
            mobileMenu.attr('aria-hidden', 'true');

            // Restore body scroll
            body.css('overflow', '');
        },

        /**
         * Search Modal Functionality
         */
        searchModal: function() {
            const searchToggle = $('.tdi-search-toggle');
            const searchModal = $('#tdi-search-modal');
            const searchClose = $('.tdi-search-modal-close');
            const searchInput = $('#tdi-search-modal input[type="search"]');

            searchToggle.on('click', function(e) {
                e.preventDefault();
                TDI_Arms.openSearchModal();
            });

            searchClose.on('click', function(e) {
                e.preventDefault();
                TDI_Arms.closeSearchModal();
            });

            // Close on escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && searchModal.is(':visible')) {
                    TDI_Arms.closeSearchModal();
                }
            });

            // Close on background click
            searchModal.on('click', function(e) {
                if ($(e.target).is(searchModal)) {
                    TDI_Arms.closeSearchModal();
                }
            });

            // Focus search input when opened
            searchModal.on('shown', function() {
                searchInput.focus();
            });
        },

        openSearchModal: function() {
            const searchModal = $('#tdi-search-modal');
            const searchToggle = $('.tdi-search-toggle');

            searchModal.attr('aria-hidden', 'false');
            searchToggle.attr('aria-expanded', 'true');
            $('body').css('overflow', 'hidden');

            // Trigger animation
            setTimeout(function() {
                searchModal.addClass('tdi-search-modal-open');
            }, 10);

            searchModal.trigger('shown');
        },

        closeSearchModal: function() {
            const searchModal = $('#tdi-search-modal');
            const searchToggle = $('.tdi-search-toggle');

            searchModal.removeClass('tdi-search-modal-open');

            setTimeout(function() {
                searchModal.attr('aria-hidden', 'true');
                searchToggle.attr('aria-expanded', 'false');
                $('body').css('overflow', '');
            }, 300);
        },

        /**
         * Back to Top Button
         */
        backToTop: function() {
            const backToTopBtn = $('#tdi-back-to-top');

            // Show/hide based on scroll position
            $(window).on('scroll', function() {
                const scrollTop = $(this).scrollTop();

                if (scrollTop > 300) {
                    backToTopBtn.addClass('tdi-back-to-top-visible');
                } else {
                    backToTopBtn.removeClass('tdi-back-to-top-visible');
                }
            });

            // Scroll to top
            backToTopBtn.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 600, 'easeInOutCubic');
            });
        },

        /**
         * Product Galleries
         */
        productGalleries: function() {
            // Initialize Swiper for product galleries
            $('.tdi-product-gallery').each(function() {
                const $this = $(this);
                const swiper = new Swiper(this, {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    keyboard: true,
                    loop: true,
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    }
                });

                // Thumbnail navigation
                const thumbnails = $this.find('.tdi-product-thumbnails img');
                thumbnails.on('click', function() {
                    const index = $(this).index();
                    swiper.slideTo(index);
                });
            });
        },

        /**
         * Shopping Cart Updates
         */
        cartUpdates: function() {
            // AJAX add to cart
            $(document).on('click', '.tdi-add-to-cart', function(e) {
                e.preventDefault();
                const $this = $(this);
                const productId = $this.data('product-id');
                const quantity = $this.data('quantity') || 1;

                $this.addClass('tdi-loading');

                $.ajax({
                    url: tdiArmsAjax.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'woocommerce_add_to_cart',
                        product_id: productId,
                        quantity: quantity,
                        nonce: tdiArmsAjax.nonce
                    },
                    success: function(response) {
                        if (response.error) {
                            TDI_Arms.showNotification(response.error, 'error');
                        } else {
                            TDI_Arms.updateCartWidget(response.fragments);
                            TDI_Arms.showNotification(response.message || 'Product added to cart!', 'success');
                        }
                    },
                    error: function() {
                        TDI_Arms.showNotification('Error adding product to cart', 'error');
                    },
                    complete: function() {
                        $this.removeClass('tdi-loading');
                    }
                });
            });

            // Update cart on page load
            if (typeof wc_cart_fragments_params !== 'undefined') {
                $(document.body).trigger('wc_fragments_refreshed');
            }
        },

        /**
         * Update Cart Widget
         */
        updateCartWidget: function(fragments) {
            $.each(fragments, function(key, value) {
                $(key).replaceWith(value);
            });
        },

        /**
         * Form Validation
         */
        formValidation: function() {
            // Contact form validation
            $('.tdi-contact-form').on('submit', function(e) {
                const $form = $(this);
                let isValid = true;

                $form.find('[required]').each(function() {
                    const $field = $(this);
                    const value = $field.val().trim();

                    if (!value) {
                        isValid = false;
                        $field.addClass('tdi-field-error');
                        TDI_Arms.showFieldError($field, 'This field is required');
                    } else {
                        $field.removeClass('tdi-field-error');
                        TDI_Arms.clearFieldError($field);
                    }

                    // Email validation
                    if ($field.attr('type') === 'email' && value) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(value)) {
                            isValid = false;
                            $field.addClass('tdi-field-error');
                            TDI_Arms.showFieldError($field, 'Please enter a valid email address');
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    TDI_Arms.showNotification('Please fill in all required fields correctly', 'error');
                }
            });

            // Clear field errors on input
            $('.tdi-contact-form [required]').on('input', function() {
                const $field = $(this);
                $field.removeClass('tdi-field-error');
                TDI_Arms.clearFieldError($field);
            });
        },

        showFieldError: function($field, message) {
            let $error = $field.siblings('.tdi-field-error-message');

            if (!$error.length) {
                $error = $('<span class="tdi-field-error-message"></span>');
                $field.after($error);
            }

            $error.text(message);
        },

        clearFieldError: function($field) {
            $field.siblings('.tdi-field-error-message').remove();
        },

        /**
         * Animations
         */
        animations: function() {
            // Animate elements on scroll
            $('.tdi-animate-on-scroll').each(function() {
                const $element = $(this);
                const elementTop = $element.offset().top;
                const elementBottom = elementTop + $element.outerHeight();
                const viewportTop = $(window).scrollTop();
                const viewportBottom = viewportTop + $(window).height();

                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $element.addClass('tdi-animated');
                }
            });

            $(window).on('scroll', function() {
                $('.tdi-animate-on-scroll:not(.tdi-animated)').each(function() {
                    const $element = $(this);
                    const elementTop = $element.offset().top;
                    const elementBottom = elementTop + $element.outerHeight();
                    const viewportTop = $(window).scrollTop();
                    const viewportBottom = viewportTop + $(window).height();

                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $element.addClass('tdi-animated');
                    }
                });
            });

            // Hover effects for product cards
            $('.tdi-product-card').hover(
                function() {
                    $(this).addClass('tdi-product-card-hover');
                },
                function() {
                    $(this).removeClass('tdi-product-card-hover');
                }
            );
        },

        /**
         * Lazy Loading
         */
        lazyLoading: function() {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const image = entry.target;
                            image.src = image.dataset.src;
                            image.srcset = image.dataset.srcset;
                            image.classList.remove('tdi-lazy');
                            imageObserver.unobserve(image);
                        }
                    });
                });

                document.querySelectorAll('.tdi-lazy').forEach(function(image) {
                    imageObserver.observe(image);
                });
            }
        },

        /**
         * Accessibility
         */
        accessibility: function() {
            // Skip to main content link
            $('<a href="#main" class="tdi-skip-link">Skip to main content</a>').prependTo('body');

            // Keyboard navigation
            $('.tdi-nav-link, .tdi-btn, .tdi-card').on('focus', function() {
                $(this).addClass('tdi-focus');
            }).on('blur', function() {
                $(this).removeClass('tdi-focus');
            });

            // ARIA live regions for notifications
            $('<div class="tdi-sr-only" aria-live="polite" aria-atomic="true" id="tdi-announcements"></div>').appendTo('body');
        },

        /**
         * Performance Optimizations
         */
        performanceOptimizations: function() {
            // Debounce resize events
            let resizeTimer;
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    TDI_Arms.handleResize();
                }, 250);
            });

            // Preload critical images
            $('.tdi-hero-image').each(function() {
                const $img = $(this);
                const preloadLink = $('<link rel="preload" as="image">');
                preloadLink.attr('href', $img.attr('src'));
                $('head').append(preloadLink);
            });
        },

        /**
         * Handle Window Resize
         */
        handleResize: function() {
            // Close mobile menu on desktop
            if ($(window).width() > 1024) {
                TDI_Arms.closeMobileMenu();
            }

            // Recalculate animations
            $('.tdi-animate-on-scroll').removeClass('tdi-animated');
            TDI_Arms.animations();
        },

        /**
         * Show Notification
         */
        showNotification: function(message, type = 'info') {
            const notification = $(`
                <div class="tdi-notification tdi-notification-${type}">
                    <div class="tdi-notification-content">
                        <span class="tdi-notification-message">${message}</span>
                        <button class="tdi-notification-close" aria-label="Close notification">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `);

            $('body').append(notification);

            // Auto remove after 5 seconds
            setTimeout(function() {
                TDI_Arms.removeNotification(notification);
            }, 5000);

            // Manual close
            notification.find('.tdi-notification-close').on('click', function() {
                TDI_Arms.removeNotification(notification);
            });
        },

        removeNotification: function(notification) {
            notification.addClass('tdi-notification-removing');
            setTimeout(function() {
                notification.remove();
            }, 300);
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        TDI_Arms.init();
    });

    // Re-initialize on AJAX complete
    $(document).ajaxComplete(function() {
        TDI_Arms.animations();
        TDI_Arms.lazyLoading();
    });

})(jQuery);

// GSAP Animations for Hero Section
if (typeof gsap !== 'undefined') {
    gsap.timeline({delay: 0.5})
        .from('.tdi-hero-title', {
            opacity: 0,
            y: 50,
            duration: 1,
            ease: 'power3.out'
        })
        .from('.tdi-hero-subtitle', {
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: 'power3.out'
        }, '-=0.5')
        .from('.tdi-hero-actions', {
            opacity: 0,
            y: 20,
            duration: 0.6,
            ease: 'power3.out'
        }, '-=0.3');

    // Parallax effect for hero background
    gsap.to('.tdi-hero', {
        backgroundPosition: '50% 100%',
        ease: 'none',
        scrollTrigger: {
            trigger: '.tdi-hero',
            start: 'top top',
            end: 'bottom top',
            scrub: true
        }
    });
}