<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 13/08/15
 * Time: 10:20 AM
 */
if(!isset($main_color)) $main_color = th_get_value_by_id('main_color');
if(!isset($main_color2)) $main_color2 = th_get_value_by_id('main_color2');
$body_bg = th_get_value_by_id('body_bg');
$container_width = th_get_value_by_id('container_width');
$preload_bg = th_get_option('preload_bg');
$important = '';
?>
<?php
$style = '';

if(!empty($body_bg)){
    $style .= 'body
    {background-color:'.$body_bg.$important.'}'."\n";
}
if(!empty($preload_bg)){
    $style .= '.preload #loading
    {background-color:'.$preload_bg.$important.'}'."\n";
}

if(!empty($container_width)) {
    $style .= '.container,.page-content-box .wrap{max-width: '.$container_width.'px !important;}';
}

/*****BEGIN MAIN COLOR*****/

if(!empty($main_color)){
	$style .= '.about-title-number a.readmore, .color, .desc.color, .item-contact-page .contact-thumb:hover, 
    .list-about-page>li.current>a, .main-nav>ul>li:hover>a, .main-nav>ul>li>a:hover, .popup-icon, 
    .product-title a:hover, a:active, a:focus, a:hover,a.active, a:not(.elementor-button):hover > span, a:hover,
    .post-meta-data li.meta-item a:hover,.product-price > span, .product-price > ins > span,.product-title a:hover, .product_list_widget > li > a:hover, .post-title a:hover
    {color:'.$main_color.$important.'}'."\n";
    
    $style .= 'button[type="submit"],.bg-color,.dm-button,#widget_indexdm .dm-header .header-button > a:hover,
    .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .button, 
    .search-icon-popup,.elth-swiper-slider ~ .swiper-button-nav, .th-slider-wrap .swiper-button-nav, .elth-swiper-slider .swiper-button-nav,
    .elth-bt-default,.preload #loading,.th-slider-wrap .swiper-pagination-bullet-active,
    .widget_calendar table caption,input[type=button], input[type=reset], input[type=submit], .woocommerce a.button, .woocommerce #respond input#submit, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
    .pagi-nav .page-numbers:hover, .pagi-nav .page-numbers.current,.thumb-extra-link a:hover,.nav-tabs > li > a,
    .item-product-grid-style2 .product-quick-view, .item-product-default .product-quick-view,
    .woocommerce-MyAccount-navigation li.is-active a, .woocommerce-MyAccount-navigation li a:hover,.th-slider-wrap .swiper-pagination-bullet-active,.tagcloud a,.item-product-grid .product-extra-link a.wishlist-link:hover, .item-product-grid .product-extra-link a.compare-link:hover,.item-product-list .product-extra-link.icon .wishlist-link:hover, .item-product-list .product-extra-link.icon .compare-link:hover,.woocommerce-MyAccount-navigation li a,.mini-cart-number,.dokan-dashboard .dokan-dashboard-wrap .dokan-dash-sidebar ul.dokan-dashboard-menu li, .dokan-dashboard .dokan-dashboard-wrap .dokan-dash-sidebar,.item-product-grid-style6 .product-price,.mini-cart-button .button, .woocommerce .mini-cart-button .button,
    .woocommerce-product-search button[type="submit"],.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .button, .item-product .product-extra-link .addcart-link, input[type=button], input[type=reset], input[type=submit], .woocommerce a.button, .woocommerce #respond input#submit, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
    a.dokan-btn-theme.vendor-dashboard,.woocommerce-account .addresses .title .edit:hover,.dokan-store-wrap .dokan-single-store .dokan-store-tabs ul li a
    {background-color:'.$main_color.$important.'}'."\n";
    
    $style .= '.dokan-dashboard .dokan-dashboard-wrap .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links:hover,
    input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme,.dokan-dashboard-wrap .dokan-product-listing-area input[type="submit"], .dokan-dashboard-wrap .dokan-product-listing-area button[type="submit"],.dokan-settings-area input[type="submit"], .dokan-settings-area button
    {background-color:'.$main_color.' !important}'."\n";

    $style .= '.main-border,.pagi-nav .page-numbers:hover, .pagi-nav .page-numbers.current,.thumb-extra-link a:hover,
    .widget-title:before,textarea:focus, input:focus
    {border-color: '.$main_color.$important.'}'."\n";

    $style .= 'blockquote,.home-icon:before
    {border-left-color: '.$main_color.$important.'}'."\n";

    $style .= '.home-title.elementor-element:before,.home-icon:before
    {border-top-color: '.$main_color.$important.'}'."\n";

    $style .= '.home-title.elementor-element:before,.item-product-grid-style6 .product-price:before
    {border-right-color: '.$main_color.$important.'}'."\n";

    $style .= '.border-bottom-color
    {border-bottom-color: '.$main_color.$important.'}'."\n";

    if(strpos($main_color, '#') > -1){
        list($r, $g, $b) = sscanf($main_color, "#%02x%02x%02x");
        $style .= '.bg-rgb
        {background-color: rgba('.$r.','.$g.','.$b.', 0.9)'.$important.'}'."\n";
    }
}

