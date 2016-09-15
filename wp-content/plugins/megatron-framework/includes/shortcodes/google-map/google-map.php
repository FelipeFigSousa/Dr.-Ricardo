<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/31/2015
 * Time: 3:20 PM
 */
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if (!class_exists('g5plusFramework_Shortcode_Google_Map')) {
	class g5plusFramework_Shortcode_Google_Map{
		function __construct() {
			add_shortcode('megatron_google_map', array($this, 'google_map' ));
		}
		function google_map($atts) {
			$location_x = $location_y = $layout_style=$marker_title=$marker_icon=$info_html=$info_max_width=$info_bg=$info_color=$map_height=$map_zoom=$map_style=$el_class=$css_animation=$duration=$delay='';
			$atts = vc_map_get_attributes( 'megatron_google_map', $atts );
			extract( $atts );
			$g5plus_options = &megatron_get_options_config();
			$min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
			$protocol = (!empty ($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
			wp_enqueue_script('megatron-google-api', $protocol . '//maps.googleapis.com/maps/api/js', array(), false, true);
			wp_enqueue_script('megatron-google-maps', plugins_url('megatron-framework/includes/shortcodes/google-map/assets/js/google-map' . $min_suffix . '.js'), array('megatron-google-api'), false, true);
			$g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
			ob_start();
			$marker_icon = wp_get_attachment_image_src( $marker_icon, 'full' );
			$info_html=htmlentities( rawurldecode( call_user_func('base64' . '_decode', strip_tags( $info_html ) ) ), ENT_COMPAT, 'UTF-8' )
			?>
			<div class="megatron-google-map<?php echo esc_attr($g5plus_animation) ?>" style="height:<?php echo esc_attr($map_height) ?>"
				 data-location-x="<?php echo esc_attr($location_x) ?>"
				 data-location-y="<?php echo esc_attr($location_y) ?>"
				 data-layout-style="<?php echo esc_attr($layout_style) ?>"
				 data-marker-title="<?php echo esc_attr($marker_title) ?>"
				 data-marker-icon="<?php echo esc_url($marker_icon[0]) ?>"
				 data-info-html="<?php echo esc_attr($info_html) ?>"
				 data-info-max-width="<?php echo esc_attr($info_max_width) ?>"
				 data-info-bg="<?php echo esc_attr($info_bg) ?>"
				 data-info-color="<?php echo wp_kses_post($info_color) ?>"
				 data-map-zoom="<?php echo esc_attr($map_zoom) ?>"
				 data-map-style="<?php echo esc_attr($map_style) ?>"
				<?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>></div>
			<?php
			$content = ob_get_clean();
			return $content;
		}
	}
	new g5plusFramework_Shortcode_Google_Map();
}