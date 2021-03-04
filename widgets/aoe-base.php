<?php
namespace Elementor;

use Elementor\Widget_Base;

abstract class AOE_Widget_Base extends Widget_Base {

    /**
     * Get categories
     *
     * @param string $filter_categories
     */
	protected function getAllCategories($taxonomy, $select = 1) {
		$data = array();

		$query = new \WP_Term_Query(array(
			'hide_empty' => true,
			'taxonomy'   => $taxonomy,
		));
		if ($select == 1) {
			$data['all'] = 'All';
		}

		if (! empty($query->terms)) {
			foreach ($query->terms as $cat) {
				$data[ $cat->slug ] = $cat->name;
			}
		}

		return $data;
	}

    /**
     * Get list Image sizes
     *
     * @return array image sizes
     */
    protected function getImgSizes()
    {
        global $_wp_additional_image_sizes;
        $output    = array();
        $imgs_size = get_intermediate_image_sizes();
        foreach ($imgs_size as $size) :
            if (in_array($size, array( 'thumbnail', 'medium', 'medium_large', 'large' ))) :
                $output[ $size ] = ucwords(str_replace(array( '_', ' - ' ), array(
                        ' ',
                        ' '
                    ), $size)) . ' (' . get_option("{$size}_size_w") . 'x' . get_option("{$size}_size_h") . ')'; elseif (isset($_wp_additional_image_sizes[ $size ])) :
                $output[ $size ] = ucwords(str_replace(array( '_', '-' ), array(
                        ' ',
                        ' '
                    ), $size)) . ' (' . $_wp_additional_image_sizes[ $size ]['width'] . 'x' . $_wp_additional_image_sizes[ $size ]['height'] . ')';
        endif;
        endforeach;
        $output['full'] = esc_html__('Full', 'add-on-element');

        return $output;
    }

}