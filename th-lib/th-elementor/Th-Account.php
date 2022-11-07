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
class Th_Account extends Widget_Base {

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
		return 'th-account';
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
		return esc_html__( 'Account manager', 'construction' );
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
		return 'eicon-person';
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

	public function get_roles() {
		global $wp_roles;
        $roles = array();
        if(isset($wp_roles->roles)){
            $roles_data = $wp_roles->roles;
            if(is_array($roles_data)){
                foreach ($roles_data as $key => $value) {
                    $roles[$key] = $value['name'];
                }
            }
        }
        return $roles;
	}

	public function login_form($redirect_to = '') {
		// if(empty($redirect_to)) $redirect_to =  apply_filters( 'login_redirect',home_url('/'));
        ?>
        <div class="elth-login-form popup-form active">
            <div class="form-header">
                <h2><?php esc_html_e( 'Log In','construction' ); ?></h2>
                <div class="desc"><?php esc_html_e( 'Become a part of our community!','construction' ); ?></div>
                <div class="message ms-done ms-default"><?php esc_html_e( 'Registration complete. Please check your email.','construction' ); ?></div>
            </div>
            <form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
                <?php do_action( 'woocommerce_login_form_start' ); ?>
                <div class="form-field">
                    <input placeholder="<?php esc_html_e( 'Username or Email Address','construction' ); ?>" type="text" name="log" id="user_login" class="input" size="20" autocomplete="off"/>
                </div>
                <div class="form-field">
                	<input placeholder="<?php esc_html_e( 'Password','construction' ); ?>" type="password" name="pwd" id="user_pass" class="input" value="" size="20" autocomplete="off"/>
                </div>
                <div class="extra-field">
                    <?php 
                        if(class_exists("woocommerce")) do_action( 'woocommerce_login_form' );
                        else do_action( 'login_form' );
                    ?>
                </div>
                <div class="forgetmenot">
                    <input name="rememberme" type="checkbox" id="remembermep" value="forever" />
                    <label class="rememberme" for="remembermep"><?php esc_html_e( 'Remember Me','construction' ); ?></label>
                </div>
                <div class="submit">
                    <input type="submit" name="wp-submit" class="elth-bt-default elth-bt-full" value="<?php esc_attr_e('Log In','construction'); ?>" />
                    <input type="hidden" name="redirect_to1" value="<?php echo esc_attr($redirect_to); ?>" />
                </div>
                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>
            <div class="nav-form">
                <?php if ( get_option( 'users_can_register' ) ) :
                    echo '<a href="#registerform" class="popup-redirect register-link">'.esc_html__("Register","construction").'</a>';
                endif;
                echo '<a href="#lostpasswordform" class="popup-redirect lostpass-link">'.esc_html__("Lost your password?","construction").'</a>';
                ?>
            </div>
        </div>
        <?php
	}

	public function register_form($redirect_to = '') {
		if(empty($redirect_to)) $redirect_to = apply_filters( 'registration_redirect', wp_login_url() );
        ?>
        <div class="elth-register-form popup-form">
            <div class="form-header">
                <h2><?php esc_html_e( 'Create an account','construction' ); ?></h2>
                <div class="desc"><?php esc_html_e( 'Welcome! Register for an account','construction' ); ?></div>
                <div class="message login_error error_1 ms-error ms-default"><?php esc_html_e( 'The user name or email address is not correct.','construction' ); ?></div>
                <!-- fix popup register -->
                <div class="message login_error error_2 ms-error ms-default"><?php esc_html_e( 'The password is not correct.','construction' ); ?></div>
                
            </div>
            <form name="registerform" id="registerform" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post" novalidate="novalidate">
                <?php do_action( 'woocommerce_register_form_start' ); ?>
                <div class="form-field">
                    <input placeholder="<?php esc_html_e('Username','construction') ?>" type="text" name="user_login" id="user_loginr" class="input" value="" size="20" autocomplete="off"/>
                </div>
                <div class="form-field">
                    <input placeholder="<?php esc_html_e('Email','construction') ?>" type="email" name="user_email" id="user_email" class="input" value="" size="25" autocomplete="off"/>
                </div>
                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ){ ?>
                    <div class="form-field">
                        <input placeholder="<?php esc_html_e( 'Password', 'construction' ); ?>" type="password" name="password" id="reg_passwordp" autocomplete="new-password" />
                    </div>
                <?php }?>
                <div class="extra-field">
                    <?php 
                        if(class_exists("woocommerce")) do_action( 'woocommerce_register_form' );
                        else do_action( 'register_form' );
                    ?>
                    <input type="hidden" name="redirect_to1" value="<?php echo esc_attr( $redirect_to ); ?>" />
                </div>                
                <?php if ( 'no' != get_option( 'woocommerce_registration_generate_password' ) ){ ?>
                    <div id="reg_passmail">
                        <?php esc_html_e( 'Registration confirmation will be emailed to you.','construction' ); ?>
                    </div>
                <?php }?>
                <div class="submit"><input type="submit" name="wp-submit" class="elth-bt-default elth-bt-full" value="<?php esc_attr_e('Register',"construction"); ?>" /></div>
                <?php do_action( 'woocommerce_register_form_end' ); ?>
            </form>

