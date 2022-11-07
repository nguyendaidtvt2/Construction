<?php
defined( 'ABSPATH' ) || exit;

class Th_Icons{
	public static $_instance = null;
	public function ekit_icons_pack(){
		add_filter( 'elementor/icons_manager/additional_tabs', [ $this, '__add_font']);
	}

	public function __add_font( $font){
        $font_new['ekiticons'] = [
			'name' => 'ekiticons',
			'label' => esc_html__( 'ThTheme - Icons', 'construction' ),
			'url' => th_Elementor::get_url_css() . 'ekiticons.css',
			'enqueue' => [th_Elementor::get_url_css() . 'ekiticons.css'],
			'prefix' => 'icon-',
			'displayPrefix' => 'icon',
			'labelIcon' => 'icon icon-home',
			'fetchJson' => th_Elementor::get_url_js() . '/ekiticons.js',
			'native' => true,
			'ver' => '1.0',
		];
		$font_new['lineicons'] = [
			'name' => 'lineicons',
			'label' => esc_html__( 'La - Icons', 'construction' ),
			'url' => th_Elementor::get_url_css() . 'line-awesome.css',
			'enqueue' => [th_Elementor::get_url_css() . 'line-awesome.css'],
			'prefix' => '',
			'displayPrefix' => '',
			'labelIcon' => 'la la-home',
			'fetchJson' => th_Elementor::get_url_js() . '/lineicons.js',
			'native' => true,
			'ver' => '1.0',
		];
        return  array_merge($font, $font_new);
    }
	
	
	// public static function __generate_font(){
	// 	global $wp_filesystem;
	// 	require_once ( ABSPATH . '/wp-admin/includes/file.php' );
	// 	WP_Filesystem();
	// 	//$css_file =  \ElementsKit::widget_dir() . 'init/assets/css/admin-ekiticon.css';
	// 	$css_file =  th_Elementor::get_url_css() . 'ekiticons.css';
	// 	if ( $wp_filesystem->exists( $css_file ) ) {
	// 		$css_source = $wp_filesystem->get_contents( $css_file );
	// 	} 
		
	// 	preg_match_all( "/\.(icon-.*?):\w*?\s*?{/", $css_source, $matches, PREG_SET_ORDER, 0 );
	// 	$iconList = [];
	// 	foreach ( $matches as $match ) {
	// 		//$new_icons[$match[1] ] = str_replace('ekit-wid-con .icon-', '', $match[1]);
	// 		$iconList[] = str_replace('icon-', '', $match[1]);
	// 	}
	// 	$icons = new \stdClass();
	// 	$icons->icons = $iconList;
	// 	$icon_data = json_encode($icons);
	// 	$file = th_Elementor::get_url_js() . 'ekiticons.js';
	// 	global $wp_filesystem;
	// 	require_once ( ABSPATH . '/wp-admin/includes/file.php' );
	// 	WP_Filesystem();
	// 	if ( $wp_filesystem->exists( $file ) ) {
	// 		$content =  $wp_filesystem->put_contents( $file, $icon_data) ;
	// 	} 
		
	// }

	public static function _get_instance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

}
