<?php
namespace Elementor;
extract($settings);
?>
<div <?php echo ''.$wdata->get_render_attribute_string('price-table-wrap');?>>
	<div class="price-header">
		<h4 class="price-title"><?php echo esc_html($title)?></h4>
		<p class="price-text"><?php echo esc_html($price)?></p>
		<p class="price-duration"><?php echo esc_html($duration)?></p>
	</div>
	<div class="price-body">
		<?php 
    	foreach (  $settings['list_text'] as $item ) {
			echo '<p>'.$item['text'].'</p>';
		}
    	?>
	</div>
	<div class="price-footer">
		<?php
		if(!empty($link['url'])){
			$target = $link['is_external'] ? ' target="_blank"' : '';
			$nofollow = $link['nofollow'] ? ' rel="nofollow"' : '';
			echo '<a class="price-button" href="'.esc_url($link['url']).'"'.$target.$nofollow.'>'.esc_html($button_text).'</a>';
		}
		?>
	</div>
</div>