            <div class="nav-form">
                <a href="#loginform" class="popup-redirect login-link"><?php esc_html_e( 'Log in','construction' ); ?></a>
                <a href="#lostpasswordform" class="popup-redirect lostpass-link"><?php esc_html_e( 'Lost your password?','construction' ); ?></a>
            </div>
        </div>
        <?php
	}
	public function lostpass_form($redirect_to = '') {
		if(empty($redirect_to)) $redirect_to =  apply_filters( 'login_redirect',home_url('/'));
        ?>
        <div class="elth-lostpass-form popup-form">
            <div class="form-header">
                <h2><?php esc_html_e( 'Reset password','construction' ); ?></h2>
                <div class="desc"><?php esc_html_e( 'Recover your password','construction' ); ?></div>
                <div class="message ms-default ms-done"><?php esc_html_e( 'Password reset email has been sent.','construction' ); ?></div>
                <div class="message login_error ms-error ms-default"><?php esc_html_e( 'The email could not be sent.
Possible reason: your host may have disabled the mail function.','construction' ); ?></div>
            </div>
            <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( network_site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
                <div class="form-field">
                    <input placeholder="<?php esc_html_e( 'Username or Email Address','construction' ); ?>" type="text" name="user_login" id="user_loginlp" class="input" value="" size="20" autocomplete="off"/>
                </div>
                <div class="extra-field">
                    <?php do_action( 'lostpassword_form' ); ?>
                    <input type="hidden" name="redirect_to1" value="<?php echo esc_attr( $redirect_to ); ?>" />
                </div>
                <div class="submit"><input type="submit" name="wp-submit" class="elth-bt-default elth-bt-full" value="<?php esc_attr_e('Get New Password','construction'); ?>" /></div>
                <div class="desc note"><?php esc_html_e( 'A password will be e-mailed to you.','construction' ); ?></div>
            </form>

            <div class="nav-form">
                <a href="#loginform" class="popup-redirect login-link"><?php esc_html_e('Log in',"construction") ?></a>
                <?php
                if ( get_option( 'users_can_register' ) ) :
                    echo '<a href="#registerform" class="popup-redirect register-link">'.esc_html__("Register","construction").'</a>';
                endif;
                ?>
            </div>
        </div>
        <?php
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
				'default'   => 'elth-account-icon',
				'options'   => [
					'elth-account-icon'		=> esc_html__( 'Icon', 'construction' ),
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
					'value' => 'la la-user',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'icon_logged',
			[
				'label' => esc_html__( 'Icon logged', 'construction' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'la la-user',
					'library' => 'solid',
				],
			]
		);

		$this->add_responsive_control(
			'align_icon',
			[
				'label' => esc_html__( 'Alignment', 'construction' ),
				'type' => Controls_Manager::CHOOSE,
				'default'	=> '',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'construction' ),
						'icon' => 'eicon-text-align-left',
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

		$this->add_control(
			'account_bttext',
			[
				'label' => esc_html__( 'Add text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type your text to add search button', 'construction' ),
			]
		);

		$this->add_control(
			'account_bttext_pos',
			[
				'label' => esc_html__( 'Text position', 'construction' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after-icon',
				'options' => [
					'after-icon'   => esc_html__( 'After icon', 'construction' ),
					'before-icon'  => esc_html__( 'Before icon', 'construction' ),
				],
				'condition' => [
					'account_bttext!' => '',
					'icon[value]!' => '',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_links',
			[
				'label' => esc_html__( 'Links', 'construction' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$repeater_text = new Repeater();
		$repeater_text->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'construction' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'la la-user',
					'library' => 'solid',
				],
			]
		);
		$repeater_text->add_control(
			'text', 
			[
				'label' => esc_html__( 'Text', 'construction' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Enter text' , 'construction' ),
				'label_block' => true,
			]
		);
		$repeater_text->add_control(
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

		$repeater_text->add_control(
			'roles',
			[
				'label' => esc_html__( 'Show with roles', 'construction' ),
				'description' => esc_html__( 'Choose roles to show. Default is show with all roles', 'construction' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_roles(),
				'default' => [],
			]
		);

		$this->add_control(
			'list_links',
			[
				'label' => esc_html__( 'Add links', 'construction' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_text->get_controls(),
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_responsive_control(
			'wrap_links_left',
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
					'{{WRAPPER}} .elth-account-manager .elth-dropdown-list' => 'left: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrap_links_right',
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
					'{{WRAPPER}} .elth-account-manager .elth-dropdown-list' => 'right: {{VALUE}};',
				],
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
					'{{WRAPPER}} .elth-account-manager' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .elth-account-manager' => 'line-height: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .elth-account-manager > i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_account_effects' );

		$this->start_controls_tab( 'icon_account_normal',
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
					'{{WRAPPER}} .elth-account-manager > i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'account_text_button_typography',
				'label' => esc_html__( 'Typography button text', 'construction' ),
				'selector' => '{{WRAPPER}} .elth-account-manager > span',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_icon',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-account-manager',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_icon',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-account-manager',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_icon',
				'selector' => '{{WRAPPER}} .elth-account-manager',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_icon',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-account-manager' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'icon_account_hover',
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
					'{{WRAPPER}} .elth-account-manager:hover i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'account_text_button_typography:hover',
				'label' => esc_html__( 'Typography button text', 'construction' ),
				'selector' => '{{WRAPPER}} .elth-account-manager:hover > span',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_icon_hover',
				'label' => esc_html__( 'Background', 'construction' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .elth-account-manager:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_icon_hover',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-account-manager:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_icon_hover',
				'selector' => '{{WRAPPER}} .elth-account-manager:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_icon_hover',
			[
				'label' => esc_html__( 'Border Radius', 'construction' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elth-account-manager:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'padding_icon',
			[
				'label' => esc_html__( 'Padding', 'construction' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elth-account-manager' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .elth-account-manager' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_links',
			[
				'label' => esc_html__( 'Links', 'construction' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_links',
			[
				'label' => esc_html__( 'Width', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' , '%'],
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
					'{{WRAPPER}} .elth-account-manager .elth-dropdown-list' => 'width: {{SIZE}}{{UNIT}};max-width: inherit;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow_links',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elth-account-manager .elth-dropdown-list',
			]
		);

		$this->add_responsive_control(
			'space_links',
			[
				'label' => esc_html__( 'Space', 'construction' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' , '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elth-account-manager .elth-dropdown-list li' => 'line-height: {{SIZE}}{{UNIT}};',
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
		?>
		<div class="elth-account-manager elth-dropdown-box <?php echo esc_attr($settings['style'])?>">
			<?php if($settings['account_bttext'] && $settings['account_bttext_pos'] == 'before-icon') echo '<span>'.$settings['account_bttext'].'</span>'?>
			<?php 
			$icon_stt = '';
			if(is_user_logged_in()) $icon_stt = '_logged';
			Icons_Manager::render_icon( $settings['icon'.$icon_stt], [ 'aria-hidden' => 'true' ] ); 
			?>
			<?php if($settings['account_bttext'] && $settings['account_bttext_pos'] == 'after-icon') echo '<span>'.$settings['account_bttext'].'</span>'?>
			<?php if(is_user_logged_in()):?>
				<ul class="elth-dropdown-list">
			    	<?php 
			    	foreach (  $settings['list_links'] as $item ) {
						$target = $item['link']['is_external'] ? ' target="_blank"' : '';
						$nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
						echo '<li><a href="'.$item['link']['url'].'"'.$target.$nofollow.' class="elementor-repeater-item-'.$item['_id'].'">';
						Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
						echo ''.$item['text'];
						echo '</a></li>';
					}
			    	?>
			    </ul>
			  <?php else:?>
			  	<div class="login-popup-content-wrap elth-popup-overlay">
			  		<i class="la la-times elth-close-popup"></i>
	                <div class="elth-login-popup-content th-scrollbar">
	                    <?php
	                    $this->login_form();
	                    $this->register_form();
	                    $this->lostpass_form();
	                    ?>
	                </div>
	                <div class="popup-overlay"></div>
	            </div>
			<?php endif;?>
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
