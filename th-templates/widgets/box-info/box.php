<?php
namespace Elementor;
extract($settings);
?>
<div <?php echo ''.$wdata->get_render_attribute_string('box-wrap');?>>
    <?php
    if($header_title) echo '<div class="header-wrap">
                                <div class="header-text">'.$header_title.'</div>
                                <span class="header-divider"></span>
                            </div>';
    ?>
    <div class="info-wrap">
        <div class="info-inner">
            <?php 
            if($info_title) echo '<h3>'.esc_html($info_title).'</h3>';
            if($info_des) echo '<p>'.esc_html($info_des).'</p>';
            if($form) echo do_shortcode('[contact-form-7 id="'.$form.'"]');
            if(!empty($list_icons)){
                echo '<div class="info-icon-list '.$icon_style.'">';
                foreach (  $list_icons as $key => $item ) {
                    $target = $item['link']['is_external'] ? ' target="_blank"' : '';
                    $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
                    $wdata->add_render_attribute( 'elth-icon-item', 'class', 'info-item-icon elementor-repeater-item-'.$item['_id'] );
                    echo    '<div '.$wdata->get_render_attribute_string( 'elth-icon-item' ).'>
                                <a class="adv-thumb-link" href="'.$item['link']['url'].'"'.$target.$nofollow.'>';
                                    Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
                    echo        '</a>
                                <h3 class="item-title"><a href="'.$item['link']['url'].'"'.$target.$nofollow.'>'.$item['title'].'</a></h3>
                                <p class="item-des">'.$item['description'].'</p>
                            </div>';
                    $wdata->remove_render_attribute( 'elth-icon-item', 'class', 'info-item-icon elementor-repeater-item-'.$item['_id'] );
                }
                echo '</div>';
            }
            if(!empty($list_images)){
                echo '<div class="info-image-list '.$image_style.'">';
                foreach (  $list_images as $key => $item ) {
                    $target = $item['link']['is_external'] ? ' target="_blank"' : '';
                    $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
                    $wdata->add_render_attribute( 'elth-image-item', 'class', 'info-item-image elementor-repeater-item-'.$item['_id'] );
                    echo    '<div '.$wdata->get_render_attribute_string( 'elth-image-item' ).'>
                                <div class="image-wrap">
                                    <a class="adv-thumb-link" href="'.$item['link']['url'].'"'.$target.$nofollow.'>';
                    echo                Group_Control_Image_Size::get_attachment_image_html( $settings['list_images'][$key], 'thumbnail', 'image' );
                    echo            '</a>
                                </div>
                            </div>';
                    $wdata->remove_render_attribute( 'elth-image-item', 'class', 'info-item-image elementor-repeater-item-'.$item['_id'] );
                }
                echo '</div>';
            }
        ?>   
        </div>
        <?php if($check_button == 'yes'):
            $target = $button_url['is_external'] ? ' target="_blank"' : '';
            $nofollow = $button_url['nofollow'] ? ' rel="nofollow"' : '';
            ?>
            <div class="readmore-wrap <?php echo esc_attr($button_style)?>">
                <a <?php echo 'href="'.$button_url['url'].'"'.$target.$nofollow;?> class="readmore">
                    <?php if($button_icon_pos == 'before-text' && $button_icon) echo '<i class="'.$button_icon['value'].'"></i>';?>
                    <?php if($button_text) echo '<span>'.esc_html($button_text).'</span>'?>   
                    <?php if($button_icon_pos == 'after-text' && $button_icon) echo '<i class="'.$button_icon['value'].'"></i>';?>                    
                </a>
            </div>
        <?php endif?>
    </div>    
</div>