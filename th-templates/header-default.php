<?php
$page_id = apply_filters('th_header_page_id',th_get_value_by_id('th_header_page'));
if(!empty($page_id)){?>
    <div id="header" class="header-page">
        <?php echo th_Template::get_vc_pagecontent($page_id);?>
    </div>
<?php
}
else{?>
    <div id="header" class="header header-default">
        <div class="header-top-default">
            <div class="container">
                <div class="logo">
                    <a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr__("logo","construction");?>">
                        <?php $th_logo=th_get_option('logo');?>
                        <?php if($th_logo!=''){
                            echo '<h1 class="hidden">'.get_bloginfo('name', 'display').'</h1><img src="' . esc_url($th_logo) . '" alt="'.esc_attr__("logo","construction").'">';
                        }   else { echo '<h1>'.get_bloginfo('name', 'display').'</h1>'; }
                        ?>
                    </a>
                </div>
            </div>
        </div>        
        <?php if ( has_nav_menu( 'primary' ) ) {?>
        <div class="header-nav-default">
            <div class="container">
                <div class="th-menu-container th-menu-offcanvas-elements th-navbar-nav-default">
                    <div class="th-nav-identity-panel toggler-icon">                 
                        <span class="th-menu-toggler">
                        <span></span>
                        </span>
                    </div>
                    <div class="th-menu-inner">
                        <?php 
                            $logo_mobile =  '';
                            $close_bt = '<div class="th-nav-identity-panel panel-inner">
                                <h2>'.get_bloginfo('name').'</h2>
                                '.$logo_mobile.'
                                <div class="close-menu">
                                    <span class="th-menu-toggler menu-open">
                                    <span></span>
                                    </span>
                                </div>
                            </div>';
                        ?>
                        <?php wp_nav_menu( array(
                            'items_wrap'      => $close_bt.'<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'container'       => false,
                            'menu_class'      => 'th-navbar-nav',
                            'depth'           => 4,
                            'echo'            => true,
                            'theme_location'  => 'primary',
                            'container'       =>false,
                            'walker'          =>new Th_Walker_Nav_Menu(),
                        )
                        );?>
                        <a href="#" class="toggle-mobile-menu"><span></span></a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>                    
    </div>
<?php
}
?>
