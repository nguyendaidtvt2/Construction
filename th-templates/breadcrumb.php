<?php
if(!isset($breadcrumb)) $breadcrumb = th_get_value_by_id('th_show_breadrumb');
if(!isset($el_class)) $el_class = '';
if($breadcrumb == '1'):
    $b_class = th_fill_css_background(th_get_option('th_bg_breadcrumb'));
	$step = '<i class="step-bread-crumb split las la-angle-right"></i>';
?>
<div class="wrap-bread-crumb <?php echo esc_attr($el_class)?>">
	<div class="container">
		<div class="bread-crumb <?php echo esc_attr($b_class)?>">
			<?php
				if(!th_is_woocommerce_page()){
	                if(function_exists('bcn_display')) bcn_display();
	                else th_breadcrumb($step);
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
</div>
<?php endif;?>