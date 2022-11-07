<?php
namespace Elementor;
extract($settings);
?>
<div class="th-slider-wrap">
<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
	<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-inner' ).'>';?>
    	<?php 
    	foreach (  $list_sliders as $key => $item ) {            
            $target = $item['link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
            if(isset($item['link']['url'])) $link = $item['link']['url'];
            else $link = "#";
            $wdata->add_render_attribute( 'elth-item', 'class', 'wslider-item elementor-repeater-item-'.$item['_id'] );
            echo    '<div '.$wdata->get_render_attribute_string( 'elth-item' ).'>';
            echo    '<div class="image-wrap">
                            <a class="adv-thumb-link elementor-animation-'.$image_hover_animation.'" href="'.$link.'"'.$target.$nofollow.'>';
            echo                Group_Control_Image_Size::get_attachment_image_html( $settings['list_sliders'][$key], 'thumbnail', 'image' );
            echo            '</a>';            
            echo        '</div>';
            if($item['style_info']){
                $wdata->remove_render_attribute( 'info_attr', 'class', $settings['style_info']);
                $wdata->add_render_attribute( 'info_attr', 'class', $item['style_info'] );
            }
            if($item['pos_h_info']){
                $wdata->remove_render_attribute( 'info_attr', 'class', $settings['pos_h_info']);
                $wdata->add_render_attribute( 'info_attr', 'class', $item['pos_h_info'] );
            }
            if($item['pos_v_info']){
                $wdata->remove_render_attribute( 'info_attr', 'class', $settings['pos_v_info']);
                $wdata->add_render_attribute( 'info_attr', 'class', $item['pos_v_info'] );
            }
            echo '<div '.$wdata->get_render_attribute_string( 'info_attr' ).'>
                    ';
            if($item['title']) echo '<h3 class="item-title hidden-on-mobile-'.$item['disable_mobile_title'].'"><a href="'.$link.'"'.$target.$nofollow.'>'.$item['title'].'</a></h3>';
            if($item['description']) echo '<p class="item-des hidden-on-mobile-'.$item['disable_mobile_des'].'">'.$item['description'].'</p>';
            if($item['content']) echo '<p class="item-content hidden-on-mobile-'.$item['disable_mobile_content'].'">'.$item['content'].'</p>';
            if($item['button_text']) echo '<a class="elth-bt-default elth-bt-medium '.$item['button_style'].' hidden-on-mobile-'.$item['disable_mobile_button'].'" href="'.$item['link']['url'].'"'.$target.$nofollow.'>'.$item['button_text'].'</a>';
            echo        '</div>
                    </div>';
            if($item['style_info']){
                $wdata->remove_render_attribute( 'info_attr', 'class', $item['style_info'] );
                $wdata->add_render_attribute( 'info_attr', 'class', $settings['style_info'] );
            }
            if($item['pos_h_info']){
                $wdata->remove_render_attribute( 'info_attr', 'class', $item['pos_h_info'] );
                $wdata->add_render_attribute( 'info_attr', 'class', $settings['pos_h_info'] );
            }
            if($item['pos_v_info']){
                $wdata->remove_render_attribute( 'info_attr', 'class', $item['pos_v_info'] );
                $wdata->add_render_attribute( 'info_attr', 'class', $settings['pos_v_info'] );
            }
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