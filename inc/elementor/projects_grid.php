<?php
/* add_ons_php */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Th_Projects_Grid extends Widget_Base {

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
        return 'projects_grid';
    }

    // public function get_id() {
    //    	return 'header-search';
    // }

    public function get_title() {
        return __( 'Projects Grid', 'construction' );
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
        return [ 'th-category' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_query',
            [
                'label' => __( 'Posts Query', 'construction' ),
            ]
        );

        $this->add_control(
            'cat_ids',
            [
                'label' => __( 'Post Category IDs to include', 'construction' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'description' => __("Enter post category ids to include, separated by a comma. Leave empty to get posts from all categories.", 'construction')
                
            ]
        );

        $this->add_control(
            'ids',
            [
                'label' => __( 'Enter Post IDs', 'construction' ),
                'type' => Controls_Manager::TEXT,
                // 'default' => '437,439,451',
                'default' => '',
                'label_block' => true,
                'description' => __("Enter Post ids to show, separated by a comma. Leave empty to show all.", 'construction')
                
            ]
        );
        $this->add_control(
            'ids_not',
            [
                'label' => __( 'Or Post IDs to Exclude', 'construction' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'description' => __("Enter post ids to exclude, separated by a comma (,). Use if the field above is empty.", 'construction')
                
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
                'label' => __( 'Posts to show', 'construction' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '3',
                'description' => esc_html__("Number of posts to show (-1 for all).", 'construction'),
                
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
            'title_portfo',
            [
                'label'       => __('Title Portfolio', 'construction'),
                'type'        => Controls_Manager::TEXT,

                'label_block' => true,
                'default'     => 'Portfolio Grid',
                // 'separator' => 'before',
                'description' => '',
            ]
        );
        $this->add_control(
            'sub_title_portfo',
            [
                'label'       => __('Sub Title Portfolio', 'construction'),
                'type'        => Controls_Manager::TEXT,

                'label_block' => true,
                'default'     => 'MY CASES',
                // 'separator' => 'before',
                'description' => '',
            ]
        );
        $this->add_control(
            'glayout',
            [
                'label' => __( 'Layout', 'construction' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-1' => esc_html__('style 1', 'construction'), 
                    'style-2' => esc_html__('style 2', 'construction'), 
                    'style-3' => esc_html__('style 3', 'construction'), 
                ],
                'default' => 'style-1',
                // 'description' => esc_html__("Number of posts to show (-1 for all).", 'construction'),
                
            ]
        );

        $this->add_control(
            'show_fix_height',
            [
                'label' => __( 'Fix image same height', 'construction' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Yes', 'construction' ),
                'label_off' => __( 'No', 'construction' ),
                'return_value' => 'yes',
                'condition' => [
                    'glayout' => 'style-2',
                ],
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
                    // 'exbig' => esc_html__('Extra Big', 'construction'), 
                    // 'mbig' => esc_html__('Bigger', 'construction'), 
                    'big' => esc_html__('Big', 'construction'), 
                    'medium' => esc_html__('Medium', 'construction'), 
                    'small' => esc_html__('Small', 'construction'), 
                    'extrasmall' => esc_html__('Extra Small', 'construction'), 
                    'no' => esc_html__('None', 'construction'), 
                    
                ],
                'default' => 'small',
                // 'description' => esc_html__("Number of posts to show (-1 for all).", 'construction'),
                
            ]
        );

        // $this->add_control(
        //     'show_excerpt',
        //     [
        //         'label' => __( 'Show Excerpt', 'construction' ),
        //         'type' => Controls_Manager::SWITCHER,
        //         'default' => 'no',
        //         'label_on' => __( 'Yes', 'construction' ),
        //         'label_off' => __( 'No', 'construction' ),
        //         'return_value' => 'yes',
        //     ]
        // );

       

        // $this->add_control(
        //     'show_author',
        //     [
        //         'label' => __( 'Show Author', 'construction' ),
        //         'type' => Controls_Manager::SWITCHER,
        //         'default' => 'yes',
        //         'label_on' => __( 'Yes', 'construction' ),
        //         'label_off' => __( 'No', 'construction' ),
        //         'return_value' => 'yes',
        //     ]
        // );

        // $this->add_control(
        //     'show_date',
        //     [
        //         'label' => __( 'Show Date', 'construction' ),
        //         'type' => Controls_Manager::SWITCHER,
        //         'default' => 'yes',
        //         'label_on' => __( 'Yes', 'construction' ),
        //         'label_off' => __( 'No', 'construction' ),
        //         'return_value' => 'yes',
        //     ]
        // );

        // $this->add_control(
        //     'show_views',
        //     [
        //         'label' => __( 'Show Views', 'construction' ),
        //         'type' => Controls_Manager::SWITCHER,
        //         'default' => 'no',
        //         'label_on' => __( 'Yes', 'construction' ),
        //         'label_off' => __( 'No', 'construction' ),
        //         'return_value' => 'yes',
        //     ]
        // );

        // $this->add_control(
        //     'show_cats',
        //     [
        //         'label' => __( 'Show Categories', 'construction' ),
        //         'type' => Controls_Manager::SWITCHER,
        //         'default' => 'yes',
        //         'label_on' => __( 'Yes', 'construction' ),
        //         'label_off' => __( 'No', 'construction' ),
        //         'return_value' => 'yes',
        //     ]
        // );

        // $this->add_control(
        //     'read_all_link',
        //     [
        //         'label' => __( 'Read All URL', 'construction' ),
        //         'type' => Controls_Manager::URL,
        //         'default' => [
        //             'url' => '#',
        //             'is_external' => '',
        //         ],
        //         'show_external' => true, // Show the 'open in new tab' button.
        //     ]
        // );

        // $this->add_control(
        //     'view_all_text',
        //     [
        //         'label'       => __('Read all Text', 'construction'),
        //         'type'        => Controls_Manager::TEXT,

        //         'label_block' => true,
        //         'default'     => 'Read All Posts',
        //         // 'separator' => 'before',
        //         'description' => '',
        //     ]
        // );

        $this->add_control(
            'show_loadmore',
            [
                'label' => __( 'Show Loadmore', 'construction' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Yes', 'construction' ),
                'label_off' => __( 'No', 'construction' ),
                'return_value' => 'yes',
            ]
        );
         $this->add_control(
            'loadmore_posts',
            [
                'label'       => __('Load more items', 'construction'),
                'type'        => Controls_Manager::TEXT,

                'label_block' => true,
                'default'     => '3',
                // 'separator' => 'before',
                'description' => '',
            ]
        );
        $this->add_control(
            'show_pagination',
            [
                'label' => __( 'Show Pagination', 'construction' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __( 'Yes', 'construction' ),
                'label_off' => __( 'No', 'construction' ),
                'return_value' => 'yes',

            ]
        );

        // $this->add_control(
        //     'show_details',
        //     [
        //         'label' => __( 'Show Details', 'construction' ),
        //         'type' => Controls_Manager::SWITCHER,
        //         'default' => 'false',
        //         'label_on' => __( 'Yes', 'construction' ),
        //         'label_off' => __( 'No', 'construction' ),
        //         'return_value' => 'yes',
        //     ]
        // );
        


        $this->end_controls_section();


        $this->start_controls_section(
            'filter_sec',
            [
                'label' => __('Filter', 'construction'),
            ]
        );

        $this->add_control(
            'show_filter',
            [
                'label'        => _x('Show Filter?','Elementor element', 'construction'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on' => _x( 'Yes', 'On/Off', 'construction' ),
                'label_off' => _x( 'No', 'On/Off', 'construction' ),
                'return_value' => 'yes',
            ]
        );
        
        $this->add_control(
            'forderby',
            [
                'label'       => __('Order by', 'construction'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'name'        => esc_html__('Name', 'construction'),
                    'slug'        => esc_html__('Slug', 'construction'),
                    'term_group'  => esc_html__('Term Group', 'construction'),
                    'term_id'     => esc_html__('Term ID', 'construction'),
                    'id'          => esc_html__('ID', 'construction'),
                    'description' => esc_html__('Description', 'construction'),
                    'parent'      => esc_html__('Parent', 'construction'),
                    'count'       => esc_html__('Count', 'construction'),
                    // 'include'     => esc_html__('Include', 'construction'),

                ],
                'default'     => 'slug',
                'separator'   => 'before',
                'description' => '',
            ]
        );

        $this->add_control(
            'forder',
            [
                'label'       => __('Sort Order', 'construction'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'ASC'  => esc_html__('Ascending', 'construction'),
                    'DESC' => esc_html__('Descending', 'construction'),
                ],
                'default'     => 'ASC',
                'separator'   => 'before',
                'description' => '',
            ]
        );

        $this->end_controls_section();

    }

    protected function render( ) {

        $settings = $this->get_settings();
        $glayout = !empty($settings['glayout']) ? $settings['glayout'] : 'style-1';

        if(is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        if(!empty($settings['ids'])){
            $ids = explode(",", $settings['ids']);
            $post_args = array(
                'post_type' => 'project',
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
                'post_type' => 'project',
                'paged' => $paged,
                'posts_per_page'=> $settings['posts_per_page'],
                'post__not_in' => $ids_not,
                'orderby'=> $settings['order_by'],
                'order'=> $settings['order'],

                'post_status' => 'publish'
            );
        }else{
            $post_args = array(
                'post_type' => 'project',
                'paged' => $paged,
                'posts_per_page'=> $settings['posts_per_page'],
                'orderby'=> $settings['order_by'],
                'order'=> $settings['order'],

                'post_status' => 'publish'
            );
        }





        if(!empty($settings['cat_ids'])){
            $post_args['tax_query'] = array(
                array(
                    'taxonomy' => 'project_cat',
                    'field'    => 'term_id',
                    'terms'    => explode(",", $settings['cat_ids']),
                )
            );
        }

        $css_classes = array(
            'gallery-items cthiso-items cthiso-flex lightgallery',
            'cthiso-'.$settings['space'].'-pad',
            'cthiso-'.$settings['columns_grid'].'-cols',
        );
         if($settings['show_loadmore'] == 'yes') $css_classes[] = ' use-loadmore';
        if( $settings['glayout'] == 'style-2' ) $css_classes[] = 'vis-det';
        // if( $glayout == 'sidefilter' ) $css_classes[] = 'row';

        $img_size = 'valik-post-grid';
        if( $settings['columns_grid'] == 'one' || $settings['columns_grid'] == 'two' ) $img_size = 'valik-featured';


        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

        ?>
        <?php 
        $folio_posts = new \WP_Query($post_args);
        if($folio_posts->have_posts()) : ?>
        <div class="cthiso-isotope-wrapper position-relative prgrid-layout-<?php echo $glayout;?>">
            
                <div class="<?php if( $glayout == 'style-3' ){ echo 'gallery-filters hid-filter'; }else{ echo 'gallery-filter_fw fl-wrap gff2 ';}; ?>">
                    <?php
                    if($settings['show_filter'] == 'yes') : 
                    $term_args = array(
                        'taxonomy'          => 'project_cat',
                        'orderby'           => $settings['forderby'], //id, count, name, slug, none
                        'order'             => $settings['forder'],
                        // 'include'           => ($port_cats) ? $port_cats : '',
                    ); 


                    $project_cats = get_terms($term_args); 

                ?>
                <?php if(count($project_cats)): ?>
                    <div class="gallery-filters hid-filter">
                        <a href="#" class="cthiso-filter cthiso-filter-active gallery-filter  gallery-filter-active" data-filter="*"><span><?php esc_html_e('All Cases','construction' );?></span></a>
                            <?php foreach($project_cats as $project_cat) { ?>
                            <a href="#" class="cthiso-filter gallery-filter" data-filter=".project_cat-<?php echo esc_attr($project_cat->slug ); ?>"><?php echo esc_html($project_cat->name ); ?></a>
                            <?php } ?>
                    </div>
                     <?php endif; 
                endif; //end showfilltergallery-filter
                ?>

                </div>
            <?php 
                if( $glayout == 'style-3' ): ?>
                </div>
            <?php endif; ?>


            
    <div class="<?php echo esc_attr($css_class );?>" 
        <?php if(  $settings['show_loadmore']  == 'yes' && ( $settings['posts_per_page'] != '-1' && $folio_posts->found_posts && $folio_posts->found_posts > $settings['posts_per_page'] ) ):
        $lmore_data = $post_args;
        $lmore_data['action'] = 'valik_lm_folio';
        $lmore_data['lmore_items'] =  $settings['loadmore_posts'];
        $lmore_data['layout'] = $glayout;
        $lmore_data['show_fix_height'] = $settings['show_fix_height'];
        ?>
         data-lm-request="<?php echo esc_url(admin_url( 'admin-ajax.php' ) ) ;?>"
         data-lm-nonce="<?php echo wp_create_nonce( 'valik_lm_folio' ); ?>"
         data-lm-settings="<?php echo esc_attr( json_encode($lmore_data) ); ?>"
        <?php endif;?>>
                <?php while($folio_posts->have_posts()) : $folio_posts->the_post(); ?>

                    <div <?php post_class('cthiso-item  gallery-item');?>> 
                        <div class="grid-item-holder">

                            <?php if(has_post_thumbnail()): ?>
                                <a href="<?php the_permalink(); ?>">
                                   <?php if( $glayout == 'style-2' && $settings['show_fix_height'] == 'yes'){
                                        the_post_thumbnail( 'valik-fix-height' );
                                   }else{
                                     the_post_thumbnail( 'valik-project' );
                                   } ?>
                                </a>
                            <?php endif; ?>
                            <div class="grid-item-holder_title">
                                <?php 
                                $terms = get_the_terms(get_the_ID(), 'project_cat');
                                if ( $terms && ! is_wp_error( $terms ) ){
                                    foreach( $terms as $key => $term){
                                        
                                       $term_link = get_term_link( $term, array( 'project_cat') );
                                        echo sprintf('<h5><a href="%1$s">%2$s</a></h5>',
                                            esc_url($term_link),
                                            esc_html($term->name)
                                        );
                                    }
                                }
                                ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                        </div>
                    </div>

                    <?php endwhile; ?>
                
            </div>
            <?php
            // if($settings['show_pagination'] == 'yes') valik_addons_custom_pagination($folio_posts->max_num_pages,$range = 2, $folio_posts) ;
            ?>
            <div class="col-md-12 msg-ajax">
                 <span class= "portfolio-msg">All Cases Loaded</span> 
            </div>
        </div>
         <?php if( $settings['show_loadmore'] == 'yes' && ( $settings['posts_per_page'] != '-1' && $folio_posts->found_posts && $folio_posts->found_posts > $settings['posts_per_page'] ) ): ?>
            <div class="folio-grid-lmore-holder">
                <a class="folio-load-more single-btn" data-click="1" data-remain="yes" href="#"><?php echo wp_kses(__('<span>Load More Cases</span>','construction'), array('i'=>array('class'=>array()),'span'=>array('class'=>array()),) );?></a>
            </div>
            
            
        <?php endif; ?>
       
        <?php endif; ?> 
        <?php wp_reset_postdata();?>
        <div class=" limit-box"></div>
        <!-- .cthiso-isotope-wrapper end -->
        <?php

    }

    

}