<?php 
$catid = array();
if ($settings['cat']) {
	foreach ($settings['cat'] as $catslug) {
		$catid[] .= get_term_by( 'slug', $catslug, 'product_cat' )->term_id;
	}
}

if ( is_front_page() ) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;   
} else {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
}

$args = array(
	'post_type' => 'product',
	'post_status' => array('publish'),
	'orderby' => $settings['orderby'],
	'order'   => $settings['order'],
	'posts_per_page' => ($settings['posts_per_page'] > 0) ? $settings['posts_per_page'] : get_option('posts_per_page'),
	'paged' => $paged
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
$css_class = 'products grid-layout';
$css_class .= ' grid-lg-'. $settings['col'] .' grid-md-'. $settings['col_tablet'] .' grid-'. $settings['col_mobile'];

$the_query = new WP_Query( $args );

if ($the_query->have_posts()){ ?>
	<ul class="<?php echo esc_attr($css_class) ?>">
		<?php 
		while ($the_query->have_posts()) { 
			$the_query->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		?>
	</ul>
	<?php 
	if ($settings['show_pagination']) {
		aoe_pagination(3, $the_query, '');
	}
}
