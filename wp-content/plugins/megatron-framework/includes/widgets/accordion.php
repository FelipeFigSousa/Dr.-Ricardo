<?php

/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 9/26/15
 * Time: 3:04 PM
 */
class G5Plus_Widget_Accordion extends g5plus_acf_widget
{
    public function __construct()
    {
        $this->widget_cssclass = 'widget-accordion';
        $this->widget_description = esc_html__("Display Accordion", 'g5plus-megatron');
        $this->widget_id = 'megatron-accordion';
        $this->widget_name = esc_html__('G5Plus: Accordion', 'g5plus-megatron');
        $this->settings = array(
            'id' => 'accordion_acf',
            'type' => 'rows',
            'title' => esc_html__('Accordion', 'g5plus-megatron'),
            'subtitle' => esc_html__('Unlimited accordion with drag and drop sortings.', 'g5plus-megatron'),
            'fields' => array(
                array(
                    'name' => 'accordion_title',
                    'title' => esc_html__('Title', 'g5plus-megatron'),
                    'type' => 'text',
                    'is_title_block' => 1
                ),
                array(
                    'name' => 'image_url',
                    'title' => esc_html__('Image', 'g5plus-megatron'),
                    'type' => 'image'
                ),
                array(
                    'name' => 'description',
                    'title' => 'Description',
                    'type' => 'text-area'
                ),
                array(
                    'name' => 'expand',
                    'title' => esc_html__('Expand', 'g5plus-megatron'),
                    'type' => 'select',
                    'std' => '',
                    'allow_clear' => '1',
                    'options' => array(
                        'false' => esc_html__('False', 'g5plus-megatron'),
                        'true' => esc_html__('True', 'g5plus-megatron')
                    )
                ),
            ),
            'extra' => array(
                array(
                    'name' => 'title',
                    'title' => esc_html__('Title Widget', 'g5plus-megatron'),
                    'type' => 'text',

                ),
                array(
                    'name' => 'multiple_select',
                    'title' => esc_html__('Multiple Select Tab', 'g5plus-megatron'),
                    'type' => 'select',
                    'std' => '',
                    'allow_clear' => '1',
                    'options' => array(
                        'false' => esc_html__('No', 'g5plus-megatron'),
                        'true' => esc_html__('Yes', 'g5plus-megatron')
                    )
                ),
                array(
                    'name' => 'image_size_option',
                    'title' => esc_html__('Image size', 'g5plus-megatron'),
                    'type' => 'select',
                    'std' => '',
                    'allow_clear' => '1',
                    'options' => array(
                        '' => esc_html__('Default', 'g5plus-megatron'),
                        'custom' => esc_html__('Custom', 'g5plus-megatron')
                    )
                ),
                array(
                    'name' => 'image_size_width',
                    'title' => esc_html__('Image size width', 'g5plus-megatron'),
                    'type' => 'text',
                    'require' => array(
                        'element' => 'image_size_option',
                        'compare' => '=',
                        'value' => array('custom')
                    )
                ),
                array(
                    'name' => 'image_size_height',
                    'title' => esc_html__('Image size height', 'g5plus-megatron'),
                    'type' => 'text',
                    'require' => array(
                        'element' => 'image_size_option',
                        'compare' => '=',
                        'value' => array('custom')
                    )
                ),
            )
        );

        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_accordion', array($this, 'vc_widget'));
        }
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);
        $widget_id = $args['widget_id'];
        $accordion_id = 'widget_accordion_'.$widget_id;
        $accordions = array_key_exists('fields', $instance) ? $instance['fields'] : array();
        $extra = array_key_exists('extra', $instance) ? $instance['extra'] : array();
        $title = array_key_exists('title', $extra) ? $extra['title'] : '';
        $multiple_select = array_key_exists('multiple_select', $extra) ? $extra['multiple_select'] : 'false';
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        $description_align = array_key_exists('description_align', $extra) ? $extra['description_align'] : '';
        $image_size_option = array_key_exists('image_size_option', $extra) ? $extra['image_size_option'] : '';
        $image_size_width = array_key_exists('image_size_width', $extra) ? $extra['image_size_width'] : '';
        $image_size_height = array_key_exists('image_size_height', $extra) ? $extra['image_size_height'] : '';
        echo wp_kses_post($before_widget);

        ?>
        <div class="slideshow-images">
            <?php if ($title != '') { ?>
                <h4 class="widget-title">
                    <?php echo esc_html($title) ?>
                </h4>
            <?php } ?>
            <?php if (isset($accordions) && is_array($accordions)) { ?>
                <div class="accordion-wrap panel-group" id="<?php echo esc_attr($accordion_id) ?>" role="tablist" aria-multiselectable="<?php echo esc_attr($multiple_select) ?>">
                    <?php
                    $index = 0;
                    foreach ($accordions as $accordion) {
                        $index++;
                        $collapse_id = 'widget_accordion_' . $widget_id . '_collapse_' . $index;
                        $heading = 'widget_accordion_' . $widget_id . '_heading_' . $index;
                        $url = $accordion['image_url']['url'];
                        $desc = array_key_exists('description', $accordion) ? $accordion['description'] : '';
                        $desc = apply_filters('widget_text', $desc, $instance, $this->id_base);
                        $accordion_title = array_key_exists('accordion_title', $accordion) ? $accordion['accordion_title'] : '';
                        $accordion_title = apply_filters('widget_title', $accordion_title, $instance, $this->id_base);
                        $expand = array_key_exists('expand', $accordion) ? $accordion['expand'] : 'false';
                        if ($image_size_option == 'custom' && $image_size_width != '' && $image_size_height != '') {
                            $resize = matthewruddy_image_resize($url, $image_size_width, $image_size_height);
                            if ($resize != null && is_array($resize))
                                $url = $resize['url'];
                        }
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab"
                                 id="<?php echo esc_attr($heading) ?>">
                                <h4 class="panel-title">
                                    <a class="<?php if($expand=='true') { echo 'collapsed';} ?>" role="button" data-toggle="collapse" data-parent="#<?php echo esc_attr($accordion_id) ?>"
                                       href="#<?php echo esc_attr($collapse_id) ?>"
                                       aria-expanded="<?php echo esc_attr($expand) ?>"
                                       aria-controls="<?php echo esc_attr($collapse_id) ?>">
                                        <span><?php echo esc_html($accordion_title) ?></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="<?php echo esc_attr($collapse_id) ?>"
                                 class="panel-collapse collapse <?php if($expand=='true'){ echo 'in';} ?> panel-content" role="tabpanel"
                                 aria-labelledby="<?php echo esc_attr($heading) ?>">
                                <div class="panel-body">
                                    <img src="<?php echo esc_url($url) ?>" alt="<?php echo esc_attr($url) ?>"/>
                                    <?php if ($desc != '') { ?>
                                        <div class="description">
                                            <p class="<?php echo esc_attr($description_align) ?>"><?php echo esc_html($desc); ?></p>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>

                        </div>
                    <?php
                    }
                    ?>

                </div>
            <?php } ?>
        </div>
        <?php
        echo wp_kses_post($after_widget);
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_accordion', $atts );
        $instance =$args = array();
        $args['widget_id'] = 'megatron-accordion';
        $instance['fields'] = array();

        if(array_key_exists('fields',$attributes)){
            $fields = (array) vc_param_group_parse_atts( $attributes['fields'] );
            $index = 0;
            foreach($fields as $field){
                $instance['fields'][$index] = array();
                if( array_key_exists('image_url',$field) && $field['image_url']!=''){
                    $instance['fields'][$index]['image_url'] = array();
                    $instance['fields'][$index]['image_url']['url'] = wp_get_attachment_url($field['image_url']);
                }
                $instance['fields'][$index]['accordion_title'] = $field['accordion_title'];
                $instance['fields'][$index]['description'] = $field['description'];
                $instance['fields'][$index]['expand'] = $field['expand'];
                $index++;
            }
        }
        $instance['extra'] = array();
        $instance['extra']['title'] = $attributes['title'];
        $instance['extra']['multiple_select'] = $attributes['multiple_select'];
        $instance['extra']['image_size_option'] = $attributes['image_size_option'];
        $instance['extra']['image_size_width'] = $attributes['image_size_width'];
        $instance['extra']['image_size_height'] = $attributes['image_size_height'];
        the_widget('G5Plus_Widget_Accordion',$instance,$args);
    }
}

