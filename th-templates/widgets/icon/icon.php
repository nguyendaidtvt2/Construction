<?php
namespace Elementor;
extract($settings);
?>
<div <?php echo ''.$wdata->get_render_attribute_string('icon-wrap');?>>
	<div class="icon-wrap <?php echo esc_attr($hover_animation)?>">
		<?php
		$target = $icon_url['is_external'] ? ' target="_blank"' : '';
		$nofollow = $icon_url['nofollow'] ? ' rel="nofollow"' : '';
		if(!empty($icon_url['url'])) echo '<a class="adv-thumb-link" href="'.$icon_url['url'].'"'.$target.$nofollow.'>';
		if($icon_type == 'icon') Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
		else echo Group_Control_Image_Size::get_attachment_image_html( $settings );
		if(!empty($number)) echo '<span class="number">'.$number.'</span>';
		if(!empty($icon_url['url'])) echo '</a>';
		?>
	</div>
	<div class="info-wrap">
		<?php if($title){
			echo '<h3>';
			if(!empty($icon_url['url'])) echo '<a href="'.$icon_url['url'].'"'.$target.$nofollow.'>';
			echo esc_html($title);
			if(!empty($icon_url['url'])) echo '</a>';
			echo '</h3>';
		}?>
		<div class="info-des">
			<?php echo '<p>'.$description_text.'</p>';?>
	        <?php if(!empty($list_social) && $check_social == 'yes'):?>
				<ul class="elth-list-social <?php echo esc_attr($social_style)?>">
			    	<?php 
			    	foreach (  $list_social as $item ) {
						$target = $item['link']['is_external'] ? ' target="_blank"' : '';
						$nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
						echo '<li><a title="'.$item['text'].'" href="'.$item['link']['url'].'"'.$target.$nofollow.' class="social-item elementor-repeater-item-'.$item['_id'].' elementor-animation-'.$social_hover_animation.'">';
						Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
						echo '</a></li>';
					}
			    	?>
			    </ul>
			<?php endif;?>
			<?php if($check_button == 'yes' && $icon_url):?>
	            <div class="readmore-wrap">
	                <a <?php echo 'href="'.$icon_url['url'].'"'.$target.$nofollow;?> class="readmore">
	                    <?php if($button_icon_pos == 'before-text' && $button_icon) echo '<i class="'.$button_icon['value'].'"></i>';?>
	                    <?php echo esc_html($button_text)?>   
	                    <?php if($button_icon_pos == 'after-text' && $button_icon) echo '<i class="'.$button_icon['value'].'"></i>';?>                    
	                </a>
	            </div>
	        <?php endif?>
		</div>
	</div>
</div>