<?php
/* add_ons_php */

class Esb_Class_Member_CPT extends Esb_Class_CPT {
    protected $name = 'member';
    protected $permalinks = array();
    protected function init(){
        $this->permalinks = get_option( 'cthpermalinks', array() );
        parent::init();
    }
    public function register(){
        $pslug = !empty($this->permalinks['cthmember_slug']) ? $this->permalinks['cthmember_slug'] : 'member';
        $labels = array( 
            'name' => __( 'Members', 'theroof-add-ons' ),
            'singular_name' => __( 'Member', 'theroof-add-ons' ), 
            'add_new' => __( 'Add New Member', 'theroof-add-ons' ),
            'add_new_item' => __( 'Add New Member', 'theroof-add-ons' ),
            'edit_item' => __( 'Edit Member', 'theroof-add-ons' ),
            'new_item' => __( 'New Member', 'theroof-add-ons' ),
            'view_item' => __( 'View Member', 'theroof-add-ons' ),
            'search_items' => __( 'Search Members', 'theroof-add-ons' ),
            'not_found' => __( 'No Members found', 'theroof-add-ons' ),
            'not_found_in_trash' => __( 'No Members found in Trash', 'theroof-add-ons' ),
            'parent_item_colon' => __( 'Parent Member:', 'theroof-add-ons' ),
            'menu_name' => __( 'Members', 'theroof-add-ons' ),
        );

        $args = array( 
            'labels' => $labels,
            'hierarchical' => true,
            'description' => __( 'List Members', 'theroof-add-ons' ),
            'supports' => array( 'title', 'editor', 'thumbnail','excerpt'/*,'comments', 'post-formats'*/),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' =>  'dashicons-groups',
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => false,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => array( 'slug' => $pslug ),
            'capability_type' => 'post',
            'show_in_rest' => true,
        );
        register_post_type( $this->name, $args );
    }

    protected function set_meta_boxes(){
        $this->meta_boxes = array(
            'socials'       => array(
                'title'                 => __( 'Member Details', 'theroof-add-ons' ),
                'context'               => 'normal', // normal - side - advanced
                'priority'              => 'high', // default - high - low
                'callback_args'         => array(),
            ),
        );
    }

