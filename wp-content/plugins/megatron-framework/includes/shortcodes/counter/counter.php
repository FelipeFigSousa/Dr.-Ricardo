<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Counter')) {
    class g5plusFramework_ShortCode_Counter
    {
        function __construct()
        {
            add_shortcode('megatron_counter', array($this, 'counter_shortcode'));
        }

        function counter_shortcode($atts)
        {
	        /**
	         * Shortcode attributes
             * @var $icon_type
             * @var $icon_image
	         * @var $value
	         * @var $value_color
	         * @var $title
	         * @var $title_color
	         * @var $el_class
	         */
            $iconClass=$icon_type=$icon_image=$value=$value_color=$title=$title_color=$el_class='';
	        $atts = vc_map_get_attributes( 'megatron_counter', $atts );
	        extract( $atts );
            if($icon_type!='' && $icon_type!='image')
            {
                vc_icon_element_fonts_enqueue( $icon_type );
                $iconClass = isset( ${"icon_" . $icon_type} ) ? esc_attr( ${"icon_" . $icon_type} ) : '';
            };
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_js = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_script('megatron_counter_js', plugins_url('megatron-framework/includes/shortcodes/counter/assets/js/jquery.countTo' . $min_suffix_js . '.js'), array(), false, true);
            wp_enqueue_style('megatron_counter_css', plugins_url('megatron-framework/includes/shortcodes/counter/assets/css/counter' . $min_suffix_css . '.css'), array(), false);
            ob_start();?>
            <div class="counter <?php echo esc_attr($el_class) ?>">
            <?php if($value!=''): ?>
                <?php if ( $icon_type != '' ) :
                    if ( $icon_type == 'image' ) :
                        $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                        <img alt="" src="<?php echo esc_url($img[0])?>"/>
                    <?php else :?>
                        <i class="<?php echo esc_attr($iconClass) ?> p-color"></i>
                    <?php endif;
                endif;?>
                <span class="display-percentage p-font" style="color: <?php echo esc_attr($value_color) ?>" data-percentage="<?php echo esc_attr($value) ?>"><?php echo esc_html($value) ?></span>
                <?php if($title!=''): ?>
                    <p class="counter-title s-font" style="color: <?php echo esc_attr($title_color) ?>"><?php echo wp_kses_post($title) ?></p>
                <?php endif;
            endif; ?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Counter();
}