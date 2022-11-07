<?php
if(!function_exists('th_get_redux_option')){
    function th_get_redux_option($key){
        $option_name = th_get_option_name();
        $th_theme_option = get_option($option_name);
        if(isset($th_theme_option[$key])){
            $values = $th_theme_option[$key];
            if(isset($values['rgba']) && isset($values['color'])){
                if($values['alpha'] != '1') $values = $values['rgba'];
                else $values = $values['color'];
            }
            return $values;
        }
        else return null;
    }
}
if(!function_exists('th_get_option_name')){
    function th_get_option_name(){
        $th_option_name = apply_filters('th_option_name',"th_theme_option");
        return $th_option_name;
    }
}
//Get option
if(!function_exists('th_get_option')){
    function th_get_option($key,$default=NULL){
        if(class_exists('Redux')){
            $value = th_get_redux_option($key);
            if(empty($value) && $default !== NULL && $value !== "0") $value = $default;
            if(isset($value['redux_repeater_data'])) $value = $value['redux_repeater_data'];
            return $value;
        }
        else{
            if(function_exists('ot_get_option')){
                $value = ot_get_option($key,$default);
                if(empty($value) && $default) $value = $default;
                return $value;
            }
        }
        return $default;
    }
}
//Get list post type
if(!function_exists('th_list_post_type')){
    function th_list_post_type($post_type = 'page',$add_empty = false,$convert = false){
        global $post;
        $post_temp = $post;
        $page_list = array();
        if($add_empty){
            if(!$convert) $page_list[''] = esc_html__('-- Choose One --','construction');
            else{
                $page_list[] = array(
                                'label' => esc_html__('--Select--','construction'),
                                'value' => 'none',
                            );
            }
        }
        if(is_admin()){
            $pages = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
            if(is_array($pages)){
                foreach ($pages as $page){
                    if(!$convert) $page_list[$page->ID] = $page->post_title;
                    else{
                        $page_list[] = array(
                                'label' => $page->post_title,
                                'value' => $page->ID,
                            );
                    }
                }
            }
        }
        $post = $post_temp;
        return $page_list;
    }
}
if(!function_exists('th_add_html_attr')){   
    function th_add_html_attr($value,$echo = false,$attr='style'){
        $output = '';
        if(!empty($attr)){
            $output = $attr.'="'.$value.'"';
        }
        if($echo) echo apply_filters('th_output_content',$output);
        else return $output;
    }
}
if(!function_exists('th_add_style_tag')){   
    function th_add_style_tag($value,$echo = false,$tag='style'){
        $output = '';
        if(!empty($tag)){
            $output = '<'.$tag.'>'.$value.'</style>';
        }
        if($echo) echo apply_filters('th_output_content',$output);
        else return $output;
    }
}
if ( !function_exists( 'th_get_google_link' ) ) {
    function th_get_google_link() {
        $font_url = '';
        $fonts  = array(
                    'Outfit:300,400,500,600,700',
                );
        if ( 'off' !== _x( 'on', 'Google font: on or off', 'construction' ) ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
            ), "//fonts.googleapis.com/css" );
        }

        return $fonts_url;
    }
}
//Get current ID
if(!function_exists('th_get_current_id')){   
    function th_get_current_id(){
        $id = get_the_ID();
        if(is_front_page() && is_home()) $id = (int)get_option( 'page_on_front' );
        if(!is_front_page() && is_home()) $id = (int)get_option( 'page_for_posts' );
        if(is_archive() || is_search()) $id = 0;
        if (class_exists('woocommerce')) {
            if(is_shop()) $id = (int)get_option('woocommerce_shop_page_id');
            if(is_cart()) $id = (int)get_option('woocommerce_cart_page_id');
            if(is_checkout()) $id = (int)get_option('woocommerce_checkout_page_id');
            if(is_account_page()) $id = (int)get_option('woocommerce_myaccount_page_id');
        }
        return $id;
    }
}
//Get page value by ID
if(!function_exists('th_get_value_by_id')){   
    function th_get_value_by_id($key,$meta_empty = false){
        if(!empty($key)){
            $id = th_get_current_id();
            $value = get_post_meta($id,$key,true);
            if(isset($value['rgba']) && isset($value['color'])){
                if($value['alpha'] != '1') $value = $value['rgba'];
                else $value = $value['color'];
            }
            if(empty($value) && !$meta_empty) $value = th_get_option($key);
            $session_page = th_get_option('session_page');
            if($session_page == '1'){
                if($key == 'th_header_page' || $key == 'th_footer_page' || $key == 'main_color' || $key == 'main_color2'){
                    $val_meta = get_post_meta($id,$key,true);
                    if(!empty($val_meta)) $_SESSION[$key] = $val_meta;
                    if(isset($_SESSION[$key])) $session_val = $_SESSION[$key];
                    else $session_val = '';
                    if(!empty($session_val)) $value = $session_val;
                }
            }
            return $value;
        }
        else return 'Missing a variable of this funtion';
    }
}

