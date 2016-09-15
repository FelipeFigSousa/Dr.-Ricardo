<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Feature')) {
	class g5plusFramework_Shortcode_Feature
	{
		function __construct()
		{
			add_shortcode('megatron_feature', array($this, 'feature_shortcode'));
		}

		function feature_shortcode($atts)
		{
			/**
			 * Shortcode attributes
			 * @var $image
			 * @var $video_url
			 * @var $sub_title
			 * @var $title
			 * @var $description
			 * @var $link
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
            $image=$video_url=$sub_title=$title=$description=$link=$el_class=$css_animation=$duration=$delay='';
			$atts = vc_map_get_attributes( 'megatron_feature', $atts );
			extract( $atts );
			$g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_feature_css', plugins_url('megatron-framework/includes/shortcodes/feature/assets/css/feature' . $min_suffix_css . '.css'), array(), false);
			$g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);

            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );
			$a_title='';
			$a_target='_self';
			$a_href='#';
            if ( strlen( $link['url'] ) > 0 ) {
                $a_href = $link['url'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            $img_id = preg_replace( '/[^\d]/', '', $image );
            $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => '370x247'  ) );
            ob_start();?>
            <div class="feature<?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <div class="feature-thumb">
                    <?php if($video_url != ''):?>
                        <a data-rel="prettyPhoto[feature]" href="<?php
                            echo esc_url($video_url);?>">
                            <?php echo wp_kses_post($img['thumbnail']);?>
                            <i class="fa fa-play-circle-o"></i>
                        </a>
                    <?php else:?>
                        <a target="<?php echo esc_attr($a_target) ?>" href="<?php echo esc_url($a_href); ?>">
                            <?php echo wp_kses_post($img['thumbnail']);?>
                        </a>
                    <?php endif;?>
                </div>
                <div class="feature-content">
                    <?php if($sub_title!=''): ?>
                    <span class="s-font">
                        <?php echo esc_html($sub_title); ?>
                    </span>
                    <?php endif;
                    if($title!=''):?>
                    <h6>
                        <a target="<?php echo esc_attr($a_target) ?>" href="<?php echo esc_url($a_href); ?>"><?php echo esc_html($title); ?></a>
                    </h6>
                    <?php endif;
                    if($description!=''): ?>
                    <p><?php echo esc_html($description); ?></p>
                    <?php endif;?>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
		}
	}
    new g5plusFramework_Shortcode_Feature();
}