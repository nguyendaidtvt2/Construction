<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 */
$page_id = th_get_option('th_404_page');
if(!empty($page_id)){	
	$style = th_get_option('th_404_page_style');
	if($style == 'full-width') {
		get_header('none');
		echo th_Template::get_vc_pagecontent($page_id);
		get_footer('none');
	}
	else{
		get_header(); ?>
		<div id="main-content" class="main-page-default">
		    <?php do_action('th_before_main_content')?>
		    <div class="container">
				<?php echo th_Template::get_vc_pagecontent($page_id);?>
			</div>
			<?php do_action('th_after_main_content')?>
		</div>
		<?php get_footer();
	}
}
else{
	get_header(); ?>
	<div id="main-content" class="main-page-default">
	    <?php do_action('th_before_main_content')?>
	    <div class="container">
	    	<div class="content-default-404">
		    	<div class="row">
		    		<div class="col-md-6 col-sm-6 col-xs-12">
		    			<div class="icon-404">
		    				<span class="number"><?php esc_html_e("404","construction")?></span>
		    				<span class="text"><?php esc_html_e("Page Not Found","construction")?></span>
		    			</div>
		    		</div>
		    		<div class="col-md-6 col-sm-6 col-xs-12">
		    			<div class="info-404">
		    				<h2><?php esc_html_e("Oops!","construction")?></h2>
		    				<h3><?php esc_html_e("Page not found on server","construction")?></h3>
		    				<p class="desc"><?php esc_html_e("The link you followed is either outdated, inaccurate or the server has been instructed not to let you have it.","construction")?></p>
		    				<a href="<?php echo home_url('/')?>" class="elth-bt-default elth-bt-medium"><?php esc_html_e("Go to Home","construction")?></a>
		    			</div>
		    		</div>
		    	</div>
		    </div>
		</div>
		<?php do_action('th_after_main_content')?>
	</div>
	<?php get_footer(); 
}?>