//Check woocommerce page
if (!function_exists('th_is_woocommerce_page')){
    function th_is_woocommerce_page() {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                }
        }
        return false;
    }
}
if(!function_exists('th_preload')){
    function th_preload(){
        $preload = th_get_option('show_preload');
        if($preload == '1'):
            $preload_style = th_get_option('preload_style');
            $preload_bg = th_get_option('preload_bg');
            $preload_img = th_get_option('preload_img');
            if(isset($preload_img['url'])) $preload_img = $preload_img['url'];
        ?>
        <div id="loading" class="preload-loading preload-style-<?php echo esc_attr($preload_style)?>">
            <div id="loading-center">
                <?php
                switch ($preload_style) {
                    case 'style2':
                        ?>
                        <div id="loading-center-absolute">
                            <div id="object<?php echo esc_attr($preload_style)?>"></div>
                        </div>
                        <?php
                        break;

                    case 'style3':
                        ?>
                        <div id="loading-center-absolute<?php echo esc_attr($preload_style)?>">
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_one<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_two<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_three<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_four<?php echo esc_attr($preload_style)?>"></div>
                        </div>
                        <?php
                        break;

                    case 'style4':
                        ?>
                        <div id="loading-center-absolute<?php echo esc_attr($preload_style)?>">
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_one<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_two<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_three<?php echo esc_attr($preload_style)?>"></div>
                        </div>
                        <?php
                        break;

                    case 'style5':
                        ?>
                        <div id="loading-center-absolute<?php echo esc_attr($preload_style)?>">
                            <div class="object<?php echo esc_attr($preload_style)?>" id="first_object<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="second_object<?php echo esc_attr($preload_style)?>"></div>
                        </div>
                        <?php
                        break;

                    case 'style6':
                        ?>
                        <div id="loading-center-absolute<?php echo esc_attr($preload_style)?>">
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_one<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_two<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_three<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_four<?php echo esc_attr($preload_style)?>"></div>
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_five<?php echo esc_attr($preload_style)?>"></div>
                        </div>
                        <?php
                        break;

                    case 'style7':
                        ?>
                        <div id="loading-center-absolute<?php echo esc_attr($preload_style)?>">
                            <div class="object<?php echo esc_attr($preload_style)?>" id="object_one<?php echo esc_attr($preload_style)?>"></div>
                        </div>
                        <?php
                        break;

                    case 'custom-image':
                        ?>
                        <div id="loading-center-absolute-image">
                            <img src="<?php echo esc_url($preload_img)?>" alt="<?php esc_attr_e("preload-image","construction");?>"/>
                        </div>
                        <?php
                        break;
                    
                    default:
                        ?>
                        <div id="loading-center-absolute">
                            <div class="object" id="object_four"></div>
                            <div class="object" id="object_three"></div>
                            <div class="object" id="object_two"></div>
                            <div class="object" id="object_one"></div>
                        </div>
                        <?php
                        break;
                }
                ?> 
            </div>
        </div>
        <?php endif;
    }
}
if(!function_exists('th_get_template')){
    function th_get_template( $view_name,$slug=false,$data=array(),$echo=FALSE ){
        $html = th_Template::load_view($view_name,$slug,$data,$echo);
        if(!$echo) return $html;
    }
}
if(!function_exists('th_get_template_post')){
    function th_get_template_post( $view_name,$slug=false,$data=array(),$echo=FALSE ){
        $view_name = 'posts/'.$view_name;
        $html = th_Template::load_view($view_name,$slug,$data,$echo);
        if(!$echo) return $html;
    }
}
if(!function_exists('th_get_template_element')){
    function th_get_template_element( $view_name,$slug=false,$data=array(),$echo=FALSE ){
        $view_name = 'elements/'.$view_name;
        $html = th_Template::load_view($view_name,$slug,$data,$echo);
        if(!$echo) return $html;
    }
}
if(!function_exists('th_get_template_widget')){
    function th_get_template_widget( $view_name,$slug=false,$data=array(),$echo=FALSE ){
        $view_name = 'widgets/'.$view_name;
        $html = th_Template::load_view($view_name,$slug,$data,$echo);
        if(!$echo) return $html;
    }
}
if(!function_exists('th_get_template_product')){
    function th_get_template_product( $view_name,$slug=false,$data=array(),$echo=FALSE ){
        $view_name = 'products/'.$view_name;
        $html = th_Template::load_view($view_name,$slug,$data,$echo);
        if(!$echo) return $html;
    }
}
if(!function_exists('th_get_template_woocommerce')){
    function th_get_template_woocommerce( $view_name,$slug=false,$data=array(),$echo=FALSE ){
        $view_name = 'woocommerce/'.$view_name;
        $html = th_Template::load_view($view_name,$slug,$data,$echo);
        if(!$echo) return $html;
    }
}
if(!function_exists('th_get_template_widget')){
    function th_get_template_widget( $view_name,$slug=false,$data=array(),$echo=FALSE ){
        $view_name = 'widgets/'.$view_name;
        $html = th_Template::load_view($view_name,$slug,$data,$echo);
        if(!$echo) return $html;
    }
}
if(!function_exists('th_output_sidebar')){
    function th_output_sidebar($position){
        $sidebar = th_get_sidebar();
        $sidebar_pos = $sidebar['position'];
        if($sidebar_pos == $position) get_sidebar();
    }
}
if(!function_exists('th_get_sidebar_list')){
    function th_get_sidebar_list(){
        global $wp_registered_sidebars;
        $sidebars = array(
            esc_html__('--Select--','construction') => ''
            );
        foreach( $wp_registered_sidebars as $id=>$sidebar ) {
          $sidebars[ $sidebar[ 'name' ] ] = $id;
        }
        return $sidebars;
    }
}
// Get sidebar
if(!function_exists('th_get_sidebar')){
    function th_get_sidebar(){
        $default=array(
            'position'=>'right',
            'id'      =>'blog-sidebar'
        );
        if(class_exists("woocommerce") && th_is_woocommerce_page()) $default['id'] = 'woocommerce-sidebar';
        return apply_filters('th_get_sidebar',$default);
    }
}
// Check sidebar
if(!function_exists('th_check_sidebar')){
    function th_check_sidebar(){
        $sidebar = th_get_sidebar();
        if($sidebar['position'] == 'no') return false;
        else return true;
    }
}
if(!function_exists('th_get_main_class')){
    function th_get_main_class(){
        $sidebar=th_get_sidebar();
        $sidebar_pos=$sidebar['position'];
        $main_class = 'content-wrap col-md-12 col-sm-12 col-xs-12';
        if($sidebar_pos != 'no' && is_active_sidebar( $sidebar['id'])) $main_class = 'content-wrap content-sidebar-'.$sidebar_pos.' col-md-9 col-sm-8 col-xs-12';
        return apply_filters('th_main_class',$main_class);
    }
}
if(!function_exists('th_get_size_crop')){
    function th_get_size_crop($size='',$default=''){
        if(!empty($size) && strpos($size, 'x')){
            $size = str_replace('|', 'x', $size);
            $size = str_replace(',', 'x', $size);
            $size = explode('x', $size);
        }
        if(empty($size) && !empty($default)) $size = $default;
        return $size;
    }
}
// MetaBox
if(!function_exists('th_display_metabox')){ 
    function th_display_metabox($type ='', $data = array(), $split = '|'){
        switch ($type) {
            case 'el-post':

                break;

            default:
                if(empty($data)) $data = ['author','date','comments'];
                ?>
                <ul class="list-inline-block post-meta-data">
                    <?php
                    if(!empty($data)){
                        foreach ($data as $key => $value) {
                            switch ($value) {
                                case 'date':
                                    ?>
                                    <li class="meta-item"><i class="la la-calendar"></i><span class="silver"><?php echo get_the_date()?></span></li>
                                    <?php
                                    //  if($key < (count($data)-1) && $split) echo '<li class="split">'.$split.'</li>';
                                    ?>
                                    <?php
                                    break;

                                case 'cats':
                                    $cats = get_the_category_list(' ');
                                    if($cats):?>
                                        <li class="meta-item"><i class="la la-folder-open" aria-hidden="true"></i>                            
                                            <?php echo apply_filters('th_output_content',$cats);?>
                                        </li>
                                        <?php 
                                        // if($key < (count($data)-1) && $split) echo '<li class="split">'.$split.'</li>';
                                        ?>
                                    <?php endif;
                                    break;

                                case 'tags':
                                    $tags = get_the_tag_list(' ',' ',' ');
                                    if($tags):?>
                                        <li class="meta-item"><i class="la la-tags" aria-hidden="true"></i>
                                            <?php $tags = get_the_tag_list(' ',' ',' ');?>
                                            <?php if($tags) echo apply_filters('th_output_content',$tags); else esc_html_e("No Tag",'construction');?>
                                        </li>
                                        <?php 
                                        // if($key < (count($data)-1) && $split) echo '<li class="split">'.$split.'</li>';
                                        ?>
                                    <?php endif;
                                    break;

                                case 'comments':
                                    ?>
                                    <li class="meta-item"><i aria-hidden="true" class="la la-comment"></i>
                                        <a href="<?php echo esc_url( get_comments_link() ); ?>"><?php echo get_comments_number(); ?> 
                                        <?php 
                                            if(get_comments_number() != 1) esc_html_e('Comments', 'construction') ;
                                            else esc_html_e('Comment', 'construction') ;
                                        ?>
                                        </a>
                                    </li>
                                    <?php 
                                    // if($key < (count($data)-1) && $split) echo '<li class="split">'.$split.'</li>';
                                    ?>
                                    <?php
                                    break;

                                case 'views':
                                    ?>
                                    <li class="meta-item"><i class="la la-eye"></i>
                                        <span class="silver"><?php echo th_get_post_view(). ' ';
                                        if(th_get_post_view() != 1) echo esc_html__("Views",'construction');
                                        else echo esc_html__("View",'construction');
                                        ?>
                                        </span>
                                    </li>
                                    <?php if($key < (count($data)-1) && $split) echo '<li class="split">'.$split.'</li>';?>
                                    <?php
                                    break;

                                default:
                                    ?>
                                    <li class="meta-item"><i class="la la-user" aria-hidden="true"></i><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_the_author(); ?></a></li>
                                    <?php 
                                    // if($key < (count($data)-1) && $split) echo '<li class="split">'.$split.'</li>';
                                    ?>
                                    <?php
                                    break;
                            }                            
                        }                        
                    }
                    ?>
                </ul>               
                <?php
                break;
        }
    }
}
//navigation
if(!function_exists('th_paging_nav')){
    function th_paging_nav($query = false,$style = '',$echo = true){
        if($query){
            $big = 999999999;
            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
            $links = array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'       => '&page=%#%',
                    'current'      => max( 1, $paged ),
                    'total'        => $query->max_num_pages,
                    'end_size'     => 2,
                    'mid_size'     => 1
                );
        }
        else{
            if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
                return;
            }

            $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
            $pagenum_link = html_entity_decode( get_pagenum_link() );
            $query_args   = array();
            $url_parts    = explode( '?', $pagenum_link );

            if ( isset( $url_parts[1] ) ) {
                wp_parse_str( $url_parts[1], $query_args );
            }

            $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
            $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

            $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
            $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

            // Set up paginated links.
            $links = array(
                'base'          => $pagenum_link,
                'format'        => $format,
                'total'         => $GLOBALS['wp_query']->max_num_pages,
                'current'       => $paged,
                'end_size'      => 2,
                'mid_size'      => 1,
                'add_args'      => array_map( 'urlencode', $query_args ),
            );
        }
        $data = array(
            'links' => $links,
            'style' => $style,
        );
        $html = th_get_template( 'paging-nav', false, $data, $echo );
        if(!$echo) return $html;
    }
}
if(!function_exists('th_get_post_list_style')){
    function th_get_post_list_style(){
        $list = apply_filters('th_post_list_item_style',array(
            '' => esc_html__('Default','construction'),
            'style2' => esc_html__('Post list 2','construction'),
            'style3' => esc_html__('Post list 3','construction'),
            'style4' => esc_html__('Post list 4','construction'),
            'style5' => esc_html__('Post list 5','construction'),
            ));        
        return $list;
    }
}
if(!function_exists('th_get_post_style')){
    function th_get_post_style($style = 'element'){
        $list = apply_filters('th_post_item_style',array(
            '' => esc_html__('Default','construction'),
            'style2' => esc_html__('Post grid 2','construction'),
            ));
        
        return $list;
    }
}
if(!function_exists('th_get_product_thumb_animation')){
    function th_get_product_thumb_animation($style = 'element'){
        $list = apply_filters('th_product_item_style',array(
            ''                  => esc_html__('None','construction'),
            'zoom-thumb'        => esc_html__('Zoom','construction'),
            'rotate-thumb'      => esc_html__('Rotate','construction'),
            'zoomout-thumb'     => esc_html__('Zoom Out','construction'),
            'translate-thumb'   => esc_html__('Translate','construction'),
            ));
        return $list;
    }
}
if(!function_exists('th_get_thumb_animation')){
    function th_get_thumb_animation($style = 'element'){
        $list = apply_filters('th_thumb_animation',array(
            ''                          => esc_html__("Default",'construction'),
            'zoom-image'                => esc_html__("Zoom",'construction'),
            'fade-out-in'               => esc_html__("Fade out-in",'construction'),
            'zoom-image fade-out-in'    => esc_html__("Zoom Fade out-in",'construction'),
            'fade-in-out'               => esc_html__("Fade in-out",'construction'),
            'zoom-rotate'               => esc_html__("Zoom rotate",'construction'),
            'zoom-rotate fade-out-in'   => esc_html__("Zoom rotate Fade out-in",'construction'),
            'overlay-image'             => esc_html__("Overlay",'construction'),
            'overlay-image zoom-image'  => esc_html__("Overlay Zoom",'construction'),
            'zoom-image line-scale'     => esc_html__("Zoom image line",'construction'),
            'gray-image'                => esc_html__("Gray image",'construction'),
            'gray-image line-scale'     => esc_html__("Gray image line",'construction'),
            'pull-curtain'              => esc_html__("Pull curtain",'construction'),
            'pull-curtain gray-image'   => esc_html__("Pull curtain gray image",'construction'),
            'pull-curtain zoom-image'   => esc_html__("Pull curtain zoom image",'construction'),
        ));
        return $list;
    }
}
if(!function_exists('th_get_product_list_style')){
    function th_get_product_list_style(){
        $list = apply_filters('th_product_list_item_style',array(
            ''          => esc_html__('Default','construction'),
            'style2'    => esc_html__('Product list 2','construction'),
            ));
        return $list;
    }
}
if(!function_exists('th_get_product_style')){
    function th_get_product_style($style = 'element'){
        $list = apply_filters('th_product_item_style',array(
            ''          => esc_html__('Default','construction'),
            'style2'    => esc_html__('Product grid 2','construction'),
            'style3'    => esc_html__('Product grid 3','construction'),
            'style4'    => esc_html__('Product grid 4','construction'),
            'style5'    => esc_html__('Product grid 5','construction'),
            'style6'    => esc_html__('Product grid 6','construction'),
            ));
        return $list;
    }
}
//get type url
if(!function_exists('th_get_filter_url')){
    function th_get_filter_url($key,$value){
        if(function_exists('th_get_current_url')) $current_url = th_get_current_url();
        else{
            if(function_exists('wc_get_page_id')) $current_url = get_permalink( wc_get_page_id( 'shop' ) );
            else $current_url = get_permalink();
        }
        $current_url = get_pagenum_link();
        if(isset($_GET[$key])){
            $current_val_string = sanitize_text_field($_GET[$key]);
            if($current_val_string == $value){
                $current_url = str_replace('&'.$key.'='.$_GET[$key], '', $current_url);
                if(strpos($current_url,'&') > -1 )$current_url = str_replace('?'.$key.'='.$_GET[$key], '?', $current_url);
                else $current_url = str_replace('?'.$key.'='.$_GET[$key], '', $current_url);
            }
            if(strpos($current_val_string,',') > -1 ) $current_val_key = explode(',', $current_val_string);
            else $current_val_key = explode('%2C', $current_val_string);
            $val_encode = str_replace(',', '%2C', $current_val_string);
            if(!empty($current_val_string)){
                if(!in_array($value, $current_val_key)) $current_val_key[] = $value;
                else{
                    $pos = array_search($value, $current_val_key);
                    unset($current_val_key[$pos]);
                }            
                $new_val_string = implode('%2C', $current_val_key);
                $current_url = str_replace($key.'='.$val_encode, $key.'='.$new_val_string, $current_url);
                if (strpos($current_url, '?') == false) $current_url = str_replace('&','?',$current_url);
            }
            else $current_url = str_replace($key.'=', $key.'='.$value, $current_url);     
        }
        else{
            if(strpos($current_url,'?') > -1 ){
                $current_url .= '&amp;'.$key.'='.$value;
            }
            else {
                $current_url .= '?'.$key.'='.$value;
            }
        }
        return $current_url;
    }
}
//get type url
if(!function_exists('th_get_key_url')){
    function th_get_key_url($key,$value){
        if(function_exists('th_get_current_url')) $current_url = th_get_current_url();
        else{
            if(function_exists('wc_get_page_id')) $current_url = get_permalink( wc_get_page_id( 'shop' ) );
            else $current_url = get_permalink();
        }
        $current_url = get_pagenum_link();
        if(isset($_GET[$key])){
            $current_url = str_replace('&'.$key.'='.$_GET[$key], '', $current_url);
            if(strpos($current_url,'&') > -1 )$current_url = str_replace('?'.$key.'='.$_GET[$key], '?', $current_url);
            else $current_url = str_replace('?'.$key.'='.$_GET[$key], '', $current_url);
        }
        if(strpos($current_url,'?') > -1 ){
            $current_url .= '&amp;'.$key.'='.$value;
        }
        else {
            $current_url .= '?'.$key.'='.$value;
        }
        return $current_url;
    }
}
if(!function_exists('th_size_random')){
    function th_size_random($size){
        if(is_array($size) && count($size) > 2){
            $sizes = array();
            if(is_array($size)){
                foreach ($size as $key => $value) {
                    $i = $key + 1;
                    if($i % 2 == 1 && isset($size[$i])) $sizes[] = array($value,$size[$i]);
                }
            }
            $k = array_rand($sizes);
            $size = $sizes[$k];
        }
        return $size;
    }
}
//Set post view
if(!function_exists('th_set_post_view')){
    function th_set_post_view($post_id=false){
        if(!$post_id) $post_id=get_the_ID();
        $view=(int)get_post_meta($post_id,'post_views',true);
        $view++;
        update_post_meta($post_id,'post_views',$view);
    }
}

