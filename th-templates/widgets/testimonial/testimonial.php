<?php
namespace Elementor;
extract($settings);
?>
<div class="th-slider-wrap th-testimonial-wrap">
<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
    <?php echo '<div '.$wdata->get_render_attribute_string( 'elth-inner' ).'>';?>
        <?php 
        foreach (  $list_sliders as $key => $item ) {
            $target = $item['link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
            $wdata->add_render_attribute( 'elth-item', 'class', 'wslider-item item-testimonial '.$style.' elementor-repeater-item-'.$item['_id'] );
            echo    '<div '.$wdata->get_render_attribute_string( 'elth-item' ).'>            
                        <div class="content-wrap">                            
                            <p class="item-content">'.$item['content'].'</p>
                        </div>
                        <div class="image-wrap">';
            if($item['image']['id']){
                echo            '<a class="adv-thumb-link elementor-animation-'.$image_hover_animation.'" href="'.$item['link']['url'].'"'.$target.$nofollow.'>';
                echo                Group_Control_Image_Size::get_attachment_image_html( $settings['list_sliders'][$key], 'thumbnail', 'image' );
                echo            '</a>';
            }
            echo        '</div>
                        <div class="inner-info">
                            <h3 class="item-title"><a href="'.$item['link']['url'].'"'.$target.$nofollow.'>'.$item['title'].'</a></h3>
                            <span class="split item-des">/</span>
                            <p class="item-des">'.$item['description'].'</p>
                        </div>
                    </div>';
            $wdata->remove_render_attribute( 'elth-item', 'class', 'wslider-item item-testimonial '.$style.' elementor-repeater-item-'.$item['_id'] );
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