    public function member_socials_callback($post, $args){
        wp_nonce_field( 'cth-cpt-fields', '_cth_cpt_nonce' );

        $socials = get_post_meta( $post->ID,'socials', true );
        ?>
        <div class="cthiso-items cthiso-flex cthiso-two-cols cthiso-big-pad">
            <div class="cthiso-item">
                <h4><?php _e( 'Job Position', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="job_pos" value="<?php echo get_post_meta( $post->ID, 'job_pos', true ); ?>">
                </div>
            </div>
            <div class="cthiso-item">
                <h4><?php _e( 'Specialization', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="specialization" value="<?php echo get_post_meta( $post->ID,'specialization', true ); ?>">
                </div>
            </div>
            <div class="cthiso-item">
                <h4><?php _e( 'Date of Birth', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="date_of_birth" value="<?php echo get_post_meta( $post->ID, 'date_of_birth', true ); ?>">
                </div>
            </div>
            <div class="cthiso-item">
                <h4><?php _e( 'Education', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="education" value="<?php echo get_post_meta( $post->ID, 'education', true ); ?>">
                </div>
            </div>
            <div class="cthiso-item">
                <h4><?php _e( 'Hobby', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="hobby" value="<?php echo get_post_meta( $post->ID, 'hobby', true ); ?>">
                </div>
            </div>
            <!-- <div class="cthiso-item"> 
                
            </div> -->
            <div class="cthiso-item">
                <h4><?php _e( 'Email address', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="email" value="<?php echo get_post_meta( $post->ID, 'email', true ); ?>">
                </div>
            </div>
            <div class="cthiso-item">
                <h4><?php _e( 'Phone Number', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="phone" value="<?php echo get_post_meta( $post->ID, 'phone', true ); ?>">
                </div>
            </div>
            <div class="cthiso-item">
                <h4><?php _e( 'Address', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="address" value="<?php echo get_post_meta( $post->ID, 'address', true ); ?>">
                </div>
            </div>
            <div class="cthiso-item">
                <h4><?php _e( 'Website', 'theroof-add-ons' ); ?></h4>
                <div class="custom-form">
                    <input type="text" name="website" value="<?php echo get_post_meta( $post->ID,'website', true ); ?>">
                </div>
            </div>
            
        </div>
        
            
            
            
            
        <h4><?php _e( 'Socials', 'theroof-add-ons' ); ?></h4>
        <div class="custom-form">
            <div class="repeater-fields-wrap repeater-socials"  data-tmpl="tmpl-user-social">
                <div class="repeater-fields">
                <?php 
                if(!empty($socials)){
                    foreach ($socials as $key => $social) {
                        get_template_part('templates-inner/social',false, array('index'=>$key,'name'=>$social['name'],'url'=>$social['url']));
                    }
                }
                ?>
                </div>
                <button class="addfield" type="button"><?php  esc_html_e( 'Add Social','theroof-add-ons' );?></button>
            </div>
        </div>
        <?php
    }

    public function save_post($post_id, $post, $update){
        if(!$this->can_save($post_id)) return;

        if(isset($_POST['job_pos'])){
            $new_val = sanitize_text_field( $_POST['job_pos'] ) ;
            $origin_val = get_post_meta( $post_id,'job_pos', true );
            if($new_val !== $origin_val){
                update_post_meta( $post_id,'job_pos', $new_val );
            }
        }
        if(isset($_POST['email'])){
            $new_val = sanitize_text_field( $_POST['email'] ) ;
            $origin_val = get_post_meta( $post_id,'email', true );
            if($new_val !== $origin_val){
                update_post_meta( $post_id,'email', $new_val );
            }
        }
        if(isset($_POST['phone'])){
            $new_val = sanitize_text_field( $_POST['phone'] ) ;
            update_post_meta( $post_id,'phone', $new_val );
        }
        if(isset($_POST['address'])){
            $new_val = sanitize_text_field( $_POST['address'] ) ;
            update_post_meta( $post_id, 'address', $new_val );
        }
        if(isset($_POST['website'])){
            $new_val = sanitize_text_field( $_POST['website'] ) ;
            update_post_meta( $post_id, 'website', $new_val );
        }
        if(isset($_POST['specialization'])){
            $new_val = sanitize_text_field( $_POST['specialization'] ) ;
            update_post_meta( $post_id, 'specialization', $new_val );
        }
        if(isset($_POST['date_of_birth'])){
            $new_val = sanitize_text_field( $_POST['date_of_birth'] ) ;
            update_post_meta( $post_id, 'date_of_birth', $new_val );
        }
        if(isset($_POST['education'])){
            $new_val = sanitize_text_field( $_POST['education'] ) ;
            update_post_meta( $post_id, 'education', $new_val );
        }
        if(isset($_POST['hobby'])){
            $new_val = sanitize_text_field( $_POST['hobby'] ) ;
            update_post_meta( $post_id,'hobby', $new_val );
        }
        if(isset($_POST['socials'])){
            update_post_meta( $post_id, 'socials', $_POST['socials'] );
        }else{
            update_post_meta( $post_id, 'socials', array() );
        }
    }

    protected function set_meta_columns(){
        $this->has_columns = true;
    }
    public function meta_columns_head($columns){
        $columns['_thumbnail'] = __( 'Thumbnail', 'theroof-add-ons' );
        $columns['_job'] = __( 'Job', 'theroof-add-ons' );
        $columns['_id'] = __( 'ID', 'theroof-add-ons' );
        return $columns;
    }
    public function meta_columns_content($column_name, $post_ID){
        if ($column_name == '_id') {
            echo $post_ID;
        }
        if ($column_name == '_job') {
            echo get_post_meta( $post_ID, 'job_pos', true );
        }
        if ($column_name == '_thumbnail') {
            echo get_the_post_thumbnail( $post_ID, 'thumbnail', array('style'=>'width:100px;height:auto;') );
        }
    }

}

new Esb_Class_Member_CPT();