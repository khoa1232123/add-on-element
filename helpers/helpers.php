<?php 

if( ! function_exists( 'aoe_pagination' ) ) {
	function aoe_pagination(  $range = 2, $current_query = '', $pages = '', $prev_icon='Previous', $next_icon='Next' ) {
		$showitems = ($range * 2)+1;

		if( $current_query == '' ) {
			global $paged;
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}

		if( $pages == '' ) {
			if( $current_query == '' ) {
				global $wp_query;
				$pages = $wp_query->max_num_pages;
				if(!$pages) {
					$pages = 1;
				}
			} else {
				$pages = $current_query->max_num_pages;
			}
		}

		if(1 != $pages) { ?>
			<nav class="navigation pagination">
				<div class="nav-links">
					<ul class="page-numbers">
						<?php if ( $paged > 1 ) { ?>
							<li>
								<a class="prev page-numbers" href="<?php echo esc_url(get_pagenum_link($paged - 1)) ?>"><?php echo $prev_icon ?></a>
							</li>
						<?php }
						for ($i=1; $i <= $pages; $i++) {
							if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
								if ($paged == $i) { ?>
									<li>
										<span class="page-numbers current"><?php echo esc_html($i) ?></span>
									</li>
								<?php } else { ?>
									<li>
										<a href="<?php echo esc_url(get_pagenum_link($i)) ?>" class="page-numbers"><?php echo esc_html($i) ?></a>
									</li>
									<?php
								}
							}
						}
						if ($paged < $pages) { ?>
							<li>
								<a class="next page-numbers" href="<?php echo esc_url(get_pagenum_link($paged + 1)) ?>"><?php echo $next_icon?></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</nav>
			<?php
		}
	}
}
