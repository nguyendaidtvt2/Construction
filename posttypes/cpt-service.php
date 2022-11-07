<?php
/* add_ons_php */

class Esb_Class_Service_CPT extends Esb_Class_CPT {
    protected $name = 'cthservice';
    protected $permalinks = array();
    protected function init(){
        $this->permalinks = get_option( 'cthpermalinks', array() );
        $this->set_builtin_metas();
        parent::init();
        // add_action( 'init', array($this, 'taxonomies'), 0 ); 
        // add_filter('manage_edit-portfolio_cat_columns', array($this, 'tax_cat_columns_head') );
        // add_filter('manage_portfolio_cat_custom_column', array($this, 'tax_cat_columns_content'), 10, 3); 
        // add_filter('single_template', array($this, 'single_template')); 

        // add_filter('use_block_editor_for_post_type', array($this, 'enable_gutenberg'), 10, 2 );
    }
    public function enable_gutenberg( $current_status, $post_type ){
        if ($post_type === 'cthservice') 
            return true;

        return $current_status;
    }

    public function register(){
        $pslug = !empty($this->permalinks['cthservice_slug']) ? $this->permalinks['cthservice_slug'] : 'service';
        $labels = array( 
            'name' => __( 'Service', 'theroof-add-ons' ),
            'singular_name' => __( 'Service', 'theroof-add-ons' ),
            'add_new' => __( 'Add New Service', 'theroof-add-ons' ),
            'add_new_item' => __( 'Add New Service', 'theroof-add-ons' ),
            'edit_item' => __( 'Edit Service', 'theroof-add-ons' ),
            'new_item' => __( 'New Service', 'theroof-add-ons' ),
            'view_item' => __( 'View Service', 'theroof-add-ons' ),
            'search_items' => __( 'Search Services', 'theroof-add-ons' ),
            'not_found' => __( 'No Services found', 'theroof-add-ons' ),
            'not_found_in_trash' => __( 'No Services found in Trash', 'theroof-add-ons' ),
            'parent_item_colon' => __( 'Parent Service:', 'theroof-add-ons' ),
            'menu_name' => __( 'Services', 'theroof-add-ons' ),
        );

        $args = array( 
            'labels' => $labels,
            'hierarchical' => true,
            'description' => 'List Services',
            'supports' => array( 'title', 'editor', 'thumbnail','excerpt'/*,'comments', 'post-formats'*/),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' =>  'dashicons-search', 
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'has_archive' => false,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => array( 'slug' => $pslug , 'with_front' => false ), 
            'capability_type' => 'post',
            'show_in_rest' => true,
            // 'supports' => array('title', 'editor')
        );
        register_post_type( $this->name, $args );
    }
    protected function set_meta_columns(){
        $this->has_columns = true;
    }
    public function meta_columns_head($columns){
        $columns['_id'] = __( 'ID', 'theroof-add-ons' );
        $columns['_thumbnail'] = __( 'Thumbnail', 'theroof-add-ons' );
        return $columns;
    }
    public function meta_columns_content($column_name, $post_ID){
        if ($column_name == '_id') {
            echo $post_ID;
        }
        if ($column_name == '_thumbnail') {
            echo get_the_post_thumbnail( $post_ID, 'thumbnail', array('style'=>'width:100px;height:auto;') );
        }
    }
       protected function set_builtin_metas(){
        $this->has_builtin_metas = true; 
        $this->tabs = [
            ['label' => esc_html_x( 'Header', 'Metabox', 'theroof-add-ons' ), 'slug' => 'general'],
            // ['label' => esc_html_x( 'Page Format', 'Metabox', 'theroof-add-ons' ), 'slug' => 'details'],
        ];

        $this->fields = [
            'show_page_header' => [
                'type'          => 'Switch',
                'label'         => esc_html__( 'Show Header Section?', 'theroof-add-ons' ),
                'default'       => true,
                'required'      => true,
                'classes'       => 'col-md-12 mb-3',
                'desc'          => '',
                'group'         => 'general',
                'returnValue'   => 'yes',
            ],
            'page_header_intro' => [
                'type'          => 'Textarea',
                'label'         => esc_html__( 'Header Intro Text', 'theroof-add-ons' ),
                'default'       => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam',
                'required'      => false,
                'classes'       => 'col-md-12 mb-3',
                'desc'          => '',
                'group'         => 'general',
                'condition'     => [
                    'show_page_header' => [
                        ['equal' => true]
                    ],
                ],
            ],
            'page_header_bg' => [
                'type'          => 'WPMedia',
                'label'         => esc_html__( 'Background Image', 'theroof-add-ons' ),
                'default'       => get_template_directory_uri() . '/assets/images/bg_6.jpg',
                'required'      => false,
                'single'        => true,
                'idOnly'        => false,
                'urlOnly'       => true,
                'showInput'     => true,
                'classes'       => 'col-md-12 mb-3',
                'desc'          => '',
                'group'         => 'general',
                'condition'     => [
                    'show_page_header' => [
                        ['equal' => true]
                    ],
                ],
            ],
            // end header tab
            
        ];
    }
    
    public function save_post($post_id, $post, $update)
    {
        if (!$this->can_save($post_id)) {
            return;
        }

        $this->save_builtin_metas($post_id);
         
        // new settings
        do_action( 'cth_cpt_'.$this->name.'_save_meta_boxes', $post_id, $post, $update );
    }
       

}

new Esb_Class_Service_CPT();