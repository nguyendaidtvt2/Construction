<?php
/* add_ons_php */

class Esb_Class_Project_CPT extends Esb_Class_CPT {
    protected $name = 'project';
    protected $permalinks = array();

    protected $tabs = array();
    protected $fields = array();
    protected function init(){
        $this->permalinks = get_option( 'cthpermalinks', array() );
        $this->set_builtin_metas();
        parent::init();
        add_action( 'init', array($this, 'taxonomies'), 0 ); 
        add_filter('manage_edit-project_cat_columns', array($this, 'tax_cat_columns_head') );
        add_filter('manage_project_cat_custom_column', array($this, 'tax_cat_columns_content'), 10, 3); 
        // add_filter('single_template', array($this, 'single_template')); 
        add_filter('pre_get_posts', array($this, 'pre_get_posts')); 


        // add_filter('use_block_editor_for_post_type', array($this, 'enable_gutenberg'), 10, 2 );

        add_filter('getarchives_where', array($this, 'getarchives_where'), 10, 3); 
        // add_filter( 'generate_rewrite_rules', array($this, 'generate_rewrite_rules') ); 

        
    }
    public function enable_gutenberg( $current_status, $post_type ){
        if ($post_type === 'project') 
            return true;

        return $current_status;
    }

    public function single_template($single_template){
        global $post;

        if ($post->post_type == 'project') {
            $single_template = get_template_part('template-parts/project/single', '', null, false);
        }
        return $single_template;
    }

    public function pre_get_posts($query){
        if ( ! is_admin() && $query->is_main_query() ) {
            if( is_post_type_archive('project') || is_tax('project_cat') ){
               
            }
        }
    }

