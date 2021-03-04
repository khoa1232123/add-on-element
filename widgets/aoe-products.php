<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\AOE_Widget_Base;
use Elementor\Plugin as ElementorPlugin;

class AOE_Products_Widget extends AOE_Widget_Base {

    public function get_name() {
        return  'aoe-products';
    }

    public function get_title() {
        return esc_html__( 'AOE Products', 'add-on-element' );
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return [ 'aoe-for-elementor' ];
    }

    public function _register_controls() {
        // Content Settings
        $this->start_controls_section(
            'content_settings',
            [
                'label' => __('Content Settings', 'add-on-element'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_responsive_control('col', [
            'label' => esc_html__('Columns', 'add-on-element'),
            'type' => Controls_Manager::NUMBER,
            'min' => '1',
            'max' => '6',
            'desktop_default' => '3',
            'tablet_default' =>  '2',
            'mobile_default' => '1',
            'description' => esc_html__('Columns post display per row. With grid layout, min column is 1, max is 6. Unlimited with carousel.', 'add-on-element'),
        ]);

        $this->add_control('cat', [
            'label' => esc_html__('Categories', 'add-on-element'),
            'type' => Controls_Manager::SELECT2,
            'default' => '',
            'multiple' => true,
            'description' => esc_html__('Select categories want display.', 'add-on-element'),
            'options' => $this->getAllCategories('product_cat', 0),
        ]);

        $this->add_control('orderby', [
            'label' => esc_html__('Order by', 'add-on-element'),
            'description' => esc_html__('', 'add-on-element'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date'       => esc_html__('Date', 'add-on-element'),
                'menu_order' => esc_html__('Menu order', 'add-on-element'),
                'title'      => esc_html__('Title', 'add-on-element'),
                'rand'       => esc_html__('Random', 'add-on-element'),
            ],
        ]);
        $this->add_control('order', [
            'label' => esc_html__('Order', 'add-on-element'),
            'description' => esc_html__('', 'add-on-element'),
            'type' => Controls_Manager::SELECT,
            'default' => 'desc',
            'options' => [
                'desc' => esc_html__('DESC', 'add-on-element'),
                'asc'  => esc_html__('ASC', 'add-on-element'),
            ],
        ]);
        $this->add_control('posts_per_page', [
            'label' => esc_html__('Number of items', 'add-on-element'),
            'type' => Controls_Manager::NUMBER,
            'default' => '3',
        ]);

        $this->add_control('show_pagination', [
            'label' => esc_html__('Show pagination', 'add-on-element'),
            'description' => esc_html__('', 'add-on-element'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'false',
            'default' => 'false',
        ]);
        
        $this->end_controls_section();

        $this->start_controls_section('product_item_style', [
            'label' => esc_html__('Product Item', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control(
            'product_item_padding',
            [
                'label'         => esc_html__('Product Item Padding', 'add-on-element'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .products .product'  => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_control('product_item_space', [
            'label' => esc_html__('Space', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .products .product' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('image_style', [
            'label' => esc_html__('Image', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('image_space', [
            'label' => esc_html__('Space', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .product img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('title_style', [
            'label' => esc_html__('Title', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('title_color', [
            'label' => esc_html__('Color', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product .woocommerce-loop-product__title' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('title_color_hv', [
            'label' => esc_html__('Color Hover', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product .woocommerce-loop-product__title:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .product .woocommerce-loop-product__title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('title_space', [
            'label' => esc_html__('Space', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .product .woocommerce-loop-product__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('price_style', [
            'label' => esc_html__('Price', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('price_color', [
            'label' => esc_html__('Color', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product .price' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .product .price',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('price_space', [
            'label' => esc_html__('Space', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .product .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('add_to_cart_style', [
            'label' => esc_html__('Cart', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('add_to_cart_color', [
            'label' => esc_html__('Text', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product .button' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('add_to_cart_color_btn', [
            'label' => esc_html__('Text hover', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product .button' => 'background-color: {{VALUE}};'
            ]
        ]);
        $this->add_control('add_to_cart_color_hv', [
            'label' => esc_html__('Text', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product .button:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('add_to_cart_color_btn_hv', [
            'label' => esc_html__('Text hover', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product .button:hover' => 'background-color: {{VALUE}};'
            ]
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'add_to_cart_typography',
                'selector' => '{{WRAPPER}} .product .button',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->end_controls_section();
    }

    private function style_tab() {}

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        include AOE_PLUGIN_PATH . '/templates/aoe-products.php';
    }

    protected function _content_template() {
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new AOE_Products_Widget() );
