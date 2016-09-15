<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/22/2015
 * Time: 3:56 PM
 */
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if (!class_exists('g5plusFramework_Shortcode_Product_Categories')) {
    class g5plusFramework_Shortcode_Product_Categories {
        function __construct() {
            add_shortcode('megatron_product_categories', array($this, 'product_categories_shortcode' ));
        }

        function  product_categories_shortcode($atts) {
            /**
             * Shortcode attributes
             * @var $title
             * @var $category
             * @var $columns
             * @var $slider
             * @var $nav
             * @var $dots
             * @var $auto_play
             * @var $auto_play_speed
             * @var $hide_empty
             * @var $orderby
             * @var $order
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $title =  $category =  $columns = $slider = $hide_empty = $orderby = $order = $el_class = $css_animation = $duration = $delay =  '';
            $atts = vc_map_get_attributes( 'megatron_product_categories', $atts );
            extract($atts);


	        $g5plus_options = &megatron_get_options_config();
            $min_suffix = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' :  '';
            wp_enqueue_style('megatron_product_css', plugins_url('megatron-framework/includes/shortcodes/product/assets/css/style' . $min_suffix . '.css'), array(), false);

            // get terms and workaround WP bug with parents/pad counts
            $args = array(
                'orderby'    => $orderby,
                'order'      => $order,
                'hide_empty' => $hide_empty == 1 ? true : false ,
                'pad_counts' => true
            );


            $product_categories = get_terms( 'product_cat', $args );

	        if (!empty($category)) {
		        $cats = explode(',',$category);
		        foreach ( $product_categories as $key => $category ) {
			        if ( ($hide_empty && $category->count == 0) || !in_array($category->slug,$cats) ) {
				        unset( $product_categories[ $key ] );
			        }
		        }
	        }


	        $g5plus_woocommerce_loop = &G5Plus_Global::get_woocommerce_loop();
            $g5plus_woocommerce_loop['columns'] = $columns;
            $g5plus_woocommerce_loop['layout'] = $slider;
            if ($slider == 'slider') {
                if (!empty($auto_play)) {
                    $g5plus_woocommerce_loop['autoPlay'] = $auto_play_speed > 0 ? $auto_play_speed : 'true';
                }

                $g5plus_woocommerce_loop['dots'] = ($dots == 'yes') ? 'true' : 'false';
                $g5plus_woocommerce_loop['nav'] = ($nav == 'yes') ? 'true' : 'false';
            }


            $class[]= 'woocommerce sc-product-wrap sc-product-category-wrap';
            if (!empty($el_class)) {
                $class[] = $el_class;
            }
            if (!empty($css_animation)) {
                $class[] = g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            }

            $class_name = join(' ',$class);

            ob_start();
            ?>
            <?php if ($product_categories) : ?>
                <div class="<?php echo esc_attr($class_name) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                    <?php if (!empty($title)) : ?>
                        <h4 class="sc-title p-font"><span><?php echo esc_html($title); ?></span></h4>
                    <?php endif; ?>
                    <?php woocommerce_product_loop_start(); ?>
                        <?php foreach ( $product_categories as $category ) : ?>
                            <?php  wc_get_template( 'content-product_cat.php', array(
                                'category' => $category
                            ) ); ?>
                        <?php endforeach; // end of the loop. ?>
                    <?php woocommerce_product_loop_end(); ?>

                </div>
            <?php else: ?>
                <div class="item-not-found"><?php esc_html_e('No item found','g5plus-megatron') ?></div>
            <?php endif; ?>

            <?php
            wp_reset_postdata();
            $content =  ob_get_clean();
            return $content;
        }

    }
    new g5plusFramework_Shortcode_Product_Categories();
}