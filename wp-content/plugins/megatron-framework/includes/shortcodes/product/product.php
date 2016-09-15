<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/15/2015
 * Time: 9:44 AM
 */
if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if (!class_exists('g5plusFramework_Shortcode_Product')) {
    class g5plusFramework_Shortcode_Product {
        function __construct() {
            add_shortcode('megatron_product', array($this, 'product_shortcode' ));
        }

        function  product_shortcode($atts) {

            /**
             * Shortcode attributes
             * @var $title
             * @var $feature
             * @var $category
             * @var $per_page
             * @var $columns
             * @var $rating
             * @var $slider
             * @var $nav
             * @var $dots
             * @var $auto_play
             * @var $auto_play_speed
             * @var $orderby
             * @var $order
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $title =  $feature = $category = $per_page = $columns = $rating = $slider = $nav = $dots = $auto_play = $auto_play_speed = $orderby = $order = $el_class = $css_animation = $duration = $delay =  '';
            $atts = vc_map_get_attributes( 'megatron_product', $atts );
            extract($atts);

	        $g5plus_options = &megatron_get_options_config();
            $min_suffix = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' :  '';
            wp_enqueue_style('megatron_product_css', plugins_url('megatron-framework/includes/shortcodes/product/assets/css/style' . $min_suffix . '.css'), array(), false);

            $meta_query = WC()->query->get_meta_query();
            $query_args = array(
	            'post_type'				=> 'product',
	            'post_status' 			=> 'publish',
	            'ignore_sticky_posts'	=> 1,
	            'posts_per_page' 		=> $per_page,
	            'meta_query' 			=> $meta_query
            );

	        if (!empty($category)) {
		        $query_args['tax_query'] = array(
			        array(
				        'taxonomy' 		=> 'product_cat',
				        'terms' 		=>  explode(',',$category),
				        'field' 		=> 'slug',
				        'operator' 		=> 'IN'
			        )
		        );
	        }

	        switch($feature) {
		        case 'sale':
			        $product_ids_on_sale = wc_get_product_ids_on_sale();
			        $query_args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
			        break;
		        case 'new-in':
			        $query_args['orderby'] = 'DESC';
			        $query_args['order'] = 'date';
			        break;
		        case 'featured':
                    $query_args['meta_query'][] = array(
                        'key'   => '_featured',
                        'value' => 'yes'
                    );
                    break;
		        case 'top-rated':
                    add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
			        break;
		        case 'recent-review':
			        add_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' ) );
			        break;
		        case 'best-selling' :
			        $query_args['meta_key'] = 'total_sales';
			        $query_args['orderby'] = 'meta_value_num';
			        break;
	        }

            if (in_array($feature,array('all','sale','featured'))) {
                $query_args['order'] = $order;

                switch ( $orderby ) {
                    case 'price' :
                        $query_args['meta_key'] = '_price';
                        $query_args['orderby']  = 'meta_value_num';
                        break;
                    case 'rand' :
                        $query_args['orderby']  = 'rand';
                        break;
                    case 'sales' :
                        $query_args['meta_key'] = 'total_sales';
                        $query_args['orderby']  = 'meta_value_num';
                        break;
                    default :
                        $query_args['orderby']  = 'date';
                }
            }


	        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );



            if($feature =='top-rated'){
                remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
            }

            if($feature =='recent-review' ){
                remove_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' )  );
            }

            $class = array('woocommerce sc-product-wrap');
            if (!empty($el_class)) {
                $class[] = $el_class;
            }
            if (!empty($css_animation)) {
                $class[] = g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            }

            $class_name = join(' ',$class);

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
	        $g5plus_woocommerce_loop['rating'] = ($rating == 1) ? 1 : 0;

            ob_start();
            ?>
            <?php if ($products->have_posts()) : ?>
                <div class="<?php echo esc_attr($class_name) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                    <?php if (!empty($title)) : ?>
                        <h4 class="sc-title p-font"><span><?php echo esc_html($title); ?></span></h4>
                    <?php endif; ?>
                    <?php woocommerce_product_loop_start(); ?>
                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    <?php endwhile; // end of the loop. ?>
                    <?php woocommerce_product_loop_end(); ?>
                </div>
            <?php else: ?>
                <div class="item-not-found"><?php esc_html_e('No item found','g5plus-megatron'); ?></div>
            <?php endif; ?>

            <?php
            wp_reset_postdata();
            $content =  ob_get_clean();
            return $content;
        }

        function order_by_comment_date_post_clauses($args){
            global $wpdb;

            $args['join'] .= "
                LEFT JOIN (
                    SELECT comment_post_ID, MAX(comment_date)  as  comment_date
                    FROM $wpdb->comments
                    WHERE comment_approved = 1
                    GROUP BY comment_post_ID
                ) as wp_comments ON($wpdb->posts.ID = wp_comments.comment_post_ID)
            ";
            $args['orderby'] = "wp_comments.comment_date DESC";
            return $args;
        }


    }
    new g5plusFramework_Shortcode_Product();
}