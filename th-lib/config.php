<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!function_exists('th_set_theme_config')){
    function th_set_theme_config(){
        global $th_dir,$th_config,$redux_option;
        /**************************************** BEGIN ****************************************/
        $th_dir = get_template_directory_uri();
        $redux_option = true;
        $th_config = array();
        $th_config['dir'] = $th_dir;
        $th_config['css_url'] = $th_dir . '/assets/css/';
        $th_config['js_url'] = $th_dir . '/assets/js/';
        $th_config['bootstrap_ver'] = '3';
        $th_config['nav_menu'] = array(
            'primary' => esc_html__( 'Primary Navigation', 'construction' ),
        );
        $th_config['mega_menu'] = '1';
        $th_config['sidebars']=array(
            array(
                'name'              => esc_html__( 'Blog Sidebar', 'construction' ),
                'id'                => 'blog-sidebar',
                'description'       => esc_html__( 'Widgets in this area will be shown on all blog page.', 'construction'),
                'before_title'      => '<h3 class="widget-title"><span>',
                'after_title'       => '</span></h3>',
                'before_widget'     => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                'after_widget'      => '</div>',
            )
        );
        if(class_exists("woocommerce")){
            $th_config['sidebars'][] = array(
                'name'              => esc_html__( 'WooCommerce Sidebar', 'construction' ),
                'id'                => 'woocommerce-sidebar',
                'description'       => esc_html__( 'Widgets in this area will be shown on all woocommerce page.', 'construction'),
                'before_title'      => '<h3 class="widget-title"><span>',
                'after_title'       => '</span></h3>',
                'before_widget'     => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                'after_widget'      => '</div>',
            );
        }
        $th_config['import_config'] = array(
                'demo_url'                  => 'construction.ththeme.net',
                'homepage_default'          => 'Home',
                'blogpage_default'          => 'Blog',
                'menu_replace'              => 'Main Menu',
                'menu_locations'            => array("Main Menu" => "primary"),
                'set_woocommerce_page'      => 1
            );
        $th_config['import_theme_option'] = '{"last_tab":"1","th_header_page":"5451","th_footer_page":"5460","th_404_page":"","th_404_page_style":"","th_show_breadrumb":"","th_bg_breadcrumb":{"background-color":"","background-repeat":"","background-size":"","background-attachment":"","background-position":"","background-image":"","media":{"id":"","height":"","width":"","thumbnail":""}},"breadcrumb_text":{"font-family":"","font-options":"","google":"1","font-weight":"","font-style":"","subsets":"","text-align":"","font-size":"","line-height":"","color":""},"breadcrumb_text_hover":{"font-family":"","font-options":"","google":"1","font-weight":"","font-style":"","subsets":"","text-align":"","font-size":"","line-height":"","color":""},"show_preload":"1","preload_bg":{"color":"","alpha":"1","rgba":""},"preload_style":"style6","show_scroll_top":"1","show_wishlist_notification":"","show_too_panel":"","remove_style_content":"","tool_panel_page":"","body_bg":{"color":"","alpha":"1","rgba":""},"main_color":{"color":"","alpha":"","rgba":""},"main_color2":{"color":"","alpha":"","rgba":""},"th_page_style":"","container_width":"","before_append_post":"193","after_append_post":"","th_sidebar_position_blog":"right","th_sidebar_blog":"blog-sidebar","blog_default_style":"list","blog_style":"","blog_title":"1","blog_number_filter":"1","blog_number_filter_list":{"redux_repeater_data":[{"title":""}]},"title":["",""],"number":["",""],"blog_type_filter":"1","post_list_size":"","post_list_item_style":"style2","post_grid_column":"2","post_grid_size":"","post_grid_excerpt":"80","post_grid_item_style":"","post_grid_type":"","th_sidebar_position_post":"right","th_sidebar_post":"blog-sidebar","post_single_thumbnail":"1","post_single_size":"","post_single_meta":"1","post_single_author":"1","post_single_navigation":"1","post_single_related":"1","post_single_related_title":"","post_single_related_number":"","post_single_related_item":"","post_single_related_item_style":"","th_sidebar_position_page":"no","th_sidebar_page":"","th_sidebar_position_page_archive":"right","th_sidebar_page_archive":"blog-sidebar","th_sidebar_position_page_search":"","th_sidebar_page_search":"","th_add_sidebar":{"redux_repeater_data":[{"title":""}]},"widget_title_heading":["h3"],"th_custom_typography":{"redux_repeater_data":[{"title":""}]},"typo_area":["body"],"typo_heading":[""],"typography_style":[{"font-family":"","font-options":"","google":"1","font-weight":"","font-style":"","subsets":"","text-align":"","font-size":"","line-height":"","color":""}],"th_sidebar_position_woo":"right","th_sidebar_woo":"woocommerce-sidebar","shop_default_style":"grid","shop_gap_product":"","woo_shop_number":"12","sv_set_time_woo":"","shop_style":"","shop_ajax":"","shop_thumb_animation":"","shop_number_filter":"1","shop_number_filter_list":{"redux_repeater_data":[{"title":""}]},"shop_type_filter":"1","shop_list_size":"","shop_list_item_style":"","shop_grid_column":"3","shop_grid_size":"","shop_grid_item_style":"style4","shop_grid_type":"","cart_page_style":"style2","checkout_page_style":"style2","th_header_page_woo":"","th_footer_page_woo":"","before_append_woo":"185","after_append_woo":"","product_single_style":"style2","sv_sidebar_position_woo_single":"no","sv_sidebar_woo_single":"","product_image_zoom":"zoom-style4","product_tab_detail":"","show_excerpt":"1","show_latest":"0","show_upsell":"0","show_related":"1","show_single_number":"6","show_single_size":"","show_single_itemres":"","show_single_item_style":"style6","before_append_woo_single":"185","before_append_tab":"","after_append_tab":"","after_append_woo_single":"","redux-backup":1}';
        $th_config['import_widget'] = '{"sidebar-store":{"woocommerce_product_categories-4":{"title":"Product categories","orderby":"name","dropdown":0,"count":0,"hierarchical":1,"show_children_only":0,"hide_empty":0,"max_depth":""},"woocommerce_products-5":{"title":"Products","number":5,"show":"","orderby":"date","order":"desc","hide_free":0,"show_hidden":0},"woocommerce_product_tag_cloud-5":{"title":"Product tags"}},"blog-sidebar":{"search-3":{"title":""},"categories-4":{"title":"","count":0,"hierarchical":0,"dropdown":0},"woocommerce_products-6":{"title":"New Products","number":5,"show":"","orderby":"date","order":"desc","hide_free":0,"show_hidden":0},"tag_cloud-4":{"title":"","count":0,"taxonomy":"post_tag"}},"woocommerce-sidebar":{"woocommerce_product_search-3":{"title":""},"woocommerce_product_categories-5":{"title":"Product categories","orderby":"name","dropdown":0,"count":0,"hierarchical":1,"show_children_only":0,"hide_empty":1,"max_depth":""},"woocommerce_products-7":{"title":"Featured Products","number":4,"show":"featured","orderby":"date","order":"desc","hide_free":0,"show_hidden":0},"woocommerce_product_tag_cloud-6":{"title":"Product tags"}}}';
        $th_config['elementor_settings'] = '{"template":"default","system_colors":[{"_id":"primary","title":"Primary","color":"#333333"},{"_id":"secondary","title":"Secondary","color":"#DD1D26"},{"_id":"text","title":"Text","color":"#555555"},{"_id":"accent","title":"Accent"}],"custom_colors":[{"_id":"0070b03","title":"Color 2","color":"#DD1D26"},{"_id":"86b4d1b","title":"White","color":"#FFFFFF"},{"_id":"01bc2ae","title":"Black","color":"#000000"},{"_id":"99d4f0f","title":"Border","color":"#E5E5E5"},{"_id":"dc78774","title":"Color 3","color":"#CE1B76"},{"_id":"12715f7","title":"Color #999","color":"#999999"},{"_id":"6c8ea4d","title":"bg #fafafa","color":"#FAFAFA"},{"_id":"58cd26d","title":"Color 4","color":"#38EDC0"},{"_id":"5bd4e9b","title":"Color 5","color":"#5C54EC"},{"_id":"afda729","title":"Color #6b6b6b","color":"#6B6B6B"},{"_id":"cd116bf","title":"Color 6","color":"#2EC840"},{"_id":"0b2ec6f","title":"Color 7","color":"#FFC600"},{"_id":"b1de05a","title":"Color 8","color":"#288DD3"},{"_id":"cbe8f9d","title":"#7e7e7e","color":"#7E7E7E"}],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_line_height":{"unit":"em","size":1.3,"sizes":[]}},{"_id":"secondary","title":"Secondary","typography_typography":"custom"},{"_id":"text","title":"Text","typography_typography":"custom","typography_line_height":{"unit":"em","size":1.5,"sizes":[]}},{"_id":"accent","title":"Accent","typography_typography":"custom"}],"custom_typography":[{"typography_typography":"custom","typography_font_size":{"unit":"px","size":60,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":48,"sizes":[]},"typography_font_weight":"bold","typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"_id":"9144d0e","title":"Title 60","typography_font_size_mobile":{"unit":"px","size":36,"sizes":[]}},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":48,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":36,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":30,"sizes":[]},"typography_line_height":{"unit":"em","size":1.2,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"ac5608f","title":"Title home","typography_font_weight":"bold","typography_font_size_tablet":{"unit":"px","size":36,"sizes":[]}},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":18,"sizes":[]},"typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"_id":"1aa392a","title":"Title 2","typography_font_weight":"bold"},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":36,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":30,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":24,"sizes":[]},"typography_font_weight":"bold","typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"12b682c","title":"Title home - normal"},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":20,"sizes":[]},"typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"a4dd5f0","title":"Title 2 - font","typography_font_weight":"600"},{"_id":"c66b30f","title":"Footer title","typography_typography":"custom","typography_font_size":{"unit":"px","size":20,"sizes":[]},"typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_font_weight":"600"},{"typography_typography":"custom","typography_font_family":"Mr Dafoe","typography_font_size":{"unit":"px","size":160,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":30,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":24,"sizes":[]},"typography_font_weight":"normal","typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_letter_spacing":{"unit":"px","size":15,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"5d13eb2","title":"Mr Dafoe 160"},{"typography_typography":"custom","typography_font_family":"Mr Dafoe","typography_font_size":{"unit":"px","size":80,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":30,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":24,"sizes":[]},"typography_font_weight":"normal","typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_letter_spacing":{"unit":"px","size":15,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"7ee7080","title":"Mr Dafoe 80"},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":36,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":28,"sizes":[]},"typography_font_size_tablet":{"unit":"px","size":28,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":26,"sizes":[]},"typography_font_weight":"bold","typography_line_height":{"unit":"em","size":1.2,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"74dd19d","title":"Title home - 36"},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":50,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":36,"sizes":[]},"typography_font_size_tablet":{"unit":"px","size":36,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":36,"sizes":[]},"typography_font_weight":"bold","typography_line_height":{"unit":"em","size":1.2,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"af0fea4","title":"Title home - 50"},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":60,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":36,"sizes":[]},"typography_font_size_tablet":{"unit":"px","size":36,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":30,"sizes":[]},"typography_font_weight":"bold","typography_line_height":{"unit":"em","size":1.2,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"4fcf340","title":"title 60"}],"default_generic_fonts":"Sans-serif","button_typography_typography":"custom","page_title_selector":"h1.entry-title","activeItemIndex":1,"viewport_md":768,"viewport_lg":1025,"active_breakpoints":["viewport_mobile","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"body_background_background":"classic","container_width":{"unit":"px","size":1440,"sizes":[]},"__globals__":{"button_background_color":"globals\/colors?id=secondary","button_hover_background_color":"","button_text_color":"globals\/colors?id=86b4d1b","button_border_color":"","button_hover_text_color":"globals\/colors?id=86b4d1b"},"button_border_radius":{"unit":"px","top":"4","right":"4","bottom":"4","left":"4","isLinked":true},"button_typography_font_weight":"600","button_text_color":"#FFFFFF","button_background_color":"#DD1D26","button_hover_text_color":"#FFFFFF","button_hover_background_color":"#000000","button_typography_font_size":{"unit":"px","size":16,"sizes":[]}}';
        $th_config['import_category'] = '';

        /**************************************** PLUGINS ****************************************/
        $th_config['require-plugin'] = array(
            array(
                'name'      => esc_html__( 'Core THTheme', 'construction'),
                'slug'      => 'core-ththeme',
                'required'  => true,
                'source'    => get_template_directory().'/plugins/core-ththeme.zip',
                'version'   => '1.3'
            ),
            array(
                'name'      => esc_html__( 'Slider Revolution', 'construction'),
                'slug'      => 'revslider',
                'required'  => true,
                'source'    => get_template_directory().'/plugins/revslider.zip',
            ),        
            array(
                'name'      => esc_html__( 'Elementor', 'construction'),
                'slug'      => 'elementor',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__( 'Redux Framework', 'construction'),
                'slug'      => 'redux-framework',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__( 'WooCommerce', 'construction'),
                'slug'      => 'woocommerce',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__( 'Contact Form 7', 'construction'),
                'slug'      => 'contact-form-7',
                'required'  => false,
            ),
            array(
                'name'      => esc_html__('MailChimp for WordPress Lite','construction'),
                'slug'      => 'mailchimp-for-wp',
                'required'  => false,
            ),
            array(
                'name'      => esc_html__('Yith WooCommerce Compare','construction'),
                'slug'      => 'yith-woocommerce-compare',
                'required'  => false,
            ),
            array(
                'name'      => esc_html__('Yith WooCommerce Wishlist','construction'),
                'slug'      => 'yith-woocommerce-wishlist',
                'required'  => false,
            ),
            array(
                'name'      => esc_html__('Dokan – Best WooCommerce Multivendor Marketplace Solution','construction'),
                'slug'      => 'dokan-lite',
                'required'  => false,
            ),
        );

    /**************************************** PLUGINS ****************************************/
        
        
    }
}
th_set_theme_config();