<?php
/* add_ons_php */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Th_members_slider extends Widget_Base {

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
        return 'members_slider';
    }

    // public function get_id() {
    //      return 'header-search';
    // }

    public function get_title() {
        return __( 'Team Members Grid', 'construction' );
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
            'section_query',
            [
                'label' => __( 'Members Query', 'construction' ),
            ]
        );

        $this->add_control(
            'ids',
            [
                'label' => __( 'Enter Member IDs', 'construction' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'description' => __("Enter Member ids to show, separated by a comma. Leave empty to show all.", 'construction')
                
            ]
        );
        $this->add_control(
            'ids_not',
            [
                'label' => __( 'Or Member IDs to Exclude', 'construction' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'description' => __("Enter member ids to exclude, separated by a comma (,). Use if the field above is empty.", 'construction')
                
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => __( 'Order by', 'construction' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'date' => esc_html__('Date', 'construction'), 
                    'ID' => esc_html__('ID', 'construction'), 
                    'author' => esc_html__('Author', 'construction'), 
                    'title' => esc_html__('Title', 'construction'), 
                    'modified' => esc_html__('Modified', 'construction'),
                    'rand' => esc_html__('Random', 'construction'),
                    'comment_count' => esc_html__('Comment Count', 'construction'),
                    'menu_order' => esc_html__('Menu Order', 'construction'),
                    'post__in' => esc_html__('ID order given (post__in)', 'construction'),
                ],
                'default' => 'date',
                'separator' => 'before',
                'description' => esc_html__("Select how to sort retrieved posts. More at ", 'construction').'<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>.', 
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __( 'Sort Order', 'construction' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => esc_html__('Ascending', 'construction'), 
                    'DESC' => esc_html__('Descending', 'construction'), 
                ],
                'default' => 'DESC',
                'separator' => 'before',
                'description' => esc_html__("Select Ascending or Descending order. More at", 'construction').'<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>.', 
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __( 'Members to show', 'construction' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '3',
                'description' => esc_html__("Number of members to show (-1 for all).", 'construction'),
                
            ]
        );

        

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Posts Layout', 'construction' ),
            ]
        );

        $this->add_control(
            'columns_grid',
            [
                'label' => __( 'Columns Grid', 'construction' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'one' => esc_html__('One Column', 'construction'), 
                    'two' => esc_html__('Two Columns', 'construction'), 
                    'three' => esc_html__('Three Columns', 'construction'), 
                    'four' => esc_html__('Four Columns', 'construction'), 
                    'five' => esc_html__('Five Columns', 'construction'), 
                    'six' => esc_html__('Six Columns', 'construction'), 
                    'seven' => esc_html__('Seven Columns', 'construction'), 
                    'eight' => esc_html__('Eight Columns', 'construction'), 
                    'nine' => esc_html__('Nine Columns', 'construction'), 
                    'ten' => esc_html__('Ten Columns', 'construction'), 
                ],
                'default' => 'three',
                // 'description' => esc_html__("Number of posts to show (-1 for all).", 'construction'),
                
            ]
        );



        $this->add_control(
            'space',
            [
                'label' => __( 'Space', 'construction' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'exbig' => esc_html__('Extra Big', 'construction'), 
                    'mbig' => esc_html__('Bigger', 'construction'), 
                    'big' => esc_html__('Big', 'construction'), 
                    'medium' => esc_html__('Medium', 'construction'), 
                    'small' => esc_html__('Small', 'construction'), 
                    'extrasmall' => esc_html__('Extra Small', 'construction'), 
                    'no' => esc_html__('None', 'construction'), 
                    
                ],
                'default' => 'medium',
                // 'description' => esc_html__("Number of posts to show (-1 for all).", 'construction'),
                
            ]
        );

        

        $this->add_control(
            'view_all_link',
            [
                'label' => __( 'View All URL', 'construction' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => '',
                ],
                'show_external' => true, // Show the 'open in new tab' button.
            ]
        );


        $this->add_control(
            'show_pagination',
            [
                'label' => __( 'Show Pagination', 'construction' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => _x( 'Yes', 'On/Off', 'construction' ),
                'label_off' => _x( 'No', 'On/Off', 'construction' ),
                'return_value' => 'yes',
            ]
        );


        


        $this->end_controls_section();

    }

    protected function render( ) {

        $settings = $this->get_settings();

        if(is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        if(!empty($settings['ids'])){
            $ids = explode(",", $settings['ids']);
            $post_args = array(
                'post_type' => 'member',
                'paged' => $paged,
                'posts_per_page'=> $settings['posts_per_page'],
                'post__in' => $ids,
                'orderby'=> $settings['order_by'],
                'order'=> $settings['order'],

                'post_status' => 'publish'
            );
        }elseif(!empty($settings['ids_not'])){
            $ids_not = explode(",", $settings['ids_not']);
            $post_args = array(
                'post_type' => 'member',
                'paged' => $paged,
                'posts_per_page'=> $settings['posts_per_page'],
                'post__not_in' => $ids_not,
                'orderby'=> $settings['order_by'],
                'order'=> $settings['order'],

                'post_status' => 'publish'
            );
        }else{
            $post_args = array(
                'post_type' => 'member',
                'paged' => $paged,
                'posts_per_page'=> $settings['posts_per_page'],
                'orderby'=> $settings['order_by'],
                'order'=> $settings['order'],

                'post_status' => 'publish'
            );
        }




        $css_classes = array(
            'cthiso-items cthiso-flex about-wrap team-box2',
            'cthiso-'.$settings['space'].'-pad',
            'cthiso-'.$settings['columns_grid'].'-cols',
        );

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

        ?>
        <div class="<?php echo esc_attr($css_class );?>">
        <?php 
            $posts_query = new \WP_Query($post_args);
            if($posts_query->have_posts()) : ?>
                <?php while($posts_query->have_posts()) : $posts_query->the_post(); ?>
                    <!-- team-item -->
                    

                    <div id="member-<?php the_ID(); ?>" <?php post_class('cthiso-item team-box'); ?>>
                        <?php
                        if(has_post_thumbnail( )){ ?>
                        <div class="team-photo">
                        <?php the_post_thumbnail('townhub-featured-image',array('class'=>'respimg') ); ?>
                        </div>
                        <?php } ?>

                        <div class="team-info fl-wrap">
                            <?php
                            the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
                            if( $job_pos = get_post_meta( get_the_ID(), 'job_pos', true ) ) echo '<h4>'.$job_pos.'</h4>';
                            ?>
                            <?php the_excerpt(); ?>
                            <?php
                            $socials = get_post_meta( get_the_ID(), 'socials' ,true ); 
                            if( !empty($socials) ):
                            ?>
                            <div class="team-social">
                                <ul class="no-list-style">
                                    <?php 
                                    foreach ((array)$socials as $social) {
                                        $iconcs = 'fab fa-'.$social['name'];
                                        if($social['name'] == 'envelope') $iconcs = 'fal fa-'.$social['name'];
                                        echo '<li><a href="'.esc_url($social['url']).'" target="_blank"><i class="'.esc_attr($iconcs).'"></i></a></li>';
                                    } ?>
                                </ul>
                            </div>
                            <?php endif; ?> 
                        </div>
                    </div>
                    <!-- team-item end  -->

                <?php endwhile; ?>
            <?php endif; ?> 

        </div>
        <?php
        ?>
        <?php
            $url = $settings['view_all_link']['url'];
            $target = $settings['view_all_link']['is_external'] ? 'target="_blank"' : '';
            if($url != '') echo '<div class="view-all-listings"><a href="' . $url . '" ' . $target .' class="btn  dec_btn  color2-bg">'.__('View All','construction').'<i class="fal fa-arrow-alt-right"></i></a></div>';
        ?>
        <?php wp_reset_postdata();?>
        <?php

    }

    protected function content_template() {}

   
    

}



