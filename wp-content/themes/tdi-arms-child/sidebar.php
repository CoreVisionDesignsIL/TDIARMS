<?php
/**
 * Sidebar Template
 *
 * @package TDI_Arms_Child
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside class="tdi-sidebar" role="complementary">
    <div class="tdi-sidebar-inner">
        <?php dynamic_sidebar('sidebar-1'); ?>

        <?php if (is_shop() || is_product_category() || is_product_taxonomy()) : ?>
            <div class="tdi-widget tdi-filter-widget">
                <h3 class="tdi-widget-title"><?php _e('Filter Products', 'tdi-arms'); ?></h3>

                <!-- Platform Filter -->
                <div class="tdi-filter-group">
                    <h4><?php _e('Platform', 'tdi-arms'); ?></h4>
                    <?php
                    $platforms = get_terms(array(
                        'taxonomy' => 'product_platform',
                        'hide_empty' => true,
                    ));

                    if (!empty($platforms) && !is_wp_error($platforms)) :
                    ?>
                        <ul class="tdi-filter-list">
                            <?php foreach ($platforms as $platform) : ?>
                                <li class="tdi-filter-item">
                                    <label class="tdi-filter-label">
                                        <input type="checkbox" name="platform[]" value="<?php echo esc_attr($platform->slug); ?>">
                                        <span class="tdi-filter-checkbox"></span>
                                        <?php echo esc_html($platform->name); ?>
                                        <span class="tdi-filter-count">(<?php echo $platform->count; ?>)</span>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Tactical Use Filter -->
                <div class="tdi-filter-group">
                    <h4><?php _e('Tactical Use', 'tdi-arms'); ?></h4>
                    <?php
                    $uses = get_terms(array(
                        'taxonomy' => 'tactical_use',
                        'hide_empty' => true,
                    ));

                    if (!empty($uses) && !is_wp_error($uses)) :
                    ?>
                        <ul class="tdi-filter-list">
                            <?php foreach ($uses as $use) : ?>
                                <li class="tdi-filter-item">
                                    <label class="tdi-filter-label">
                                        <input type="checkbox" name="tactical_use[]" value="<?php echo esc_attr($use->slug); ?>">
                                        <span class="tdi-filter-checkbox"></span>
                                        <?php echo esc_html($use->name); ?>
                                        <span class="tdi-filter-count">(<?php echo $use->count; ?>)</span>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Price Filter -->
                <div class="tdi-filter-group">
                    <h4><?php _e('Price Range', 'tdi-arms'); ?></h4>
                    <div class="tdi-price-filter">
                        <div class="tdi-price-range">
                            <input type="number" name="min_price" placeholder="<?php esc_attr_e('Min', 'tdi-arms'); ?>" min="0">
                            <span><?php _e('to', 'tdi-arms'); ?></span>
                            <input type="number" name="max_price" placeholder="<?php esc_attr_e('Max', 'tdi-arms'); ?>" min="0">
                        </div>
                        <button type="button" class="tdi-btn tdi-btn-small tdi-filter-apply">
                            <?php _e('Apply', 'tdi-arms'); ?>
                        </button>
                    </div>
                </div>

                <!-- Attributes Filter -->
                <?php
                $attributes = wc_get_attribute_taxonomies();
                if (!empty($attributes)) :
                    foreach ($attributes as $attribute) :
                        $taxonomy = wc_attribute_taxonomy_name($attribute->attribute_name);
                        if (taxonomy_exists($taxonomy)) :
                            $terms = get_terms(array(
                                'taxonomy' => $taxonomy,
                                'hide_empty' => true,
                            ));

                            if (!empty($terms) && !is_wp_error($terms)) :
                ?>
                                <div class="tdi-filter-group">
                                    <h4><?php echo esc_html($attribute->attribute_label); ?></h4>
                                    <ul class="tdi-filter-list">
                                        <?php foreach ($terms as $term) : ?>
                                            <li class="tdi-filter-item">
                                                <label class="tdi-filter-label">
                                                    <input type="checkbox" name="<?php echo esc_attr($taxonomy); ?>[]" value="<?php echo esc_attr($term->slug); ?>">
                                                    <span class="tdi-filter-checkbox"></span>
                                                    <?php echo esc_html($term->name); ?>
                                                    <span class="tdi-filter-count">(<?php echo $term->count; ?>)</span>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                <?php
                            endif;
                        endif;
                    endforeach;
                endif;
                ?>

                <div class="tdi-filter-actions">
                    <button type="button" class="tdi-btn tdi-btn-small tdi-filter-clear">
                        <?php _e('Clear All', 'tdi-arms'); ?>
                    </button>
                </div>
            </div>

            <!-- Featured Products -->
            <div class="tdi-widget">
                <h3 class="tdi-widget-title"><?php _e('Featured Products', 'tdi-arms'); ?></h3>
                <?php
                $featured_args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 3,
                    'meta_query' => array(
                        array(
                            'key' => '_featured',
                            'value' => 'yes'
                        )
                    ),
                    'orderby' => 'rand',
                );

                $featured_query = new WP_Query($featured_args);

                if ($featured_query->have_posts()) :
                    echo '<div class="tdi-featured-sidebar-products">';
                    while ($featured_query->have_posts()) :
                        $featured_query->the_post();
                ?>
                        <div class="tdi-sidebar-product">
                            <div class="tdi-sidebar-product-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </a>
                            </div>
                            <div class="tdi-sidebar-product-info">
                                <h4 class="tdi-sidebar-product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
                                <div class="tdi-sidebar-product-price">
                                    <?php woocommerce_template_loop_price(); ?>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                    echo '</div>';
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <!-- Categories -->
            <div class="tdi-widget">
                <h3 class="tdi-widget-title"><?php _e('Product Categories', 'tdi-arms'); ?></h3>
                <?php
                $args = array(
                    'taxonomy' => 'product_cat',
                    'orderby' => 'name',
                    'show_count' => true,
                    'pad_counts' => true,
                    'hide_empty' => true,
                    'title_li' => '',
                    'echo' => false,
                );

                $product_categories = wp_list_categories($args);

                if (!empty($product_categories)) {
                    echo '<ul class="tdi-category-list">' . $product_categories . '</ul>';
                }
                ?>
            </div>

            <!-- Tactical Information -->
            <div class="tdi-widget tdi-info-widget">
                <h3 class="tdi-widget-title"><?php _e('Tactical Information', 'tdi-arms'); ?></h3>
                <div class="tdi-info-content">
                    <p><?php _e('All TDI Arms products are manufactured to ISO 9001:2015 standards and are battle-tested by military and law enforcement professionals worldwide.', 'tdi-arms'); ?></p>
                    <ul class="tdi-info-features">
                        <li><i class="fas fa-check"></i> <?php _e('Lifetime Warranty', 'tdi-arms'); ?></li>
                        <li><i class="fas fa-check"></i> <?php _e('Free Shipping Over $100', 'tdi-arms'); ?></li>
                        <li><i class="fas fa-check"></i> <?php _e('Expert Customer Support', 'tdi-arms'); ?></li>
                        <li><i class="fas fa-check"></i> <?php _e('30-Day Return Policy', 'tdi-arms'); ?></li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/warranty')); ?>" class="tdi-btn tdi-btn-small">
                        <?php _e('Learn More', 'tdi-arms'); ?>
                    </a>
                </div>
            </div>

        <?php endif; ?>

        <?php dynamic_sidebar('product-filters'); ?>
    </div>
</aside>