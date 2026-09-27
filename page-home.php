<?php

/**
 * Template Name: Home Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 * Good for landingpages and other types of pages where you want to add a lot of custom markup.
 *
 * @package justg
 */

get_header();
$container  = velocitytheme_option('justg_container_type', 'container');
$sliders = velocity_toko30_slider();
?>
<div class="wrapper mt-3 mt-md-0" id="page-wrapper">
    <div class="" id="content">
        <?php if ($sliders) : ?>
            <div id="carouselExampleInterval" class="carousel slide border" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($sliders as $i => $slider) : ?>
                        <div class="carousel-item<?php echo $i ? '' : ' active'; ?>" data-bs-interval="3000">
                            <img class="d-block w-100" src="<?php echo esc_url($slider); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($sliders) > 1) : ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="row mx-md-auto pt-3">
            <?php do_action('justg_before_content'); ?>
            <main class="site-main" id="main" role="main">
                <h3 class="title-single-part"><?php echo esc_html(trim(get_option('blogname') . '-' . get_option('blogdescription'), '-')); ?></h3>
                <div class="produk-home">
                    <?php
                    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
                    $produk_query = new WP_Query(array(
                        'posts_per_page' => 8,
                        'post_type' => 'store_product',
                        'paged' => $paged,
                    ));

                    if ($produk_query->have_posts()) :
                        velocity_toko30_grid_produk($produk_query);
                        echo '<div class="pagination pagi-home">';
                        echo paginate_links([
                            'total' => $produk_query->max_num_pages,
                            'current' => $paged,
                            'prev_text' => __('&laquo; Prev'),
                            'next_text' => __('Next &raquo;'),
                        ]);
                        echo '</div>';
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

                <!-- Artikel section -->
                <?php $args = array(
                    'posts_per_page' => 3,
                    'post_type' => 'post',
                    'cat' => (int) get_theme_mod('velocity_news', 0),
                    'ignore_sticky_posts' => true,
                );
                $wp_query = new WP_Query($args);
                if ($wp_query->have_posts()) : ?>
                    <div class="blog-home">
                        <?php if (get_theme_mod('velocity_judul_news', 'Info Terbaru') !== '') { ?>
                            <h3 class="title-single-part"><?php echo esc_html(get_theme_mod('velocity_judul_news', 'Info Terbaru')); ?></h3>
                        <?php } ?>
                        <div class="row mx-0">
                            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <article <?php post_class('row mx-0 border p-md-2 p-2 rounded mb-3'); ?> id="post-<?php the_ID(); ?>">
                                    <div class="col-md-2 p-md-2 p-0">
                                        <?php if (has_post_thumbnail()) { ?>
                                            <div class="ratio ratio-1x1">
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                                    <?php the_post_thumbnail('medium', array('class' => 'w-100 h-100 object-fit-cover')); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-10 p-md-2 py-2 px-0">
                                        <div class="judul-posts">
                                            <h6>
                                                <a class="colortheme text-uppercase" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                            </h6>
                                        </div>
                                        <div class="entry-content">
                                            <?php echo esc_html(wp_trim_words(get_the_content(), 30)); ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif;
                wp_reset_postdata(); ?>
            </main><!-- #main -->
            <?php do_action('justg_after_content'); ?>
        </div>
    </div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
