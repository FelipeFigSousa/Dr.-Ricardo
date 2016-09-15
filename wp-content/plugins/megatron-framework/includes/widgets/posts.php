<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/17/2015
 * Time: 5:29 PM
 */
class G5Plus_Widget_Posts extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-posts';
        $this->widget_description = esc_html__( "Posts widget", 'g5plus-megatron' );
        $this->widget_id          = 'g5plus-posts';
        $this->widget_name        = esc_html__( 'G5Plus: Posts', 'g5plus-megatron' );
        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title','g5plus-megatron')
            ),
            'source'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Source', 'g5plus-megatron' ),
                'options' => array(
                    'random' => esc_html__('Random','g5plus-megatron'),
                    'popular' => esc_html__('Popular','g5plus-megatron'),
                    'recent'  => esc_html__( 'Recent', 'g5plus-megatron' ),
                    'oldest' => esc_html__('Oldest','g5plus-megatron')
                )
            ),
            'number' => array(
                'type'  => 'number',
                'std'   => '5',
                'label' => esc_html__( 'Number of posts to show', 'g5plus-megatron' ),
            )
        );
        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_post', array($this, 'vc_widget'));
        }
        parent::__construct();
    }

    function widget( $args, $instance ) {
        if ( $this->get_cached_widget( $args ) )
            return;

        extract( $args, EXTR_SKIP );
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $source        = empty( $instance['source'] ) ? '' : $instance['source'];
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $query_args = array();

        switch ($source) {
            case 'random' :
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'rand',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
            case 'popular':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'comment_count',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;

            case 'recent':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
            case 'oldest':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'post_date',
                    'order' => 'ASC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
        }

        ob_start();
        $r = new WP_Query( $query_args);
        if ($r->have_posts()) : ?>
            <?php echo wp_kses_post($args['before_widget']); ?>
            <?php if ( $title ) {
		        echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
	        } ?>

            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <div class="widget_posts_item clearfix">
                    <?php if(function_exists('g5plus_post_thumbnail'))
                        {
                            $thumbnail = g5plus_post_thumbnail('blog-sidebar');
                            if (!empty($thumbnail)) : ?>
                                <div class="widget-posts-thumbnail">
                                    <?php echo wp_kses_post($thumbnail); ?>
                                </div>
                            <?php endif;
                        }
                    ?>
                    <div class="widget-posts-content-wrap">
                        <a class="widget-posts-title p-font" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        <div class="widget-posts-date s-font s-color">
                            <?php echo get_the_date('F j, Y'); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

            <?php echo wp_kses_post($args['after_widget']); ?>
        <?php endif;
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        $content =  ob_get_clean();
        echo wp_kses_post($content);
        $this->cache_widget( $args, $content );
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_post', $atts );
        $args = array();
        $args['widget_id'] = 'g5plus-posts';
        $args['widget_cssclass']    = 'widget-posts';
        $args['widget_name']        = esc_html__( 'G5Plus: Posts', 'g5plus-megatron' );
        the_widget('G5Plus_Widget_Posts',$attributes,$args);
    }
}

if (!function_exists('g5plus_register_widget_posts')) {
    function g5plus_register_widget_posts() {
        register_widget('G5Plus_Widget_Posts');

        if(function_exists('vc_map')){
            vc_map( array(
                'name' => esc_html__( 'G5Plus Post', 'g5plus-megatron' ),
                'base' => 'g5plusframework_widget_post',
                'icon' => 'fa fa-pencil-square-o',
                'category' => esc_html__( 'Megatron Widgets', 'g5plus-megatron' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'Post for your site', 'g5plus-megatron' ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'g5plus-megatron' ),
                        'param_name' => 'title'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Source', 'g5plus-megatron' ),
                        'param_name' => 'source',
                        'value' => array(
                            esc_html__('Random','g5plus-megatron') => 'random',
                            esc_html__('Popular','g5plus-megatron') => 'popular',
                            esc_html__( 'Recent', 'g5plus-megatron' ) => 'recent',
                            esc_html__('Oldest','g5plus-megatron') => 'oldest'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Number of post', 'g5plus-megatron' ),
                        'param_name' => 'number',
                        'value' => '5'
                    )
                )
            ) );
        }
    }
    add_action('widgets_init', 'g5plus_register_widget_posts', 1);
}