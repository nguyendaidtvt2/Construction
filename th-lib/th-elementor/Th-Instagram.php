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
class Th_Instagram extends Widget_Base {

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
		return 'th-instagram';
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
		return esc_html__( 'Instagram', 'construction' );
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
		return 'eicon-instagram-gallery';
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
			'section_style',
			[
				'label' => esc_html__( 'Style', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'style',
			[
				'label' 	=> esc_html__( 'Style', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'elth-instagram-grid',
				'options'   => [
					'elth-instagram-grid'		=> esc_html__( 'Grid', 'construction' ),
					'elth-instagram-slider'	=> esc_html__( 'Slider', 'construction' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'media_from',
			[
				'label' 	=> esc_html__( 'Media from', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'username',
				'options'   => [
					'username'		=> esc_html__( 'Username', 'construction' ),
					'media-lib'		=> esc_html__( 'Media library', 'construction' ),
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'construction' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_control(
			'username', 
			[
				'label' => esc_html__( 'User name', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'condition' => [
					'media_from' => 'username',
				]
			]
		);

		$this->add_control(
			'token', 
			[
				'label' => esc_html__( 'Token', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'condition' => [
					'media_from' => 'username',
				]
			]
		);

		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Photos number', 'construction' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 50,
				'step' => 1,
				'default' => 6,
				'condition' => [
					'media_from' => 'username',
				]
			]
		);

		$this->add_control(
			'photos_size',
			[
				'label' 	=> esc_html__( 'Image size', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'0'		=> esc_html__( 'Small', 'construction' ),
					'1'		=> esc_html__( 'Medium', 'construction' ),
					'2'		=> esc_html__( 'Large', 'construction' ),
				],
				'condition' => [
					'media_from' => 'username',
				]
			]
		);

		$this->add_control(
			'text_hover', 
			[
				'label' => esc_html__( 'Text hover', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'condition' => [
					'media_from' => 'username',
				]
			]
		);

		$repeater_images = new Repeater();
		$repeater_images->add_control(
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
		$repeater_images->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'include' => [],
				'default' => 'large',
			]
		);			
		$repeater_images->add_control(
			'text_hover', 
			[
				'label' => esc_html__( 'Text hover', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater_images->add_control(
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

		$this->add_control(
			'list_images',
			[
				'label' => esc_html__( 'Add images', 'construction' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_images->get_controls(),
				'title_field' => esc_html__( 'Item', 'construction' ),
				'condition' => [
					'media_from' => 'media-lib',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__( 'Slider', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'style' => 'elth-instagram-slider',
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

		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'Item', 'construction' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_item',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' , '%'],
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
					'{{WRAPPER}} .elth-instagram .list-instagram li' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'item_effects' );

		$this->start_controls_tab( 'item_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_item',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_item',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_item',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'item_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_control(
			'color_icon',
			[
				'label' => esc_html__( 'Color icon', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li a .instagram-text-follow i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'size_icon',
			[
				'label' => esc_html__( 'Size icon', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li a .instagram-text-follow i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_hover_typography',
				'label' => esc_html__( 'Typography text hover', 'construction' ),
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li a .instagram-text-follow .text',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_item_hover',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_item_hover',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_item_hover',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_bg_item_hover',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'background_item_overlay_hover',
			[
				'label' => esc_html__( 'Background overlay', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_item_overlay',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li a .img-wrap:before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();	

		$this->add_control(
			'separator_padding_bf',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'padding_item',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'width_links',
			[
				'label' => esc_html__( 'Space', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' , '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li' => 'margin: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elth-instagram .list-instagram' => 'margin: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding_wrap_item',
			[
				'label' => esc_html__( 'Padding wrap', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'construction' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'image_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_image',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li img',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_image',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_image',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'image_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_image_hover',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li:hover img',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_image_hover',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li:hover img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_image_hover',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li:hover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .elth-instagram .list-instagram li:hover img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'padding_image',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin_icon',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-instagram .list-instagram li img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slider_nav',
			[
				'label' => esc_html__( 'Slider Navigation', 'construction' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => 'elth-instagram-slider',
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
					'style' => 'elth-instagram-slider',
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
		$this->add_render_attribute( 'elth-wrapper', 'class', 'elth-instagram' );
		$this->add_render_attribute( 'elth-inner', 'class', 'list-instagram' );
		if ( $settings['style'] == 'elth-instagram-slider' ) {
			$this->add_render_attribute( 'elth-wrapper', 'class', 'elth-swiper-slider swiper-container' );
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
		}
		?>
		<?php echo '<div '.$this->get_render_attribute_string( 'elth-wrapper' ).'>';?>
			<?php echo '<ul '.$this->get_render_attribute_string( 'elth-inner' ).'>';?>
		    	<?php 
		    	if($settings['hover_animation']) $animation_class = 'elementor-animation-'.$settings['hover_animation'];
		    	else $animation_class = '';
		    	if($settings['media_from'] == 'media-lib'){
			    	foreach (  $settings['list_images'] as $key => $item ) {
						$target = $item['link']['is_external'] ? ' target="_blank"' : '';
						$nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
						echo '<li '.$this->get_render_attribute_string( 'elth-item' ).'><a href="'.$item['link']['url'].'"'.$target.$nofollow.' class="elementor-repeater-item-'.$item['_id'].' '.esc_attr($animation_class).'">';
						echo '<div class="img-wrap '.esc_attr($animation_class).'">'.Group_Control_Image_Size::get_attachment_image_html( $settings['list_images'][$key], 'thumbnail', 'image' ).'</div>';
						echo '<span class="instagram-text-follow"><i class="fab fa-instagram"></i> ';
						if($item['text_hover']) echo '<span class="text">'.$item['text_hover'].'</span>';
						echo '</span>';
						echo '</a></li>';
					}
				}
				else{
					if(!empty($settings['username']) && function_exists('th_scrape_instagram')){
		                $media_array = th_scrape_instagram($settings['username'], $settings['number'], $settings['token'], $settings['photos_size']);
		                if(isset($media_array['photos'])) $media_array = $media_array['photos'];
		                if(!empty($media_array)){
		                    foreach ($media_array as $item) {
		                        if(isset($item['link']) && isset($item['thumbnail_src'])){
		                        	echo 	'<li '.$this->get_render_attribute_string( 'elth-item' ).'><a href="'.esc_url($item['link']).'" rel="nofollow">
					                        	<div class="img-wrap '.esc_attr($animation_class).'"><img src="'.esc_url($item['thumbnail_src']).'"/></div>
					                        	<span class="instagram-text-follow"><i class="fab fa-instagram"></i> ';
					                if($settings['text_hover']) echo '<span class="text">'.$settings['text_hover'].'</span>';        	
				                    echo 	'</a></li>';
		                        }
		                    }              
		                }
		            }
				}
		    	?>
		    </ul>
		    <?php if ( $settings['style'] == 'elth-instagram-slider' ):?>
			    <?php if ( $settings['slider_navigation'] == 'yes' ):?>
				    <div class="swiper-button-nav swiper-button-next"><?php Icons_Manager::render_icon( $settings['slider_icon_next'], [ 'aria-hidden' => 'true' ] );?></div>
					<div class="swiper-button-nav swiper-button-prev"><?php Icons_Manager::render_icon( $settings['slider_icon_prev'], [ 'aria-hidden' => 'true' ] );?></div>
				<?php endif?>
				<?php if ( $settings['slider_pagination'] == 'yes' ):?>
					<div class="swiper-pagination"></div>
				<?php endif?>
			<?php endif?>
		</div>
		<?php
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