if(!empty($main_color2)){
    $style .= '.color2
    {color:'.$main_color2.$important.'}'."\n";
    
    $style .= '.bg-color2,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .button:hover,.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover, .nav-tabs > li.active > a,.elth-bt-default:hover,.nav-tabs > li > a.active, .nav-tabs > li > a:hover, .item-product-grid-style2 .product-thumb .product-quick-view:hover, .item-product-default .product-thumb .product-quick-view:hover, .elth-swiper-slider ~ .swiper-button-nav:hover, .th-slider-wrap .swiper-button-nav:hover, .elth-swiper-slider .swiper-button-nav:hover,.tagcloud a:hover,.item-product-grid .product-extra-link a.wishlist-link, .item-product-grid .product-extra-link a.compare-link,.item-product-list .product-extra-link.icon .wishlist-link, .item-product-list .product-extra-link.icon .compare-link,.woocommerce-MyAccount-navigation li.is-active a, .woocommerce-MyAccount-navigation li a:hover,.dokan-dashboard .dokan-dashboard-wrap .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover, .dokan-dashboard .dokan-dashboard-wrap .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover, .dokan-dashboard .dokan-dashboard-wrap .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,button[type="submit"]:hover,.dokan-dashboard-wrap .pagination-wrap ul.pagination > li > a:hover, .dokan-dashboard-wrap .pagination-wrap ul.pagination > li > span.current, .pagination-wrap ul.pagination > li > span.current,
    .mini-cart-button .button:hover, .woocommerce .mini-cart-button .button:hover,.woocommerce-product-search button[type="submit"]:hover,.item-product .list-info-wrap .product-extra-link .addcart-link:hover,
    .woocommerce-account .addresses .title .edit,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .button:hover, .item-product .product-extra-link .addcart-link:hover, input[type=button]:hover, input[type=reset]:hover, input[type=submit]:hover, .woocommerce a.button:hover, .woocommerce #respond input#submit:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.dokan-store-wrap .dokan-single-store .dokan-store-tabs ul li a:hover
    {background-color:'.$main_color2.$important.'}'."\n";

    $style .= '.main-border2,.dokan-dashboard-wrap .pagination-wrap ul.pagination > li > a:hover, .dokan-dashboard-wrap .pagination-wrap ul.pagination > li > span.current, .pagination-wrap ul.pagination > li > span.current
    {border-color: '.$main_color2.$important.'}'."\n";
    
    $style .= 'a.dokan-btn-theme.vendor-dashboard:hover,input[type="submit"].dokan-btn-theme:hover, a.dokan-btn-theme:hover, .dokan-btn-theme:hover, input[type="submit"].dokan-btn-theme:focus, a.dokan-btn-theme:focus, .dokan-btn-theme:focus, input[type="submit"].dokan-btn-theme:active, a.dokan-btn-theme:active, .dokan-btn-theme:active, input[type="submit"].dokan-btn-theme.active, a.dokan-btn-theme.active, .dokan-btn-theme.active, .open .dropdown-toggleinput[type="submit"].dokan-btn-theme, .open .dropdown-togglea.dokan-btn-theme, .open .dropdown-toggle.dokan-btn-theme,.dokan-settings-area input[type="submit"]:hover, .dokan-settings-area button:hover, .dokan-dashboard-wrap .dokan-product-listing-area input[type="submit"]:hover, .dokan-dashboard-wrap .dokan-product-listing-area button[type="submit"]:hover
    {background-color:'.$main_color2.' !important}'."\n";

    if(strpos($main_color2, '#') > -1){
        list($r, $g, $b) = sscanf($main_color2, "#%02x%02x%02x");
        $style .= '.bg-rgb,.item-product-grid-style4 .thumb-extra-link
        {background-color: rgba('.$r.','.$g.','.$b.', 0.5)'.$important.'}'."\n";
    }
}

