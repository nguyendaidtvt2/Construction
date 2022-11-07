<?php
if(empty($size_list)) $size_list = array(570,500);
if(!isset($excerpt_list)) $excerpt_list = 0;
$c_class = 'col-md-6 col-sm-12 col-xs-12';
if(!has_post_thumbnail()) $c_class = 'col-md-12 col-sm-12 col-xs-12';
global $post;
?>
<div class="col-md-12 col-sm-12 col-xs-12 item-post-wrap">
    <div class="item-post item-post-list item-style2">
        <div class="row">
            <?php if($item_thumbnail == 'yes' && has_post_thumbnail()):?>
                <div class="<?php echo esc_attr($c_class)?>">
                    <div class="post-thumb banner-advs zoom-image overlay-image">
                        <a href="<?php echo esc_url(get_the_permalink())?>" class="adv-thumb-link">
                            <?php echo get_the_post_thumbnail(get_the_ID(),$size_list)?>
                        </a>
                    </div>
                </div>
            <?php endif;?>
            <div class="<?php echo esc_attr($c_class)?>">
                <div class="post-info">
                   <?php if($item_meta == 'yes') th_display_metabox('',$item_meta_select);?>
                    <?php if($item_title == 'yes'):?><h3 class="titlelv2 post-title"><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php the_title()?></a></h3><?php endif?>
                    <?php if($item_excerpt == 'yes'){
                        if(!$excerpt_list || $excerpt_list == 0) echo '<p class="desc">'.get_the_excerpt().'</p>';
                        else echo '<p class="desc">'.th_substr(get_the_excerpt(),0,(int)$excerpt_list).'</p>';
                    }?>
                    <?php if($item_button == 'yes'):?>
                        <div class="readmore-wrap">
                            <a href="<?php echo esc_url(get_the_permalink()) ?>" class="elth-bt-default">
                                <?php if($button_icon_pos == 'before-text' && $button_icon) echo '<i class="'.$button_icon['value'].'"></i>';?>
                                <?php echo esc_html($button_text)?>   
                                <?php if($button_icon_pos == 'after-text' && $button_icon) echo '<i class="'.$button_icon['value'].'"></i>';?>                    
                            </a>
                        </div>
                    <?php endif?>
                </div>
            </div>
        </div>
    </div>
</div>