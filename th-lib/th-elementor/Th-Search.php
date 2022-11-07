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
class Th_Search extends Widget_Base {

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
		return 'th-search';
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
		return esc_html__( 'Search form', 'construction' );
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
		return 'eicon-search';
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
				'default'   => 'elth-search-default',
				'options'   => [
					'elth-search-default'		=> esc_html__( 'Default', 'construction' ),
					'elth-search-icon'  		=> esc_html__( 'Icon', 'construction' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_button',
			[
				'label' => esc_html__( 'Search button', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'construction' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'la la-search',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'search_bttext',
			[
				'label' => esc_html__( 'Add text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type your text to add search button', 'construction' ),
			]
		);

		$this->add_control(
			'search_bttext_pos',
			[
				'label' => esc_html__( 'Text position', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after-icon',
				'options' => [
					'after-icon'   => esc_html__( 'After icon', 'construction' ),
					'before-icon'  => esc_html__( 'Before icon', 'construction' ),
				],
				'condition' => [
					'search_bttext!' => '',
					'icon[value]!' => '',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form',
			[
				'label' => esc_html__( 'Form', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'placeholder',
			[
				'label' => esc_html__( 'Placeholder', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Enter key to search', 'construction' ),
				'placeholder' => esc_html__( 'Type your placeholder here', 'construction' ),
			]
		);
		$this->add_control(
			'search_in',
			[
				'label'		=> esc_html__( 'Search in', 'construction' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'product',
				'options'   => [
					'product'  => esc_html__( 'Product', 'construction' ),
					'post'     => esc_html__( 'Post', 'construction' ),
					'all'      => esc_html__( 'All', 'construction' ),
				],
			]
		);
		$this->add_control(
			'show_cat',
			[
				'label' => esc_html__( 'Show choose category', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'construction' ),
				'label_off' => esc_html__( 'Hide', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'search_in!' => 'all'
				]
			]
		);
		$this->add_control(
			'cats', 
			[
				'label' => esc_html__( 'Categories', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter slug categories. The values separated by ",". Example cat-1,cat-2. Default will show all categories', 'construction' ),
				'condition' => [
					'show_cat' => 'yes'
				]
			]
		);
		$this->add_control(
			'live_search',
			[
				'label' => esc_html__( 'Live search', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_popup',
			[
				'label' => esc_html__( 'Icon - popup', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon_popup',
			[
				'label' => esc_html__( 'Icon', 'construction' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'la la-search',
					'library' => 'solid',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_search_button',
			[
				'label' => esc_html__( 'Search button', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_icon',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-search-form input[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .search-icon-popup' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);	

		$this->add_responsive_control(
			'height_icon',
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
					'{{WRAPPER}} .search-icon-popup' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .search-icon-popup' => 'line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elth-search-form input[type="submit"]' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elth-search-form .elth-text-bt-search > *' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .elth-search-form .elth-text-bt-search > i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_begin_tabs',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'search_button_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elth-search-form .elth-text-bt-search > i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'search_text_button_typography',
				'label' => esc_html__( 'Typography button text', 'construction' ),
				'selector' => '{{WRAPPER}} .elth-search-form .elth-text-bt-search > span',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_icon',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-search-form input[type="submit"]',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => esc_html__( 'Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elth-search-form .elth-submit-form:hover .elth-text-bt-search > i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'search_text_button_typography_hover',
				'label' => esc_html__( 'Typography button text', 'construction' ),
				'selector' => '{{WRAPPER}} .elth-search-form .elth-submit-form:hover .elth-text-bt-search > span',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_icon_hover',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-search-form input[type="submit"]:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->add_control(
			'separator_end_tabs',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'padding_icon',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elth-search-form input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .search-icon-popup' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elth-search-form input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'icon_border',
				'selector'  => '{{WRAPPER}} .elth-search-form input[type="submit"]',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elth-search-form input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_form',
			[
				'label' => esc_html__( 'Form', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_form',
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
					'{{WRAPPER}} .elth-search-form' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height_form',
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
					'{{WRAPPER}} .elth-search-form' => 'line-height: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'align_form',
			[
				'label' => esc_html__( 'Alignment', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'default'	=> '',
				'options' => [
					'form-left' => [
						'title' => esc_html__( 'Left', 'construction' ),
						'icon' => 'eicon-text-align-left',
					],
					'form-center' => [
						'title' => esc_html__( 'Center', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
					'form-right' => [
						'title' => esc_html__( 'Right', 'construction' ),
						'icon' => 'eicon-text-align-right',
					],
				],
			]
		);

		$this->add_responsive_control(
			'padding_form',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin_form',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-search-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_form',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-search-form',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_form',
				'selector' => '{{WRAPPER}} .elth-search-form',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_form_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-search-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'form_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-search-form',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_cat',
			[
				'label' => esc_html__( 'Categories dropdown', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_cat',
			[
				'label' => esc_html__( 'Title', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'All categories', 'construction' ),
				'placeholder' => esc_html__( 'Type your title here', 'construction' ),
			]
		);

		$this->add_control(
			'title_cat_color',
			[
				'label' => esc_html__( 'Title Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elth-dropdown-box .current-search-cat' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'width_cat',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-dropdown-box' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding_cat',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-dropdown-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin_cat',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-dropdown-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_cat',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-dropdown-box',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_cat',
				'selector' => '{{WRAPPER}} .elth-dropdown-box',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_cat_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-dropdown-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon_popup',
			[
				'label' => esc_html__( 'Icon - popup', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_icon_popup',
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
					'{{WRAPPER}} .elth-search-icon' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height_icon_popup',
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
					'{{WRAPPER}} .elth-search-icon' => 'line-height: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'size_icon_popup',
			[
				'label' => esc_html__( 'Size icon', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_popup_effects' );

		$this->start_controls_tab( 'icon_popup_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_control(
			'color_icon_popup',
			[
				'label' => esc_html__( 'Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_icon_popup',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .search-icon-popup',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_icon_popup',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .search-icon-popup',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_icon_popup',
				'selector' => '{{WRAPPER}} .search-icon-popup',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_icon_popup',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'icon_popup_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_control(
			'color_icon_popup_hover',
			[
				'label' => esc_html__( 'Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup:hover i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_icon_popup_hover',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .search-icon-popup:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_icon_popup_hover',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .search-icon-popup:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_icon_popup_hover',
				'selector' => '{{WRAPPER}} .search-icon-popup:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_icon_popup_hover',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();	

		$this->add_control(
			'separator_icon_popup',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'padding_icon_popup',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin_icon_popup',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon-popup' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_bg_popup',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'background_search_popup_heading',
			[
				'label' => esc_html__( 'Background popup', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_search_popup',
				'label' => esc_html__( 'Background popup', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-search-icon .elth-search-form-wrap',
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
		?>
		<div class="elth-search-wrap <?php echo esc_attr($settings['style'].' live-search-'.$settings['live_search'])?>">
			<?php if($settings['style'] == 'elth-search-icon'):?>
				<div class="search-icon-popup">
					<?php Icons_Manager::render_icon( $settings['icon_popup'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php endif;?>
			<div class="elth-search-form-wrap">
				<i class="la la-times elth-close-search-form"></i>
				<form class="elth-search-form <?php echo esc_attr($settings['align_form'])?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			        <?php if($settings['show_cat'] == 'yes' && $settings['search_in'] != 'all'):?>
			            <div class="elth-dropdown-box">
			                <span class="dropdown-link current-search-cat">
			                	<?php echo esc_html($settings['title_cat'])?>
			                	<i class="la la-angle-down"></i>		                		
			                </span>
			                <ul class="list-none elth-dropdown-list">
			                    <li class="active"><a class="select-cat-search" href="#" data-filter=""><?php echo esc_html($settings['title_cat'])?></a></li>
			                    <?php
			                        $taxonomy = 'category';
			                        $tax_key = 'category_name';
			                        if($settings['search_in'] == 'product') $taxonomy = $tax_key = 'product_cat';
			                        if(!empty($cats)){
			                            $custom_list = explode(",",$cats);
			                            foreach ($custom_list as $key => $cat) {
			                                $term = get_term_by( 'slug',$cat, $taxonomy );
			                                if(!empty($term) && is_object($term)){
			                                    if(!empty($term) && is_object($term)){
			                                        echo '<li><a class="select-cat-search" href="#" data-filter="'.$term->slug.'">'.$term->name.'</a></li>';
			                                    }
			                                }
			                            }
			                        }
			                        else{
			                            $product_cat_list = get_terms($taxonomy);
			                            if(is_array($product_cat_list) && !empty($product_cat_list)){
			                                foreach ($product_cat_list as $cat) {
			                                    echo '<li><a class="select-cat-search" href="#" data-filter="'.$cat->slug.'">'.$cat->name.'</a></li>';
			                                }
			                            }
			                        }
			                    ?>
			                </ul>
			            </div>
			            <input class="cat-value" type="hidden" name="<?php echo esc_attr($tax_key)?>" value="" />
			        <?php endif;?>
			        <input name="s" onblur="if (this.value=='') this.value = this.defaultValue" onfocus="if (this.value==this.defaultValue) this.value = ''" value="<?php echo esc_attr($settings['placeholder']);?>" type="text" autocomplete="off">
			        <?php if($settings['search_in'] != 'all'):?>
			            <input type="hidden" name="post_type" value="<?php echo esc_attr($settings['search_in'])?>" />
			        <?php endif;?>
			        <div class="elth-submit-form">
			            <input type="submit" value="">
			            <span class="elth-text-bt-search">
			            	<?php if($settings['search_bttext'] && $settings['search_bttext_pos'] == 'before-icon') echo '<span>'.$settings['search_bttext'].'</span>'?>
			            	<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			            	<?php if($settings['search_bttext'] && $settings['search_bttext_pos'] == 'after-icon') echo '<span>'.$settings['search_bttext'].'</span>'?>
			            </span>
			        </div>
			        <div class="elth-list-product-search th-scrollbar">
			            <p class="text-center"><?php esc_html_e("Please enter key search to display results.","construction")?></p>
			        </div>
			    </form>
			</div>
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
