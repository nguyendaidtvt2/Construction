<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$view          = th_get_option('shop_default_style','grid');
$grid_type      = th_get_option('shop_grid_type');
$item_style     = th_get_option('shop_grid_item_style');
$item_style_list= th_get_option('shop_list_item_style');
$column         = th_get_option('shop_grid_column',4);
$size           = th_get_option('shop_grid_size');
$size_list      = th_get_option('shop_list_size');
$thumbnail_hover_animation      = th_get_option('shop_thumb_animation');
$type_active = $view;
if(isset($_GET['type']) && $_GET['type']) $type_active = sanitize_text_field($_GET['type']);
$size = th_get_size_crop($size);
$size_list = th_get_size_crop($size_list);
$slug = $item_style;
if($view == 'grid' && $type_active == 'list'){
    $view = $type_active;
    $slug = $item_style_list;
}

$item_wrap = 'class="list-col-item list-'.$column.'-item"';
$item_inner = 'class="item-product-wrap product"';
$button_icon_pos = $button_icon = $button_text = $item_rate = '';
$item_thumbnail = $item_quickview = $item_label = $item_title = $item_price = $item_button = 'yes';
$attr = array(
	'item_wrap'         => $item_wrap,
    'item_inner'        => $item_inner,
    'button_icon_pos'   => $button_icon_pos,
    'button_icon'       => $button_icon,
    'button_text'       => $button_text,
    'size'              => $size,
    'size_list'         => $size_list,
    'type_active'       => $type_active,
    'view'              => $view,
    'column'            => $column,
    'item_style'        => $item_style,
    'item_style_list'   => $item_style_list,
    'item_thumbnail'    => $item_thumbnail,
    'item_quickview'    => $item_quickview,
    'item_label'        => $item_label,
    'item_title'        => $item_title,
    'item_rate'         => $item_rate,
    'item_price'        => $item_price,
    'item_button'       => $item_button,
    'animation'         => $thumbnail_hover_animation,
	);
?>
<?php th_get_template_woocommerce('loop/'.$view.'/'.$view,$slug,$attr,true);?>