if(!function_exists('th_get_post_view')){
    function th_get_post_view($post_id=false){
        if(!$post_id) $post_id=get_the_ID();
        return (int)get_post_meta($post_id,'post_views',true);
    }
}

if(!function_exists('th_substr')){
    function th_substr($string='',$start=0,$end=1){
        $output = '';
        if(!empty($string)){
            $string = strip_tags($string);
            if($end < strlen($string)){
                if($string[$end] != ' '){
                    for ($i=$end; $i < strlen($string) ; $i++) { 
                        if($string[$i] == ' ' || $string[$i] == '.' || $i == strlen($string)-1){
                            $end = $i;
                            break;
                        }
                    }
                }
            }
            $output = substr($string,$start,$end);
        }
        return $output;
    }
}
if(!function_exists('th_fill_css_typography')){
    function th_fill_css_typography($data,$important = ''){
        $style = '';
        if(!empty($data['color'])) $style .= 'color:'.$data['color'].$important.';';
        if(!empty($data['font-family'])) $style .= 'font-family:'.$data['font-family'].$important.';';
        if(!empty($data['font-size'])) $style .= 'font-size:'.$data['font-size'].$important.';';
        if(!empty($data['font-style'])) $style .= 'font-style:'.$data['font-style'].$important.';';
        if(!empty($data['font-variant'])) $style .= 'font-variant:'.$data['font-variant'].$important.';';
        if(!empty($data['font-weight'])) $style .= 'font-weight:'.$data['font-weight'].$important.';';
        if(!empty($data['letter-spacing'])) $style .= 'letter-spacing:'.$data['letter-spacing'].$important.';';
        if(!empty($data['line-height'])) $style .= 'line-height:'.$data['line-height'].$important.';';
        if(!empty($data['text-decoration'])) $style .= 'text-decoration:'.$data['text-decoration'].$important.';';
        if(!empty($data['text-transform'])) $style .= 'text-transform:'.$data['text-transform'].$important.';';
        if(!empty($data['text-align'])) $style .= 'text-align:'.$data['text-align'].$important.';';
        return $style;
    }
}
if(!function_exists('th_fix_import_category')){
    function th_fix_import_category($taxonomy){
        global $th_config;
        $data = $th_config['import_category'];
        if(!empty($data)){
            $data = json_decode($data,true);
            if(is_array($data)){
                foreach ($data as $cat => $value) {
                    $parent_id = 0;
                    $term = get_term_by( 'slug',$cat, $taxonomy );
                    if(isset($term->term_id)){
                        $term_parent = get_term_by( 'slug', $value['parent'], $taxonomy );
                        if(isset($term_parent->term_id)) $parent_id = $term_parent->term_id;
                        if($parent_id) wp_update_term( $term->term_id, $taxonomy, array('parent'=> $parent_id) );
                        if($value['thumbnail']){
                            if($taxonomy == 'product_cat')  update_woocommerce_term_meta( $term->term_id, 'thumbnail_id', $value['thumbnail']);
                            else{
                                update_term_meta( $term->term_id, 'thumbnail_id', $value['thumbnail']);
                            }
                        }
                    }
                }
            }
        }
    }
}
if(!function_exists('th_get_terms_filter')){
    function th_get_terms_filter($taxonomy){
        $get_terms_args = array( 'hide_empty' => '1' );

        $orderby = wc_attribute_orderby( $taxonomy );

        switch ( $orderby ) {
            case 'name' :
                $get_terms_args['orderby']    = 'name';
                $get_terms_args['menu_order'] = false;
            break;
            case 'id' :
                $get_terms_args['orderby']    = 'id';
                $get_terms_args['order']      = 'ASC';
                $get_terms_args['menu_order'] = false;
            break;
            case 'menu_order' :
                $get_terms_args['menu_order'] = 'ASC';
            break;
        }

        $terms = get_terms( $taxonomy, $get_terms_args );

        if (is_array($terms) && 0 === count( $terms ) ) {
            return;
        }

        switch ( $orderby ) {
            case 'name_num' :
                usort( $terms, '_wc_get_product_terms_name_num_usort_callback' );
            break;
            case 'parent' :
                usort( $terms, '_wc_get_product_terms_parent_usort_callback' );
            break;
        }
        return $terms;
    }
}
//Compare URL
if(!function_exists('th_compare_url')){
    function th_compare_url($icon='',$id = false,$text = '',$class='silver'){
        $html = '';
        if(empty($text)) $text = esc_html__("Compare","construction");
        if(empty($icon)) $icon = '<i aria-hidden="true" class="la la-refresh"></i>';
        if(class_exists('YITH_Woocompare')){
            if(!$id) $id = get_the_ID();
            $cp_link = str_replace('&', '&amp;',add_query_arg( array('action' => 'yith-woocompare-add-product','id' => $id )));
            $html = '<a href="'.esc_url($cp_link).'" class="product-compare compare compare-link '.esc_attr($class).'" data-product_id="'.get_the_ID().'">'.$icon.'<span>'.$text.'</span></a>';
        }
        return $html;
    }
}
if(!function_exists('th_wishlist_url')){
    function th_wishlist_url($icon='',$text='',$class='silver'){
        $html = '';
        if(empty($text)) $text = esc_html__("Wishlist","construction");
        if(empty($icon)) $icon = '<i class="la la-heart-o" aria-hidden="true"></i>';
        if(class_exists('YITH_WCWL')) $html = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist wishlist-link '.esc_attr($class).'" rel="nofollow" data-product-id="'.get_the_ID().'" data-product-title="'.esc_attr(get_the_title()).'">'.$icon.'<span>'.$text.'</span></a>';
        return $html;
    }
}
//Fill css background
if(!function_exists('th_fill_css_background')){
    function th_fill_css_background($data){
        $string = '';
        if(!empty($data['background-color'])) $string .= 'background-color:'.$data['background-color'].';';
        if(!empty($data['background-repeat'])) $string .= 'background-repeat:'.$data['background-repeat'].';';
        if(!empty($data['background-attachment'])) $string .= 'background-attachment:'.$data['background-attachment'].';';
        if(!empty($data['background-position'])) $string .= 'background-position:'.$data['background-position'].';';
        if(!empty($data['background-size'])) $string .= 'background-size:'.$data['background-size'].';';
        if(!empty($data['background-image'])) $string .= 'background-image:url("'.$data['background-image'].'");';
        if(!empty($string)) return Th_Assets::build_css($string);
        else return false;
    }
}
if(!function_exists('th_fill_css_typography')){
    function th_fill_css_typography($data,$important = ''){
        $style = '';
        if(!empty($data['color'])) $style .= 'color:'.$data['color'].$important.';';
        if(!empty($data['font-family'])) $style .= 'font-family:'.$data['font-family'].$important.';';
        if(!empty($data['font-size'])) $style .= 'font-size:'.$data['font-size'].$important.';';
        if(!empty($data['font-style'])) $style .= 'font-style:'.$data['font-style'].$important.';';
        if(!empty($data['font-variant'])) $style .= 'font-variant:'.$data['font-variant'].$important.';';
        if(!empty($data['font-weight'])) $style .= 'font-weight:'.$data['font-weight'].$important.';';
        if(!empty($data['letter-spacing'])) $style .= 'letter-spacing:'.$data['letter-spacing'].$important.';';
        if(!empty($data['line-height'])) $style .= 'line-height:'.$data['line-height'].$important.';';
        if(!empty($data['text-decoration'])) $style .= 'text-decoration:'.$data['text-decoration'].$important.';';
        if(!empty($data['text-transform'])) $style .= 'text-transform:'.$data['text-transform'].$important.';';
        if(!empty($data['text-align'])) $style .= 'text-align:'.$data['text-align'].$important.';';
        return $style;
    }
}
//Custom BreadCrumb
if(!function_exists('th_breadcrumb')){
    function th_breadcrumb($step = '') {
        global $post;
        if(is_home() && !is_front_page()) echo '<a href="'.esc_url(home_url('/')).'">'.esc_html__('Home','construction').'</a>'.$step.'<span>'.esc_html__('Blog','construction').'</span>';
        else echo '<a href="'.esc_url(home_url('/')).'">'.esc_html__('Home','construction').'</a>';
        if (is_single()){
            echo apply_filters('s7upf_output_content',$step);
            echo get_the_category_list($step);
            echo apply_filters('s7upf_output_content',$step).'<span>'.get_the_title().'</span>';
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( get_the_ID() );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = $step.'<a href="'.esc_url(get_permalink($ancestor)).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a>';
                }
                echo apply_filters('s7upf_output_content',$output);
                echo '<span>'.$title.'</span>';
            } else {
                echo apply_filters('s7upf_output_content',$step).'<span>'.get_the_title().'</span>';
            }
        }
        elseif(is_archive()) echo apply_filters('s7upf_output_content',$step)."<span>".get_the_archive_title()."</span>";
        elseif(is_search()) echo apply_filters('s7upf_output_content',$step)."<span>".esc_html__("Search Results for: ","construction").get_search_query().'</span>';
        elseif(is_404()) echo apply_filters('s7upf_output_content',$step)."<span>".esc_html__("404 ","construction")."</span>";
    }
}
if(!function_exists('th_fix_import_category')){
    function th_fix_import_category($taxonomy){
        global $s7upf_config;
        $data = $s7upf_config['import_category'];
        if(!empty($data)){
            $data = json_decode($data,true);
            if(is_array($data)){
                foreach ($data as $cat => $value) {
                    $parent_id = 0;
                    $term = get_term_by( 'slug',$cat, $taxonomy );
                    if(isset($term->term_id)){
                        $term_parent = get_term_by( 'slug', $value['parent'], $taxonomy );
                        if(isset($term_parent->term_id)) $parent_id = $term_parent->term_id;
                        if($parent_id) wp_update_term( $term->term_id, $taxonomy, array('parent'=> $parent_id) );
                        if($value['thumbnail']){
                            if($taxonomy == 'product_cat')  update_woocommerce_term_meta( $term->term_id, 'thumbnail_id', $value['thumbnail']);
                            else{
                                update_term_meta( $term->term_id, 'thumbnail_id', $value['thumbnail']);
                            }
                        }
                    }
                }
            }
        }
    }
}
if(!function_exists('th_remove_all_pages')){
    function th_remove_all_pages(){
        $pages = get_pages();
        if( $pages ) {
            foreach( $pages as $page ) {
                wp_delete_post( $page->ID, true );
            }
        }
        $post = get_page_by_title( 'Hello world!', OBJECT, 'post' );
        if(isset($post->ID)) wp_delete_post( $post->ID, true );
    }
}
// fix popup register
if(!function_exists('th_register_user')){
    function th_register_user(){
        $user_data_ajax = $_POST['user_data'];
        $user_data = array();
        foreach ($user_data_ajax as $key => $value) {
            $user_data[$value['name']] = $value['value'];
        }
        $output = array();
        $output['status'] = 'error';
        $output['message'] = '<div class="message-wrap"><div class="message login_error ms-error ms-default">'.esc_html__("Your username or email has been exist. Please check again. ","construction").'</div></div>';
        if(!empty($user_data)){
            if(!username_exists($user_data['user_login']) && !email_exists($user_data['user_email'])){                
                $user_id = wp_insert_user( $user_data );
                // if(class_exists('WC_Emails')) WC_Emails::customer_new_account($user_id);
                $output['status'] = 'success';
                $output['message'] = '<div class="message login_info ms-info ms-default">'.esc_html__("Account registration has been successful","construction").'</div>';
            }            
            if(username_exists($username)){
                $output['status'] = 'error';
                $output['message'] = '<div class="message-wrap"><div class="message login_error ms-error ms-default">'.esc_html__("Your username has been exist.","construction").'</div></div>';
            }           
            if(username_exists($email)){
                $output['status'] = 'error';
                $output['message'] = '<div class="message-wrap"><div class="message login_error ms-error ms-default">'.esc_html__("Your email has been exist.","construction").'</div></div>';
            }
        }
        echo ''.$output['message'];
        die();
    }
}
add_action( 'wp_ajax_custom_register_user', 'th_register_user' );
add_action( 'wp_ajax_nopriv_custom_register_user', 'th_register_user' );