<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\AOE_Widget_Base;
use Elementor\Plugin as ElementorPlugin;

class AOE_Posts_Carousel_Widget extends AOE_Widget_Base {

    public function get_name() {
        return  'aoe-posts-carousel';
    }

    public function get_title() {
        return esc_html__( 'AOE Posts Carousel', 'add-on-element' );
    }

    public function get_script_depends() {
        return [
            'aoe-script'
        ];
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_categories() {
        return [ 'aoe-for-elementor' ];
    }

    public function _register_controls() {
        // Content Settings
        $this->start_controls_section(
            'content_settings',
            [
                'label' => __( 'Content Settings', 'add-on-element' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control('cat', [
            'label' => esc_html__('Categories', 'add-on-element'),
            'type' => Controls_Manager::SELECT2,
            'default' => '',
            'multiple' => 'true',
            'description' => esc_html__('Select categories want display.', 'add-on-element'),
            'options' => $this->getAllCategories('category', 0),
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

        $this->add_control('image_size', [
            'label' => esc_html__('Image size', 'add-on-element'),
            'type' => Controls_Manager::SELECT,
            'default' => 'medium',
            'options' => $this->getImgSizes(),
            'description' => esc_html__('Select image size fit to layout you want use.', 'add-on-element'),
        ]);

        $this->add_control('show_date_post', [
            'label' => esc_html__('Show date post', 'add-on-element'),
            'description' => esc_html__('', 'add-on-element'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->add_control('show_author_post', [
            'label' => esc_html__('Show author post', 'add-on-element'),
            'description' => esc_html__('', 'add-on-element'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->add_control('show_excerpt_post', [
            'label' => esc_html__('Show excerpt post', 'add-on-element'),
            'description' => esc_html__('', 'add-on-element'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->add_control('show_read_more', [
            'label' => esc_html__('Show read more', 'add-on-element'),
            'description' => esc_html__('', 'add-on-element'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->add_control('text_read_more', [
            'label' => esc_html__('Text read more', 'add-on-element'),
            'description' => esc_html__('', 'add-on-element'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Read more',
            'condition' => [
                'show_read_more' => 'true'
            ],
        ]);

        $this->end_controls_section();
        
        $this->start_controls_section(
            'content_settings',
            [
                'label' => __( 'Carousel Settings', 'add-on-element' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_responsive_control('show_items', [
            'label' => esc_html__('Show items', 'add-on-element'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 6,
            'desktop_default' => 4,
            'tablet_default' =>  2,
            'mobile_default' => 1,
            'description' => esc_html__('The number of items displayed.', 'add-on-element'),
        ]);
        
        $this->add_control('loop', [
            'label' => __( 'Loop', 'add-on-element' ),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'true',
            'default' => 'true',
        ]);
        $this->add_control('dots',[
            'label' => __( 'Dots', 'add-on-element' ),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->add_control('navs', [
            'label' => __( 'Navs', 'add-on-element' ),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->add_control('margin', [
            'label' => __( 'Margin', 'add-on-element' ),
            'type' => Controls_Manager::NUMBER,
            'default' => 10,
            'placeholder' => __( 'Enter the margin between to slides', 'add-on-element' ),
        ]);

        $this->add_control('autoplay', [
            'label' => __( 'Autoplay', 'add-on-element' ),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'add-on-element' ),
            'label_off' => __( 'Hide', 'add-on-element' ),
            'return_value' => 'true',
            'default' => 'true',
        ]);

        $this->add_control('autoplaytimeout', [
            'label' => __( 'AutoplayTimeout', 'add-on-element' ),
            'type' => Controls_Manager::NUMBER,
            'description' => esc_html__('Unit in seconds.', 'add-on-element'),
            'min' => 1,
            'default' => 3,
            'placeholder' => __( 'Enter the margin between to slides', 'add-on-element' ),
            'condition' => [
                'autoplay' => 'true'
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('post_item_style', [
            'label' => esc_html__('Post Item', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control(
            'post_item_padding',
            [
                'label'         => esc_html__('Post Item Padding', 'add-on-element'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .post-item'  => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_control('post_item_space', [
            'label' => esc_html__('Space', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .post-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .post-media img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .post-item .entry-title a' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('title_color_hv', [
            'label' => esc_html__('Color Hover', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-item .entry-title a:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .post-item .entry-title a',
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
                '{{WRAPPER}} .post-item .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('excerpt_style', [
            'label' => esc_html__('Excerpt', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('excerpt_color', [
            'label' => esc_html__('Color', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-item .entry-content' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .post-item .entry-content',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('excerpt_space', [
            'label' => esc_html__('Space', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .post-item .entry-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('meta_style', [
            'label' => esc_html__('Meta', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('meta_color', [
            'label' => esc_html__('Text', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .posted-on, {{WRAPPER}} .post-author' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('meta_color_link', [
            'label' => esc_html__('Link', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .posted-on a, {{WRAPPER}} .post-author a' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('meta_color_link_hv', [
            'label' => esc_html__('Link Hover', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .posted-on a:hover, {{WRAPPER}} .post-author a:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('meta_space', [
            'label' => esc_html__('Space', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .posted-on, {{WRAPPER}} .post-author' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('readmore_style', [
            'label' => esc_html__('Read more', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('readmore_color', [
            'label' => esc_html__('Color', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-item a.readmore' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('readmore_color_hv', [
            'label' => esc_html__('Color Hover', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-item a.readmore:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'readmore_typography',
                'selector' => '{{WRAPPER}} .post-item a.readmore',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section('navs_dots_style', [
            'label' => esc_html__('Navs and dots', 'add-on-element'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('navs_heading', [
            'label' => esc_html__('Navigations', 'add-on-element'),
            'type' => Controls_Manager::HEADING,
        ]);
        $this->start_controls_tabs('navs_color_tabs');

        $this->start_controls_tab(
            'readmore_color_normal_tab',
            [
                'label'         => esc_html__('Normal', 'add-on-element'),
            ]
        );

        $this->add_control('navs_color', [
            'label' => esc_html__('Color', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-nav button' => 'color: {{VALUE}};'
            ]
        ]);

        $this->add_control('navs_background', [
            'label' => esc_html__('Background', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-nav button' => 'background: {{VALUE}};'
            ]
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab( 'navs_color_hv_tab', [
            'label' => esc_html__('Hover', 'add-on-element'),
        ]);

        $this->add_control('navs_color_hv', [
            'label' => esc_html__('Color', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-nav button:hover' => 'color: {{VALUE}};'
            ]
        ]);

        $this->add_control('navs_background_hv', [
            'label' => esc_html__('Background', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-nav button:hover' => 'background: {{VALUE}};'
            ]
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control('navs_size', [
            'label' => esc_html__('Size', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .owl-nav button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('navs_font_size', [
            'label' => esc_html__('Font size', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .owl-nav button' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('dots_heading', [
            'label' => esc_html__('Dots', 'add-on-element'),
            'type' => Controls_Manager::HEADING,
            'separator'   => 'before',
        ]);
        $this->add_control('dots_color', [
            'label' => esc_html__('Color', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-dots button span' => 'background: {{VALUE}};'
            ]
        ]);

        $this->add_control('dots_color_hv', [
            'label' => esc_html__('Color hover', 'add-on-element'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .owl-dots button:hover span, {{WRAPPER}} .owl-dots button.active span' => 'background: {{VALUE}};'
            ]
        ]);

        $this->add_control('dots_size', [
            'label' => esc_html__('Size', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .owl-dots button span' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('dots_space', [
            'label' => esc_html__('Space', 'add-on-element'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .owl-dots button span' => 'margin: {{SIZE}}{{UNIT}};',
            ],
        ]);
        
        $this->end_controls_section();
    }

    private function style_tab() {}

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute(
            'carousel_options',
            [
                'id'          => 'post-carousel-' . $this->get_id(),
                'data-loop'   => $settings[ 'loop' ],
                'data-dots'   => $settings[ 'dots' ],
                'data-navs'   => $settings[ 'navs' ],
                'data-margin' => $settings[ 'margin' ],
                'data-autoplay' => $settings['autoplay'],
                'data-autoplaytimeout' => $settings['autoplaytimeout'],
                'data-showitems' => $settings['show_items'],
                'data-showitemstablet' => $settings['show_items_tablet'],
                'data-showitemsmobile' => $settings['show_items_mobile'],
            ]
        );
        $settings['carousel_options'] = $this->get_render_attribute_string( 'carousel_options' );
        include AOE_PLUGIN_PATH . '/templates/aoe-posts-carousel.php';
    }

    protected function _content_template() {}

}

Plugin::instance()->widgets_manager->register_widget_type( new AOE_Posts_Carousel_Widget() );