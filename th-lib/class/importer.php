<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 13/08/15
 * Time: 10:20 AM
 */

if(class_exists('th_PluginsImporter') and !class_exists('th_Importer'))
{
    class th_Importer extends  th_PluginsImporter
    {
        static function init()
        {
            add_action('admin_init',array(__CLASS__,'_do_import'));
        }

        static function _do_import()
        {
            if(isset($_REQUEST['th_do_import']) and $_REQUEST['th_do_import'] || isset($_REQUEST['media']))
            {

                //Check Permission
                if(!current_user_can('manage_options')){
                    echo json_encode(array('status'=>0,'message'=>esc_html__('You do not have permission to do this','construction')));die;
                }
                self::load_lib();

                //Check Importer Plugins was installed
                if ( !class_exists( 'WP_Importer' ) or ! class_exists( 'WP_Import' ) ){
                    echo json_encode(array('status'=>0,'message'=>esc_html__('Importer Class Was Not Installed','construction')));die;
                }
                global $th_config;
                $st_import_config = $th_config['import_config'];
                extract($st_import_config);

                $step =isset($_REQUEST['step'])? $_REQUEST['step']:1;
                $import_media = isset($_REQUEST['media'])? $_REQUEST['media']:1;
                if($import_media == '2') $step = 3;
                $data_dir=self::$_import_path;
                $data_url=self::$_import_url;
                $package=self::$_package;
                if($step==1) {
                    th_remove_all_pages();
                    //Update theme_options
                    $data_option= $th_config['import_theme_option'];
                    if(!empty($data_option)){
                        $options=json_decode($data_option,true); // unserialize
                        if(!function_exists('th_get_option_name'))
                        {
                            echo json_encode( array(
                                    'status'   =>0,
                                    'messenger'=>"<span class='red'>".esc_html__("Plugin: 7up core must be installed first. Stop working!","construction")."</span>",
                                    'next_url' => ''
                                )
                            );
                            die;
                        }
                        update_option( th_get_option_name(), $options ); // and overwrite the current theme-options
                        echo json_encode( array(
                                'status'   =>"ok",
                                'messenger'=>esc_html__("Importing the demo theme options...","construction")."<span>".esc_html__("DONE!","construction")."</span><br>",
                                'next_url' =>  admin_url(self::$_import_page."&th_do_import=1&media={$import_media}&package={$package}&step=" . ($step + 1))
                            )
                        );
                    }
                    else{
                        echo json_encode( array(
                                'status'   =>0,
                                'messenger'=>"<span class='red'>".esc_html__("Theme option contain NULL content. Stop working!","construction")."</span>",
                                'next_url' => ''
                            )
                        );
                    }

                }

                //Update Widgets
                if($step==2){

                    // Add data to widgets
                    $widget_data = $th_config['import_widget'];
                    $data_object = json_decode($widget_data);
                    if(!empty($data_object)){
                        $import_widgets = self::wie_import_data( $data_object );
                        echo json_encode( array(
                                'status'   =>1,
                                'messenger'=>esc_html__("Importing the demo widgets...","construction")." <span>".esc_html__("DONE!","construction")."</span>.<br>",
                                'next_url' => admin_url(self::$_import_page."&th_do_import=1&media={$import_media}&package={$package}&step=" . ($step + 1)),
                            )
                        );
                    }
                    else{
                        echo json_encode( array(
                                'status'   =>0,
                                'messenger'=>"<span class='red'>".esc_html__("Widget option contain NULL content. Stop working!","construction")."</span>",
                                'next_url' => ''
                            )
                        );
                    }
                }

                //Import XML

                if($step==3){
                    if($import_media != '2'){
                        wp_delete_nav_menu($menu_replace);
                    }
                    $stt_file=isset($_REQUEST['file_number'])?$_REQUEST['file_number']:0;
                    $ds_file=array_filter(glob($data_dir.'/data/*'),'is_file');
                    $file_name=isset($ds_file[$stt_file])?$ds_file[$stt_file]:false;
                    if(!$file_name){
                        echo json_encode( array(
                                'status'   =>0,
                                'messenger'=>"<span class='red'>".esc_html__("File Not Found. Stop working!","construction")."</span>",
                                'next_url' => ''
                            )
                        );
                        die;
                    }

                    $nexturl=admin_url(self::$_import_page."&th_do_import=1&media={$import_media}&package={$package}&step=" . ($step).'&file_number='.($stt_file+1));
                    if($stt_file>=count($ds_file)-1){
                        $nexturl=admin_url(self::$_import_page."&th_do_import=1&media={$import_media}&package={$package}&step=" . ($step+1));
                    }
                    ob_start();
                    $importer = new WP_Import();
                    $theme_xml = $file_name;
                    $importer->fetch_attachments = true;
                    if(basename($file_name) != 'media.xml'){
                        if($import_media != '2'){
                            $importer->import($theme_xml);
                            @ob_clean();
                            echo json_encode( array(
                                    'status'   =>1,
                                    'messenger'=>sprintf("Importing data: %s %d of %d ... <span>DONE!</span><br>",basename($file_name),$stt_file+1, count($ds_file)-0),
                                    'next_url' => $nexturl,
                                    'file'     => $ds_file,
                                )
                            );
                        }
                        else{
                            echo json_encode( array(
                                    'status'   =>1,
                                    'messenger'=>'',
                                    'next_url' => $nexturl,
                                    'file'     => $ds_file,
                                )
                            );
                        }
                    }
                    else{
                        @ob_clean();
                        if($import_media != '0'){
                            $importer->import($theme_xml);
                            if($import_media == '2') $nexturl = '';
                            @ob_clean();
                            echo json_encode( array(
                                    'status'   =>1,
                                    'messenger'=>sprintf("Importing data: %s %d of %d ... <span>DONE!</span><br>",basename($file_name),$stt_file+1, count($ds_file)-0),
                                    'next_url' => $nexturl,
                                    'file'     => $ds_file,
                                )
                            );
                        }
                        else{
                            echo json_encode( array(
                                        'status'   =>1,
                                        'messenger'=>sprintf("Importing data: %s %d of %d ... <span>Pass!</span><br>",basename($file_name),$stt_file+1, count($ds_file)-0),
                                        'next_url' => $nexturl,
                                        'file'     => $ds_file,
                                    )
                                );
                        }
                    }                    
                }

                // Set Up Menu Theme Location

                if($step==4) {
                    th_fix_import_category('product_cat');
                    //  Set imported menus to registered theme locations
                    $locations = get_theme_mod('nav_menu_locations'); // registered menu locations in theme
                    $menus = wp_get_nav_menus(); // registered menus
                    if ($menus) {
                        foreach ($menus as $menu) { // assign menus to theme locations
                            if (!empty($menu_locations))
                                foreach ($menu_locations as $key => $st_over_menu) {
                                    if ($menu->name == $key) {
                                        $locations[$st_over_menu] = $menu->term_id;
                                    }
                                }
                        }
                    }
                    set_theme_mod('nav_menu_locations', $locations); // set menus to locations

                    $nexturl = admin_url(self::$_import_page . "&th_do_import=1&package={$package}&step=" . ($step+1) );
                    echo json_encode(array(
                            'status' => 1,
                            'messenger' => esc_html__("Importing menu settings ...","construction")." <span>".esc_html__("DONE!","construction")."</span><br>",
                            'next_url' => $nexturl,
                        )
                    );
                }

                // Set reading options
                if($step == '5'){
                    $stt_file=isset($_REQUEST['rev_number'])?$_REQUEST['rev_number']:0;
                    $ds_file=array_filter(glob($data_dir.'/data-slider/*'),'is_file');
                    $file_name=isset($ds_file[$stt_file])?$ds_file[$stt_file]:false;
                    $nexturl=admin_url(self::$_import_page."&th_do_import=1&media={$import_media}&package={$package}&step=" . ($step+1));
                    if($stt_file<count($ds_file) && class_exists('RevSlider')){   
                        $nexturl=admin_url(self::$_import_page."&th_do_import=1&media={$import_media}&package={$package}&step=" . ($step).'&rev_number='.($stt_file+1));                     
                        if($file_name){
                            $slider = new RevSlider();
                            $response = $slider->importSliderFromPost(true, true, $data_dir . '/data-slider'.'/'.basename($file_name));
                            echo json_encode( array(
                                    'status'   => 1,
                                    'messenger'=> sprintf("Importing data: %s %d of %d ... <span>DONE!</span><br>",basename($file_name),$stt_file+1, count($ds_file)-0),
                                    'next_url' => $nexturl,
                                    'file'     => $ds_file,
                                )
                            );
                        }
                    }
                    else{                    
                        // Set reading options
                        if(!$set_woocommerce_page) {
                            $next_url = '';
                            $messenger = '<span>'.esc_html__("All Done! Have Fun","construction").'</span>';
                        }
                        else {
                            $next_url = admin_url(self::$_import_page . "&th_do_import=1&package={$package}&step=" . ($step+1) );
                            $messenger = '';
                        }
                        if($homepage_default != ""){
                            $homepage = get_page_by_title( $homepage_default );
                            if(is_object($homepage)) {
                                update_option('show_on_front', 'page');
                                update_option('page_on_front', $homepage->ID); // Front Page
                            }
                        }
                        if($blogpage_default != ""){
                            $homepage = get_page_by_title( $blogpage_default );
                            if(is_object($homepage)) {
                                update_option('show_on_front', 'page');
                                update_option('page_for_posts', $homepage->ID); // Blog Page
                            }
                        }

                        echo json_encode( array(
                                'status'   =>"ok",
                                'messenger'=>esc_html__("Setting reading options...","construction")." <span>".esc_html__("DONE!","construction")."</span><br/>".$messenger,
                                'next_url' => $next_url,
                            )
                        );
                    }
                }

                if($step=='6')
                {

                    //Setup WooCommerce page
                    if(class_exists('Woocommerce') and class_exists('WC_Install'))
                    {
                        WC_Install::create_pages();
                        WC_Admin_Notices::remove_notice( 'install' );
                    }
                    if(function_exists('vc_editor_set_post_types')){
                        $list = array(
                            'post',
                            'page',
                            'th_header',
                            'th_footer',
                            'th_mega_item',
                        );
                        vc_editor_set_post_types($list);
                    }
                    if(class_exists('Elementor\Core\Admin\Admin')){
                        $cpt_support = ['page','post','th_header','th_footer','th_mega_item'];
                        update_option( 'elementor_cpt_support', $cpt_support );
                        update_option( 'elementor_css_print_method', 'external' );
                        $my_post = get_page_by_title( 'Default Kit', OBJECT, 'elementor_library' );
                        if(isset($my_post->ID)){
                            $settings = json_decode($th_config['elementor_settings'],true);
                            update_post_meta($my_post->ID,'_elementor_page_settings',$settings);
                        }
                    }                 
                    echo json_encode( array(
                            'status'   =>"ok",
                            'messenger'=>esc_html__("Setting WooCommerce options...","construction")." <span>".esc_html__("DONE!","construction")."</span><br/><span>".esc_html__("All Done! Have Fun","construction")."</span>",
                            'next_url' => '',
                        )
                    );
                }
                die;
            }
        }
    }

    th_Importer::init();
}
