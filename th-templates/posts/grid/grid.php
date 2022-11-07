<?php
// $column set column in grid style
// $item_wrap set attribute in wrap div
// $item_inner set attribute in wrap inner div
// $item_thumbnail on/off thumbnail yes or empty
// $item_meta on/off meta yes or empty
// $item_title on/off title yes or empty
// $item_excerpt on/off excerpt yes or empty
// $item_button on/off button yes or empty
if(empty($size)) $size = array(450,300);
if(empty($item_meta_select)) $item_meta_select = ['author','comments'];
?>
<?php if(isset($column) && $view != 'slider'):?><?php echo '<div '.$item_wrap.'>';?><?php endif;?>
<?php echo '<div '.$item_inner.'>';?>
    <?php if($item_thumbnail == 'yes' && has_post_thumbnail()):?>
        <div class="post-thumb overlay-image zoom-image">
            <a href="<?php echo esc_url(get_the_permalink()) ?>" class="adv-thumb-link elementor-animation-<?php echo esc_attr($thumbnail_hover_animation)?>">
                <?php echo get_the_post_thumbnail(get_the_ID(),$size);?>
                <?php th_display_metabox('',['date']);?>
            </a>
        </div>
    <?php endif?> 
    <div class="post-info">
        <?php if($item_meta == 'yes') th_display_metabox('',$item_meta_select);?>
        <?php if($item_title == 'yes'):?><h3 class="title18 post-title"><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php the_title()?></a></h3><?php endif?>
        <?php if($item_excerpt == 'yes') echo '<p class="desc">'.th_substr(get_the_excerpt(),0,(int)$excerpt).'</p>';?>
        <?php if($item_button == 'yes'):?>
            <div class="readmore-wrap">
                <a href="<?php echo esc_url(get_the_permalink()) ?>" class="elth-bt-default readmore">
                    <?php if($button_icon_pos == 'before-text' && $button_icon) echo '<i class="'.$button_icon['value'].'"></i>';?>
                    <?php echo esc_html($button_text)?>   
                    <?php if($button_icon_pos == 'after-text' && $button_icon) echo '<i class="'.$button_icon['value'].'"></i>';?>                    
                </a>
            </div>
        <?php endif?>
    </div>
</div>
<?php if(isset($column) && $view != 'slider'):?></div><?php endif;?>