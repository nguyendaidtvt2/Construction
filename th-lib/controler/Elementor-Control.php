<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
defined( 'ABSPATH' ) || exit;

class Th_Elementor{

    // instance of all control's base class
    public static function get_url_css(){
        return get_template_directory_uri() . '/assets/css/';
    }

    public static function get_url_js(){
        return get_template_directory_uri() . '/assets/js/';
    }

    public static function get_dir(){
        return get_template_directory() . '/th-lib/class/';
    }

    public function __construct() {

        // Includes necessary files
        $this->include_files();
        // load icons
        th_Icons::_get_instance()->ekit_icons_pack();
        
        // Initilizating control hooks
        add_action('elementor/controls/controls_registered', array( $this, 'icon' ), 11 );
        add_action('elementor/controls/controls_registered', array( $this, 'image_choose' ), 11 );
        add_action('elementor/controls/controls_registered', array( $this, 'ajax_select2' ), 11 );
        add_action('elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ), 5 );
        add_action('elementor/widgets/widgets_registered', array( $this, 'remove_pro_element' ), 15);
        // add_action( 'elementor/element/before_section_start', 'before_section_start', 10, 3 );
        // add_action( 'elementor/frontend/section/before_render', array( $this, 'section_before_render'), 20 );

    }

    private function include_files(){
        // Controls_Manager

        // image choose
        include_once self::get_dir() . 'image-choose.php';

        // icons
        include_once self::get_dir() . 'icon.php';
        include_once self::get_dir() . 'icons.php';

        // ajax select2
        include_once self::get_dir() . 'ajax-select2.php';
        include_once self::get_dir() . 'ajax-select2-api.php';
    }

    public function icon( $controls_manager ) {
        $controls_manager->unregister_control( $controls_manager::ICON );
        $controls_manager->register_control( $controls_manager::ICON, new Th_Icon());
    }

    public function image_choose( $controls_manager ) {
        $controls_manager->register_control('imagechoose', new Th_Image_Choose());
    }

    public function ajax_select2( $controls_manager ) {
        $controls_manager->register_control('ajaxselect2', new Th_Ajax_Select2());
    }

    public function add_elementor_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'th-category',
            [
                'title' => esc_html__( 'ThTheme', 'construction' ),
                'icon' => 'la la-plug',
            ]
        );
    }

    public function before_section_start( $element, $section_id, $args ) {
        if ( 'section' === $element->get_name()) {
            $element->start_controls_section(
                'custom_section',
                [
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'label' => esc_html__( 'Custom Section', 'construction' ),
                ]
            );

            $element->add_control(
                'custom_control',
                [
                'type' => \Elementor\Controls_Manager::NUMBER,
                'label' => esc_html__( 'Custom Control', 'construction' ),
                ]
            );

            $element->end_controls_section();
        }
    }

    public function section_before_render( \Elementor\Element_Base $element ) {
        if ( 'section' === $element->get_name()) {
            $data = $element->get_settings_for_display();
                $element->add_render_attribute( '_wrapper', [
                    'class' => 'my-custom-class',
                    'data-my_data' => 'my-data-value',
                ] );
       }
    }

    public function remove_pro_element( $widgets_manager ) {
        $elementor_widget_blacklist = [
          'posts'
          ,'portfolio'
          ,'slides'
          ,'form'
          ,'login'
          ,'media-carousel'
          ,'testimonial-carousel'
          ,'nav-menu'
          ,'pricing'
          ,'facebook-comment'
          ,'nav-menu'
          ,'animated-headline'
          ,'price-list'
          ,'price-table'
          ,'facebook-button'
          ,'facebook-comments'
          ,'facebook-embed'
          ,'facebook-page'
          ,'add-to-cart'
          ,'categories'
          ,'elements'
          ,'products'
          ,'flip-box'
          ,'carousel'
          ,'countdown'
          ,'share-buttons'
          ,'author-box'
          ,'breadcrumbs'
          ,'search-form'
          ,'post-navigation'
          ,'post-comments'
          ,'theme-elements'
          ,'blockquote'
          ,'template'
          ,'wp-widget-audio'
          ,'woocommerce'
          ,'social'
          ,'library'
        ];
        foreach($elementor_widget_blacklist as $widget_name){
            $widgets_manager->unregister_widget_type($widget_name);
        }
    }

}
new Th_Elementor();

