<?php
namespace Elementor;
use WC;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Th_MiniCart extends Widget_Base {

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
		return 'th-mini-cart';
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
		return esc_html__( 'Mini Cart', 'construction' );
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
		return 'eicon-cart';
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

	public function mini_cart() {
		do_action( 'woocommerce_before_mini_cart' );
		if(!\WC()->cart) return;
		if ( ! \WC()->cart->is_empty() ) : ?>
		    <div class="product-mini-cart list-mini-cart-item th-scrollbar">
		        <?php
		            do_action( 'woocommerce_before_mini_cart_contents' );
		            $count_item = 0;
		            foreach ( \WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		                $count_item++;
		                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		                $product_price     = apply_filters( 'woocommerce_cart_item_price', \WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
		                
		                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		                    $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
		                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		                    ?>
		                    <div class="item-info-cart product-mini-cart table-custom <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>" data-key="<?php echo esc_attr($cart_item_key)?>">
		                        <div class="product-thumb">
		                            <a href="<?php echo esc_url($product_permalink)?>" class="product-thumb-link">
		                                <?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(array(70,70)), $cart_item, $cart_item_key )?>
		                            </a>
		                        </div>
		                        <div class="product-info">
		                            <h3 class="title14 product-title"><a href="<?php echo esc_url($product_permalink)?>"><?php echo esc_html($product_name)?></a></h3>
		                            <div class="mini-cart-qty">
		                                <span><?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="qty-num">' . sprintf( '%s', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?> x <span class="price-wrap"><?php echo apply_filters( 'woocommerce_cart_item_price', \WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );?></span></span>
		                            </div>
		                        </div>
		                        <div class="product-delete text-right">
		                            <a href="#" class="remove-product"><i class="la la-trash-alt"></i></a>
		                        </div>
		                    </div>
		                    <?php
		                }
		            }

		            do_action( 'woocommerce_mini_cart_contents' );
		        ?>
		    </div>

		    <input class="get-cart-number" type="hidden" value="<?php echo esc_attr($count_item)?>">

		    <div class="mini-cart-footer">
			    <div class="mini-cart-total clearfix">
			        <span class="pull-left"><?php esc_html_e( 'TOTAL', 'construction' ); ?></span>
			        <strong class="pull-right mini-cart-total-price get-cart-price"><?php echo \WC()->cart->get_cart_subtotal(); ?></strong>
			    </div>

			    <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			    <div class="mini-cart-button">
			        <?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
			    </div>
			</div>

		<?php else : ?>

		    <div class="mini-cart-empty"><?php esc_html_e( 'No products in the cart.', 'construction' ); ?></div>

		<?php endif;
		do_action( 'woocommerce_after_mini_cart' );
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
				'default'   => 'elth-cart-icon',
				'options'   => [
					'elth-cart-icon'		=> esc_html__( 'Icon', 'construction' ),
				],
			]
		);

		$this->add_control(
			'style_content',
			[
				'label' 	=> esc_html__( 'Content Style', 'construction' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'elth-mini-cart-dropdown',
				'options'   => [
					'elth-mini-cart-dropdown'		=> esc_html__( 'Icon', 'construction' ),
					'elth-mini-cart-side'		=> esc_html__( 'Side', 'construction' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'construction' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'la la-shopping-cart',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'text', 
			[
				'label' => esc_html__( 'Text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'align_button',
			[
				'label' => esc_html__( 'Alignment', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'default'	=> '',
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
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price',
			[
				'label' => esc_html__( 'Price', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_price',
			[
				'label' => esc_html__( 'Show price', 'construction' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'construction' ),
				'label_off' => esc_html__( 'Hide', 'construction' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dropdown_pos',
			[
				'label' => esc_html__( 'Dropdown', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_dropdown', 
			[
				'label' => esc_html__( 'Title', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Items',
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Button', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_icon',
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
					'{{WRAPPER}} .elth-mini-cart' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .elth-mini-cart' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'align_button_text',
			[
				'label' => esc_html__( 'Alignment', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'default'	=> '',
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
					'{{WRAPPER}} .mini-cart-link' => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .mini-cart-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'button_cart_effects' );

		$this->start_controls_tab( 'button_cart_normal',
			[
				'label' => esc_html__( 'Normal', 'construction' ),
			]
		);

		$this->add_control(
			'color_icon',
			[
				'label' => esc_html__( 'Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-icon i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cart_text_button_typography',
				'label' => esc_html__( 'Typography button text', 'construction' ),
				'selector' => '{{WRAPPER}} .elth-mini-cart .mini-cart-text-bt',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_bt',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-mini-cart',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_bt',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-mini-cart',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_bt',
				'selector' => '{{WRAPPER}} .elth-mini-cart',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_bt',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'button_cart_hover',
			[
				'label' => esc_html__( 'Hover', 'construction' ),
			]
		);

		$this->add_control(
			'color_icon_hover',
			[
				'label' => esc_html__( 'Icon Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart:hover .mini-cart-icon i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cart_text_button_typography_hover',
				'label' => esc_html__( 'Typography button text', 'construction' ),
				'selector' => '{{WRAPPER}} .elth-mini-cart:hover .mini-cart-text-bt',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_bt_hover',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-mini-cart:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_bt_hover',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-mini-cart:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_bt_hover',
				'selector' => '{{WRAPPER}} .elth-mini-cart:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_bt_hover',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();	

		$this->add_control(
			'separator_bt_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'padding_button',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin_button',
			[
				'label' => esc_html__( 'Margin', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_number',
			[
				'label' => esc_html__( 'Number', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_number',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' , '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-number' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height_number',
			[
				'label' => esc_html__( 'Height', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' , '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-number' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'size_number',
			[
				'label' => esc_html__( 'Size number', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-number' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'color_number',
			[
				'label' => esc_html__( 'Color number', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-number' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_number',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-mini-cart .mini-cart-number',
			]
		);

		$this->add_responsive_control(
			'pos_left_number',
			[
				'label' => esc_html__( 'Position left', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' , '%'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-number' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pos_top_number',
			[
				'label' => esc_html__( 'Position top', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' , '%'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-number' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_number',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-mini-cart .mini-cart-number',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__( 'Price', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cart_price_typography',
				'label' => esc_html__( 'Typography', 'construction' ),
				'selector' => '{{WRAPPER}} .elth-mini-cart .mini-cart-total-price',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dropdown_style',
			[
				'label' => esc_html__( 'Dropdown/side', 'construction' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_dropdown_typography',
				'label' => esc_html__( 'Title Typography', 'construction' ),
				'selector' => '{{WRAPPER}} .mini-cart-content > h2',
			]
		);

		$this->add_responsive_control(
			'dropdown_pos_left',
			[
				'label' => esc_html__( 'Wrap Left', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'default'	=> '',
				'options' => [
					'0' => [
						'title' => esc_html__( '0', 'construction' ),
						'icon' => 'eicon-text-align-left',
					],
					'inherit' => [
						'title' => esc_html__( 'Inherit', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-content' => 'left: {{VALUE}};',
				],
				'condition' => [
					'style_content' => 'elth-mini-cart-dropdown',
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_pos_right',
			[
				'label' => esc_html__( 'Wrap Right', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'default'	=> '',
				'options' => [
					'0' => [
						'title' => esc_html__( '0', 'construction' ),
						'icon' => 'eicon-text-align-right',
					],
					'inherit' => [
						'title' => esc_html__( 'Inherit', 'construction' ),
						'icon' => 'eicon-text-align-center',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-content' => 'right: {{VALUE}};',
				],
				'condition' => [
					'style_content' => 'elth-mini-cart-dropdown',
				]
			]
		);

		$this->add_responsive_control(
			'padding_content',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_content',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-mini-cart .mini-cart-content',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_content',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-mini-cart .mini-cart-content',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_content',
				'selector' => '{{WRAPPER}} .elth-mini-cart .mini-cart-content',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_radius_content',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart .mini-cart-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_bg_overlay',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'background_search_popup_heading',
			[
				'label' => esc_html__( 'Background overlay', 'construction' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_overlay',
				'label' => esc_html__( 'Background overlay', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-mini-cart-side .mini-cart-side-overlay',
				'condition' => [
					'style_content' => 'elth-mini-cart-side',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer_side_style',
			[
				'label' => esc_html__( 'Footer side', 'construction' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style_content' => 'elth-mini-cart-side',
				]
			]
		);

		$this->add_responsive_control(
			'padding_footer_side',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart-side .mini-cart-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_footer_side',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-mini-cart-side .mini-cart-footer',
			]
		);

		$this->add_control(
			'footer_text_color',
			[
				'label' => esc_html__( 'Text Color', 'construction' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mini-cart-total > *' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'footer_text_space',
			[
				'label' => esc_html__( 'Space text', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mini-cart-total' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_footer_side',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-mini-cart-side .mini-cart-footer',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_footer_side',
				'selector' => '{{WRAPPER}} .elth-mini-cart-side .mini-cart-footer',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_radius_footer_side',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-mini-cart-side .mini-cart-footer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		if(class_exists("woocommerce")){
			?>
			<div class="elth-mini-cart <?php echo esc_attr($settings['style'].' '.$settings['style_content'])?>">			
				<?php if($settings['style_content'] == 'elth-mini-cart-side') echo '<div class="mini-cart-side-overlay"></div>';?>
				<a class="mini-cart-link" href="<?php echo wc_get_cart_url()?>">
	                <span class="mini-cart-icon">
	                	<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
	                </span>
	                <span class="mini-cart-text">
	                    <span class="mini-cart-number set-cart-number">0</span>
	                    <?php if($settings['text']) echo '<span class="mini-cart-text-bt">'.$settings['text'].'</span>';?>
	                    <?php if($settings['show_price'] == 'yes'):?>
		                    <span class="mini-cart-total-price set-cart-price">
		                    	<?php 
		                    	if(\WC()->cart) echo \WC()->cart->get_cart_total();
		                    	else echo wc_price(0);
		                    	?>                    		
		                    </span>
		                <?php endif?>
	                </span>
	            </a>
	            <div class="mini-cart-content">
	            	<?php 
	            	$h_title = esc_html__('item','construction');
	            	if($settings['title_dropdown']) $h_title = $settings['title_dropdown'];
	            	?>
			        <h2 class="title18 font-bold"><span class="set-cart-number">0</span> <?php echo esc_html($h_title)?></h2>
			        <div class="mini-cart-main-content"><?php $this->mini_cart()?></div>
			        <div class="total-default hidden"><?php echo wc_price(0)?></div>
			        <i class="la la-times elth-close-mini-cart"></i>
			    </div>
			</div>
			<?php
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
