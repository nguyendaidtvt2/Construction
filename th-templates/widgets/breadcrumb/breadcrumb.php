<?php
namespace Elementor;
extract($settings);
if(empty($step))$step = '<i class="step-bread-crumb las la-angle-right"></i>';
?>
<div class="wrap-bread-crumb wrap-bread-crumb-elementor <?php echo esc_attr($style)?>">
	<div class="bread-crumb">
		<?php
			if(!th_is_woocommerce_page()){
				th_breadcrumb($step);
            }
            else {
            	if(function_exists('woocommerce_breadcrumb')){
	            	woocommerce_breadcrumb(array(
	            	'delimiter'		=> $step,
	            	'wrap_before'	=> '',
	            	'wrap_after'	=> '',
	            	'before'      	=> '<span>',
					'after'       	=> '</span>',
	            	));
	            }
            }
        ?>
	</div>
</div>