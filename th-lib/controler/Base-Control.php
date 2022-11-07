<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!defined('ABSPATH')) return;
if(!class_exists('Th_BaseController')){
    class Th_BaseController{
        static function _init(){
            //Default Framwork Hooked
            add_filter( 'wp_title', array(__CLASS__,'_wp_title'), 10, 2 );
            add_action( 'wp', array(__CLASS__,'_setup_author') );
            add_action( 'after_setup_theme', array(__CLASS__,'_after_setup_theme') );
            add_action( 'widgets_init',array(__CLASS__,'_add_sidebars'));
            add_action( 'wp_enqueue_scripts',array(__CLASS__,'_add_scripts'));

            //Custom hooked
            add_filter( 'th_get_sidebar',array(__CLASS__,'_blog_filter_sidebar'));
            add_filter( 'th_header_page_id',array(__CLASS__,'_header_id'));
            add_filter( 'th_footer_page_id',array(__CLASS__,'_footer_id'));
            add_action( 'admin_enqueue_scripts',array(__CLASS__,'_add_admin_scripts'));

            if(class_exists("woocommerce") && !is_admin()){
                add_action('woocommerce_product_query', array(__CLASS__, '_woocommerce_product_query'), 20);
            }
            add_action('after_switch_theme', array(__CLASS__,'th_setup_options'));
            add_filter('body_class', array(__CLASS__,'th_body_classes'));
            add_filter('th_pagecontent', array(__CLASS__,'th_pagecontent'));
            add_filter('the_content', array(__CLASS__,'th_pagecontent'));

            // 7up hook
            add_action( 'pre_get_posts', array(__CLASS__,'th_custom_posts_per_page'));
            add_action( 'th_before_main_content', array(__CLASS__,'th_display_breadcrumb'),20);
            // Before/After append settings
            $terms = array('product_cat','product_tag','category','post_tag');
            foreach ($terms as $term_name) {
                add_action($term_name.'_add_form_fields', array(__CLASS__,'th_product_cat_metabox_add'), 10, 1);
                add_action($term_name.'_edit_form_fields', array(__CLASS__,'th_product_cat_metabox_edit'), 10, 1);    
                add_action('created_'.$term_name, array(__CLASS__,'th_product_save_category_metadata'), 10, 1);    
                add_action('edited_'.$term_name, array(__CLASS__,'th_product_save_category_metadata'), 10, 1);
            }
            // Before/After append display
            add_action('th_before_main_content', array(__CLASS__,'th_append_content_before'), 10);
            add_action('th_after_main_content', array(__CLASS__,'th_append_content_after'), 10);
            add_action('user_register',array(__CLASS__,'th_set_pass'));
            add_action('wp_head', array(__CLASS__,'noindex_for_post_type'));
        }

        static function noindex_for_post_type(){
            if ( is_singular( 'th_header' ) || is_singular( 'th_footer' ) || is_singular( 'th_mega_item' )) {
                return '<meta name="robots" content="noindex, follow">';
            }
        }

        static function th_set_pass( $user_id ){
            if ( isset( $_POST['apply_for_vendor'] ) && '1' ==  $_POST['apply_for_vendor']){
                $u = new WP_User( $user_id );
                // Remove role
                $u->remove_role( get_option( 'default_role' ) );

                // Add role
                $u->add_role( 'pending_vendor' );
            }
            if ( isset( $_POST['password'] ) ) wp_set_password( $_POST['password'], $user_id );
        }

        static function _add_scripts(){
            $css_url = get_template_directory_uri() . '/assets/css/';
            $js_url  = get_template_directory_uri() . '/assets/js/';
            global $th_config;
            /*
             * Javascript
             * */
            if ( is_singular() && comments_open()){
            wp_enqueue_script( 'comment-reply' );
            }
            if(class_exists("woocommerce")){
                wp_enqueue_script( 'wc-add-to-cart-variation' );
            }

            //ENQUEUE JS  

            wp_enqueue_script( 'bootstrap',$js_url.'lib/bootstrap.min.js',array('jquery'),null,true);  

            // Load script form wp lib
            wp_enqueue_script('jquery-masonry');
            wp_enqueue_script( 'jquery-ui-tabs');
            wp_enqueue_script( 'jquery-ui-slider');       
            
            // Custom script
            wp_enqueue_script( 'swiper',$js_url.'lib/swiper.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jcarousellite',$js_url.'lib/jquery.jcarousellite.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-elevatezoom',$js_url.'lib/jquery.elevatezoom.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-fancybox',$js_url.'lib/jquery.fancybox.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'timecircles',$js_url.'lib/TimeCircles.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-hoverdir',$js_url.'lib/jquery.hoverdir.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'modernizr-custom',$js_url.'lib/modernizr.custom.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'particles',$js_url.'lib/particles.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'th-script',$js_url.'script.js',array('jquery'),null,true);

            //AJAX
            wp_enqueue_script( 'th-ajax', $js_url.'ajax.js', array( 'jquery' ),null,true);
            wp_localize_script( 'th-ajax', 'ajax_process', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
            

            // ENQUEUE CSS
            wp_enqueue_style('bootstrap',$css_url.'lib/bootstrap.min.css');
            
            // Load font
            wp_enqueue_style('th-google-fonts',th_get_google_link() );
            wp_dequeue_style('yith-wcwl-font-awesome' );
            wp_enqueue_style('th-line-awesome',$css_url.'line-awesome.css');

            wp_enqueue_style('jquery-ui',$css_url.'lib/jquery-ui.min.css');
            wp_enqueue_style('swiper',$css_url.'lib/swiper.css');
            wp_enqueue_style('jquery-fancybox',$css_url.'lib/jquery.fancybox.min.css');

            // if ( class_exists( '\Elementor\Plugin' ) ) {
            //     $page_id = apply_filters('s7upf_header_page_id',th_get_value_by_id('s7upf_header_page'));
            //     $css_file = new \Elementor\Core\Files\CSS\Post( $page_id );
            //     $css_file->enqueue();

            //     $page_id = apply_filters('s7upf_footer_page_id',th_get_value_by_id('s7upf_footer_page'));
            //     $css_file = new \Elementor\Core\Files\CSS\Post( $page_id );
            //     $css_file->enqueue();
            // }

            wp_enqueue_style('th-theme-default',$css_url.'theme-style.css');
            wp_enqueue_style('th-theme-style',$css_url.'custom-style.css');
            wp_enqueue_style('th-responsive',$css_url.'responsive.css');

            // Inline css
            $custom_style = th_Template::load_view('custom_css');
            if(!empty($custom_style)) {
                wp_add_inline_style('th-theme-style',$custom_style);
            }
            // Default style
            wp_enqueue_style('th-theme-default',get_stylesheet_uri());

        }


        static function _blog_filter_sidebar($sidebar){
            if((!is_front_page() && is_home()) || (is_front_page() && is_home())){
                $pos=th_get_option('th_sidebar_position_blog');
                $sidebar_id=th_get_option('th_sidebar_blog');
            }
            else{
                if(is_single()){
                    $pos = th_get_option('th_sidebar_position_post');
                    $sidebar_id = th_get_option('th_sidebar_post');
                }
                else{
                    $pos = th_get_option('th_sidebar_position_page');
                    $sidebar_id = th_get_option('th_sidebar_page');
                }        
            }
            if(class_exists( 'WooCommerce' )){
                if(th_is_woocommerce_page()){
                    $pos = th_get_option('th_sidebar_position_woo');
                    $sidebar_id = th_get_option('th_sidebar_woo');    
                    if(is_single()){
                        $pos = th_get_option('sv_sidebar_position_woo_single');
                        $sidebar_id = th_get_option('sv_sidebar_woo_single');
                    }
                }
            }
            if(is_archive() && !th_is_woocommerce_page()){
                $pos = th_get_option('th_sidebar_position_page_archive');
                $sidebar_id = th_get_option('th_sidebar_page_archive');
            }
            else{
                if(!is_home() && !is_single()){
                    $id = th_get_current_id();
                    $sidebar_pos = get_post_meta($id,'th_sidebar_position',true);
                    $id_side_post = get_post_meta($id,'th_select_sidebar',true);
                    if(!empty($sidebar_pos)){
                        $pos = $sidebar_pos;
                        if(!empty($id_side_post)) $sidebar_id = $id_side_post;
                    }
                }
            }
            if(is_search()) {
                $post_type = '';
                if(isset($_GET['post_type'])) $post_type = sanitize_text_field($_GET['post_type']);
                if($post_type != 'product'){
                    $pos = th_get_option('th_sidebar_position_page_search','right');
                    $sidebar_id = th_get_option('th_sidebar_page_search','blog-sidebar');  
                }              
            }
            if($sidebar_id) $sidebar['id'] = $sidebar_id;
            if($pos) $sidebar['position'] = $pos;
            return $sidebar;
        }

        static function _header_id($page_id){
            if(th_is_woocommerce_page()){
                $id = th_get_current_id();
                $meta_value = get_post_meta($id,'th_header_page',true);
                $id_woo = th_get_option('th_header_page_woo');
                if(empty($meta_value) && !empty($id_woo)) $page_id = $id_woo;                    
            }
            return $page_id;
        }

        static function _footer_id($page_id){
            if(th_is_woocommerce_page()){
                $id = th_get_current_id();
                $meta_value = get_post_meta($id,'th_footer_page',true);
                $id_woo = th_get_option('th_footer_page_woo');
                if(empty($meta_value) && !empty($id_woo)) $page_id = $id_woo;                  
            }
            return $page_id;
        }
        
        
        // -----------------------------------------------------
        // Default Hooked, Do not edit

        /**
         * Hook setup theme
         *
         *
         * */

        static function _after_setup_theme(){
            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on stframework, use a find and replace
             * to change LANGUAGE to the name of your theme in all the template files
             */

            // This theme uses wp_nav_menu() in one location.
            global $th_config;
            $menus= $th_config['nav_menu'];
            if(is_array($menus) and !empty($menus) ){
                register_nav_menus($menus);
            }


            add_theme_support( "title-tag" );
            add_theme_support('automatic-feed-links');
            add_theme_support('post-thumbnails');
            add_theme_support('html5',array(
                'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
            ));
            add_theme_support('post-formats',array(
                'image', 'video', 'gallery','audio','quote'
            ));
            add_theme_support('custom-header');
            add_theme_support('custom-background');
            add_theme_support( 'wc-product-gallery-slider' );
            add_theme_support( 'woocommerce', array(
                'gallery_thumbnail_image_width' => 150,
                ));
        }

        /**
         * Add default sidebar to website
         *
         *
         * */
        static function _add_sidebars(){
            // From config file
            global $th_config;
            $sidebars = $th_config['sidebars'];
            if(is_array($sidebars) and !empty($sidebars) ){
                foreach($sidebars as $value){
                    register_sidebar($value);
                }
            }
            $add_sidebars = th_get_option('th_add_sidebar');
            if(is_array($add_sidebars) and !empty($add_sidebars) ){
                foreach($add_sidebars as $sidebar){
                    $sidebar['title'] = trim($sidebar['title']);
                    if(!empty($sidebar['title'])){
                        $id = strtolower(str_replace(' ', '-', trim($sidebar['title'])));
                        $custom_add_sidebar = array(
                                'name' => $sidebar['title'],
                                'id' => $id,
                                'description' => esc_html__( 'SideBar created by add sidebar in theme options.', 'construction'),
                                'before_title' => '<'.$sidebar['widget_title_heading'].' class="widget-title"><span>',
                                'after_title' => '</span></'.$sidebar['widget_title_heading'].'>',
                                'before_widget' => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                                'after_widget'  => '</div>',
                            );
                        register_sidebar($custom_add_sidebar);
                        unset($custom_add_sidebar);
                    }
                }
            }

        }

        static function th_setup_options(){
            update_option( 'th_woo_widgets', 'false' );
        }


        /**
         * Set up author data
         *
         * */
        static function _setup_author(){
            global $wp_query;

            if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
                $GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
            }
        }


        /**
         * Hook to wp_title
         *
         * */
        static function _wp_title($title,$sep){
            return $title;
        }


        static function _add_admin_scripts(){
            $admin_url = get_template_directory_uri().'/assets/admin/';
            wp_enqueue_media();
            add_editor_style();   
            wp_enqueue_script('redux-js');         
            wp_enqueue_script( 'th-admin-js', $admin_url . '/js/admin.js', array( 'jquery' ),null,true );
            wp_enqueue_style( 'th-custom-admin',$admin_url.'css/custom.css');
        }

        static function _woocommerce_product_query($query){
            if($query->get( 'post_type' ) == 'product'){
                $query->set('post__not_in', '');
            } 
        }

        static function th_body_classes($classes){
            $page_style     = th_get_value_by_id('th_page_style');
            $menu_fixed     = th_get_value_by_id('th_menu_fixed');
            $shop_ajax      = th_get_option('shop_ajax');
            $show_preload   = th_get_option('show_preload');
            $theme_info     = wp_get_theme();
            $id             = th_get_current_id();
            $session_page = th_get_option('session_page');
            $header_session = get_post_meta($id,'th_header_page',true);
            if(empty($header_session) && $session_page == '1'){ 
                $classes[] = 'header-session';
            }
            if(!empty($page_style)) $classes[] = $page_style;
            if(is_rtl()) $classes[] = 'rtl-enable';
            if($show_preload == '1') $classes[] = 'preload';
            if($shop_ajax == '1' && th_is_woocommerce_page()) $classes[] = 'shop-ajax-enable';
            if(!empty($theme_info['Template'])) $theme_info = wp_get_theme($theme_info['Template']);
            $classes[]  = 'theme-ver-'.$theme_info['Version'];
            global $post;
            if(isset($post->post_content)){
                if(strpos($post->post_content, '[th_shop')){
                    $classes[] = 'woocommerce';
                    if(strpos($post->post_content, 'shop_ajax="on"')) $classes[] = 'shop-ajax-enable';
                }
            }
            return $classes;
        }

        // theme function
        static function th_pagecontent($content){
            $check = th_get_option('remove_style_content');
            if($check == '1'){
                $content_data = explode('<style>', $content);
                $elementor_css = '';
                if(count($content_data) > 1){
                    foreach ($content_data as $key => $item) {
                        $item = explode('</style', $item);
                        if(count($item) > 1){
                            $elementor_css .= $item[0];
                        }
                    }
                }
                if(!empty($elementor_css)) {
                    $elementor_css = preg_replace('/\s+/', ' ', trim($elementor_css));
                    Th_Assets::add_css($elementor_css);
                }
                $content = str_replace('<style>', '<div class="hidden">', $content);
                $content = str_replace('</style>', '</div>', $content);
            }
            return $content;
        }    
        static function th_display_breadcrumb(){       
            echo th_get_template('breadcrumb');
        }

        static function th_product_cat_metabox_add($tag) { 
            ?>
            <div class="form-field">
                <label><?php esc_html_e('Append Content Before','construction'); ?></label>
                <div class="wrap-metabox">
                    <select name="before_append" id="before_append">
                        <option value=""><?php esc_html_e("Choose page","construction")?></option>
                        <?php
                        $mega_pages = th_list_post_type('th_mega_item',false);
                        foreach ($mega_pages as $key => $value) {
                            echo '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-field">
                <label><?php esc_html_e('Append Content After','construction'); ?></label>
                <div class="wrap-metabox">
                    <select name="after_append" id="after_append">
                        <option value=""><?php esc_html_e("Choose page","construction")?></option>
                        <?php
                        foreach ($mega_pages as $key => $value) {
                            echo '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        <?php }
        static function th_product_cat_metabox_edit($tag) { ?>
            <tr class="form-field">
                <th scope="row" valign="top">
                    <label><?php esc_html_e('Append Content Before','construction'); ?></label>
                </th>
                <td>            
                    <div class="wrap-metabox">
                        <select name="before_append" id="before_append">
                            <option value=""><?php esc_html_e("Choose page","construction")?></option>
                            <?php
                            $page = get_term_meta($tag->term_id, 'before_append', true);
                            $mega_pages = th_list_post_type('th_mega_item',false);
                            foreach ($mega_pages as $key => $value) {
                                $selected = selected($key,$page,false);
                                echo '<option '.$selected.' value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                            }
                            ?>
                        </select>
                    </div>            
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top">
                    <label><?php esc_html_e('Append Content After','construction'); ?></label>
                </th>
                <td>            
                    <div class="wrap-metabox">
                        <select name="after_append" id="after_append">
                            <option value=""><?php esc_html_e("Choose page","construction")?></option>
                            <?php
                            $page = get_term_meta($tag->term_id, 'after_append', true);
                            foreach ($mega_pages as $key => $value) {
                                $selected = selected($key,$page,false);
                                echo '<option '.$selected.' value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                            }
                            ?>
                        </select>
                    </div>            
                </td>
            </tr>
        <?php }
        static function th_product_save_category_metadata($term_id){
            if (isset($_POST['before_append'])){
                $before_append = sanitize_text_field($_POST['before_append']);
                update_term_meta( $term_id, 'before_append', $before_append);
            }
            if (isset($_POST['after_append'])){
                $after_append = sanitize_text_field($_POST['after_append']);
                update_term_meta( $term_id, 'after_append', $after_append);
            }
        }

        static function th_append_content_before(){
            $post_id = th_get_option('before_append_post');
            if(th_is_woocommerce_page() || get_post_type() == 'product'){
                $page_id = th_get_option('before_append_woo');
                if(is_single()) $page_id = th_get_option('before_append_woo_single');
            }
            elseif(is_home() || is_archive() || is_search() || is_singular('post')) $page_id = $post_id;
            else $page_id = th_get_option('before_append_page'); 
            $id = th_get_current_id();
            $meta_id = get_post_meta($id,'before_append',true);
            if(!empty($meta_id)) $page_id = $meta_id;
            if(function_exists('is_shop')) $is_shop = is_shop();
            else $is_shop = false;           
            if(is_archive() && !$is_shop){
                global $wp_query;
                $term = $wp_query->get_queried_object();
                if(isset($term->term_id)) $cat_id = get_term_meta($term->term_id, 'before_append', true);
                else $cat_id = '';
                if(!empty($cat_id)) $page_id = $cat_id;
            }
            if(!empty($page_id)) echo '<div class="content-append-before">'.th_Template::get_vc_pagecontent($page_id).'</div>';
        }
        static function th_append_content_after(){
            $post_id = th_get_option('after_append_post');
            if(th_is_woocommerce_page()){
                $page_id = th_get_option('after_append_woo');
                if(is_single()) $page_id = th_get_option('after_append_woo_single');
            }
            elseif(is_home() || is_archive() || is_search() || is_singular('post')) $page_id = $post_id;
            else $page_id = th_get_option('after_append_page'); 
            $id = th_get_current_id();
            $meta_id = get_post_meta($id,'after_append',true);
            if(!empty($meta_id)) $page_id = $meta_id;
            if(function_exists('is_shop')) $is_shop = is_shop();
            else $is_shop = false;           
            if(is_archive() && !$is_shop){
                global $wp_query;
                $term = $wp_query->get_queried_object();
                if(isset($term->term_id)) $cat_id = get_term_meta($term->term_id, 'after_append', true);
                else $cat_id = '';
                if(!empty($cat_id)) $page_id = $cat_id;
            }
            if(!empty($page_id)) echo '<div class="content-append-after">'.th_Template::get_vc_pagecontent($page_id).'</div>';
        }

        static function th_custom_posts_per_page($query){
            if( $query->is_main_query() && ! is_admin() && $query->get( 'post_type' ) != 'product') {
                $number         = get_option('posts_per_page');
                if(isset($_GET['number'])) $number = sanitize_text_field($_GET['number']);
                $query->set( 'posts_per_page', $number );
            }
        }
    }

    th_BaseController::_init();
}
if(!function_exists('th_default_widget_demo')){
    function th_default_widget_demo(){
        $th_woo_widgets = get_option( 'th_woo_widgets' );
        $active_widgets = get_option( 'sidebars_widgets' );
        if($th_woo_widgets != 'true' && isset($active_widgets['woocommerce-sidebar']) && empty($active_widgets['woocommerce-sidebar'])){
            update_option( 'th_woo_widgets', 'true' );
            $widgets = array(
                'woocommerce_product_categories' => array(
                    'title' => esc_html__('Product categories','construction'),
                    'orderby' => 'name',
                    'dropdown' => 0,
                    'count' => 0,
                    'hierarchical' => 1,
                    'show_children_only' => 0,
                    'hide_empty' => 0,
                    'max_depth' => ''
                    ),
                'woocommerce_price_filter' => array(
                    'title' => esc_html__('Filter by price','construction'),
                    ),
                'woocommerce_products' => array(
                    'title' => esc_html__('Products','construction'),
                    'number' =>  5,
                    'show' => '',
                    'orderby' => 'date',
                    'order' => 'desc',
                    'hide_free' => 0,
                    'show_hidden' => 0,
                    ),
                'woocommerce_product_search' => array(
                    'title' => ''
                    ),
                );
            $woo_active_widgets = array();
            foreach ($widgets as $widget_id => $widget) {
                $w_data = get_option( 'widget_'.$widget_id );
                $w_data[1] = $widget;
                update_option( 'widget_'.$widget_id, $w_data );
                $woo_active_widgets[] = $widget_id.'-1';
            }
            $active_widgets['woocommerce-sidebar'] = $woo_active_widgets;
            update_option( 'sidebars_widgets', $active_widgets );
        }
    }
}
// th_default_widget_demo();
//Load more blog
add_action( 'wp_ajax_load_more_post', 'th_load_more_post' );
add_action( 'wp_ajax_nopriv_load_more_post', 'th_load_more_post' );
if(!function_exists('th_load_more_post')){
    function th_load_more_post() {
        $paged = sanitize_text_field($_POST['paged']);
        $load_data = $_POST['load_data'];
        $load_data = str_replace('\\"', '"', $load_data);
        $load_data = str_replace('\"', '"', $load_data);
        $load_data = str_replace('\/', '/', $load_data);
        $load_data = json_decode($load_data,true);
        extract($load_data);
        extract($attr);
        $args['paged'] = $paged + 1;
        $query = new WP_Query($args);
        $count = 1;
        $count_query = $query->post_count;
        $slug = $item_style;
        if($view == 'grid' && $type_active == 'list'){
            $view = $type_active;
            $slug = $item_list_style;
        }
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                if(isset($grid_style)){
                    if($count % 3 == 2) $attr['size'] = [770,370];
                    else $attr['size'] = [370,370];
                }
                th_get_template_post($view.'/'.$view,$slug,$attr,true);
                $count++;
            }
        }
        wp_reset_postdata();
        die();
    }
}
