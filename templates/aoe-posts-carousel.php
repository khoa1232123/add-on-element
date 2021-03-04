<?php 
$args = array(
	'orderby' => $settings['orderby'],
	'order'   => $settings['order'],
	'posts_per_page' => ($settings['posts_per_page'] > 0) ? $settings['posts_per_page'] : get_option('posts_per_page')
);

$css_class = 'aoe-posts carousel-layout owl-carousel owl-theme';
$css_class_item = 'item';

if ($settings['cat']) {
	$catid = array();
	foreach ($settings['cat'] as $catslug) {
		$catid[] .= get_category_by_slug($catslug)->term_id;
	}
	if(!empty($catid)) {
		$args['category__in'] = $catid;
	}
}

$the_query = new WP_Query($args);

if ($the_query->have_posts()){ ?>
	<div class="<?php echo esc_attr($css_class) ?>" <?php echo $settings['carousel_options']; ?>>
		<?php 
		while ($the_query->have_posts()){
			$the_query->the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class($css_class_item); ?>>
				<header class="entry-header">
					<?php
					if ( has_post_thumbnail() ) {
						?>
						<div class="post-media">
							<?php the_post_thumbnail( $settings['image_size'] ); ?>
						</div>
						<?php 
					}
					if ($settings['show_date_post']) {
						echo sprintf( __( '<span class="posted-on">Posted on %s </span>', 'storefront' ), get_the_date() );
					}
					if ($settings['show_author_post']) {
						echo sprintf( 
							'<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>', 
							__( 'By', 'storefront' ), 
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), 
							esc_html( get_the_author() )
						);
					}
					the_title( 
						sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), 
						'</a></h2>' 
					);
					?>
				</header>
				<?php 
				if($settings['show_excerpt_post']) { ?>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
				<?php }
				if ($settings['show_read_more'] && $settings['text_read_more'] != '') {
					echo sprintf(
						'<a href="%1$s" class="readmore">%2$s</a>', 
						get_the_permalink(), 
						esc_html($settings['text_read_more'], 'add-on-element')
					);
				} ?>
			</article>
			<?php
		}
		?>
	</div>
	<?php
}
wp_reset_postdata();