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
class Th_image_box extends Widget_Base {

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
		return 'image_box';
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
		return esc_html__( 'Image Box v2', 'construction' );
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
		return 'eicon-button';
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
			'content',
			[
				'label' => esc_html__( 'Image box', 'construction' )
			]
		);

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'construction' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
               
            ]
        );

        $this->add_control(
            'description',
            [
                'label'               =>  esc_html__( 'Description', 'construction' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'image_box',
            [
                'label'         => esc_html__( 'Upload Image', 'construction' ),
                'type'        => Controls_Manager::MEDIA,
            ]
        );
		 $this->add_control(
            'awesome_icon',
            [
                'label' => __( 'Awesome Font Icon', 'construction' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => '',
                ],
            ]
        );
        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'construction' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );


		$this->end_controls_section();
        
		$this->start_controls_section(
			'image_box_style-section',
			array(
				'label'     => esc_html__( 'Style', 'construction' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);
        $this->add_control(
			'image_box_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'construction' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-image-title a' => 'color: {{VALUE}};',
 
				],
			]
		);
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'image_box_title__typography',
				'label'    => esc_html__( 'Typography', 'construction' ),
				'selector' => '{{WRAPPER}} .thim-image-title a',
			]
		);
        $this->add_control(
			'image_box_bg_color',
			[
				'label'     => esc_html__( 'Background Box Color', 'construction' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-image-title' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .thim-image-title:before' => 'background-color: {{VALUE}};',
 
				],
			]
		);
        $this->add_control(
			'image_box_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Box Hover Color', 'construction' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-image-title:hover' => 'background-color: {{VALUE}};',
 
				],
			]
		);
        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();?>
		<div class="th-our-service-sc">
			<div class="th-our-service-image-warp">
				<div class="th-our-service-image">
					<?php if(!empty($settings['image_box']['id'])) echo wp_get_attachment_image( $settings['image_box']['id'], 'full' ); ?>
					<div class="th-our-service-image-content-hover">
						<?php \Elementor\Icons_Manager::render_icon( $settings['awesome_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<p><?php  if(!empty($settings['description'])) echo $settings['description']; ?></p>
					</div>
				</div>
			</div>
			<div class="th-our-service-title">
				<?php  if(!empty($settings['title'])) echo $settings['title']; ?>
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