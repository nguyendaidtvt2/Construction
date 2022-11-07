<?php
namespace Elementor;
use Th_Template;
extract($settings);
?>
<div class="th-slider-wrap">
<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
	<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-inner' ).'>';?>
    	<?php 
    	foreach (  $list_items as $key => $item ) {
            $wdata->add_render_attribute( 'elth-item', 'class', 'wslider-item elementor-repeater-item-'.$item['_id'] );
            echo    '<div '.$wdata->get_render_attribute_string( 'elth-item' ).'>';
            echo        Th_Template::get_vc_pagecontent($item['megapage']);
            echo    '</div>';
            $wdata->remove_render_attribute( 'elth-item', 'class', 'wslider-item elementor-repeater-item-'.$item['_id'] );
        }
    	?>
	</div>
</div>
<?php if ( $slider_navigation == 'yes' ):?>
    <div class="swiper-button-nav swiper-button-next"><?php Icons_Manager::render_icon( $slider_icon_next, [ 'aria-hidden' => 'true' ] );?></div>
    <div class="swiper-button-nav swiper-button-prev"><?php Icons_Manager::render_icon( $slider_icon_prev, [ 'aria-hidden' => 'true' ] );?></div>
<?php endif?>
<?php if ( $slider_pagination == 'yes' ):?>
    <div class="swiper-pagination"></div>
<?php endif?>
</div>