<?php   
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 17/09/15
 * Time: 10:20 AM
 */

if(!class_exists('Th_CustomizeConfig'))
{
    class Th_CustomizeConfig
    {
        public function __construct(){
            add_action( 'customize_controls_enqueue_scripts', array($this,'th_loading_script') );
            if(class_exists('OT_Loader')){
                add_action( 'customize_register', array($this,'th_customizer_register'));
            }
        }

        public function th_sanitize_callback($value)
        {
            return $value;
        }

        public function th_loading_script()
        {
            wp_enqueue_script( 'th-customizer-js', get_template_directory_uri().'/assets/admin/js/customizer.js', array(), null, true);
        }

        public function th_customizer_register($wp_customize){
            global $th_config;
            $option_name = ot_options_id();
            $options = get_option( ot_options_id() );
            $sections = $th_config['theme-option']['sections'];
            $settings = $th_config['theme-option']['settings'];
            $wp_customize->add_panel( 'theme_option', array(
                'priority'       => 10,
                'capability'     => 'edit_theme_options',
                'title'          => 'Theme Settings',
            ) );
            foreach ($sections as $key => $section) {
                $g_title = explode('</i>', $section['title']);
                $title = $g_title[1];
                $wp_customize->add_section( $section['id'], array(
                    'priority'       => $key,
                    'capability'     => 'edit_theme_options',
                    'title'          => $title,
                    'panel'          => 'theme_option',
                ));
                
                foreach ($settings as $key2 => $setting) {
                    if($setting['section'] == $section['id'] && isset($options[$setting['id']])){
                        $wp_customize->add_setting( $option_name.'['.$setting['id'].']', array(
                            'default'           => $options[$setting['id']],
                            'capability'        => 'edit_theme_options',
                            'type'           => 'option',
                            'sanitize_callback' => array($this, 'th_sanitize_callback')
                            )
                        );
                        switch ($setting['type']) {
                            case 'upload':
                                $wp_customize->add_control( 
                                    new WP_Customize_Image_Control( 
                                    $wp_customize, 
                                    $option_name.'['.$setting['id'].']',
                                    array(
                                        'label'      => $setting['label'],
                                        'section'    => $setting['section'],
                                        'settings'   => $option_name.'['.$setting['id'].']',
                                        'priority'   => $key.$key2
                                    ) ) 
                                );
                                break;

                            case 'textarea-simple':
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'textarea'
                                        )
                                    )
                                );
                                break;

                            case 'page-select':
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'dropdown-pages'
                                        )
                                    )
                                );
                                break;

                            case 'background':
                                $wp_customize->add_control(
                                    new Th_Customize_Bg(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings1'   => $option_name.'['.$setting['id'].']',                                            
                                        )
                                    )
                                );
                                break;

                            case 'typography':
                                $wp_customize->add_control(
                                    new Th_Customize_Typography(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings1'  => $option_name.'['.$setting['id'].']',
                                            'key_id'     => $setting['id'],
                                        )
                                    )
                                );
                                break;

                            case 'colorpicker':
                                $wp_customize->add_control(
                                    new WP_Customize_Color_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']'
                                        )
                                    )
                                );
                                break;

                            case 'select':
                                $choices = $setting['choices'];
                                $customize_choices = array();
                                foreach ($choices as $choice) {
                                    if(isset($choice['value']) && isset($choice['label'])) $customize_choices[$choice['value']] = $choice['label'];
                                }
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'select',
                                            'class'       => 'select-sidebar',
                                            'choices'   => $customize_choices
                                        )
                                    )
                                );
                                unset($customize_choices);
                                break;

                            case 'sidebar-select':
                                global $wp_registered_sidebars;
                                $customize_choices = array('' => '-- Choose Sidebar --');
                                foreach ($wp_registered_sidebars as $choice) {
                                    $customize_choices[$choice['id']] = $choice['name'];
                                }
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'select',
                                            'choices'   => $customize_choices
                                        )
                                    )
                                );
                                unset($customize_choices);
                                break;

                            case 'on-off':
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'radio',
                                            'choices'    => array(
                                                'on'     => 'On',
                                                'off'    => 'Off'
                                                )
                                        )
                                    )
                                );
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    
                }
            }
        }       

    }
    new Th_CustomizeConfig;
}
if(class_exists('WP_Customize_Control')){
    class Th_Customize_Bg extends WP_Customize_Control{
        public $label;
        public $settings1;
        public function render_content() {
            if(!is_array($this->value())) $values = json_decode(urldecode($this->value()),true);
            else $values = $this->value();
            $setting_id = str_replace('[', '-', $this->settings1);
            $setting_id = str_replace(']', '', $setting_id);
            ?>
            <div class="format-setting type-background <?php echo esc_attr($setting_id);?>" data-setting="<?php echo esc_attr($this->settings1);?>">
                <?php if(!empty($this->label)) echo '<span class="customize-control-title">'.$this->label.'</span>';?>
                <div class="format-setting-inner">
                    <div class="ot-background-group">
                        <div class="option-customize-ui-colorpicker-input-wrap">
                            <input type="text" name="<?php echo esc_attr($this->settings1);?>[background-color]" id="<?php echo esc_attr($this->settings1);?>-picker" value="<?php echo esc_attr($values['background-color']);?>" class="hide-color-picker sv-background-color sv-color-picker">
                        </div>
                        <select name="<?php echo esc_attr($this->settings1);?>[background-repeat]" id="<?php echo esc_attr($this->settings1);?>-repeat" class="option-customize-ui-select sv-background-repeat">
                            <option value="" <?php if($values['background-repeat'] == '') echo'selected="selected"';?>><?php esc_html_e('background-repeat','construction');?></option>
                            <option value="no-repeat" <?php if($values['background-repeat'] == 'no-repeat') echo'selected="selected"';?>><?php esc_html_e('No Repeat','construction');?></option>
                            <option value="repeat" <?php if($values['background-repeat'] == 'repeat') echo'selected="selected"';?>><?php esc_html_e('Repeat All','construction');?></option>
                            <option value="repeat-x" <?php if($values['background-repeat'] == 'repeat-x') echo'selected="selected"';?>><?php esc_html_e('Repeat Horizontally','construction');?></option>
                            <option value="repeat-y" <?php if($values['background-repeat'] == 'repeat-y') echo'selected="selected"';?>><?php esc_html_e('Repeat Vertically','construction');?></option>
                            <option value="inherit" <?php if($values['background-repeat'] == 'inherit') echo'selected="selected"';?>><?php esc_html_e('Inherit','construction');?></option>
                        </select>
                        <select name="<?php echo esc_attr($this->settings1);?>[background-attachment]" id="<?php echo esc_attr($this->settings1);?>-attachment" class="option-customize-ui-select sv-background-attachment">
                            <option value="" <?php if($values['background-attachment'] == '') echo'selected="selected"';?>><?php esc_html_e('background-attachment','construction');?></option>
                            <option value="fixed" <?php if($values['background-attachment'] == 'fixed') echo'selected="selected"';?>><?php esc_html_e('Fixed','construction');?></option>
                            <option value="scroll" <?php if($values['background-attachment'] == 'scroll') echo'selected="selected"';?>><?php esc_html_e('Scroll','construction');?></option>
                            <option value="inherit" <?php if($values['background-attachment'] == 'inherit') echo'selected="selected"';?>><?php esc_html_e('Inherit','construction');?></option>
                        </select>
                        <select name="<?php echo esc_attr($this->settings1);?>[background-position]" id="<?php echo esc_attr($this->settings1);?>-position" class="option-customize-ui-select sv-background-position">
                            <option value="" <?php if($values['background-position'] == '') echo'selected="selected"';?>><?php esc_html_e('background-position','construction');?></option>
                            <option value="left top" <?php if($values['background-position'] == 'left top') echo'selected="selected"';?>><?php esc_html_e('Left Top','construction');?></option>
                            <option value="left center" <?php if($values['background-position'] == 'left center') echo'selected="selected"';?>><?php esc_html_e('Left Center','construction');?></option>
                            <option value="left bottom" <?php if($values['background-position'] == 'left bottom') echo'selected="selected"';?>><?php esc_html_e('Left Bottom','construction');?></option>
                            <option value="center top" <?php if($values['background-position'] == 'center top') echo'selected="selected"';?>><?php esc_html_e('Center Top','construction');?></option>
                            <option value="center center" <?php if($values['background-position'] == 'center center') echo'selected="selected"';?>><?php esc_html_e('Center Center','construction');?></option>
                            <option value="center bottom" <?php if($values['background-position'] == 'center bottom') echo'selected="selected"';?>><?php esc_html_e('Center Bottom','construction');?></option>
                            <option value="right top" <?php if($values['background-position'] == 'right top') echo'selected="selected"';?>><?php esc_html_e('Right Top','construction');?></option>
                            <option value="right center" <?php if($values['background-position'] == 'right center') echo'selected="selected"';?>><?php esc_html_e('Right Center','construction');?></option>
                            <option value="right bottom" <?php if($values['background-position'] == 'right bottom') echo'selected="selected"';?>><?php esc_html_e('Right Bottom','construction');?></option>
                        </select>
                        <input type="text" name="<?php echo esc_attr($this->settings1);?>[background-size]" id="<?php echo esc_attr($this->settings1);?>-size" value="<?php echo esc_attr($values['background-size']);?>" class="widefat ot-background-size-input option-customize-ui-input sv-background-size" placeholder="<?php esc_attr_e("background-size","construction")?>">
                    </div>
                    <div class="option-customize-ui-upload-parent">
                        <img <?php if(empty($values['background-image'])) echo th_add_html_attr('display:none;margin-top:10px');?> src="<?php echo esc_url($values['background-image']);?>"/>
                        <input type="hidden" name="<?php echo esc_attr($this->settings1);?>[background-image]" id="<?php echo esc_attr($this->settings1);?>-image" value="<?php echo esc_attr($values['background-image']);?>" class="widefat option-customize-ui-upload-input sv-background-image" placeholder="<?php esc_attr_e("background-image","construction")?>">
                        <a href="#" class="ot_upload_media option-customize-ui-button button button-primary light upload_single_image" rel="4" title="<?php esc_attr_e('Add Media','construction');?>">
                            <span class="icon ot-icon-plus-circle"></span><?php esc_html_e('Add Media','construction');?>
                        </a>
                        <a <?php if(empty($values['background-image'])) echo th_add_html_attr('display:none');?> href="#" class="ot_upload_media option-customize-ui-button button button-primary light remove_single_image" rel="4" title="<?php esc_attr_e('Add Media','construction');?>">
                            <span class="icon ot-icon-plus-circle"></span><?php esc_html_e('Remove','construction');?>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
    }  

    class Th_Customize_Typography extends WP_Customize_Control{
        public $label;
        public $settings1;
        public $key_id;
        public function render_content() {
            if(!is_array($this->value())) $values = json_decode(urldecode($this->value()),true);
            else $values = $this->value();
            $setting_id = str_replace('[', '-', $this->settings1);
            $setting_id = str_replace(']', '', $setting_id);
            ?>
            <div class="format-setting type-typography <?php echo esc_attr($setting_id);?>" data-setting="<?php echo esc_attr($this->settings1);?>">
                <?php if(!empty($this->label)) echo '<span class="customize-control-title">'.$this->label.'</span>';?>
                <div class="format-setting-inner">
                    <div class="wp-picker-container">
                        <span <?php echo th_add_html_attr('vertical-align: top')?>><?php esc_html_e('Choose Color','construction')?></span>
                        <input type="text" name="<?php echo esc_attr($this->settings1);?>[font-color]" value="<?php echo esc_attr($values['font-color'])?>" class="hide-color-picker sv-color-picker sv-typography-font-color">
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Family','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-family]" class="option-customize-ui-select sv-typography-font-family">
                            <option <?php if($values['font-family'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-family','construction')?></option>
                            <?php 
                            if(function_exists('ot_recognized_font_families')) $family_list = ot_recognized_font_families($this->key_id);
                            else $family_list = array();
                            if(!empty($family_list)){
                                foreach ($family_list as $key => $value) {
                                    if($values['font-family'] == $key) $selected = 'selected="selected"';
                                    else $selected = '';
                                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                } 
                            }
                            ?>                            
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Size','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-size]" class="option-customize-ui-select sv-typography-font-size">
                            <option <?php if($values['font-size'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-size','construction')?></option>
                            <?php for ($i=0; $i <= 150; $i++) { 
                                if($values['font-size'] == $i.'px') $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.esc_attr($i).'px" '.$selected.'>'.$i.'px</option>';
                            }?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Style','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-style]" class="option-customize-ui-select sv-typography-font-style">
                            <option <?php if($values['font-style'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-style','construction')?></option>
                            <option <?php if($values['font-style'] == 'normal') echo'selected="selected"';?> value="normal"><?php esc_html_e('Normal','construction')?></option>
                            <option <?php if($values['font-style'] == 'italic') echo'selected="selected"';?> value="italic"><?php esc_html_e('Italic','construction')?></option>
                            <option <?php if($values['font-style'] == 'oblique') echo'selected="selected"';?> value="oblique"><?php esc_html_e('Oblique','construction')?></option>
                            <option <?php if($values['font-style'] == 'inherit') echo'selected="selected"';?> value="inherit"><?php esc_html_e('Inherit','construction')?></option>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Variant','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-variant]" class="option-customize-ui-select sv-typography-font-variant">
                            <option <?php if($values['font-variant'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-variant','construction')?></option>
                            <option <?php if($values['font-variant'] == 'normal') echo'selected="selected"';?> value="normal"><?php esc_html_e('Normal','construction')?></option>
                            <option <?php if($values['font-variant'] == 'small-caps') echo'selected="selected"';?> value="small-caps"><?php esc_html_e('Small Caps','construction')?></option>
                            <option <?php if($values['font-variant'] == 'inherit') echo'selected="selected"';?> value="inherit"><?php esc_html_e('Inherit','construction')?></option>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Weight','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-weight]" class="option-customize-ui-select sv-typography-font-weight">
                            <option <?php if($values['font-weight'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-weight','construction')?></option>
                            <option <?php if($values['font-weight'] == 'normal') echo'selected="selected"';?> value="normal"><?php esc_html_e('Normal','construction')?></option>
                            <option <?php if($values['font-weight'] == 'bold') echo'selected="selected"';?> value="bold"><?php esc_html_e('Bold','construction')?></option>
                            <option <?php if($values['font-weight'] == 'bolder') echo'selected="selected"';?> value="bolder"><?php esc_html_e('Bolder','construction')?></option>
                            <option <?php if($values['font-weight'] == 'lighter') echo'selected="selected"';?> value="lighter"><?php esc_html_e('Lighter','construction')?></option>
                            <option <?php if($values['font-weight'] == '100') echo'selected="selected"';?> value="100"><?php esc_html_e('100','construction')?></option>
                            <option <?php if($values['font-weight'] == '200') echo'selected="selected"';?> value="200"><?php esc_html_e('200','construction')?></option>
                            <option <?php if($values['font-weight'] == '300') echo'selected="selected"';?> value="300"><?php esc_html_e('300','construction')?></option>
                            <option <?php if($values['font-weight'] == '400') echo'selected="selected"';?> value="400"><?php esc_html_e('400','construction')?></option>
                            <option <?php if($values['font-weight'] == '500') echo'selected="selected"';?> value="500"><?php esc_html_e('500','construction')?></option>
                            <option <?php if($values['font-weight'] == '600') echo'selected="selected"';?> value="600"><?php esc_html_e('600','construction')?></option>
                            <option <?php if($values['font-weight'] == '700') echo'selected="selected"';?> value="700"><?php esc_html_e('700','construction')?></option>
                            <option <?php if($values['font-weight'] == '800') echo'selected="selected"';?> value="800"><?php esc_html_e('800','construction')?></option>
                            <option <?php if($values['font-weight'] == '900') echo'selected="selected"';?> value="900"><?php esc_html_e('900','construction')?></option>
                            <option <?php if($values['font-weight'] == 'inherit') echo'selected="selected"';?> value="inherit"><?php esc_html_e('Inherit','construction')?></option>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Letter Spacing','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[letter-spacing]" class="option-customize-ui-select sv-typography-letter-spacing">
                            <?php $spacing_array = array(
                                ''         => 'letter-spacing',
                                '-0.1em'   => '-0.1em',
                                '-0.09em'  => '-0.09em',
                                '-0.08em'  => '-0.08em',
                                '-0.07em'  => '-0.07em',
                                '-0.06em'  => '-0.06em',
                                '-0.05em'  => '-0.05em',
                                '-0.04em'  => '-0.04em',
                                '-0.03em'  => '-0.03em',
                                '-0.02em'  => '-0.02em',
                                '-0.01em'  => '-0.01em',
                                '0em'      => '0em',
                                '0.01em'   => '0.01em',
                                '0.02em'   => '0.02em',
                                '0.03em'   => '0.03em',
                                '0.04em'   => '0.04em',
                                '0.05em'   => '0.05em',
                                '0.06em'   => '0.06em',
                                '0.07em'   => '0.07em',
                                '0.08em'   => '0.08em',
                                '0.09em'   => '0.09em',
                                '0.1em'    => '0.1em'
                            );
                            foreach ($spacing_array as $key => $value) {
                                if($values['letter-spacing'] == $key) $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.esc_attr($key).'" '.$selected.'>'.$value.'</option>';
                            }
                            ?>                            
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Line Height','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[line-height]" class="option-customize-ui-select sv-typography-line-height">
                            <option <?php if($values['line-height'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('line-height','construction')?></option>
                            <?php for ($i=0; $i <= 150; $i++) { 
                                if($values['line-height'] == $i.'px') $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.esc_attr($i).'px" '.$selected.'>'.$i.'px</option>';
                            }?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Text Decoration','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[text-decoration]" class="option-customize-ui-select sv-typography-text-decoration">
                            <?php $decoration_array = array(
                                ''              => 'text-decoration',
                                'blink'         => 'Blink',
                                'inherit'       => 'Inherit',
                                'line-through'  => 'Line Through',
                                'none'          => 'None',
                                'overline'      => 'Overline',
                                'underline'     => 'Underline'
                            );
                            foreach ($decoration_array as $key => $value) {
                                if($values['text-decoration'] == $key) $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.esc_attr($key).'" '.$selected.'>'.$value.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Text Transform','construction')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[text-transform]" class="option-customize-ui-select sv-typography-text-transform">
                            <?php $transform_array = array(
                                ''              => 'text-transform',
                                'capitalize'    => 'Capitalize',
                                'inherit'       => 'Inherit',
                                'lowercase'     => 'Lowercase',
                                'none'          => 'None',
                                'uppercase'     => 'Uppercase',
                            );
                            foreach ($transform_array as $key => $value) {
                                if($values['text-transform'] == $key) $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.esc_attr($key).'" '.$selected.'>'.$value.'</option>';
                            }
                            ?>
                            
                        </select>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
