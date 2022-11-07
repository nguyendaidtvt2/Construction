<?php    
$id = get_the_ID();
if(is_front_page() && is_home()) $id = (int)get_option( 'page_on_front' );
if(!is_front_page() && is_home()) $id = (int)get_option( 'page_for_posts' );
if($id) $title  = get_the_title($id);
else $title = esc_html__("Blog","construction");
if(is_archive()) $title = get_the_archive_title();
if(is_search()) $title = esc_html__("Search Result","construction");
if(function_exists('woocommerce_page_title') && th_is_woocommerce_page()) $title = woocommerce_page_title(false);
global $post;
if($show_number == 'on' || $show_number == '1') $show_number = 'yes';
if($show_type == 'on' || $show_type == '1') $show_type = 'yes';
if(isset($show_order) && $show_order == 'yes') $show_order = true;
else $show_order = false;
if(!isset($show_title)) $show_title = true; 
?>
<?php if($show_title || $show_number == 'yes' || $show_type == 'yes' || $show_order):?>
    <div class="title-page clearfix top-filter">
        <?php if($show_title):?>
            <h2><?php echo apply_filters('th_output_content',$title)?></h2>
        <?php endif;?>
        <?php if($show_number == 'yes' || $show_type == 'yes' || $show_order):?>
            <ul class="sort-pagi-bar list-inline-block">
                <?php
                    global $wp_query;
                    if(function_exists('is_shop')) if(is_shop()) $show_order = true;
                    if($show_order == true) $add_class = 'load-shop-ajax';
                    else $add_class = '';
                    $orderby = apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
                    if(isset($_GET['orderby'])) $orderby = sanitize_text_field($_GET['orderby']);
                    if($show_order):?>
                        <li>
                            <div class="sort-by">
                                <div class="select-box inline-block">
                                    <?php th_catalog_ordering($wp_query,$orderby,true,$add_class);?>
                                </div>
                            </div>
                        </li>
                    <?php endif;
                ?>
                <?php if($show_number == 'yes'):
                    $source = 'blog';
                    if(th_is_woocommerce_page() || strpos($post->post_content, '[th_shop')) $source = 'shop';
                    $list   = th_get_option($source.'_number_filter_list');
                    $check_list = '';
                    if(isset($list[0]['number'])) $check_list = trim($list[0]['number']);
                    if(empty($list) || !$check_list){
                        $list = array(12,16,20,24);
                    }
                    else{
                        $temp = array();
                        foreach ($list as $value) {
                            $temp[] = (int)$value['number'];
                        }
                        $list = $temp;
                    }
                    $number_df = get_option( 'posts_per_page' );
                    if(!in_array((int)$number_df, $list)) $list = array_merge(array((int)$number_df),$list);
                    if(!in_array((int)$number, $list) && $number) $list = array_merge(array((int)$number),$list);
                    if(is_home() && isset($wp_query->query_vars['posts_per_page'])) $number = $wp_query->query_vars['posts_per_page'];
                    if(isset($_GET['number'])) $number = sanitize_text_field($_GET['number']);
                ?>
                <li>
                    <div class="elth-dropdown-box show-by">
                        <a href="#" class="dropdown-link"><span class="gray"><?php esc_html_e("Items:","construction")?> </span><span class="number"><?php echo esc_html((int)$number)?></span></a>
                        <ul class="elth-dropdown-list list-none">
                            <?php
                            if(is_array($list)){
                                foreach ($list as $value) {
                                    if($value == $number) $active = ' active';
                                    else $active = '';
                                    echo '<li><a data-number="'.esc_attr($value).'" class="'.esc_attr($add_class.$active).'" href="'.esc_url(th_get_key_url('number',$value)).'">'.$value.'</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </li>
                <?php endif;?>
                <?php if($show_type == 'yes'):?>
                <li>
                    <div class="view-type">
                        <a data-type="grid" href="<?php echo esc_url(th_get_key_url('type','grid'))?>" class="grid-view <?php echo esc_attr($add_class)?> <?php if($style == 'grid') echo 'active'?>"><i class="la la-th"></i></a>
                        <a data-type="list" href="<?php echo esc_url(th_get_key_url('type','list'))?>" class="list-view <?php echo esc_attr($add_class)?> <?php if($style == 'list') echo 'active'?>"><i class="la la-list"></i></a>
                    </div>
                </li>
                <?php endif;?>
            </ul>
        <?php endif;?>
    </div>
<?php endif;?>