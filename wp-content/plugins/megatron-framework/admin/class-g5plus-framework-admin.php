<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/28/2015
 * Time: 5:18 PM
 */
if (!class_exists('g5plusFramework_Admin')) {
    class g5plusFramework_Admin
    {

        private $prefix;


        private $version;


        public function __construct($prefix, $version)
        {
            $this->prefix = $prefix;
            $this->version = $version;

            add_action('wp_ajax_popup_icon', array($this, 'popup_icon'));
        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles()
        {

            /*$pages = isset($_GET['page']) ? $_GET['page'] : '';
            if ($pages == '_options') return;*/

            wp_enqueue_style($this->prefix . 'admin', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/css/admin.css'), array(), $this->version, 'all');

            wp_enqueue_style($this->prefix . 'popup-icon', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/css/popup-icon.css'), array(), $this->version, 'all');

            wp_enqueue_style($this->prefix . 'bootstrap-tagsinput', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'), array(), $this->version, 'all');

            wp_enqueue_style($this->prefix . 'select2', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/plugins/jquery.select2/select2.css'), array(), $this->version, 'all');
        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts()
        {

            wp_enqueue_script($this->prefix . 'admin', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/js/admin.js'), array('jquery'), $this->version, false);

            wp_enqueue_script($this->prefix . 'bootstrap-tagsinput', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'), array('jquery'), $this->version, false);

            wp_enqueue_script($this->prefix . 'select2', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/plugins/jquery.select2/select2.min.js'), array('jquery'), $this->version, false);

            wp_enqueue_script($this->prefix . 'media-init', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/js/g5plus-media-init.js'), array('jquery'), $this->version, false);
            if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
            }

            wp_enqueue_script($this->prefix . 'popup-icon', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/js/popup-icon.js'), array('jquery'), $this->version, false);

            wp_localize_script($this->prefix . 'admin', 'g5plus_framework_meta', array(
                'ajax_url' => admin_url('admin-ajax.php?activate-multi=true')
            ));
        }

        public function popup_icon()
        {
            $megatron_font_awesome = &megatron_get_font_awesome();
            $megatron_icons = &megatron_get_theme_icon();
            ob_start();
            ?>
            <div id="g5plus-framework-popup-icon-wrapper">
	            <div class="popup-icon-wrapper">
		            <div class="popup-content">
			            <div class="popup-search-icon">
				            <input placeholder="Search" type="text" id="txtSearch">

				            <div class="preview">
					            <span></span> <a id="iconPreview" href="javascript:;"><i class="fa fa-home"></i></a>
				            </div>
				            <div style="clear: both;"></div>
			            </div>
			            <div class="list-icon">
				            <h3>Font Megatron</h3>
				            <ul id="group-1">
					            <?php foreach ($megatron_icons as $icon) {
						            $arrkey=array_keys($icon);
						            ?>
						            <li><a title="<?php echo esc_attr($arrkey[0]); ?>" href="javascript:;"><i
									            class="<?php echo esc_attr($arrkey[0]); ?>"></i></a></li>
						            <?php

					            } ?>
				            </ul>
				            <br>
				            <h3>Font Awesome</h3>
				            <ul id="group-2">
					            <?php foreach ($megatron_font_awesome as $icon) {
						            $arrkey=array_keys($icon);
						            ?>
						            <li><a title="<?php echo esc_attr($arrkey[0]); ?>" href="javascript:;"><i
									            class="<?php echo esc_attr($arrkey[0]); ?>"></i></a></li>
						            <?php

					            } ?>
				            </ul>
			            </div>
		            </div>
		            <div class="popup-bottom">
			            <a id="btnSave" href="javascript:;" class="button button-primary">Insert Icon</a>
		            </div>
	            </div>
            </div>
            <?php
            die(); // this is required to return a proper result
        }
    }
}