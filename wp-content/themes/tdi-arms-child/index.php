<?php
/**
 * Main Index Template
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package TDI_Arms_Child
 */

get_header(); ?>

<div class="tdi-main-content">
    <div class="tdi-container">
        <div class="tdi-content-area">
            <main id="main" class="tdi-site-main" role="main">

            <?php if (have_posts()) : ?>

                <?php if (is_home() && !is_front_page()) : ?>
                    <header class="tdi-page-header">
                        <h1 class="tdi-page-title"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>

                <?php
                // Start the Loop
                while (have_posts()) :
                    the_post();

                    /**
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', get_post_type());

                endwhile; ?>

                <div class="tdi-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('&laquo; Previous', 'tdi-arms'),
                        'next_text' => __('Next &raquo;', 'tdi-arms'),
                    ));
                    ?>
                </div>

            <?php else : ?>

                <div class="tdi-no-results">
                    <h2 class="tdi-no-results-title"><?php _e('Nothing Found', 'tdi-arms'); ?></h2>
                    <p class="tdi-no-results-text">
                        <?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'tdi-arms'); ?>
                    </p>
                    <?php get_search_form(); ?>
                </div>

            <?php endif; ?>

            </main>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();