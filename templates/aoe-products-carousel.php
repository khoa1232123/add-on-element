<?php 
$catid = array();
if ($settings['cat']) {
	foreach ($settings['cat'] as $catslug) {
		$catid[] .= get_term_by( 'slug', $catslug, 'product_cat' )->term_id;
	}
}

$args = array(
	'post_type' => 'product',
	'post_status' => array('publish'),
	'orderby' => $settings['orderby'],
	'order'   => $settings['order'],
	'posts_per_page' => ($settings['posts_per_page'] > 0) ? $settings['posts_per_page'] : get_option('posts_per_page'),
);

if(!empty($catid)) {
	$args['tax_query'] = array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'id', 
			'terms'     => $catid
		)
	);
}
$css_class = 'products carousel-layout owl-carousel owl-theme';

$the_query = new WP_Query( $args );

if ($the_query->have_posts()){ ?>
	<div class="<?php echo esc_attr($css_class) ?>" <?php echo $settings['carousel_options']; ?>>
		<?php 
		while ($the_query->have_posts()) { 
			$the_query->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		?>
	</div>
	<?php 
}
