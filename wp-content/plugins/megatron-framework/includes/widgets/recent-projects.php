<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/26/15
 * Time: 5:24 PM
 */
class G5Plus_Widget_Recent_Portfolio extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-recent-portfolio';
        $this->widget_description = esc_html__( "Recent Portfolio", 'g5plus-megatron' );
        $this->widget_id          = 'recent-portfolio';
        $this->widget_name        = esc_html__( 'G5Plus: Recent Projects', 'g5plus-megatron' );
        $this->settings           = array(
            'title' => array(
                'type'  => 'text',
                'std'   => 'Recent Projects',
                'label' => esc_html__( 'Title', 'g5plus-megatron' ),
            ),
            'post_per_page' => array(
                'type'  => 'number',
                'std'   => '9',
                'label' => esc_html__( 'Total', 'g5plus-megatron' ),
            ),
            'columns' => array(
                'type'  => 'select',
                'std'   => '3',
                'options'      => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    ),
                'label' => esc_html__( 'Columns', 'g5plus-megatron' ),
            ),

        );

        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_recent_projects', array($this, 'vc_widget'));
        }
        parent::__construct();
    }

    function widget( $args, $instance ) {

        if(!class_exists('G5PlusFramework_Portfolio')){
            return;
        }

        extract( $args, EXTR_SKIP );
        $title  = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $columns  = ( ! empty( $instance['columns'] ) ) ? absint( $instance['columns'] ) : 3;
        $post_per_page  = ( ! empty( $instance['post_per_page'] ) ) ? absint( $instance['post_per_page'] ) : 9;

        $query_args = array(
            'posts_per_page'   => $post_per_page,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'portfolio',
            'post_status'      => 'publish');

        ob_start();
	    $class_names = 'columns-' . $columns;
        $r  = new WP_Query( $query_args );
        if ($r->have_posts()) {
            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            } ?>
            <ul class="<?php echo esc_attr($class_names); ?>">
                <?php
                while ( $r->have_posts() ){
                    $r->the_post();
                    $permalink = get_permalink();
                    $title_post = get_the_title();
                    $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
                    $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
                    $thumbnail_url = '';
                    if(count($arrImages)>0){
                        $resize = matthewruddy_image_resize($arrImages[0],270,270);
                        if($resize!=null && is_array($resize) ) {
                            $thumbnail_url = $resize['url'];
                        }
                    } ?>
                    <li>
                        <a href="<?php echo esc_url($permalink) ?>">
                            <img src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo esc_attr($title_post) ?>">
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php
            echo wp_kses_post($args['after_widget']);
        }
        wp_reset_postdata();
        $content =  ob_get_clean();
        echo wp_kses_post($content);
        $this->cache_widget( $args, $content );
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_recent_projects', $atts );
        $args = array();
        $args['widget_id'] = 'recent-portfolio';
        the_widget('G5Plus_Widget_Recent_Portfolio',$attributes,$args);
    }
}
if (!function_exists('g5plus_register_widget_recent_portfolio')) {
    function g5plus_register_widget_recent_portfolio() {
        register_widget('G5Plus_Widget_Recent_Portfolio');

        if(function_exists('vc_map')){
            vc_map( array(
                'name' => esc_html__( 'G5Plus Recent Projects', 'g5plus-megatron' ),
                'base' => 'g5plusframework_widget_recent_projects',
                'icon' => 'fa fa-th-large',
                'category' => esc_html__( 'Megatron Widgets', 'g5plus-megatron' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'Recent projects for your site', 'g5plus-megatron' ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'g5plus-megatron' ),
                        'param_name' => 'title'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Number of post', 'g5plus-megatron' ),
                        'param_name' => 'post_per_page'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Columns', 'g5plus-megatron' ),
                        'param_name' => 'columns',
                        'value' => array(
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6'
                        )
                    )
                )
            ) );
        }
    }
    add_action('widgets_init', 'g5plus_register_widget_recent_portfolio', 1);
}