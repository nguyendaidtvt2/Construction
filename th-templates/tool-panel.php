<?php
$show = th_get_option('show_too_panel');
$tool_id = th_get_option('tool_panel_page');
if($show == '1' && !empty($tool_id)){
	echo th_Template::get_vc_pagecontent($tool_id,true);
}