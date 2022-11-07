<?php
/* add_ons_php */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Th_Our_Partners extends Widget_Base {

    /**
    * Get widget name.
    *
    * Retrieve alert widget name. 
    *
    * 
    * @access public
    *
    * @return string Widget name.
    */
    public function get_name() {
        return 'our_partners';
    }

    // public function get_id() {
    //    	return 'header-search';
    // }

    public function get_title() {
        return __( 'Our Partners', 'construction' );
    }

    public function get_icon() {
        // Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
        return 'cth-elementor-icon';
    }

    /**
    * Get widget categories.
    *
    * Retrieve the widget categories.
    *
    * 
    * @access public
    *
    * @return array Widget categories.
    */
    public function get_categories() {
        return [ 'th-category' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_images',
            [
                'label' => __( 'Content', 'construction' ),
            ]
        );

        $this->add_control(
            'images',
            [
                'label' => __( 'Partners Images', 'construction' ),
                'type' => Controls_Manager::GALLERY,
                'default' => array(
                    array('id' => 6405,'url'=>''),
                    array('id' => 6406,'url'=>''),
                    array('id' => 6407,'url'=>''),
                    array('id' => 6408,'url'=>''),
                    array('id' => 6409,'url'=>''),
                    array('id' => 6410,'url'=>''),
                )
            ]
        );

        $this->add_control(
            'links',
            [
                'label' => __( 'Partner Links', 'construction' ),
                'type' => Controls_Manager::TEXTAREA, // WYSIWYG,
                'default' => 'https://jquery.com/|https://envato.com/|https://wordpress.org/|https://jquery.com/|https://envato.com/|https://wordpress.org/',
                // 'show_label' => false,
                'description' => __( 'Enter links for each partner (Note: divide links with linebreaks (Enter) or | and no spaces).', 'construction' )
            ]
        );

        $this->add_control(
            'is_external',
            [
                'label' => __( 'Is External Links', 'construction' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => _x( 'Yes', 'On/Off', 'construction' ),
                'label_off' => _x( 'No', 'On/Off', 'construction' ),
                'return_value' => 'yes',
            ]
        );
        $this->end_controls_section();

    }

    protected function render( ) {

        $settings = $this->get_settings();

        
        $css_classes = array(
            'clients-carousel-wrap fl-wrap',
            // 'posts-grid-',//.$settings['columns_grid']
        );

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

        // var_dump($settings['images']);
        if(is_array($settings['images']) && !empty($settings['images'])):

            $seppos = strpos(strip_tags($settings['links']), "|");
            if($seppos !== false){
                $partnerslinks = explode("|", strip_tags($settings['links']));
            }else{
                $partnerslinks = preg_split( '/\r\n|\r|\n/', strip_tags($settings['links']) );//explode("\n", $content);
            }
        ?>
        <div class="<?php echo esc_attr($css_class );?>">

            <div class="cc-btn cc-prev"><i class="fal fa-angle-left"></i></div>
            <div class="cc-btn cc-next"><i class="fal fa-angle-right"></i></div>
            <div class="clients-carousel">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php 
                        foreach ($settings['images'] as $key => $image) {
                            ?>
                            <!--client-item-->
                            <div class="swiper-slide">
                                <?php 
                                if(isset($partnerslinks[$key])){
                                    $target = $settings['is_external'] == 'yes'? ' target="_blank"':'';
                                    echo '<a class="client-item" href="'.esc_url( $partnerslinks[$key] ).'"'.$target.'>';
                                }else{
                                    echo '<a class="client-item" href="javascript:void(0);">';
                                }
                                echo wp_get_attachment_image( $image['id'],  'partner' ); ?>
                                </a>
                            </div>
                            <!--client-item end-->
                        <?php
                        }
                        ?>                                                                                                                                                                                                                                        
                    </div>
                </div>
            </div>
        </div>
        <?php
        endif;
    }
    

}
