<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Mailchimp')) {
    class g5plusFramework_Shortcode_Mailchimp
    {
        function __construct()
        {
            add_shortcode('megatron_mailchimp', array($this, 'mailchimp_shortcode'));
        }

        function mailchimp_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $color_scheme
             * @var $button_bg
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $color_scheme=$el_class=$css_animation=$duration=$delay='';
            $atts = vc_map_get_attributes( 'megatron_mailchimp', $atts );
            extract( $atts );
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_js = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_script('megatron_mailchimp_js', plugins_url('megatron-framework/includes/shortcodes/mailchimp/assets/js/mailchimp' . $min_suffix_js . '.js'), array(), false, true);
            wp_enqueue_style('megatron_mailchimp_css', plugins_url('megatron-framework/includes/shortcodes/mailchimp/assets/css/mailchimp' . $min_suffix_css . '.css'), array(), false);
            ob_start();?>
            <div class="mailchimp <?php echo esc_attr($button_bg.' '.$color_scheme.$g5plus_animation) ?>">
                <?php echo do_shortcode('[mc4wp_form]'); ?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Mailchimp();
}