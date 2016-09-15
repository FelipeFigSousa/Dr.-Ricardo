<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Call_Action')) {
	class g5plusFramework_Shortcode_Call_Action
	{
		function __construct()
		{
			add_shortcode('megatron_call_action', array($this, 'call_action_shortcode'));
		}

		function call_action_shortcode($atts)
		{
			/**
			 * Shortcode attributes
			 * @var $layout_style
             * @var $icon_type
             * @var $icon_image
             * @var $height
             * @var $color
			 * @var $title
             * @var $description
			 * @var $link
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
            $iconClass=$layout_style=$icon_type=$height=$icon_image=$color=$title=$description=$link=$el_class=$css_animation=$duration=$delay='';
			$atts = vc_map_get_attributes( 'megatron_call_action', $atts );
			extract( $atts );
			$g5plus_animation = esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
			$g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_call_action_css', plugins_url('megatron-framework/includes/shortcodes/call-action/assets/css/call-action' . $min_suffix_css . '.css'), array(), false);
            if($icon_type!='' && $icon_type!='image')
            {
                vc_icon_element_fonts_enqueue( $icon_type );
                $iconClass = isset( ${"icon_" . $icon_type} ) ? esc_attr( ${"icon_" . $icon_type} ) : '';
            }
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

            $call_action_class = array('call-action', $layout_style, $color, $height , $g5plus_animation);

            $call_action_button_class = array('m-button', "m-button-xs");
            if($layout_style == 'style2'){
                if($color == 'call-action-transparent'){
                    $call_action_button_class[]= 'm-button-gray m-button-bg';
                }else{
                    $call_action_button_class[]= 'm-button-light m-button-bordered-2';
                }
            }else{
                if($color == 'call-action-transparent'){
                    $call_action_button_class[]= 'm-button-gray m-button-bg';
                }else{
                    $call_action_button_class[]= 'm-button-light m-button-bordered';
                }
            }
            ob_start();?>
            <div class="<?php echo join(' ', $call_action_class) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <div class="container">
                    <?php if ( $icon_type != '' ) :
                        if ( $icon_type == 'image' ) :
                            $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                            <img src="<?php echo esc_url($img[0])?>"/>
                        <?php else :?>
                            <i class="<?php echo esc_attr($iconClass) ?>"></i>
                        <?php endif;
                    endif;?>
                    <h4><?php echo esc_html($title)?></h4>
                    <?php if(!empty($description)):?>
                        <p><?php echo wp_kses_post($description)?></p>
                    <?php endif;?>
                    <a class="<?php echo join(' ', $call_action_button_class) ?>" href="<?php echo esc_url($a_href); ?>"
                       target="<?php echo esc_attr($a_target); ?>"><?php echo esc_html($a_title); ?>
                    </a>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
		}
	}
    new g5plusFramework_Shortcode_Call_Action();
}