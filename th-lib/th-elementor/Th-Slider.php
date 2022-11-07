<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Th_Slider extends Widget_Base {

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
		return 'th-slider';
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
		return esc_html__( 'Slider', 'construction' );
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
		return 'eicon-slides';
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

	public function get_all_pages($post_type = 'wpcf7_contact_form') {
		global $post;
        $post_temp = $post;
        $page_list = array(''=>esc_html__("--Select one--","construction"));
        if(is_admin()){
            $pages = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
            if(is_array($pages)){
                foreach ($pages as $page) {
                    $page_list[$page->ID] = $page->post_title;
                }
            }
        }
        $post = $post_temp;
        return $page_list;
	}

	public function get_slider_settings() {
		$this->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__( 'Slider', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
			'slider_middle',
			[
				'label' => esc_html__( 'Middle', 'construction' ),
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
			'slider_mousewheel',
			[
				'label' => esc_html__( 'Mousewheel', 'construction' ),
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

		$this->add_control(
			'slider_effects',
			[
				'label' 	=> esc_html__( 'Effects', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''		=> esc_html__( 'Default', 'construction' ),
					'fade'			=> esc_html__( 'Fade', 'construction' ),
					'coverflow'		=> esc_html__( 'Coverflow', 'construction' ),
					'flip'			=> esc_html__( 'Flip', 'construction' ),
					'cube'			=> esc_html__( 'cube', 'construction' ),
				],
			]
		);

		$this->end_controls_section();
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
					'{{WRAPPER}} .'.$class.' .adv-thumb-link:after' => 'background-color: {{VALUE}}; opacity: 1; visibility: visible;',
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
					'{{WRAPPER}} .'.$class.' img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => $key.'_css_filters_hover',
				'selector' => '{{WRAPPER}} .'.$class.' img:hover',
			]
		);

		$this->add_control(
			$key.'_overlay_hover',
			[
				'label' => esc_html__( 'Overlay', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover .adv-thumb-link:after' => 'background-color: {{VALUE}}; opacity: 1; visibility: visible;',
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
					'{{WRAPPER}} .'.$class.' .adv-thumb-link::after' => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .'.$class.' .adv-thumb-link' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			$key.'_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'construction' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	public function get_box_image($key='box-key',$class="box-class",$add = "") {
		if(empty($add)) $add = $this;
		$add->add_responsive_control(
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

        $add->add_responsive_control(
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

		$add->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $key.'_border',
				'selector' => '{{WRAPPER}} .'.$class.' .adv-thumb-link',
				'separator' => 'before',
			]
		);

		$add->add_responsive_control(
			$key.'_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' .adv-thumb-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$add->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .'.$class.' .adv-thumb-link',
			]
		);
	}

	public function get_text_styles($key='text', $class="text-class", $add="") {
		if(empty($add)) $add = $this;
		$add->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $key.'_typography',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$add->start_controls_tabs( $key.'_effects' );

		$add->start_controls_tab( $key.'_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$add->add_control(
			$key.'_color',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'color: {{VALUE}};',
				],
			]
		);

		$add->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$add->end_controls_tab();

		$add->start_controls_tab( $key.'_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$add->add_control(
			$key.'_color_hover',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$add->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $key.'_shadow_hover',
				'selector' => '{{WRAPPER}} .'.$class.':hover',
			]
		);

		$add->end_controls_tab();

		$add->end_controls_tabs();

		$add->add_responsive_control(
			$key.'_space',
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
					'{{WRAPPER}} .'.$class => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

	}

	public function get_text_styles2($key='text', $class="text-class", $add="") {
		if(empty($add)) $add = $this;
		$add->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $key.'_typography',
				'selector' => '{{WRAPPER}} '.$class,
			]
		);

		$add->start_controls_tabs( $key.'_effects' );

		$add->start_controls_tab( $key.'_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$add->add_control(
			$key.'_color',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} '.$class => 'color: {{VALUE}};',
				],
			]
		);

		$add->end_controls_tab();

		$add->start_controls_tab( $key.'_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$add->add_control(
			$key.'_color_hover',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} '.$class.':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$add->end_controls_tab();

		$add->end_controls_tabs();

		$add->add_responsive_control(
			$key.'_space',
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
					'{{WRAPPER}} '.$class => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

	}

	public function get_box_settings($key='box-key',$class="box-class",$add="") {
		if(empty($add)) $add = $this;
		$add->add_responsive_control(
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

        $add->add_responsive_control(
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

        $add->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $key.'_background',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .'.$class,
			]
        );

        $add->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $key.'_border',
                'label' => esc_html__( 'Border', 'construction' ),
                'separator' => 'before',
				'selector' => '{{WRAPPER}} .'.$class,
			]
        );

        $add->add_responsive_control(
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

		$add->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);
	}

	public function get_box_settings2($key='box-key',$class="box-class",$add="") {
		if(empty($add)) $add = $this;
		$add->add_responsive_control(
			$key.'_padding',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} '.$class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $add->add_responsive_control(
			$key.'_margin',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} '.$class => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $add->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $key.'_background',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} '.$class,
			]
        );

        $add->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $key.'_border',
                'label' => esc_html__( 'Border', 'construction' ),
                'separator' => 'before',
				'selector' => '{{WRAPPER}} '.$class,
			]
        );

        $add->add_responsive_control(
			$key.'_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} '.$class => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$add->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} '.$class,
			]
		);
	}

	public function get_slider_styles() {
		$this->start_controls_section(
			'section_style_slider_nav',
			[
				'label' => esc_html__( 'Slider Navigation', 'construction' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slider_nav_style',
			[
				'label' => esc_html__( 'Style', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'Default', 'construction' ),
					'slider-nav-style2'  => esc_html__( 'Style 2', 'construction' ),
					'slider-nav-style3'  => esc_html__( 'Style 3', 'construction' ),
				],
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

		$this->add_control(
			'nav_color',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav i' => 'color: {{VALUE}};',
				],
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

		$this->add_control(
			'nav_color_hover',
			[
				'label' => esc_html__( 'Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-nav:hover i' => 'color: {{VALUE}};',
				],
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
					'value' => 'las la-angle-right',
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
					'value' => 'las la-angle-left',
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
					'slider_pagination' => 'yes',
				]
			]
		);

		$this->add_control(
			'slider_pag_style',
			[
				'label' => esc_html__( 'Style', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'Default', 'construction' ),
					'slider-pag-style2'  => esc_html__( 'Style 2', 'construction' ),
					'slider-pag-style3'  => esc_html__( 'Style 3', 'construction' ),
					'slider-pag-style4'  => esc_html__( 'Style 4', 'construction' ),
				],
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
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'construction' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' 	=> esc_html__( 'Style', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''		=> esc_html__( 'Default', 'construction' ),
					'megacontent'		=> esc_html__( 'Mega content', 'construction' ),
				],
			]
		);

		$repeater_sliders = new Repeater();

		$repeater_sliders->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'construction' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater_sliders->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'include' => [],
				'default' => 'large',
			]
		);
		$repeater_sliders->add_control(
			'separator_title',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$repeater_sliders->add_control(
			'title', 
			[
				'label' => esc_html__( 'Title/name', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		$this->get_text_styles2('title','{{CURRENT_ITEM}} .item-title a',$repeater_sliders);		

		$repeater_sliders->add_control(
			'disable_mobile_title',
			[
				'label' => esc_html__( 'Hidden on mobile', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		$repeater_sliders->add_control(
			'separator_description',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$repeater_sliders->add_control(
			'description', 
			[
				'label' => esc_html__( 'Description/position', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		$this->get_text_styles2('description','{{CURRENT_ITEM}} .item-des',$repeater_sliders);
		$repeater_sliders->add_control(
			'disable_mobile_des',
			[
				'label' => esc_html__( 'Hidden on mobile', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		$repeater_sliders->add_control(
			'separator_content',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$repeater_sliders->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'construction' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => '',
				'placeholder' => esc_html__( 'Type your content here', 'construction' ),
			]
		);
		$this->get_text_styles2('content2','{{CURRENT_ITEM}} .item-content',$repeater_sliders);
		$repeater_sliders->add_control(
			'disable_mobile_content',
			[
				'label' => esc_html__( 'Hidden on mobile', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		$repeater_sliders->add_control(
			'separator_link',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$repeater_sliders->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'construction' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'construction' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);
		$repeater_sliders->add_control(
			'button_text', 
			[
				'label' => esc_html__( 'Button Text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => "",
				'placeholder' => esc_html__( 'Enter text' , 'construction' ),
				'label_block' => true,
			]
		);
		$repeater_sliders->add_control(
			'button_style',
			[
				'label' 	=> esc_html__( 'Button Style', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''		=> esc_html__( 'Default', 'construction' ),
					'style2'		=> esc_html__( 'Style 2', 'construction' ),
					'style3'		=> esc_html__( 'Style 3', 'construction' ),
				],
			]
		);
		$repeater_sliders->add_control(
			'disable_mobile_button',
			[
				'label' => esc_html__( 'Hidden on mobile', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		$repeater_sliders->add_control(
			'separator_info_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
		$repeater_sliders->add_responsive_control(
			'style_info',
			[
				'label' => esc_html__( 'Style Info', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'elth-info-inner',
				'options' => [
					'elth-info-inner' 		=> esc_html__( 'Inner', 'construction' ),
					'elth-info-outer' 		=> esc_html__( 'Outter', 'construction' ),
				],
			]
		);
		$repeater_sliders->add_responsive_control(
			'width_info',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$repeater_sliders->add_responsive_control(
			'height_info',
			[
				'label' => esc_html__( 'Height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$repeater_sliders->add_responsive_control(
			'align_info',
			[
				'label' => esc_html__( 'Alignment Info', 'construction' ),
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
					'{{WRAPPER}} {{CURRENT_ITEM}} .content-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$repeater_sliders->add_responsive_control(
			'pos_h_info',
			[
				'label' => esc_html__( 'Horizontal Info', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'inner-left' => [
						'title' => esc_html__( 'Left', 'construction' ),
						'icon' => 'eicon-text-align-left',
					],
					'inner-center' => [
						'title' => esc_html__( 'Center', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
					'inner-right' => [
						'title' => esc_html__( 'Right', 'construction' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$repeater_sliders->add_responsive_control(
			'pos_v_info',
			[
				'label' => esc_html__( 'Vertical Info', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'inner-top' => [
						'title' => esc_html__( 'Top', 'construction' ),
						'icon' => 'eicon-text-align-left',
					],
					'inner-middle' => [
						'title' => esc_html__( 'Middle', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
					'inner-bottom' => [
						'title' => esc_html__( 'Bottom', 'construction' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$repeater_sliders->add_responsive_control(
			'pos_info',
			[
				'label' => esc_html__( 'Position Info', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .content-wrap' => 'top: {{TOP}}{{UNIT}};right: {{RIGHT}}{{UNIT}};bottom: {{BOTTOM}}{{UNIT}};left: {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$this->get_box_settings2('content_box','{{CURRENT_ITEM}} .content-wrap',$repeater_sliders); 
		$repeater_sliders->add_control(
			'item_overlay_background',
			[
				'label' => esc_html__( 'Overlay background', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .image-wrap:before' => 'background-color: {{COLOR}}',
				],
			]
		); 

		$this->add_control(
			'list_sliders',
			[
				'label' => esc_html__( 'Add slide item', 'construction' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_sliders->get_controls(),
				'title_field' => '{{{title}}}',
				'condition' => [
					'style!' => 'megacontent',
				]
			]
		);

		$repeater_contents = new Repeater();

		$repeater_contents->add_control(
			'megapage',
			[
				'label' => esc_html__( 'Choose content', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => $this->get_all_pages('th_mega_item'),
			]
		);

		$this->add_control(
			'list_items',
			[
				'label' => esc_html__( 'Add mega item', 'construction' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_contents->get_controls(),
				'title_field' => esc_html__( 'Page ID: {{{megapage}}}', 'construction' ),
				'condition' => [
					'style' => 'megacontent',
				]
			]
		);

		$this->add_responsive_control(
			'align',
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
					'{{WRAPPER}} .swiper-container .wslider-item' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->get_slider_settings();

		$this->start_controls_section(
			'section_style_slider_box',
			[
				'label' => esc_html__( 'Slider box', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->get_box_settings('slider_box','swiper-wrapper');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style!' => 'megacontent',
				]
			]
		);

		$this->get_thumb_styles('image','image-wrap');

		$this->get_box_image('image','image-wrap');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style!' => 'megacontent',
				]
			]
		);

		$this->get_text_styles('title','item-title a');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_des',
			[
				'label' => esc_html__( 'Description', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style!' => 'megacontent',
				]
			]
		);

		$this->get_text_styles('des','item-des');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content text', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style!' => 'megacontent',
				]
			]
		);

		$this->get_text_styles('content','item-content');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content_box',
			[
				'label' => esc_html__( 'Content box', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style!' => 'megacontent',
				]
			]
		);

		$this->add_responsive_control(
			'style_info',
			[
				'label' => esc_html__( 'Style Info', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'elth-info-inner',
				'options' => [
					'elth-info-inner' 		=> esc_html__( 'Inner', 'construction' ),
					'elth-info-outer' 		=> esc_html__( 'Outter', 'construction' ),
				],
			]
		);
		$this->add_responsive_control(
			'width_info',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .content-wrap' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$this->add_responsive_control(
			'height_info',
			[
				'label' => esc_html__( 'Height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .content-wrap' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$this->add_responsive_control(
			'align_info',
			[
				'label' => esc_html__( 'Alignment Info', 'construction' ),
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
					'{{WRAPPER}} .content-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pos_h_info',
			[
				'label' => esc_html__( 'Horizontal Info', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'inner-left' => [
						'title' => esc_html__( 'Left', 'construction' ),
						'icon' => 'eicon-text-align-left',
					],
					'inner-center' => [
						'title' => esc_html__( 'Center', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
					'inner-right' => [
						'title' => esc_html__( 'Right', 'construction' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$this->add_responsive_control(
			'pos_v_info',
			[
				'label' => esc_html__( 'Vertical Info', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'inner-top' => [
						'title' => esc_html__( 'Top', 'construction' ),
						'icon' => 'eicon-text-align-left',
					],
					'inner-middle' => [
						'title' => esc_html__( 'Middle', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
					'inner-bottom' => [
						'title' => esc_html__( 'Bottom', 'construction' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$this->add_responsive_control(
			'pos_info',
			[
				'label' => esc_html__( 'Position Info', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .content-wrap' => 'top: {{TOP}}{{UNIT}};right: {{RIGHT}}{{UNIT}};bottom: {{BOTTOM}}{{UNIT}};left: {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'style_info' => 'elth-info-inner'
				]
			]
		);

		$this->get_box_settings('content_box','content-wrap');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_box',
			[
				'label' => esc_html__( 'Box item', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->get_box_settings('box','wslider-item');

		$this->end_controls_section();

		$this->get_slider_styles();
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
		$slider_items_tablet = $slider_items_mobile = $slider_items_laptop = $slider_items_tablet_extra = $slider_column = $slider_space_tablet = $slider_space_mobile = $slider_space_laptop = $slider_space_tablet_extra = '';
		extract($settings);
		$this->add_render_attribute( 'elth-wrapper', 'class', 'elth-swiper-slider swiper-container slider-wrap '.$style );
		if($slider_nav_style) $this->add_render_attribute( 'elth-wrapper', 'class', $slider_nav_style );
		if($slider_pag_style) $this->add_render_attribute( 'elth-wrapper', 'class', $slider_pag_style );
		if($slider_middle == 'yes') $this->add_render_attribute( 'elth-wrapper', 'class', 'slider-middle-item' );
		$this->add_render_attribute( 'info_attr', 'class', 'content-wrap elth-banner-info-content' );
		if($settings['style_info']) $this->add_render_attribute( 'info_attr', 'class', $settings['style_info'] );
		if($settings['pos_h_info']) $this->add_render_attribute( 'info_attr', 'class', $settings['pos_h_info'] );
		if($settings['pos_v_info']) $this->add_render_attribute( 'info_attr', 'class', $settings['pos_v_info'] );
		$this->add_render_attribute( 'elth-wrapper', 'data-items', $slider_items );
		$this->add_render_attribute( 'elth-wrapper', 'data-items-tablet', $slider_items_tablet);
		$this->add_render_attribute( 'elth-wrapper', 'data-items-mobile', $slider_items_mobile );
		$this->add_render_attribute( 'elth-wrapper', 'data-items-laptop', $slider_items_laptop );
		$this->add_render_attribute( 'elth-wrapper', 'data-items-extra_tablet', $slider_items_tablet_extra);
		$this->add_render_attribute( 'elth-wrapper', 'data-space', $slider_space );
		$this->add_render_attribute( 'elth-wrapper', 'data-space-tablet', $slider_space_tablet );
		$this->add_render_attribute( 'elth-wrapper', 'data-space-mobile', $slider_space_mobile );
		$this->add_render_attribute( 'elth-wrapper', 'data-space-laptop', $slider_space_laptop );
		$this->add_render_attribute( 'elth-wrapper', 'data-space-extra_tablet', $slider_space_tablet_extra);
		$this->add_render_attribute( 'elth-wrapper', 'data-column', $slider_column );
		$this->add_render_attribute( 'elth-wrapper', 'data-auto', $slider_auto );
		$this->add_render_attribute( 'elth-wrapper', 'data-center', $slider_center );
		$this->add_render_attribute( 'elth-wrapper', 'data-loop', $slider_loop );
		$this->add_render_attribute( 'elth-wrapper', 'data-speed', $slider_speed );
		$this->add_render_attribute( 'elth-wrapper', 'data-mousewheel', $slider_mousewheel );
		$this->add_render_attribute( 'elth-wrapper', 'data-navigation', $slider_navigation );
		$this->add_render_attribute( 'elth-wrapper', 'data-pagination', $slider_pagination );
		$this->add_render_attribute( 'elth-wrapper', 'data-effect', $slider_effects );
		$this->add_render_attribute( 'elth-inner', 'class', 'swiper-wrapper' );
		$this->add_render_attribute( 'elth-item', 'class', 'swiper-slide' );
		$attr = array(
			'wdata'		=> $this,
			'settings'	=> $settings,
		);
		echo th_get_template_widget('slider/slider',$settings['style'],$attr);
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