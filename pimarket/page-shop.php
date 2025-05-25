<?php
/*
Template Name: Shop Page
*/

get_header(); ?>

<main>
    <div id="content">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1><?php the_title(); ?></h1>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        endif;
        ?>
        <div class="shop-products">
            <h2>Products</h2>
            <?php
            $args = array(
                'post_type' => 'product',
                'post_parent' => get_the_ID(),
                'posts_per_page' => -1,
            );
            $products = new WP_Query($args);
            if ($products->have_posts()) :
                while ($products->have_posts()) : $products->the_post();
                    ?>
                    <div class="product-item">
                        <h3><?php the_title(); ?></h3>
                        <div class="product-description">
                            <?php the_content(); ?>
                        </div>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="product-image">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="product-price">
                            <?php echo get_post_meta(get_the_ID(), '_product_price', true); ?> лв.
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No products found</p>';
            endif;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
