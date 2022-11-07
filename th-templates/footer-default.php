<?php
$page_id = apply_filters('th_footer_page_id',th_get_value_by_id('th_footer_page'));
if(!empty($page_id)) {?>
	<div id="footer" class="footer-page">
        <?php echo th_Template::get_vc_pagecontent($page_id);?>
    </div>
<?php
}
else{
?>
	<div id="footer" class="footer-default">
		<div class="container">
			<p class="copyright desc white"><?php esc_html_e("Copyright by ththeme. All Rights Reserved.","construction")?></p>
		</div>
	</div>
<?php
}