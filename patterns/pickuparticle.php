<?php
/**
 * Title: pickup
 * Slug: sintama/pickuparticle
 */

?>
<!-- wp:group -->
<h2 class="wp-block-heading has-text-align-center">Pickup記事</h2>  
    <div class="pickup-carousel-container">
		<div class="swiper my-pickup-swiper">
			<div class="swiper-wrapper">
				<?php
					$sticky_posts = get_option( 'sticky_posts' );// WordPressで「先頭に固定表示」にチェックを入れた投稿を取得する
					if ( ! empty( $sticky_posts ) ) {
						$pickup_query = new WP_Query( array(
							'posts_per_page'      => 8, 
							'post__in'            => $sticky_posts,
							'ignore_sticky_posts' => 1,
						) );
						if ( $pickup_query->have_posts() ) :
							while ( $pickup_query->have_posts() ) :
								$pickup_query->the_post();
								?>
								<div class="swiper-slide"> 
									<div class="article-container">
									<a href="<?php the_permalink(); ?>">
										 <span class="pickup-thumbnail">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'large' ); ?>
										<?php else : ?>
											 <?php
											$no_image_id = 80;
											$image_data = wp_get_attachment_image_src($no_image_id, 'full');											
											$image_url = $image_data[0];?>
											<img src="<?php echo esc_url($image_url); ?>" alt="No image">
										<?php endif; ?>
										</span>
										<span class="pickup-title"><?php the_title(); ?></span>
										<span class ="slide-day">
											day:<?php echo get_the_date('y/m/d') ?>
										</span>
									</a>
								    </div>
								</div>
								<?php
							endwhile;
						endif;
						wp_reset_postdata();
					}
					?>
		</div>		
	    </div>
		<div class="swiper-pagination"></div>
		<div class="swiper-button-prev"></div>
	    <div class="swiper-button-next"></div>
	</div>
	
<!-- /wp:group -->

  




