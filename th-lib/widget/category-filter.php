<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 24/12/15
 * Time: 10:20 AM
 */
if(!class_exists('Th_Category_Fillter') && class_exists("woocommerce"))
{
    class Th_Category_Fillter extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            if(function_exists('th_reg_widget')) th_reg_widget( 'Th_Category_Fillter' );
        }

        function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('Categories Filter','construction'),
                array( 'description' => esc_html__( 'Filter product shop page', 'construction' ), ));

            $this->default=array(
                'title' => '',
                'category' => array(),
            );
        }



        function widget( $args, $instance ) {
            // Widget output
            global $post;
            $check_shop = false;
            if(isset($post->post_content)){
                if(strpos($post->post_content, '[th_shop')){
                    $check_shop = true;
                }
            }
            if ( ! is_shop() && ! is_product_taxonomy() ) {
                if(!$check_shop) return;
            }
            if(!is_single()){
                echo apply_filters('th_output_content',$args['before_widget']);
                if ( ! empty( $instance['title'] ) ) {
                   echo apply_filters('th_output_content',$args['before_title']) . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
                }

                $instance=wp_parse_args($instance,$this->default);
                extract($instance);
                if(is_object($category)) $category = json_decode(json_encode($category), true);
                if(is_array($category) && !empty($category)){
                    echo        '<ul>';                
                        $cat_current = '';
                        if(isset($_GET['product_cat'])) $cat_current = sanitize_text_field($_GET['product_cat']);
                        if($cat_current != '') $cat_current = explode(',', $cat_current);
                        else $cat_current = array();
                        foreach ($category as $cat_slug) {
                            $cat = get_term_by('slug',$cat_slug,'product_cat');
                            if(is_object($cat)){
                                if(in_array($cat->slug, $cat_current)) $active = 'active';
                                else $active = '';
                                echo        '<li><a data-cat='.esc_attr($cat->slug).' href="'.esc_url(th_get_filter_url('product_cat',$cat->slug)).'" class="load-shop-ajax '.$active.'"> '.$cat->name.'</a><span class="smoke">('.$cat->count.')</span></li>';
                            }
                        }
                    echo      '</ul>';
                }      
                echo apply_filters('th_output_content',$args['after_widget']);
            }
        }

        function update( $new_instance, $old_instance ) {

            // Save widget options
            $instance=array();
            $instance=wp_parse_args($instance,$this->default);
            $new_instance=wp_parse_args($new_instance,$instance);

            return $new_instance;
        }

        function form( $instance ) {
            // Output admin widget options form

            $instance=wp_parse_args($instance,$this->default);
            extract($instance);
            if(is_object($category)) $category = json_decode(json_encode($category), true);
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:' ,'construction'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label><?php esc_html_e( 'Categories:' ,'construction'); ?></label></br>
                <?php 
                $cats = get_terms('product_cat');
                if(is_array($cats) && !empty($cats)){
                    foreach ($cats as $cat) {
                        if(in_array($cat->slug, $category)) $checked = 'checked="checked"';
                        else $checked = '';
                        echo '<input '.$checked.' id="'.esc_attr($this->get_field_id( 'category' )).'" type="checkbox" name="'.esc_attr($this->get_field_name( 'category' )).'[]" value="'.esc_attr($cat->slug).'"><span>'.$cat->name.'</span>';
                    }
                }
                else echo esc_html__("No any category.","construction");
                ?>
            </p>            
        <?php
        }
    }

    Th_Category_Fillter::_init();

}
