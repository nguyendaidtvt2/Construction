<?php
namespace Elementor;
extract($settings);
if($show_day == 'yes') $show_day = 'true';
else $show_day = 'false';
if($fg_width['size']) $fg_width = $fg_width['size'];
else $fg_width = '0.03';
if($bg_width['size']) $bg_width = $bg_width['size'];
else $bg_width = '1';
?>
<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
	<div class="th-time-countdown <?php echo esc_attr($style.' canvas-'.$show_canvas.' show-text-'.$show_text)?>" 
	data-date="<?php echo esc_attr($date_time)?>" 
	data-day="<?php echo esc_attr($day_text)?>" 
	data-hour="<?php echo esc_attr($day_hour)?>" 
	data-mins="<?php echo esc_attr($day_mins)?>" 
	data-secs="<?php echo esc_attr($day_secs)?>" 
	data-color="<?php echo esc_attr($color)?>" 
	data-circle_bg="<?php echo esc_attr($circle_bg)?>" 
	data-fg_width="<?php echo esc_attr($fg_width)?>" 
	data-bg_width="<?php echo esc_attr($bg_width)?>" 
	data-show_day="<?php echo esc_attr($show_day)?>">		
	</div>
</div>

