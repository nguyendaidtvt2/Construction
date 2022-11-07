<?php
namespace Elementor;
use WP_Query;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Th_Shop extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'th-shop';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Shop', 'construction' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-pages';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'th-category' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'hello-world' ];
	}

	public function get_button_styles($key='button', $class="btn-class") {

		$this->add_control(
			$key.'_text', 
			[
				'label' => esc_html__( 'Text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			$key.'_align',
			[
				'label' => esc_html__( 'Alignment', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'construction' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'construction' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.'-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $key.'_typography',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->add_control(
			$key.'_icon',
			[
				'label' => esc_html__( 'Icon', 'construction' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_responsive_control(
			$key.'_size_icon',
			[
				'label' => esc_html__( 'Size icon', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			$key.'_icon_pos',
			[
				'label' => esc_html__( 'Icon position', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after-icon',
				'options' => [
					'after-text'   => esc_html__( 'After text', 'construction' ),
					'before-text'  => esc_html__( 'Before text', 'construction' ),
				],
				'condition' => [
					$key.'_text!' => '',
					$key.'_icon[value]!' => '',
				]
			]
		);

		$this->add_responsive_control(
			$key.'_spacing',
			[
				'label' => esc_html__( 'Space', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.'-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			$key.'_icon_spacing_left',
			[
				'label' => esc_html__( 'Icon Space left', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' i' => 'margin-left: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			$key.'_icon_spacing_right',
			[
				'label' => esc_html__( 'Icon Space right', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' i' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs( $key.'_effects' );

		$this->start_controls_tab( $key.'_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_control(
			$key.'_color',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $key.'_background',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->add_responsive_control(
			$key.'_padding',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( $key.'_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_control(
			$key.'_color_hover',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $key.'_background_hover',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .'.$class.':hover',
			]
		);

		$this->add_responsive_control(
			$key.'_padding_hover',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_shadow_hover',
				'selector' => '{{WRAPPER}} .'.$class.':hover',
			]
		);

		$this->add_control(
			$key.'_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}
	
	public function get_text_styles($key='text', $class="text-class") {
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $key.'_typography',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->start_controls_tabs( $key.'_effects' );

		$this->start_controls_tab( $key.'_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_control(
			$key.'_color',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( $key.'_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_control(
			$key.'_color_hover',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $key.'_shadow_hover',
				'selector' => '{{WRAPPER}} .'.$class.':hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}
	public function get_thumb_styles($key='thumb', $class="thumb-image") {
		$this->start_controls_tabs( $key.'_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_control(
			$key.'_opacity',
			[
				'label' => esc_html__( 'Opacity', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => $key.'_css_filters',
				'selector' => '{{WRAPPER}} .'.$class.' img',
			]
		);

		$this->add_control(
			$key.'_overlay',
			[
				'label' => esc_html__( 'Overlay', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class.' .product-thumb-link:before' => 'background-color: {{VALUE}}; opacity: 1; visibility: visible;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_control(
			$key.'_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => $key.'_css_filters_hover',
				'selector' => '{{WRAPPER}} .'.$class.':hover img',
			]
		);

		$this->add_control(
			$key.'_overlay_hover',
			[
				'label' => esc_html__( 'Overlay', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover .product-thumb-link:before' => 'background-color: {{VALUE}}; opacity: 1; visibility: visible;',
				],
			]
		);

		$this->add_control(
			$key.'_background_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' img' => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .'.$class.' .product-thumb-link::after' => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .'.$class.' .product-thumb-link' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			$key.'_hover_animation',
			[
				'label' 	=> esc_html__( 'Hover Animation', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'elth-post-grid',
				'options'   => [
					''					=> esc_html__( 'None', 'construction' ),
					'zoom-thumb'		=> esc_html__( 'Zoom', 'construction' ),
					'rotate-thumb'		=> esc_html__( 'Rotate', 'construction' ),
					'zoomout-thumb'		=> esc_html__( 'Zoom Out', 'construction'),
					'translate-thumb'	=> esc_html__( 'Translate', 'construction'),
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	public function get_slider_settings() {
		$this->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__( 'Slider', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'display' => 'elth-product-slider',
				]
			]
		);

		$this->add_responsive_control(
			'slider_items',
			[
				'label' => esc_html__( 'Items', 'construction' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 1,
				'condition' => [
					'slider_auto' => '',
				]
			]
		);

		$this->add_responsive_control(
			'slider_space',
			[
				'label' => esc_html__( 'Space(px)', 'construction' ),
				'description'	=> esc_html__( 'For example: 20', 'construction' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 200,
				'step' => 1,
				'default' => 0
			]
		);

		$this->add_control(
			'slider_column',
			[
				'label' => esc_html__( 'Columns', 'construction' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'slider_speed',
			[
				'label' => esc_html__( 'Speed(ms)', 'construction' ),
				'description'	=> esc_html__( 'For example: 3000 or 5000', 'construction' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 3000,
				'max' => 10000,
				'step' => 100,
			]
		);		

		$this->add_control(
			'slider_auto',
			[
				'label' => esc_html__( 'Auto width', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'slider_center',
			[
				'label' => esc_html__( 'Center', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'slider_loop',
			[
				'label' => esc_html__( 'Loop', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'slider_navigation',
			[
				'label' => esc_html__( 'Navigation', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'construction' ),
				'label_off' => esc_html__( 'Hide', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'slider_pagination',
			[
				'label' => esc_html__( 'Pagination', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'construction' ),
				'label_off' => esc_html__( 'Hide', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	public function get_box_image($key='box-key',$class="box-class") {
		$this->add_responsive_control(
			$key.'_padding',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
        );

        $this->add_responsive_control(
			$key.'_margin',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $key.'_border',
				'selectors' => [
					'{{WRAPPER}} .'.$class.' .product-thumb-link',
					'{{WRAPPER}} .'.$class.' .product-thumb-link::before',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			$key.'_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' .product-thumb-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .'.$class.' .product-thumb-link',
			]
		);
	}

	public function get_box_settings($key='box-key',$class="box-class") {

		$this->add_responsive_control(
			$key.'_padding_wrap',
			[
				'label' => esc_html__( 'Padding Column', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .list-col-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_responsive_control(
			$key.'_padding',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			$key.'_margin',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $key.'_background',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .'.$class,
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $key.'_border',
                'label' => esc_html__( 'Border', 'construction' ),
                'separator' => 'before',
				'selector' => '{{WRAPPER}} .'.$class,
			]
        );

        $this->add_responsive_control(
			$key.'_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);
	}

	public function get_slider_styles() {
		$this->start_controls_section(
			'section_style_slider_nav',
			[
				'label' => esc_html__( 'Slider Navigation', 'construction' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'display' => 'elth-product-slider',
					'slider_navigation' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'width_slider_nav',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height_slider_nav',
			[
				'label' => esc_html__( 'Height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .swiper-button-nav i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding_slider_nav',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin_slider_nav',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'slider_nav_effects' );

		$this->start_controls_tab( 'slider_nav_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_slider_nav',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .swiper-button-nav',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_slider_nav',
				'selector' => '{{WRAPPER}} .swiper-button-nav',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_slider_nav',
				'selector' => '{{WRAPPER}} .swiper-button-nav',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_radius_slider_nav',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'slider_nav_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_slider_nav_hover',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .swiper-button-nav:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_slider_nav_hover',
				'selector' => '{{WRAPPER}} .swiper-button-nav:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_slider_nav_hover',
				'selector' => '{{WRAPPER}} .swiper-button-nav:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_radius_slider_nav_hover',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();	

		$this->add_control(
			'separator_slider_nav',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'slider_icon_next',
			[
				'label' => esc_html__( 'Icon next', 'construction' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'la la-angle-right',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'slider_icon_prev',
			[
				'label' => esc_html__( 'Icon prev', 'construction' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'la la-angle-left',
					'library' => 'solid',
				],
			]
		);

		$this->add_responsive_control(
			'slider_icon_size',
			[
				'label' => esc_html__( 'Size icon', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_nav_space',
			[
				'label' => esc_html__( 'Space', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slider_pag',
			[
				'label' => esc_html__( 'Slider Pagination', 'construction' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'display' => 'elth-product-slider',
					'slider_pagination' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'width_slider_pag',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span' => 'width: {{SIZE}}{{UNIT}};',
				], 
			]
		);

		$this->add_responsive_control(
			'height_slider_pag',
			[
				'label' => esc_html__( 'Height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_bg_normal',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'background_pag_heading',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_slider_pag',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .swiper-pagination span',
			]
		);

		$this->add_control(
			'opacity_pag',
			[
				'label' => esc_html__( 'Opacity', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'separator_bg_active',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'background_pag_heading_active',
			[
				'label' => esc_html__( 'Active', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_slider_pag_active',
				'label' => esc_html__( 'Background', 'construction' ),
				'description'	=> esc_html__( 'Active status', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .swiper-pagination span.swiper-pagination-bullet-active',
			]
		);

		$this->add_control(
			'opacity_pag_active',
			[
				'label' => esc_html__( 'Opacity', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span.swiper-pagination-bullet-active' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'separator_shadow',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_slider_pag',
				'selector' => '{{WRAPPER}} .swiper-pagination span',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_slider_pag',
				'selector' => '{{WRAPPER}} .swiper-pagination span',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_radius_slider_pag',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_pag_space',
			[
				'label' => esc_html__( 'Space', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		// BEGIN TAB_CONTENT
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Layout', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'display',
			[
				'label' 	=> esc_html__( 'Display', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'elth-product-grid',
				'options'   => [
					'elth-product-grid'		=> esc_html__( 'Grid', 'construction' ),
					'elth-product-list'		=> esc_html__( 'List', 'construction' ),
				],
			]
		);

		$this->add_control(
			'item_thumbnail',
			[
				'label' => esc_html__( 'Thumbnail', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'item_title',
			[
				'label' => esc_html__( 'Title', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'item_quickview',
			[
				'label' => esc_html__( 'Quick View', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'item_label',
			[
				'label' => esc_html__( 'Label', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'item_price',
			[
				'label' => esc_html__( 'Price', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'item_rate',
			[
				'label' => esc_html__( 'Rate', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'item_button',
			[
				'label' => esc_html__( 'Button', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' 	=> esc_html__( 'Pagination', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''				=> esc_html__( 'None', 'construction' ),
					'pagination'	=> esc_html__( 'Pagination', 'construction' ),
					'load-more'		=> esc_html__( 'Load more', 'construction' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_posts',
			[
				'label' => esc_html__( 'Query', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Number', 'construction' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' 	=> esc_html__( 'Order by', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''		=> esc_html__( 'None', 'construction' ),
					'ID'		=> esc_html__( 'ID', 'construction' ),
					'author'	=> esc_html__( 'Author', 'construction' ),
					'title'		=> esc_html__( 'Title', 'construction' ),
					'name'		=> esc_html__( 'Name', 'construction' ),
					'date'		=> esc_html__( 'Date', 'construction' ),
					'modified'		=> esc_html__( 'Last Modified Date', 'construction' ),
					'parent'		=> esc_html__( 'Parent', 'construction' ),
					'post_views'		=> esc_html__( 'Post views', 'construction' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' 	=> esc_html__( 'Order', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'DESC',
				'options'   => [
					'DESC'		=> esc_html__( 'DESC', 'construction' ),
					'ASC'		=> esc_html__( 'ASC', 'construction' ),
				],
			]
		);

		$this->add_control(
			'cats', 
			[
				'label' => esc_html__( 'Categories', 'construction' ),
				'description' => esc_html__( 'Enter slug categories. The values separated by ",". Example cat-1,cat-2. Default will show all categories', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'cat-1,cat-2', 'construction' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_grid',
			[
				'label' => esc_html__( 'Grid', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);		

		$this->add_control(
			'item_style',
			[
				'label' 	=> esc_html__( 'Item style', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'style1',
				'options'   => [
					'style1'		=> esc_html__( 'Style 1 - default', 'construction' ),
					'style2'		=> esc_html__( 'Style 2', 'construction' ),
					'style3'		=> esc_html__( 'Style 3', 'construction' ),
					'style4'		=> esc_html__( 'Style 4', 'construction' ),
					'style5'		=> esc_html__( 'Style 5', 'construction' ),
					'style6'		=> esc_html__( 'Style 6', 'construction' ),
				],
			]
		);

		$this->add_responsive_control(
			'column',
			[
				'label' => esc_html__( 'Column', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 8,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
			]
		);

		$this->add_control(
			'grid_type',
			[
				'label' 	=> esc_html__( 'Grid type', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''				=> esc_html__( 'Default', 'construction' ),
					'grid-masonry'	=> esc_html__( 'Masonry', 'construction' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list',
			[
				'label' => esc_html__( 'List', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);		

		$this->add_control(
			'item_list_style',
			[
				'label' 	=> esc_html__( 'Item style', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'style1',
				'options'   => [
					'style1'		=> esc_html__( 'Style 1 - default', 'construction' ),
					'style2'		=> esc_html__( 'Style 2', 'construction' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_top_filter',
			[
				'label' => esc_html__( 'Top filter', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_top_filter',
			[
				'label' => esc_html__( 'Status', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_type',
			[
				'label' => esc_html__( 'Type', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_top_filter' => 'yes',
				]
			]
		);
		$this->add_control(
			'show_number',
			[
				'label' => esc_html__( 'Number', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_top_filter' => 'yes',
				]
			]
		);

		$this->add_control(
			'show_order',
			[
				'label' => esc_html__( 'Order', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_top_filter' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_filter',
			[
				'label' => esc_html__( 'Filter button', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'filter_show',
			[
				'label' => esc_html__( 'Status', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'filter_style',
			[
				'label' 	=> esc_html__( 'Style', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''					=> esc_html__( 'Style 1', 'construction' ),
					'filter-col'		=> esc_html__( 'Style 2', 'construction' ),
					'filter-col filter-col-list'	=> esc_html__( 'Style 3', 'construction' ),
				],
				'condition' => [
					'filter_show' => 'yes',
				]
			]
		);

		$this->add_control(
			'filter_column',
			[
				'label' 	=> esc_html__( 'Column', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'filter-4-col',
				'options'   => [
					'filter-2-col'				=> esc_html__( '2 Column', 'construction' ),
					'filter-3-col'				=> esc_html__( '3 Column', 'construction' ),
					'filter-4-col'				=> esc_html__( '4 Column', 'construction' ),
				],
				'condition' => [
					'filter_show' => 'yes',
					'filter_style' => ['filter-col','filter-col filter-col-list'],
				]
			]
		);

		$this->add_control(
			'filter_cats', 
			[
				'label' => esc_html__( 'Categories', 'construction' ),
				'description' => esc_html__( 'Enter slug categories. The values separated by ",". Example cat-1,cat-2', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'cat-1,cat-2', 'construction' ),
				'condition' => [
					'filter_show' => 'yes',
				]
			]
		);

		$this->add_control(
			'filter_price',
			[
				'label' => esc_html__( 'Price', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'filter_show' => 'yes',
				]
			]
		);

		$this->add_control(
			'filter_attr', 
			[
				'label' => esc_html__( 'Attributes', 'construction' ),
				'description' => esc_html__( 'Enter slug attributes. The values separated by ",". Example attribute-1,attribute-2', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'cat-1,cat-2', 'construction' ),
				'condition' => [
					'filter_show' => 'yes',
				]
			]
		);

		$this->end_controls_section();
		// END TAB_CONTENT

		// BEGIN TAB_STYLE

		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'Item', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_width',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' , 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.01,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-slider-view .item-product' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .product-grid-view .list-col-item' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->get_box_settings('item','item-product');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_thumbnail',
			[
				'label' => esc_html__( 'Thumbnail', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail_list', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);

		$this->get_thumb_styles('thumbnail','product-thumb');

		$this->get_box_image('thumbnail','product-thumb');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_info',
			[
				'label' => esc_html__( 'Info', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'info_align',
			[
				'label' => esc_html__( 'Alignment', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'construction' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'construction' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'construction' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .product-info' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->get_box_settings('info','product-info');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->get_text_styles('title','product-info .product-title a');

		$this->add_responsive_control(
			'title_space',
			[
				'label' => esc_html__( 'Space', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-info .product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__( 'Price', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_regular',
			[
				'label' => esc_html__( 'Regular', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'regular_typography',
				'selectors' => [
					'{{WRAPPER}} .product-price > span',
					'{{WRAPPER}} .product-price ins',
				]
			]
		);

		$this->add_control(
			'regular_color',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-price > span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .product-price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_sale',
			[
				'label' => esc_html__( 'Sale', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sale_typography',
				'selectors' => [
					'{{WRAPPER}} .product-price > del',
				]
			]
		);

		$this->add_control(
			'sale_color',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-price > del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_price',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'price_space',
			[
				'label' => esc_html__( 'Space', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-info .product-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'item_button' => 'yes',
				]
			]
		);

		$this->get_button_styles('button','addcart-link');

		$this->end_controls_section();

		// END TAB_STYLE
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();
		extract($settings);
		$view = str_replace('elth-product-', '', $display);
        if(!empty($css_class)) $el_class .= ' '.$css_class;
        $filter_show = '';
        $el_class = 'product-'.$view.'-view '.$grid_type.' filter-'.$filter_show;

		if(isset($column['size'])) $column = $column['size'];
		if(isset($column_tablet['size'])) $column_tablet = $column_tablet['size'];
		if(isset($column_mobile['size'])) $column_mobile = $column_mobile['size'];

		$this->add_render_attribute( 'elth-wrapper', 'class', 'elth-products-wrap js-content-wrap wrap-box '.$el_class );
		$this->add_render_attribute( 'elth-inner', 'class', 'js-content-main list-product-wrap row');
		$this->add_render_attribute( 'elth-item-grid', 'class', 'list-col-item list-'.esc_attr($column).'-item list-'.esc_attr($column_tablet).'-item-tablet list-'.esc_attr($column_mobile).'-item-mobile');
		$this->add_render_attribute( 'elth-item', 'class', 'item-product item-product-default');
		if ( $view == 'slider' ) {
			$this->add_render_attribute( 'elth-wrapper', 'class', 'elth-swiper-slider swiper-container' );
			$this->add_render_attribute( 'elth-wrapper', 'data-items', $slider_items );
			$this->add_render_attribute( 'elth-wrapper', 'data-items-tablet', $slider_items_tablet);
			$this->add_render_attribute( 'elth-wrapper', 'data-items-mobile', $slider_items_mobile );
			$this->add_render_attribute( 'elth-wrapper', 'data-space', $slider_space );
			$this->add_render_attribute( 'elth-wrapper', 'data-space-tablet', $slider_space_tablet );
			$this->add_render_attribute( 'elth-wrapper', 'data-space-mobile', $slider_space_mobile );
			$this->add_render_attribute( 'elth-wrapper', 'data-column', $slider_column );
			$this->add_render_attribute( 'elth-wrapper', 'data-auto', $slider_auto );
			$this->add_render_attribute( 'elth-wrapper', 'data-center', $slider_center );
			$this->add_render_attribute( 'elth-wrapper', 'data-loop', $slider_loop );
			$this->add_render_attribute( 'elth-wrapper', 'data-speed', $slider_speed );
			$this->add_render_attribute( 'elth-wrapper', 'data-navigation', $slider_navigation );
			$this->add_render_attribute( 'elth-wrapper', 'data-pagination', $slider_pagination );
			$this->add_render_attribute( 'elth-inner', 'class', 'swiper-wrapper' );
			$this->add_render_attribute( 'elth-item', 'class', 'swiper-slide' );
		}
		else{
			$this->add_render_attribute( 'elth-wrapper', 'data-column', $column );
			$this->add_render_attribute( 'elth-wrapper', 'data-column-tablet', $column_tablet );
			$this->add_render_attribute( 'elth-wrapper', 'data-column-mobile', $column_mobile );
		}
        if ( get_query_var( 'paged' ) ) $paged = get_query_var( 'paged' ); 
        elseif ( get_query_var( 'page' ) ) $paged = get_query_var( 'page' ); 
        else $paged = 1;
        $args = array(
            'post_type'         => 'product',
            'order'             => 'ASC',
            'posts_per_page'    => $number,
            'paged'             => $paged,
            );
        $attr_taxquery = array();
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        if(!empty($_chosen_attributes) && is_array($_chosen_attributes)){
            $attr_taxquery = array('relation ' => 'AND');
            foreach ($_chosen_attributes as $key => $value) {
                $attr_taxquery[] =  array(
                                    'taxonomy'      => $key,
                                    'terms'         => $value['terms'],
                                    'field'         => 'slug',
                                    'operator'      => 'IN'
                                );
            }            
        }
        if(isset( $_GET['product_cat'])) $cats = sanitize_text_field($_GET['product_cat']);
        if(!empty($cats)) {
            $cats = explode(",",$cats);
            $attr_taxquery[]=array(
                'taxonomy'=>'product_cat',
                'field'=>'slug',
                'terms'=> $cats
            );
        }
        if (!empty($attr_taxquery)){
            $attr_taxquery['relation'] = 'AND';
            $args['tax_query'] = $attr_taxquery;
        }
        $args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'slug',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',
            );
        if( isset( $_GET['min_price']) && isset( $_GET['max_price']) ){
            $min = sanitize_text_field($_GET['min_price']);
            $max = sanitize_text_field($_GET['max_price']);
            $args['post__in'] = th_filter_price($min,$max);
        }
        switch ($orderby) {
            case 'price' :
                $args['orderby']  = "meta_value_num ID";
                $args['order']    = 'ASC';
                $args['meta_key'] = '_price';
            break;

            case 'price-desc' :
                $args['orderby']  = "meta_value_num ID";
                $args['order']    = 'DESC';
                $args['meta_key'] = '_price';
            break;

            case 'popularity' :
                $args['meta_key'] = 'total_sales';                        
                $args['order']    = 'DESC';
            break;

            case 'rating' :
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby'] = 'meta_value_num';
                $args['order']    = 'DESC';
            break;

            case 'date':
                $args['orderby'] = 'date';
                $args['order']    = 'DESC';
                break;
            
            default:
                $args['orderby'] = 'menu_order title';
                break;
        }
        $product_query = new WP_Query($args);
        $count = 1;
        $count_query = $product_query->post_count;
        $max_page = $product_query->max_num_pages;

        $size = $thumbnail_size;
        $size_list = $thumbnail_list_size;
        if($size == 'custom' && isset($thumbnail_custom_dimension)) $size = array($thumbnail_custom_dimension['width'],$thumbnail_custom_dimension['height']);        
        if($size_list == 'custom' && isset($thumbnail_list_custom_dimension)) $size_list = array($thumbnail_list_custom_dimension['width'],$thumbnail_list_custom_dimension['height']);        
        $item_wrap = $this->get_render_attribute_string( 'elth-item-grid' );
        $item_inner = $this->get_render_attribute_string( 'elth-item' );
        $type_active = $view;
        if(isset($_GET['type']) && $_GET['type']) $type_active = sanitize_text_field($_GET['type']);
        $attr = array(
            'el_class'      => $el_class,
            'product_query' => $product_query,
            'count'         => $count,
            'count_query'   => $count_query,
            'max_page'      => $max_page,
            'args'          => $args,
            'column'        => $column,
            'view'       	=> $view,
            'type_active'   => $type_active,
            'settings'      => $settings,
            'size'      	=> $size,
            'size_list'     => $size_list,
            'item_wrap'		=> $item_wrap,
            'item_inner'	=> $item_inner,
            'wdata'			=> $this,
        );
        th_get_template_widget('shop/shop','',$attr,true);
        wp_reset_postdata();
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function content_template() {
		
	}
}