/*****END MAIN COLOR*****/

/*****BEGIN CUSTOM CSS*****/
$custom_css = th_get_option('custom_css');
if(!empty($custom_css)){
    $style .= $custom_css."\n";
}

/*****END CUSTOM CSS*****/

/*****BEGIN BREADCRUMB COLOR*****/
$bread_color = th_get_option('breadcrumb_text');
$bread_color_hover = th_get_option('breadcrumb_text_hover');
if(is_array($bread_color) && !empty($bread_color)){
    $style .= '.bread-crumb a,.bread-crumb span{';
    $style .= th_fill_css_typography($bread_color);
    $style .= '}'."\n";
}
if(is_array($bread_color_hover) && !empty($bread_color_hover)){
    $style .= '.bread-crumb a:hover{';
    $style .= th_fill_css_typography($bread_color_hover);
    $style .= '}'."\n";
}
/*****END CUSTOM CSS*****/

/*****BEGIN MENU COLOR*****/
$menu_color = th_get_option('sv_menu_color');
$menu_hover = th_get_option('sv_menu_color_hover');
$menu_active = th_get_option('sv_menu_color_active');
$menu_color2 = th_get_option('sv_menu_color2');
$menu_hover2 = th_get_option('sv_menu_color_hover2');
$menu_active2 = th_get_option('sv_menu_color_active2');
if(is_array($menu_color) && !empty($menu_color)){
    $style .= '.main-nav>ul>li>a{';
    $style .= th_fill_css_typography($menu_color);
    $style .= '}'."\n";
}
if(!empty($menu_hover)){
    $style .= 'nav.main-nav > ul>li:hover>a,
    nav.main-nav>ul>li>a:focus,
    nav.main-nav>ul>li.current-menu-item>a,
    nav.main-nav>ul>li.current-menu-ancestor>a
    {color:'.$menu_hover.'}'."\n";
}
if(!empty($menu_active)){
    $style .= 'nav.main-nav>ul>li.current-menu-item>a,
    nav.main-nav>ul>li.current-menu-ancestor>a,
    nav.main-nav>ul>li:hover>a
    {background-color:'.$menu_active.'}'."\n";
}
// Sub menu
if(is_array($menu_color2) && !empty($menu_color2)){
    $style .= 'nav .sub-menu>li>a{';
    $style .= th_fill_css_typography($menu_color2);
    $style .= '}'."\n";
}
if(!empty($menu_hover2)){
    $style .= 'nav.main-nav li:not(.has-mega-menu) .sub-menu li:hover >a,
    nav.main-nav li:not(.has-mega-menu) .sub-menu li>a:focus,
    nav.main-nav .sub-menu li.current-menu-item >a,
    nav.main-nav .sub-menu li.current-menu-ancestor >a
    {color:'.$menu_hover2.'}'."\n";
}
if(!empty($menu_active2)){
    $style .= 'nav.main-nav li:not(.has-mega-menu) .sub-menu li:hover,
    nav.main-nav .sub-menu li.current-menu-item,
    nav.main-nav .sub-menu li.current-menu-ancestor
    {background-color:'.$menu_active2.'}'."\n";
}
/*****END MENU COLOR*****/

/*****BEGIN TYPOGRAPHY*****/
$typo_data = th_get_option('th_custom_typography');
if(is_array($typo_data) && !empty($typo_data)){
    foreach ($typo_data as $value) {
        switch ($value['typo_area']) {
             case 'body':
                $style_class = 'body';
                break;

            case 'header':
                $style_class = '#header';
                break;

            case 'footer':
                $style_class = '#footer';
                break;

            case 'widget':
                $style_class = '#main-content .widget';
                break;
            
            default:
                $style_class = '#main-content';
                break;
        }
        $class_array = explode(',', $style_class);
        $new_class = '';
        if(is_array($class_array)){
            foreach ($class_array as $prefix) {
                $new_class .= $prefix.' '.$value['typo_heading'].',';
            }
        }
        if(!empty($new_class)) $style .= $new_class.' .nocss{';
        $style .= th_fill_css_typography($value['typography_style']);        
        $style .= '}';
        $style .= "\n";
    }
}

/*****END TYPOGRAPHY*****/

$custom_css = th_get_option('custom_css');
if(!empty($custom_css)){
    $style .= $custom_css."\n";
}
if(!empty($style)) echo apply_filters('th_output_content',$style);
?>