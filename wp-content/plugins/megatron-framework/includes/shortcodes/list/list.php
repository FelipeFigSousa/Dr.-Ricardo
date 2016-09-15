<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/7/2015
 * Time: 4:43 PM
 */
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_List')) {
	class g5plusFramework_Shortcode_List
	{
		function __construct()
		{
			add_shortcode('megatron_list', array($this, 'list_shortcode'));
		}
		function list_shortcode($atts)
		{
			/**
			 * Shortcode attributes
			 * @var $layout_style
			 * @var $title
			 * @var $color
			 * @var $values_general
			 * @var $values_separate
			 * @var $icon_type
			 * @var $icon_image
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
			$iconClass=$layout_style=$title=$color=$values_separate=$values_general=$icon_type=$icon_image=$el_class=$css_animation=$duration=$delay='';
			$atts = vc_map_get_attributes( 'megatron_list', $atts );
			extract( $atts );
			$g5plus_options = &megatron_get_options_config();
			$min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
			wp_enqueue_style('megatron_list_css', plugins_url('megatron-framework/includes/shortcodes/list/assets/css/list' . $min_suffix_css . '.css'), array(), false);
			$g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
			ob_start();?>
			<ul class="list <?php echo esc_attr($layout_style.' '.$color.$g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
				<?php if($layout_style!='style6'):
					$number_list = 1;
					$values_general = (array) vc_param_group_parse_atts( $values_general );
					foreach( $values_general as $data) {
						$title = isset($data['title']) ? $data['title'] : '';
						if(!empty($title)):?>
						<li class="list-item">
							<span class="list-before-title p-font">
								<?php if($layout_style == 'style3'):?>
									<?php echo esc_attr($number_list.'.')?>
								<?php endif; if($layout_style == 'style4' || $layout_style == 'style5'):?>
									<?php if($number_list<10) echo esc_attr('0'.$number_list)?>
									<?php if($number_list>=10)echo esc_attr($number_list)?>
								<?php endif;?>
							</span>
							<span class="list-title">
								<?php echo esc_html($title)?>
							</span>
						</li>
						<?php endif;
						$number_list++;
					}
				endif;
				if($layout_style == 'style6'):
					$values_separate = (array) vc_param_group_parse_atts( $values_separate );
					foreach($values_separate as $data){
						$iconClass ='';
						$title = isset($data['title'])?$data['title']:'';
						$icon_type = isset($data['icon_type']) ? $data['icon_type']:'';
						if($icon_type!='' && $icon_type!='image')
						{
							vc_icon_element_fonts_enqueue( $icon_type );
							$iconClass = isset( $data{"icon_" . $icon_type} ) ? esc_attr( $data{"icon_" . $icon_type} ) : '';
						}
						if($icon_type=='image'){
							$icon_image = isset( $data['icon_image']) ? esc_attr($data['icon_image']):'';
						}
						if(!empty($title)):?>
						<li class="list-item">
							<span class="list-before-title">
								<?php if ( $icon_type != '' ) :
									if ( $icon_type == 'image' ) :
										$img = wp_get_attachment_image_src( $icon_image, 'full' );?>
										<img src="<?php echo esc_url($img[0])?>"/>
									<?php else :?>
										<i class="<?php echo esc_attr($iconClass) ?>"></i>
									<?php endif;
								endif;?>
							</span>
							<span class="list-title">
								<?php echo esc_html($title)?>
							</span>
						</li>
					<?php
					endif;
					}
				endif;?>

			</ul>
			<?php
			$content = ob_get_clean();
			return $content;
		}
	}
	new g5plusFramework_Shortcode_List();
}