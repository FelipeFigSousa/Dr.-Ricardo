<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_View_Demo')) {
    class g5plusFramework_Shortcode_View_Demo
    {
        function __construct()
        {
            add_shortcode('megatron_view_demo', array($this, 'view_demo_shortcode'));
        }

        function view_demo_shortcode($atts)
        {
	        /**
	         * Shortcode attributes
	         * @var $text
	         * @var $image
	         * @var $link
             * @var $is_new
	         * @var $el_class
	         * @var $css_animation
	         * @var $duration
	         * @var $delay
	         */
            $text=$image=$link=$is_new=$el_class=$css_animation=$duration=$delay='';
	        $atts = vc_map_get_attributes( 'megatron_view_demo', $atts );
	        extract( $atts );
	        $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_view_demo_css', plugins_url('megatron-framework/includes/shortcodes/view-demo/assets/css/view-demo' . $min_suffix_css . '.css'), array(), false);
            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );
	        $a_title='';
	        $a_target='_self';
	        $a_href='#';
            if ( strlen( $link['title'] ) > 0 ) {
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            ob_start();?>
            <div class="view-demo<?php if ($is_new == 'yes') echo ' new-demo'; echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <div class="demo-image">
                    <?php $img = wp_get_attachment_image_src( $image, 'full' );?>
                    <img alt="<?php echo esc_attr($text); ?>" class="img-responsive" src="<?php echo esc_url($img[0])?>"/>
                    <div class="overlay-view-demo">
                        <div class="content-middle">
                            <div class="content-middle-inner">
                                <a class="m-button m-button-bg m-button-xs m-button-primary" href="<?php echo esc_url($a_href); ?>" target="<?php echo esc_attr($a_target); ?>"><?php echo esc_html($a_title); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
	            <?php if($text!=''):?>
                <a class="view-link p-font" href="<?php echo esc_url($a_href); ?>" target="<?php echo esc_attr($a_target); ?>"><?php echo esc_html($text); ?></a>
	            <?php endif;?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_View_Demo();
}