if (!function_exists('g5plus_register_widget_accordion')) {
    function g5plus_register_widget_accordion()
    {
        register_widget('G5Plus_Widget_Accordion');

        if(function_exists('vc_map')){
            vc_map( array(
                'name' => 'G5Plus Accordion',
                'base' => 'g5plusframework_widget_accordion',
                'icon' => 'fa fa-bars',
                'category' => esc_html__( 'Megatron Widgets', 'g5plus-megatron' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'A custom accordion for your site', 'g5plus-megatron' ),
                'params' => array(
                    array(
                        'type' => 'param_group',
                        'heading' => esc_html__( 'Accordion group', 'g5plus-megatron' ),
                        'param_name' => 'fields',
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Accordion title', 'g5plus-megatron'),
                                'param_name' => 'accordion_title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_html__('Image', 'g5plus-megatron'),
                                'param_name' => 'image_url',
                                'value' => '',
                            ),
                            array(
                                'type' => 'textarea',
                                'heading' => esc_html__( 'Description', 'g5plus-megatron' ),
                                'param_name' => 'description'
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__( 'Expand', 'g5plus-megatron' ),
                                'param_name' => 'expand',
                                'value' => array(
                                    esc_html__( 'No', 'g5plus-megatron' )  => 'false',
                                    esc_html__( 'Yes',  'g5plus-megatron' ) => 'true'
                                )
                            )
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title widget', 'g5plus-megatron' ),
                        'param_name' => 'title'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Multiple select tab', 'g5plus-megatron' ),
                        'param_name' => 'multiple_select',
                        'value' => array(
                            esc_html__( 'No', 'g5plus-megatron' )  => 'false',
                            esc_html__( 'Yes',  'g5plus-megatron' ) => 'true'
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Image size option', 'g5plus-megatron' ),
                        'param_name' => 'image_size_option',
                        'value' => array(
                            esc_html__( 'Default', 'g5plus-megatron' )  => 'left',
                            esc_html__( 'Custom',  'g5plus-megatron' ) => 'custom'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Image size width', 'g5plus-megatron' ),
                        'param_name' => 'image_size_width',
                        'dependency' => array('element'=>'image_size_option','value'=>'custom')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Image size height', 'g5plus-megatron' ),
                        'param_name' => 'image_size_height',
                        'dependency' => array('element'=>'image_size_option','value'=>'custom')
                    ),
                )
            ) );
        }
    }

    add_action('widgets_init', 'g5plus_register_widget_accordion', 1);
}