<?php
/**
 * Title: meta情報
 * Slug: sintama/hidden-written-by
 */

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"0.2em","margin":{"bottom":"var:preset|spacing|60"}}},"textColor":"accent-4","fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group has-accent-4-color has-text-color has-link-color has-small-font-size" style="margin-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph -->
	<p><?php esc_html_e( '投稿日:', 'twentytwentyfive' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:post-date {"format":"Y/m/d"} /-->
	<!-- wp:paragraph -->
	<p><?php esc_html_e( 'カテゴリ:', 'twentytwentyfive' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:post-terms {"term":"category","isLink":false,"style":{"typography":{"fontWeight":"600"}}} /-->
</div>
<!-- /wp:group -->