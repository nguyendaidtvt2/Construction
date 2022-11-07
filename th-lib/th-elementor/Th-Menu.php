<?php
namespace Elementor;
use th_Walker_Nav_Menu;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Th_Menu extends Widget_Base {

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
		return 'th-menu';
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
		return esc_html__( 'Menu', 'construction' );
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
		return 'eicon-nav-menu';
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

	public function get_menus(){
        $list = [];
        $menus = wp_get_nav_menus();
        foreach($menus as $menu){
            $list[$menu->slug] = $menu->name;
        }

        return $list;
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
            'content_tab',
            [
                'label' => esc_html__('Menu settings', 'construction'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
		);

        $this->add_control(
            'nav_menu',
            [
                'label'     =>esc_html__( 'Select menu', 'construction' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $this->get_menus(),
            ]
		);

		$this->add_control(
			'main_menu_style',
			[
				'label' => esc_html__( 'Menu style', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'Default', 'construction' ),
					'icon' => esc_html__( 'Menu icon', 'construction' ),
				],
			]
		);

		$this->add_control(
			'menu_sticky',
			[
				'label' => esc_html__( 'Menu sticky', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

        $this->add_responsive_control(
			'main_menu_position',
			[
				'label' => esc_html__( 'Menu position', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'construction' ),
					'center' => esc_html__( 'Center', 'construction' ),
                    'right' => esc_html__( 'Right', 'construction' ),
                    'justified'  => esc_html__( 'Justified', 'construction' ),
				],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'th_menubar_background',
				'label' => esc_html__( 'Background', 'construction' ),
                'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .th-menu-container',
			]
        );

        $this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet' ],
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .th-menu-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );        

		$this->end_controls_section();

		$this->start_controls_section(
            'content_side_tab',
            [
                'label' => esc_html__('Menu side/mobile', 'construction'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
		);

		$this->add_control(
			'th_nav_menu_logo',
			[
				'label' => esc_html__( 'Choose Mobile Menu Logo', 'construction' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$this->add_responsive_control(
            'mobile_menu_panel_background',
            [
                'label' => esc_html__( 'Item text color', 'construction' ),
                'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .menu-style-icon .th-menu-inner' => 'background-image: linear-gradient(180deg, {{VALUE}} 0%, {{VALUE}} 100%);',
				],
            ]
        );

		$this->add_responsive_control(
			'mobile_menu_panel_spacing',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .menu-style-icon .th-menu-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mobile_menu_panel__head_spacing',
			[
				'label' => esc_html__( 'Head Padding', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .th-nav-identity-panel.panel-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'mobile_menu_panel_width',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 260,
						'max' => 900,
						'step' => 1,
                    ],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
                ],
				'selectors' => [
					'{{WRAPPER}} .menu-style-icon .th-menu-inner' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
        // Custom menu item lv0
        $this->start_controls_section(
            'style_tab_menuitem',
            [
                'label' => esc_html__('Menu item style', 'construction'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => esc_html__( 'Typography', 'construction' ),
				'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .th-navbar-nav > li > a',
			]
		);

        $this->add_responsive_control(
			'menu_item_spacing',
			[
				'label' => esc_html__( 'Spacing (a)', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);	

        $this->add_responsive_control(
			'menu_item_spacing_li',
			[
				'label' => esc_html__( 'Spacing (li)', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_item_margin',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav > li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
            'nav_menu_tabs'
		);
			// Normal
			$this->start_controls_tab(
				'nav_menu_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'construction' ),
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'item_background',
					'label' => esc_html__( 'Item background', 'construction' ),
					'types' => ['classic', 'gradient'],
					'selector' => '{{WRAPPER}} .th-navbar-nav > li > a',
				]
			);

			$this->add_responsive_control(
				'menu_text_color',
				[
					'label' => esc_html__( 'Item text color', 'construction' ),
					'type' => Controls_Manager::COLOR,
					'devices' => [ 'desktop', 'tablet' ],
					'selectors' => [
						'{{WRAPPER}} .th-navbar-nav > li > a' => 'color: {{VALUE}}',
					],
				]
			);
	
			$this->end_controls_tab();

			// Hover
			$this->start_controls_tab(
				'nav_menu_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'construction' ),
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'item_background_hover',
					'label' => esc_html__( 'Item background', 'construction' ),
					'types' => ['classic', 'gradient'],
					'selector' => '{{WRAPPER}} .th-navbar-nav > li > a:hover, {{WRAPPER}} .th-navbar-nav > li > a:focus, {{WRAPPER}} .th-navbar-nav > li > a:active, {{WRAPPER}} .th-navbar-nav > li:hover > a',
				]
			);
	
			$this->add_responsive_control(
				'item_color_hover',
				[
					'label' => esc_html__( 'Item text color', 'construction' ),
					'type' => Controls_Manager::COLOR,
					'devices' => [ 'desktop', 'tablet' ],
					'selectors' => [
						'{{WRAPPER}} .th-navbar-nav > li > a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li > a:focus' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li > a:active' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li:hover > a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li:hover > a .th-submenu-indicator' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li > a:hover .th-submenu-indicator' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li > a:focus .th-submenu-indicator' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li > a:active .th-submenu-indicator' => 'color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_tab();

			// active
			$this->start_controls_tab(
				'nav_menu_active_tab',
				[
					'label' => esc_html__( 'Active', 'construction' ),
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'		=> 'nav_menu_active_bg_color',
					'label' 	=> esc_html__( 'Item background', 'construction' ),
					'types'		=> ['classic', 'gradient'],
					'selector'	=> '{{WRAPPER}} .th-navbar-nav > li.current-menu-item > a'
				]
			);
	
			$this->add_responsive_control(
				'nav_menu_active_text_color',
				[
					'label' => esc_html__( 'Item text color (Active)', 'construction' ),
					'type' => Controls_Manager::COLOR,
					'devices' => [ 'desktop', 'tablet' ],
					'selectors' => [
						'{{WRAPPER}} .th-navbar-nav > li.current-menu-item > a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li.current-menu-ancestor > a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav > li.current-menu-ancestor > a .th-submenu-indicator' => 'color: {{VALUE}}',
					],
				]
			);	

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'menu_item0_border_heading',
			[
				'label' => esc_html__( 'Items Border', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_item0_border',
				'label' => esc_html__( 'Border', 'construction' ),
				'selector' => '{{WRAPPER}} .th-navbar-nav > li > a',
			]
		);

		$this->add_control(
			'menu_item0_border_last_child_heading',
			[
				'label' => esc_html__( 'Border Last Child', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_item0_border_last_child',
				'label' => esc_html__( 'Border last Child', 'construction' ),
				'selector' => '{{WRAPPER}} .th-navbar-nav > li:last-child > a',
			]
		);

		$this->add_control(
			'menu_item0_border_first_child_heading',
			[
				'label' => esc_html__( 'Border First Child', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_item0_border_first_child',
				'label' => esc_html__( 'Border First Child', 'construction' ),
				'selector' => '{{WRAPPER}} .th-navbar-nav > li:first-child > a',
			]
		);

        $this->end_controls_section();
        // Custom sub menu item
        $this->start_controls_section(
            'style_tab_submenu_item',
            [
                'label' => esc_html__('Submenu item style', 'construction'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'style_tab_submenu_item_arrow',
			[
				'label' => esc_html__( 'Submenu Indicator', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'th_line_arrow',
				'options' => [
					'th_line_arrow'  => esc_html__( 'Line Arrow', 'construction' ),
					'th_plus_icon' => esc_html__( 'Plus', 'construction' ),
					'th_fill_arrow' => esc_html__( 'Fill Arrow', 'construction' ),
					'th_none' => esc_html__( 'None', 'construction' ),
                ],
			]
		);
		
		$this->add_responsive_control(
			'style_tab_submenu_indicator_color',
			[
				'label' => esc_html__( 'Indicator color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'devices' => [ 'desktop', 'tablet' ],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav .sub-menu a .indicator-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'style_tab_submenu_item_arrow!' => 'th_none'
				]
			]
		);
		$this->add_responsive_control(
			'submenu_indicator_spacing',
			[
				'label' => esc_html__( 'Indicator Margin', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav-default a .indicator-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'style_tab_submenu_item_arrow!' => 'th_none'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_item_typography',
				'label' => esc_html__( 'Typography', 'construction' ),
				'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .th-navbar-nav .sub-menu > li > a',
			]
        );

		$this->add_responsive_control(
			'submenu_item_spacing',
			[
				'label' => esc_html__( 'Spacing', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
				'devices' => [ 'desktop', 'tablet' ],
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav .sub-menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'submenu_active_hover_tabs'
		);
			$this->start_controls_tab(
				'submenu_normal_tab',
				[
					'label'	=> esc_html__('Normal', 'construction')
				]
			);

			$this->add_responsive_control(
				'submenu_item_color',
				[
					'label' => esc_html__( 'Item text color', 'construction' ),
					'type' => Controls_Manager::COLOR,
					'devices' => [ 'desktop', 'tablet' ],
					'selectors' => [
						'{{WRAPPER}} .th-navbar-nav .sub-menu > li > a' => 'color: {{VALUE}}',
					],
					
				]
			);
	
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'menu_item_background',
					'label' => esc_html__( 'Item background', 'construction' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .th-navbar-nav .sub-menu > li > a',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'submenu_hover_tab',
				[
					'label'	=> esc_html__('Hover', 'construction')
				]
			);
	
			$this->add_responsive_control(
				'item_text_color_hover',
				[
					'label' => esc_html__( 'Item text color (hover)', 'construction' ),
					'type' => Controls_Manager::COLOR,
					'devices' => [ 'desktop', 'tablet' ],
					'selectors' => [
						'{{WRAPPER}} .th-navbar-nav .sub-menu > li > a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav .sub-menu > li > a:focus' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav .sub-menu > li > a:active' => 'color: {{VALUE}}',
						'{{WRAPPER}} .th-navbar-nav .sub-menu > li:hover > a' => 'color: {{VALUE}}',
					],
				]
			);
	
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'menu_item_background_hover',
					'label' => esc_html__( 'Item background (hover)', 'construction' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '
					{{WRAPPER}} .th-navbar-nav .sub-menu > li > a:hover,
					{{WRAPPER}} .th-navbar-nav .sub-menu > li > a:focus,
					{{WRAPPER}} .th-navbar-nav .sub-menu > li > a:active,
					{{WRAPPER}} .th-navbar-nav .sub-menu > li:hover > a',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'submenu_active_tab',
				[
					'label'	=> esc_html__('Active', 'construction')
				]
			);

			$this->add_responsive_control(
				'nav_sub_menu_active_text_color',
				[
					'label' => esc_html__( 'Item text color (Active)', 'construction' ),
					'type' => Controls_Manager::COLOR,
					'devices' => [ 'desktop', 'tablet' ],
					'selectors' => [
						'{{WRAPPER}} .th-navbar-nav .sub-menu > li.current-menu-item > a' => 'color: {{VALUE}} !important'
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'		=> 'nav_sub_menu_active_bg_color',
					'label' 	=> esc_html__( 'Item background (Active)', 'construction' ),
					'types'		=> ['classic', 'gradient'],
					'selector'	=> '{{WRAPPER}} .th-navbar-nav .sub-menu > li.current-menu-item > a',
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'menu_item_border_heading',
			[
				'label' => esc_html__( 'Sub Menu Items Border', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_item_border',
				'label' => esc_html__( 'Border', 'construction' ),
				'selector' => '{{WRAPPER}} .th-navbar-nav .sub-menu > li > a',
			]
		);

		$this->add_control(
			'menu_item_border_last_child_heading',
			[
				'label' => esc_html__( 'Border Last Child', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_item_border_last_child',
				'label' => esc_html__( 'Border last Child', 'construction' ),
				'selector' => '{{WRAPPER}} .th-navbar-nav .sub-menu > li:last-child > a',
			]
		);

		$this->add_control(
			'menu_item_border_first_child_heading',
			[
				'label' => esc_html__( 'Border First Child', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_item_border_first_child',
				'label' => esc_html__( 'Border First Child', 'construction' ),
				'selector' => '{{WRAPPER}} .th-navbar-nav .sub-menu > li:first-child > a',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'style_tab_submenu_panel',
            [
                'label' => esc_html__('Submenu panel style', 'construction'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'panel_submenu_border',
				'label' => esc_html__( 'Panel Menu Border', 'construction' ),
				'selector' => '{{WRAPPER}} .th-navbar-nav .sub-menu',
			]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'submenu_container_background',
                'label' => esc_html__( 'Container background', 'construction' ),
                'types' => [ 'classic','gradient' ],
                'selector' => '{{WRAPPER}} .th-navbar-nav .sub-menu',
            ]
        );

        $this->add_responsive_control(
			'submenu_panel_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet' ],
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'submenu_panel_padding',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet' ],
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .th-navbar-nav .sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'submenu_container_width',
			[
				'label' => esc_html__( 'Container width', 'construction' ),
                'type' => Controls_Manager::TEXT,
                'devices' => [ 'desktop', 'tablet' ],
                'selectors' => [
                    '{{WRAPPER}} .th-navbar-nav .sub-menu' => 'min-width: {{VALUE}};',
                ]
			]
		);
		

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'panel_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'construction' ),
				'selector' => '{{WRAPPER}} .th-navbar-nav .sub-menu',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'menu_toggle_style_tab',
			[
				'label' => esc_html__( 'Icon menu Style', 'construction' ),
                'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'menu_toggle_style_title',
			[
				'label' => esc_html__( 'Icon menu Toggle', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'menu_toggle_icon_position',
			[
				'label' => esc_html__( 'Position', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Top', 'construction' ),
						'icon' => 'la la-angle-left',
					],
					'right' => [
						'title' => esc_html__( 'Middle', 'construction' ),
						'icon' => 'la la-angle-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .toggler-icon' => 'float: {{VALUE}}',
                ],
			]
		);

        $this->add_responsive_control(
			'menu_toggle_padding',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .toggler-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'menu_toggle_spacing',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .toggler-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'menu_toggle_width',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
                ],
				'selectors' => [
					'{{WRAPPER}} .toggler-icon' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'menu_toggle_size',
			[
				'label' => esc_html__( 'Size', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
                ],
				'selectors' => [
					'{{WRAPPER}} .toggler-icon .th-menu-toggler' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'menu_toggle_size_height',
			[
				'label' => esc_html__( 'Size height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
                ],
				'selectors' => [
					'{{WRAPPER}} .toggler-icon .th-menu-toggler' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'menu_toggle_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                ],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .toggler-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->start_controls_tabs(
            'menu_toggle_normal_and_hover_tabs'
        );

        $this->start_controls_tab(
            'menu_toggle_normal',
            [
                'label' => esc_html__( 'Normal', 'construction' ),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'menu_toggle_background',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .toggler-icon',
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_toggle_border',
                'label' => esc_html__( 'Border', 'construction' ),
                'separator' => 'before',
				'selector' => '{{WRAPPER}} .toggler-icon',
			]
        );

        $this->add_control(
			'menu_toggle_icon_color',
			[
				'label' => esc_html__( 'Humber Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .toggler-icon .th-menu-toggler span' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .toggler-icon .th-menu-toggler:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .toggler-icon .th-menu-toggler:after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'menu_toggle_hover',
            [
                'label' => esc_html__( 'Hover', 'construction' ),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'menu_toggle_background_hover',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .toggler-icon:hover',
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_toggle_border_hover',
                'label' => esc_html__( 'Border', 'construction' ),
                'separator' => 'before',
				'selector' => '{{WRAPPER}} .toggler-icon:hover',
			]
        );

        $this->add_control(
			'menu_toggle_icon_color_hover',
			[
				'label' => esc_html__( 'Humber Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Core\Schemes\Color::get_type(),
					'value' => Core\Schemes\Color::COLOR_1,
                ],
				'selectors' => [
					'{{WRAPPER}} .toggler-icon .th-menu-toggler:hover span' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .toggler-icon .th-menu-toggler:hover:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .toggler-icon .th-menu-toggler:hover:after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
			'menu_close_style_title',
			[
				'label' => esc_html__( 'Close Toggle', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'menu_close_spacing',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
                'devices' => [ 'desktop','tablet','mobile' ],
				'selectors' => [
					'{{WRAPPER}} .close-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'menu_close_margin',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
                'devices' => [ 'desktop','tablet','mobile' ],
				'selectors' => [
					'{{WRAPPER}} .close-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'menu_close_width',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 45,
						'max' => 100,
						'step' => 1,
					],
                ],
				'selectors' => [
					'{{WRAPPER}} .close-menu' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'menu_close_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                ],
				'selectors' => [
					'{{WRAPPER}} .close-menu' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->start_controls_tabs(
            'menu_close_normal_and_hover_tabs'
        );

        $this->start_controls_tab(
            'menu_close_normal',
            [
                'label' => esc_html__( 'Normal', 'construction' ),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'menu_close_background',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .close-menu',
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_close_border',
                'label' => esc_html__( 'Border', 'construction' ),
                'separator' => 'before',
				'selector' => '{{WRAPPER}} .close-menu',
			]
        );

        $this->add_control(
			'menu_close_icon_color',
			[
				'label' => esc_html__( 'Humber Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Core\Schemes\Color::get_type(),
					'value' => Core\Schemes\Color::COLOR_1,
                ],
				'selectors' => [
					'{{WRAPPER}} .close-menu .th-menu-toggler span' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .close-menu .th-menu-toggler:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .close-menu .th-menu-toggler:after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'menu_close_hover',
            [
                'label' => esc_html__( 'Hover', 'construction' ),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'menu_close_background_hover',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .close-menu:hover',
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_close_border_hover',
                'label' => esc_html__( 'Border', 'construction' ),
                'separator' => 'before',
				'selector' => '{{WRAPPER}} .close-menu:hover',
			]
        );

        $this->add_control(
			'menu_close_icon_color_hover',
			[
				'label' => esc_html__( 'Humber Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Core\Schemes\Color::get_type(),
					'value' => Core\Schemes\Color::COLOR_1,
                ],
				'selectors' => [
					'{{WRAPPER}} .close-menu .th-menu-toggler:hover span' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .close-menu .th-menu-toggler:hover:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .close-menu .th-menu-toggler:hover:after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'mobile_menu_logo_style_tab',
			[
				'label' => esc_html__( 'Mobile Menu Logo', 'construction' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'mobile_menu_logo_width',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mobile-logo > img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mobile_menu_logo_height',
			[
				'label' => esc_html__( 'Height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mobile-logo > img' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mobile_menu_logo_margin',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mobile-logo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mobile_menu_logo_padding',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mobile-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		$settings = $this->get_settings_for_display();

		if($settings['nav_menu'] != '' && wp_get_nav_menu_items($settings['nav_menu']) !== false){
			$icon_html = '<div class="th-nav-identity-panel toggler-icon">					
							<span class="th-menu-toggler">
							<span></span>
							</span>
						</div>';
			$logo_mobile = '';
			if(isset($settings['th_nav_menu_logo']['url']) && !empty($settings['th_nav_menu_logo']['url'])){
				$logo_mobile = 	'<a class="mobile-logo" href="'.home_url('/').'">
									<img src="'.$settings['th_nav_menu_logo']['url'].'" alt="'.esc_attr__("logo mobile","construction").'" >
								</a>';
			}
			$close_bt = '<div class="th-nav-identity-panel panel-inner">
							'.$logo_mobile.'
							<div class="close-menu">
								<span class="th-menu-toggler menu-open">
								<span></span>
								</span>
							</div>
						</div>';
			$args = [
				'items_wrap'      => $close_bt.'<ul id="%1$s" class="%2$s">%3$s</ul>',
				'container'       => false,
				'menu_id'         => 'main-menu',
				'menu'         	  => $settings['nav_menu'],
				'menu_class'      => 'th-navbar-nav menupos-' . $settings['main_menu_position'],
				'depth'           => 4,
				'echo'            => true,
				'fallback_cb'     => 'wp_page_menu',
				'walker'          => new Th_Walker_Nav_Menu()
			];
			if( $settings['menu_sticky']== 'yes') $sticky_class = 'menu-sticky-on';
			else $sticky_class = '';
			echo 	'<div class="th-menu-container th-menu-offcanvas-elements th-navbar-nav-default ' .$settings['style_tab_submenu_item_arrow'].' menu-style-'.$settings['main_menu_style'].' '.$sticky_class.'">
						'.$icon_html.'
						<div class="th-menu-inner">';
							wp_nav_menu($args);
			echo 		'</div>
					</div>';
		}
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