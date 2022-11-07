<?php
namespace Elementor;
?>
<div <?php echo ''.$wdata->get_render_attribute_string('logo-wrap');?>>
	<a href="<?php echo esc_url(home_url('/'));?>">
	<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings );?>
	</a>
</div>