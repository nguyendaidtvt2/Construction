<?php
namespace Elementor;
extract($settings);
$attr = array(
    'item_wrap'         => $item_wrap,
    'item_inner'        => $item_inner,
    'button_icon_pos'   => $button_icon_pos,
    'button_icon'       => $button_icon,
    'button_text'       => $button_text,
    'size'              => $size,
    'excerpt'           => $excerpt,
    'column'            => $column,
    'item_style'        => $item_style,
    'view'              => $view,
    'item_thumbnail'    => $item_thumbnail,
    'item_title'        => $item_title,
    'item_excerpt'      => $item_excerpt,
    'item_button'       => $item_button,
    'item_meta'         => $item_meta,
    'item_meta_select'  => $item_meta_select,
    'thumbnail_hover_animation'     => $thumbnail_hover_animation,
    'style'             => 'grid',
    'item_style_list'   => '',
    );
?>
<div class="th-slider-wrap">
    <?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
    	<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-inner' ).'>';?>
        	<?php 
        	if($post_query->have_posts()) {
                while($post_query->have_posts()) {
                    $post_query->the_post();
        			th_get_template_post('grid/grid',$item_style,$attr,true);
        		}
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