<?php 
extract($settings);
?>
<div <?php echo ''.$wdata->get_render_attribute_string('button-wrap');?>>
    <a <?php echo ''.$wdata->get_render_attribute_string('button-inner');?>>
        <?php if($button_icon_pos == 'before-text' && $button_icon['value']) echo '<i class="'.$button_icon['value'].'"></i>';?>
        <?php if($button_text) echo '<span>'.esc_html($button_text).'</span>'?>   
        <?php if($button_icon_pos == 'after-text' && $button_icon['value']) echo '<i class="'.$button_icon['value'].'"></i>';?>                    
    </a>
</div>