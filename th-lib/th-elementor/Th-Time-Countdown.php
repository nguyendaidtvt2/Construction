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
class Th_Time_Countdown extends Widget_Base {

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
		return 'th-time-countdown';
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
		return esc_html__( 'Time Countdown', 'construction' );
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
		return 'eicon-countdown';
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
	public function is_reload_preview_required() {
		return true;
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

	public function get_box_settings($key='box-key',$class="box-class") {		

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
				'types' => [ 'classic' , 'gradient' ],
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
			'section_image',
			[
				'label' => esc_html__( 'Content', 'construction' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' 	=> esc_html__( 'Style', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'style1',
				'options'   => [
					'style1'		=> esc_html__( 'Style 1', 'construction' ),
					'style2'		=> esc_html__( 'Style 2', 'construction' ),
					'style3'		=> esc_html__( 'Style 3', 'construction' ),
				],
			]
		);

		$this->add_control(
			'date_time',
			[
				'label' => esc_html__( 'Choose Date Time', 'construction' ),
				'type' => Controls_Manager::DATE_TIME,
			]
		);

		$this->add_control(
			'show_canvas',
			[
				'label' => esc_html__( 'Show canvas', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'style!' => 'style3',
				]
			]
		);		

		$this->add_control(
			'show_day',
			[
				'label' => esc_html__( 'Show day', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_text',
			[
				'label' => esc_html__( 'Show text', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'construction' ),
				'label_off' => esc_html__( 'Off', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'day_text', 
			[
				'label' => esc_html__( 'Day text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html('Days','construction'),
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->add_control(
			'day_hour', 
			[
				'label' => esc_html__( 'Hour text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html('Hours','construction'),
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->add_control(
			'day_mins', 
			[
				'label' => esc_html__( 'Minute text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html('Minutes','construction'),
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->add_control(
			'day_secs', 
			[
				'label' => esc_html__( 'Second text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html('Seconds','construction'),
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_canvas',
			[
				'label' => esc_html__( 'Canvas & Wrap', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .th-time-countdown' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .th-time-countdown' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'align',
			[
				'label' 	=> esc_html__( 'Align', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''		=> esc_html__( 'Default', 'construction' ),
					'left'		=> esc_html__( 'Left', 'construction' ),
					'right'		=> esc_html__( 'right', 'construction' ),
					'center'	=> esc_html__( 'Center', 'construction' ),
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Main color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'show_canvas' => 'yes',
					'style!'      => 'style3',
				]
			]
		);

		$this->add_control(
			'circle_bg',
			[
				'label' => esc_html__( 'Circle background', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'show_canvas' => 'yes',
					'style!'      => 'style3',
				]
			]
		);

		$this->add_responsive_control(
			'fg_width',
			[
				'label' => esc_html__( 'Circle width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'description'	=> esc_html__( 'Default 0.03', 'construction' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.01,
						'step' => 0.01,
						'max' => 0.5,
					],
				],
				'condition' => [
					'show_canvas' => 'yes',
					'style!'      => 'style3',
				]
			]
		);

		$this->add_responsive_control(
			'bg_width',
			[
				'label' => esc_html__( 'Circle background width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'description'	=> esc_html__( 'Default 1', 'construction' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.1,
						'step' => 0.1,
						'max' => 1.4,
					],
				],
				'condition' => [
					'show_canvas' => 'yes',
					'style!'      => 'style3',
				]
			]
		);

		$this->end_controls_section();

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
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .th-time-countdown .time_circles>div' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'item_max_width',
			[
				'label' => esc_html__( 'Max Width', 'construction' ),
				'description' => esc_html__( 'Default 20%', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'size_units' => [ '%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 25,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .th-time-countdown .time_circles>div' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'item_height',
			[
				'label' => esc_html__( 'Height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .th-time-countdown .time_circles>div' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->get_box_settings('item','th-time-countdown .time_circles>div');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_number',
			[
				'label' => esc_html__( 'Number', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->get_text_styles('number','th-time-countdown .number');

		$this->get_box_settings('box_number','th-time-countdown .number');

		$this->add_responsive_control(
			'number_bottom',
			[
				'label' => esc_html__( 'Space bottom', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'step' => 1,
						'max' => 100,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .th-time-countdown .number' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => esc_html__( 'Text', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->get_text_styles('text','th-time-countdown .text');

		$this->get_box_settings('box_text','th-time-countdown .text');

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
		$this->add_render_attribute( 'elth-wrapper', 'class', 'countdown-wrap countdown-'.$settings['align'] );
		$attr = array(
			'wdata'		=> $this,
			'settings'	=> $settings,
		);
		echo th_get_template_widget('countdown/countdown','',$attr);
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