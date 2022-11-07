<?php 
/* add_ons_php */

require_once  ( trailingslashit( get_template_directory() ). '/posttypes/cpt-project.php' );
require_once  ( trailingslashit( get_template_directory() ). '/posttypes/cpt-service.php' );
require_once  ( trailingslashit( get_template_directory() ). '/posttypes/cpt-member.php' );
abstract class Esb_Class_CPT {
    protected $name = '';
    protected $meta_boxes = array();
    protected $has_builtin_metas = false;
    protected $tabs = array();
    protected $fields = array();
    protected $has_columns = false;

    protected $meta_df_options = array();

    public function __construct( ) {
        $this->set_meta_option_default();
        $this->set_meta_boxes();
        $this->set_meta_columns();
        $this->init();
    }
    protected function init(){
        add_action( 'init', array($this, 'register') );

        if(!empty($this->meta_boxes)){
            add_action( 'add_meta_boxes_'.$this->name, array($this, 'add_meta_boxes') );
            // add_action( 'save_post_'.$this->name, array($this, 'save_post'), 10, 3 );
        }
        if(!empty($this->meta_boxes) || $this->has_builtin_metas ){
            // add_action( 'add_meta_boxes_'.$this->name, array($this, 'add_meta_boxes') );
            add_action( 'save_post_'.$this->name, array($this, 'save_post'), 10, 3 );
        }
        if($this->has_columns){
            add_action( 'manage_'.$this->name.'_posts_columns', array($this, 'meta_columns_head') );
            add_action( 'manage_'.$this->name.'_posts_custom_column', array($this, 'meta_columns_content'), 10, 2 );
        }

        if( $this->has_builtin_metas ){
            add_action( 'current_screen', array($this, 'current_screen') );
            add_action('rest_api_init', array($this, 'rest_api'));

            add_action( 'add_meta_boxes_'.$this->name, array($this, 'add_builtin_meta_boxes') );
        }
    }

