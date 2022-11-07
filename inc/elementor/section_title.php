<?php
/* add_ons_php */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Th_Section_Title extends Widget_Base { 

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
        return 'section_title';
    }

    // public function get_id() {
    //    	return 'header-search';
    // }

    public function get_title() {
        return __( 'Section Title', 'construction' );
    }

    public function get_icon() {
        // Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
        return 'eicon-button';
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
        return [  'th-category' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'construction' ),
            ]
        );

        $this->add_control(
            'local',
            [
                'label' => __( 'Section Title Location', 'construction' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => esc_html__('Left', 'construction'), 
                    'center' => esc_html__('Center', 'construction'),  
                ],
                'default' => 'left',                
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'construction' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Most Popular Palces',
                'label_block' => true,
                
            ]
        );

        $this->add_control(
            'over_title',
            [
                'label' => __( 'Sub Title', 'construction' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Best Listings',
                'label_block' => true,
                // 'separator' => 'before'
                
            ]
        );
        $this->add_control(
            'show_sep',
            [
                'label' => __( 'Show Separator', 'construction' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => _x( 'Yes', 'On/Off', 'construction' ),
                'label_off' => _x( 'No', 'On/Off', 'construction' ),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'separator_loction',
            [
                'label' => __( 'Separator Location', 'construction' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'all' => esc_html__('ALL', 'construction'), 
                    'left' => esc_html__('Left', 'construction'), 
                    'right' => esc_html__('Right', 'construction'), 
                ],
                'default' => 'all',                
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => __( 'Description', 'construction' ),
                'type' => Controls_Manager::TEXTAREA, // WYSIWYG,
                'default' => '<p>Proin dapibus nisl ornare diam varius tempus. Aenean a quam luctus, finibus tellus ut, convallis eros sollicitudin turpis.</p>',
                // 'show_label' => false,
            ]
        );

        

        

        $this->end_controls_section();

    }

    protected function render( ) {

        $settings = $this->get_settings();
        ?>
        <div class="section-title section-title-<?php echo $settings['local']; ?> fl-wrap">
            <?php 
                if($settings['show_sep'] == 'yes'): ?>
                <?php if(!empty($settings['over_title'])) echo '<div class="section-subtitle section-subtitle-'.$settings['separator_loction'].'">'.$settings['over_title'].'</div>'; ?>
            <?php endif; ?>
            <?php if(!empty($settings['title'])) echo '<h2><span>'.$settings['title'].'</span></h2>'; ?>
            <?php echo $settings['sub_title'];?> 
        </div>
        <?php
    }
}


