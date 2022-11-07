<?php
namespace Elementor;
use Th_Template;
extract($settings);
?>
<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
    <div class="inner-popup-wrap">
        <i class="la la-times elth-close-popup"></i>
        <div class="popup-content-wrap th-scrollbar">
            <?php echo Th_Template::get_vc_pagecontent($megapage);?>
        </div>
    </div>
</div>