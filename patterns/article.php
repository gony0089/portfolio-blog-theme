<?php
/**
 * Title: article
 * Slug: sintama/article
 */

?>
<!-- wp:group -->
<div class="article-main-container">
<div class="article-sub-container">
  <div class="article-list"><h3>記事一覧</h3></div>

  <div class="article-category">
        <div class="category-box">
            <a href="<?php echo esc_url(home_url('/')); ?>" data-category-id="0">
                <span class="category_box_name">なし</span></a>
        </div>

        <?php 
        $beauty_cat_id = 19;
        $beauty_cat = get_category($beauty_cat_id);
        $beauty_cat_link = get_category_link($beauty_cat_id);
         ?>
        <div class="category-box">
            <a href="<?php echo esc_url( $beauty_cat_link); ?>" data-category-id="<?php echo $beauty_cat_id; ?>">
                <span class="category_box_name"><?php echo esc_html($beauty_cat->name); ?></span></a>
        </div>
        
        <?php 
        $thinking_cat_id = 20;
        $thinking_cat = get_category($thinking_cat_id);
        $thinking_cat_link = get_category_link($thinking_cat_id);
        ?>
        <div class="category-box">
            <a href="<?php echo esc_url($thinking_cat_link); ?>" data-category-id="<?php echo $thinking_cat_id; ?>">
                <span class="category_box_name"><?php echo esc_html($thinking_cat->name) ?></span></a>
        </div>
  </div>
</div>

<div class="article-list-container">
    <?php  
    $args = array(
        'posts_per_page' => 9,
        'orderby'       =>'date',
        'order'         =>'DESC',
        'ignore_sticky_posts' => 1,//固定表示優先解除
    );
    $the_query = new WP_Query($args);
    ?>
  <?php if ( $the_query->have_posts() ) : ?>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); // 投稿がある限り、1件ずつ取り出すループ ?>
            <article class="article-item">
                <a href="<?php the_permalink(); ?>" class="article-item__link">
                    <span class="article-item-thumbnail">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail('medium'); // アイキャッチ画像を中サイズで表示 ?>
                        <?php else: ?>
                            <?php
                                $no_image_id = 80;
                                $image_data = wp_get_attachment_image_src($no_image_id, 'full');											
                                $image_url = $image_data[0];
                            ?>
							<img src="<?php echo esc_url($image_url); ?>" alt="No image">
                        <?php endif; ?>
                        <span class="article-item-info">
                        <span class="article-item-title"><?php the_title(); ?></span>
                        <span class ="article-days">
                                            day:<?php echo get_the_date('y/m/d') ?>
                        </span>
                        </span>
                     </span>
                </a>
            </article>
        <?php endwhile;  ?>
    <?php else: ?>
        <p>記事が見つかりませんでした。</p>
    <?php endif;  ?>
</div>
    <button type="button" class="load-more-button">もっと見る</button>
</div>
<!-- /wp:group -->

