<?php
/**
 * Title: Sidebar
 * Slug: sintama/sidebar
 */

?>
<!-- wp:paragraph -->
 <div class="article-side-container">
    <h3 class="side-new-article">new article</h3>
    <?php 
    $args = array(
        'posts_per_page' => 4,
        'orderby' =>'date',
        'order' =>'DESC',
        'ignore_sticky_posts' => 1,
    );
    $the_query = new WP_Query($args); ?>

    <?php if ( $the_query->have_posts() ) :  ?>
        <?php while ($the_query->have_posts() ) : $the_query->the_post(); ?>
        <article class="article-item side-item">
            <a href="<?php the_permalink(); ?>" class="article-item__link">
                <span class="article-item-thumbnail side-img">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('medium'); ?>
                        <?php else: ?>
                            <?php 
                                $no_image_id = 80;
                                $image_data = wp_get_attachment_image_src($no_image_id,'full');
                                $image_url = $image_data[0]; ?>
                                <img src="<?php  echo esc_url($image_url); ?>" alt="no image">
                                <?php endif; ?>
                </span>
                 <span class="article-item-info">
                                    <span class="article-item-title side-title"><?php the_title(); ?></span>
                                    <span class ="article-days side-article-days">
                                        day:<?php echo get_the_date('y/m/d') ?></span>
                </span>
            </a>
        </article>
        <?php endwhile; ?>
         <?php else: ?>
            <p>記事が見つかりませんでした。</p>
          <?php endif;  ?>
          <?php wp_reset_postdata(); ?>
 </div>
<!-- /wp:paragraph -->