    public function rest_api(){
        register_rest_route( 'cth/v1', '/'.$this->name.'/metabox/(?P<pid>[\d]+)', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'get_metas'),
            'permission_callback' => function () {
                return current_user_can( 'edit_posts' );
            }
        ) );
    }

    protected function set_meta_option_default(){
        $this->meta_df_options = array(
            'title'                 => __( 'Default title', 'theroof-add-ons' ),
            'context'               => 'normal', // normal - side - advanced
            'priority'              => 'default', // default - high - low
            'callback_args'         => array()
        );
    }

    protected function set_meta_boxes(){}

    protected function can_save($post_id){
        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */
        // If this is just a revision, don't send the email.
        if ( wp_is_post_revision( $post_id ) )
            return false;

        // Check if our nonce is set.
        if ( ! isset( $_POST['th_cpt_nonce'] ) ) {
            return false;
        }
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['th_cpt_nonce'], 'cth-cpt-fields' ) ) {
            return false;
        }
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return false;
        }
        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return false;
        }

        return true;
    }

    protected function filter_meta_args($args, $post){
        return $args;
    }

    public function add_meta_boxes($post){
        $count = 0; // for print nonce on first
        foreach ($this->meta_boxes as $key => $options) {
            $options = array_merge($this->meta_df_options, $options);
            $options['callback_args'] = array_merge($options['callback_args'], array('index_count'  => $count));
            $options['callback_args'] = $this->filter_meta_args($options['callback_args'], $post);
            add_meta_box(
                $this->name.'_'.$key,
                $options['title'],
                array($this, $this->name.'_'.$key.'_callback'),
                $this->name,
                $options['context'],
                $options['priority'],
                $options['callback_args']
            );
            $count++;
        }
    }

    public function add_builtin_meta_boxes($post){
        add_meta_box(
            $this->name.'_bin_metas',
            sprintf( _x('%s Details', 'Metabox title', 'theroof-add-ons'), ucfirst($this->name) ),
            array($this, 'builtin_meta_callback'),
            $this->name,
            'normal', // normal - side - advanced
            'high', // default - high - low
            array()
        );
    }

    public function builtin_meta_callback($post, $args){
        wp_nonce_field('cth-cpt-fields', 'thcpt_nonce', false);
        ?>
        <div class="cthopts-tabs" ptype="<?php echo esc_attr($this->name); ?>" pid="<?php echo esc_attr($post->ID); ?>"></div>
        <?php
    }

    public function save_post($post_id, $post, $update){}
    protected function set_meta_columns(){}
    public function meta_columns_head($columns){}
    public function meta_columns_content($column_name, $post_ID){}
    // new theme options
    public function current_screen(){
        if ( function_exists('get_current_screen')) {  
            // $pt = get_current_screen()->post_type;
            $currenscreen = get_current_screen();
            if( $currenscreen->id == $this->name && $currenscreen->base == 'post' && $currenscreen->post_type == $this->name ){
                add_action( 'admin_enqueue_scripts', array($this, 'builtin_metas_scripts') );
            }
        }
    }
    public function builtin_metas_scripts(){
        wp_enqueue_style('fontawesome-pro', get_template_directory_uri() . '/assets/vendors/fontawesome-pro/css/all.min.css', false);
        wp_enqueue_style('cthtabs', get_template_directory_uri() . '/inc/cthoptions/css/metabox.css', false);

        wp_enqueue_script('react', get_template_directory_uri() . '/inc/cthoptions/vendors/react.production.min.js', array(), null, true);
        wp_enqueue_script('react-dom', get_template_directory_uri() . '/inc/cthoptions/vendors/react-dom.production.min.js', array(), null, true);
        // media library
        wp_enqueue_media();
        // wp_enqueue_script('ace-mode-css', get_template_directory_uri() . '/inc/cthoptions/vendors/ace-builds/src-min-noconflict/mode-css.js', array(), _THEROOF_VERSION, true);
        // wp_enqueue_script('ace-theme-monokai', get_template_directory_uri() . '/inc/cthoptions/vendors/ace-builds/src-min-noconflict/theme-monokai.js', array(), _THEROOF_VERSION, true);
        
        wp_enqueue_script('cthoptions-37', get_template_directory_uri() . '/inc/cthoptions/js/53.bundle.js', array('underscore'), null, true);
        wp_enqueue_script('cthoptions-707', get_template_directory_uri() . '/inc/cthoptions/js/875.bundle.js', array(), null, true);
        wp_enqueue_script('cthoptions-tab', get_template_directory_uri() . '/inc/cthoptions/js/tab.bundle.js', array('react', 'react-dom', 'cthoptions-37', 'cthoptions-707'), null, true);

        // wp_localize_script('cthoptions-form', 'th_rest_url', get_rest_url());
        // wp_localize_script('cthoptions-form', 'th_tabs', $tabs);
        wp_localize_script('cthoptions-tab', 'th_options', [
            'rest_url'      => esc_url_raw( rest_url() ), // get_rest_url(),
            'nonce'         => wp_create_nonce( 'wp_rest' ),
            'tabs'          => $this->tabs,
            'options'       => $this->fields,
            'i18n'          => array(
                'submit'        => _x( 'Save Changes', 'Theme Option', 'theroof-add-ons' ),
                'submitting'    => _x( 'Submitting', 'Theme Option', 'theroof-add-ons' ),
                'reset'         => _x( 'Reset Section', 'Theme Option', 'theroof-add-ons' ),
                'rpfadd'        => _x( 'Add', 'Theme Option - Repeater', 'theroof-add-ons' ),
                'rpfdelete'     => _x( 'Delete', 'Theme Option - Repeater', 'theroof-add-ons' ),

                'icf_select_icon'       => _x( 'Select an icon', 'Theme Option - Icon', 'theroof-add-ons' ),
                'icf_select'            => _x( 'Select', 'Theme Option - Icon', 'theroof-add-ons' ),
                'icf_all'               => _x( 'All', 'Theme Option - Icon', 'theroof-add-ons' ),
                'icf_solid'             => _x( 'Solid', 'Theme Option - Icon', 'theroof-add-ons' ),
                'icf_regular'           => _x( 'Regular', 'Theme Option - Icon', 'theroof-add-ons' ),
                'icf_light'             => _x( 'Light', 'Theme Option - Icon', 'theroof-add-ons' ),
                'icf_brands'            => _x( 'Brands', 'Theme Option - Icon', 'theroof-add-ons' ),
                'icf_duotone'           => _x( 'Duotone', 'Theme Option - Icon', 'theroof-add-ons' ),
                'icf_type_search'       => _x( 'Type to search', 'Theme Option - Icon', 'theroof-add-ons' ),

                'ff_family'             => _x( 'Font Family', 'Theme Option - GFont', 'theroof-add-ons' ),
                'ff_variant'            => _x( 'Font Weight & Style', 'Theme Option - GFont', 'theroof-add-ons' ),
                'ff_subset'             => _x( 'Font Subsets', 'Theme Option - GFont', 'theroof-add-ons' ),
                'ff_size'               => _x( 'Font Size', 'Theme Option - GFont', 'theroof-add-ons' ),
                'ff_lineHeight'         => _x( 'Line Height', 'Theme Option - GFont', 'theroof-add-ons' ),
                'ff_color'              => _x( 'Color', 'Theme Option - GFont', 'theroof-add-ons' ),
                'ff_selectors'          => _x( 'CSS Selectors', 'Theme Option - GFont', 'theroof-add-ons' ),

                'tn_width'              => _x( 'Width (px)', 'Theme Option - Thumbnail', 'theroof-add-ons' ),
                'tn_height'             => _x( 'Height (px)', 'Theme Option - Thumbnail', 'theroof-add-ons' ),
                'tn_crop'               => _x( 'Hard crop?', 'Theme Option - Thumbnail', 'theroof-add-ons' ),

                'sc_url'                => _x( 'URL', 'Theme Option - Socials', 'theroof-add-ons' ),

                'icl_label'             => _x( 'Label', 'Theme Option - Icon List', 'theroof-add-ons' ),
                'icl_url'               => _x( 'URL', 'Theme Option - Icon List', 'theroof-add-ons' ),
            ),
        ]);
        wp_localize_script('cthoptions-tab', '_gFonts', $this->google_fonts());
    }
    protected function google_fonts(){
        global $wp_filesystem;
        require_once ( ABSPATH . '/wp-admin/includes/file.php' );
        WP_Filesystem();
        $local_file = get_parent_theme_file_path( '/inc/cthoptions/vendors/google-fonts-by-popularity.json');
        if ( $wp_filesystem->exists( $local_file ) ) {
            $jsonObj = json_decode( $wp_filesystem->get_contents( $local_file ), true );
            if( $jsonObj ){
                return $jsonObj['items'];
            }
        } 
        return [];
    }
    public function get_metas(WP_REST_Request $request){
        $pid = $request->get_param('pid');
        $return = [ 'debug' => false, 'pid' => $pid ];
        if( $pid && get_post( $pid ) ){
            if( !empty($this->fields) ){
                foreach ($this->fields as $fname => $fopts) {
                    $mtval = get_post_meta( $pid, $fname, true );
                    $return[$fname.'_raw'] = $mtval;
                    switch ($fopts['type']) {
                        case 'Switch':
                            if( isset($fopts['returnValue']) && $mtval ==  $fopts['returnValue'] ){
                                $mtval = true;
                            }else{
                                $mtval = false; 
                            }
                            break;
                        case 'WPMedia':
                            if( isset($fopts['single']) && $fopts['single'] && ( ( isset($fopts['idOnly']) && $fopts['idOnly'] ) || ( isset($fopts['urlOnly']) && $fopts['urlOnly'] ) ) ){
                                $return[$fname.'_dep'] = get_post_meta( $pid, $fname.'_dep', true );
                            }
                            break;
                    }
                    $return[$fname] = $mtval;
                }
            }
        }
        return new WP_REST_Response( $return, 200 );
    }
    protected function save_builtin_metas($post_id){
        if( !empty($this->fields) ){
            foreach ($this->fields as $fname => $fopts) {
                if( $fopts['type'] == 'WPMedia' ){
                    if( isset($_POST[$fname.'_dep']) && isset($fopts['single']) && $fopts['single'] && ( ( isset($fopts['idOnly']) && $fopts['idOnly'] ) || ( isset($fopts['urlOnly']) && $fopts['urlOnly'] ) ) ){
                        update_post_meta( $post_id, $fname.'_dep', $_POST[$fname.'_dep'] );
                    }
                }
                if( $fopts['type'] == 'Switch' && !isset($_POST[$fname])  ){
                    update_post_meta( $post_id, $fname, false );
                }
                if( isset($_POST[$fname]) ){
                    update_post_meta( $post_id, $fname, $_POST[$fname] );
                }
            }
        }
    }
}