    public function register(){
        $pslug = !empty($this->permalinks['cthproject_slug']) ? $this->permalinks['cthproject_slug'] : 'project';
        $labels = array( 
            'name' => _x( 'Project', 'Dashboard', 'theroof-add-ons' ),
            'singular_name' => _x( 'Project', 'Dashboard', 'theroof-add-ons' ),
            'add_new' => _x( 'Add New Project', 'Dashboard', 'theroof-add-ons' ),
            'add_new_item' => _x( 'Add New Project', 'Dashboard', 'theroof-add-ons' ),
            'edit_item' => _x( 'Edit Project', 'Dashboard', 'theroof-add-ons' ),
            'new_item' => _x( 'New Project', 'Dashboard', 'theroof-add-ons' ),
            'view_item' => _x( 'View Project', 'Dashboard', 'theroof-add-ons' ),
            'search_items' => _x( 'Search Projects', 'Dashboard', 'theroof-add-ons' ),
            'not_found' => _x( 'No Projects found', 'Dashboard', 'theroof-add-ons' ),
            'not_found_in_trash' => _x( 'No Projects found in Trash', 'Dashboard', 'theroof-add-ons' ),
            'parent_item_colon' => _x( 'Parent Project:', 'Dashboard', 'theroof-add-ons' ),
            'menu_name' => _x( 'Projects', 'Dashboard', 'theroof-add-ons' ),
        );

        $args = array( 
            'labels' => $labels,
            'hierarchical' => true,
            'description' => 'List Projects',
            'supports' => array( 'title', 'editor',  'author', 'thumbnail','comments','excerpt', 'page-attributes' /*'title', 'editor', 'excerpt', 'thumbnail','comments',*//*, 'post-formats'*/),
            'taxonomies' => array('project_cat'),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-editor-kitchensink', 
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => array( 'slug' => $pslug , 'with_front' => false ),
            'capability_type' => 'post',
            // https://wordpress.stackexchange.com/questions/324221/enable-gutenberg-on-custom-post-type
            // 'show_in_rest'      => true,
        );
        register_post_type( $this->name, $args );
    }
    public function taxonomies(){
        $cslug = !empty($this->permalinks['cthproject_cat_slug']) ? $this->permalinks['cthproject_cat_slug'] : 'project_cat';
        $labels = array(
            'name' => __( 'Categories', 'theroof-add-ons' ),
            'singular_name' => __( 'Category', 'theroof-add-ons' ),
            'search_items' =>  __( 'Search Categories','theroof-add-ons' ),
            'all_items' => __( 'All Categories','theroof-add-ons' ),
            'parent_item' => __( 'Parent Category','theroof-add-ons' ),
            'parent_item_colon' => __( 'Parent Category:','theroof-add-ons' ),
            'edit_item' => __( 'Edit Category','theroof-add-ons' ), 
            'update_item' => __( 'Update Category','theroof-add-ons' ),
            'add_new_item' => __( 'Add New Category','theroof-add-ons' ),
            'new_item_name' => __( 'New Category Name','theroof-add-ons' ),
            'menu_name' => __( 'Categories','theroof-add-ons' ),
          );     

        // Now register the taxonomy

        register_taxonomy('project_cat',array('project'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => $cslug , 'with_front' => false ),
        ));

    }
    public function tax_cat_columns_head($columns) {
        // $columns['_thumbnail'] = __('Thumbnail','theroof-add-ons');
        $columns['_id'] = __('ID','theroof-add-ons');
        return $columns;
    }

    public function tax_cat_columns_content($c, $column_name, $term_id) {
        if ($column_name == '_id') {
            echo $term_id;
        }
        // if ($column_name == '_thumbnail') {
        //     $term_meta = get_term_meta( $term_id, ESB_META_PREFIX.'term_meta', true );
        //     if(isset($term_meta['featured_img']) && !empty($term_meta['featured_img'])){
        //         echo wp_get_attachment_image( $term_meta['featured_img']['id'], 'thumbnail', false, array('style'=>'width:100px;height:auto;') );
                
        //     }
        // }
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

    public function getarchives_where( $where, $args ){
        if ( isset($args['post_type']) && $args['post_type'] == 'project' ) {      
            $where = "WHERE post_type = '$args[post_type]' AND post_status = 'publish'";
        }

        return $where;
    }

    public function generate_rewrite_rules( $wp_rewrite ){
        $slug = _x( 'project', 'project url slug', 'theroof-add-ons' );
        $new_rules = array(
            $slug.'/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$' => 'index.php?post_type=project&year=$matches[1]&monthnum=$matches[2]&day=$matches[3]',
            $slug.'/([0-9]{4})/([0-9]{1,2})/?$' => 'index.php?post_type=project&year=$matches[1]&monthnum=$matches[2]',
            $slug.'/([0-9]{4})/?$' => 'index.php?post_type=project&year=$matches[1]' 
        );

        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    }
    protected function set_builtin_metas(){
        $this->has_builtin_metas = true; 
        $this->tabs = [
            ['label' => esc_html_x( 'Header', 'Metabox', 'theroof-add-ons' ), 'slug' => 'general'],
            ['label' => esc_html_x( 'Details', 'Metabox', 'theroof-add-ons' ), 'slug' => 'details'],
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
            'slayout' => [
                'type'          => 'Select',
                'label'         => esc_html__( 'Layout', 'theroof-add-ons' ),
                'options'       => [
                    ['label' => esc_html__( 'Elementor', 'theroof-add-ons' ), 'value' => 'elementor'],
                    ['label' => esc_html__( 'Slider', 'theroof-add-ons' ), 'value' => 'slider'],
                    ['label' => esc_html__( 'Gallery', 'theroof-add-ons' ), 'value' => 'gallery'],
                ],
                'default'       => 'elementor',
                'required'      => true,
                'classes'       => 'col-md-12 mb-3',
                'desc'          => '',
                'group'         => 'details',
            ],
            'photos' => [
                'type'          => 'WPMedia',
                'label'         => esc_html__( 'Photos', 'theroof-add-ons' ),
                'default'       => '',
                'required'      => false,
                'single'        => false,
                'idOnly'        => false,
                'urlOnly'       => false,
                'showInput'     => false,
                'classes'       => 'col-md-12 mb-3',
                'desc'          => '',
                'group'         => 'details',
                'condition'     => [
                    'slayout' => [
                        ['in' => ['slider', 'gallery']]
                    ],
                ],
            ],
        ];
    }
    
    public function save_post($post_id, $post, $update)
    {
        // error_log('save project post');
        if (!$this->can_save($post_id)) {
            return;
        }
        
        $this->save_builtin_metas($post_id);

        // new settings
        do_action( 'cth_cpt_'.$this->name.'_save_meta_boxes', $post_id, $post, $update );
        
    }
}

new Esb_Class_Project_CPT();