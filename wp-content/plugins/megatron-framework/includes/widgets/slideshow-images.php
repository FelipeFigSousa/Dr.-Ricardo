<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 9/26/15
 * Time: 3:04 PM
 */

class G5Plus_Widget_SlideShow_Images extends  g5plus_acf_widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-slideshow-images';
        $this->widget_description = esc_html__( "Display Slideshow image", 'g5plus-megatron' );
        $this->widget_id          = 'megatron-slideshow-images';
        $this->widget_name        = esc_html__( 'G5Plus: Slideshow Images', 'g5plus-megatron' );
        $this->settings           = array(
            'id'          => 'slideshow_images_acf',
            'type'        => 'rows',
            'title'       => esc_html__('Slideshow Images', 'g5plus-megatron'),
            'subtitle'    => esc_html__('Unlimited slide show image with drag and drop sortings.', 'g5plus-megatron'),
            'fields'      => array(
                array(
                    'name' => 'image_title',
                    'title' => esc_html__( 'Title',  'g5plus-megatron'),
                    'type'  => 'text',
                    'is_title_block' => 1
                ),
                array(
                    'name' => 'image_url',
                    'title' => esc_html__( 'Image',  'g5plus-megatron'),
                    'type'  => 'image'
                ),
            ),
            'extra'     => array(
                array(
                    'name'   => 'title',
                    'title'   => esc_html__( 'Title Widget',  'g5plus-megatron'),
                    'type'    => 'text',

                ),
                array(
                    'name'   => 'image_size_option',
                    'title'   => esc_html__( 'Image size',  'g5plus-megatron'),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    'options' => array(
                        ''  => esc_html__( 'Default', 'g5plus-megatron' ),
                        'custom' => esc_html__( 'Custom',  'g5plus-megatron' )
                    )
                ),
                array(
                    'name'   => 'image_size_width',
                    'title'   => esc_html__( 'Image size width',  'g5plus-megatron'),
                    'type'    => 'text',
                    'require' => array(
                        'element' => 'image_size_option',
                        'compare' => '=',
                        'value' => array('custom')
                    )
                ),
                array(
                    'name'   => 'image_size_height',
                    'title'   => esc_html__( 'Image size height',  'g5plus-megatron'),
                    'type'    => 'text',
                    'require' => array(
                        'element' => 'image_size_option',
                        'compare' => '=',
                        'value' => array('custom')
                    )
                ),
                array(
                    'name'  => 'description',
                    'title' => 'Description',
                    'type'  => 'text-area'
                ),
                array(
                    'name'   => 'description_align',
                    'title'   => esc_html__( 'Description Align',  'g5plus-megatron'),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    'options' => array(
                        'left'  => esc_html__( 'Left', 'g5plus-megatron' ),
                        'right' => esc_html__( 'Right',  'g5plus-megatron' ),
                        'center' => esc_html__( 'Center',  'g5plus-megatron' )
                    )
                ),
            )
        );
        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_slideshow_images', array($this, 'vc_widget'));
        }
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $widget_id = $args['widget_id'];
        $slide_shows = array_key_exists('fields',$instance) ? $instance['fields'] : array() ;
        $extra = array_key_exists('extra',$instance) ? $instance['extra'] : array() ;
        $title = array_key_exists('title',$extra) ? $extra['title'] : '';
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $description_align = array_key_exists('description_align',$extra) ? $extra['description_align'] : '';
        $description = array_key_exists('description',$extra) ? $extra['description'] : '';
        $description = apply_filters( 'widget_text', $description, $instance, $this->id_base );
        $image_size_option = array_key_exists('image_size_option',$extra) ? $extra['image_size_option'] : '';
        $image_size_width = array_key_exists('image_size_width',$extra) ? $extra['image_size_width'] : '';
        $image_size_height = array_key_exists('image_size_height',$extra) ? $extra['image_size_height'] : '';
        echo wp_kses_post($before_widget);

        $data_plugin_options = $owl_carousel_class = '';
        $data_plugin_options = 'data-plugin-options=\'{ "items" : 1,"dots": false, "nav": true, "autoplay": true}\'';
        $owl_carousel_class = 'owl-carousel';
        ?>
        <div class="slideshow-images">
            <?php if($title!=''){ ?>
                <h4 class="widget-title">
                    <?php echo esc_html($title) ?>
                </h4>
            <?php } ?>
            <?php if(isset($slide_shows) && is_array($slide_shows)){ ?>
                <div class="owl-carousel" <?php echo wp_kses_post($data_plugin_options) ?>>
                    <?php foreach($slide_shows as $slide_show ){
                        $url = $slide_show['image_url']['url'];
                            if($image_size_option=='custom' && $image_size_width!='' && $image_size_height!=''){
                                $resize = matthewruddy_image_resize($url,$image_size_width,$image_size_height);
                                if($resize!=null && is_array($resize) )
                                    $url = $resize['url'];
                            }
                            ?>
                            <img src="<?php echo esc_url($url)?>" alt="<?php echo esc_attr($slide_show['image_title']) ?>" />
                        <?php
                        }
                     ?>
                </div>
            <?php } ?>
            <?php if(array_key_exists('description',$extra) && $extra['description']!=''){ ?>
                <div class="description">
                    <p class="<?php echo esc_attr($description_align) ?>"><?php echo esc_html($description); ?></p>
                </div>
            <?php } ?>
        </div>
        <?php
        echo wp_kses_post($after_widget);
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_slideshow_images', $atts );
        $instance =$args = array();
        $args['widget_id'] = 'megatron-free-text';
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
                $instance['fields'][$index]['image_title'] = $field['image_title'];
                $index++;
            }
        }
        $instance['extra'] = array();
        $instance['extra']['title'] = $attributes['title'];
        $instance['extra']['image_size_option'] = $attributes['image_size_option'];
        $instance['extra']['image_size_width'] = $attributes['image_size_width'];
        $instance['extra']['image_size_height'] = $attributes['image_size_height'];
        $instance['extra']['description'] = $attributes['description'];
        $instance['extra']['description_align'] = $attributes['description_align'];
        the_widget('G5Plus_Widget_SlideShow_Images',$instance,$args);
    }
}
if (!function_exists('g5plus_register_widget_slideshow_images')) {
    function g5plus_register_widget_slideshow_images() {
        register_widget('G5Plus_Widget_SlideShow_Images');

        if(function_exists('vc_map')){
            vc_map( array(
                'name' => 'G5Plus Slide Show Images',
                'base' => 'g5plusframework_widget_slideshow_images',
                'icon' => 'fa fa-picture-o',
                'category' => esc_html__( 'Megatron Widgets', 'g5plus-megatron' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'A custom slide show image for your site', 'g5plus-megatron' ),
                'params' => array(
                    array(
                        'type' => 'param_group',
                        'heading' => esc_html__( 'Image slide', 'g5plus-megatron' ),
                        'param_name' => 'fields',
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Image title', 'g5plus-megatron'),
                                'param_name' => 'image_title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_html__('Image', 'g5plus-megatron'),
                                'param_name' => 'image_url',
                                'value' => '',
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title widget', 'g5plus-megatron' ),
                        'param_name' => 'title'
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
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Description', 'g5plus-megatron' ),
                        'param_name' => 'description'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Description Align', 'g5plus-megatron' ),
                        'param_name' => 'description_align',
                        'value' => array(
                            esc_html__( 'Left', 'g5plus-megatron' )  => 'left',
                            esc_html__( 'Right',  'g5plus-megatron' ) => 'right',
                            esc_html__( 'Center',  'g5plus-megatron' ) => 'center'
                        )
                    )
                )
            ) );
        }
    }
    add_action('widgets_init', 'g5plus_register_widget_slideshow_images', 1);
}