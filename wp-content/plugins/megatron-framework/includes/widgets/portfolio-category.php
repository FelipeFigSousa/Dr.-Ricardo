<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/2/2015
 * Time: 11:48 AM
 */
class G5Plus_Widget_Portfolio_Category extends G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-portfolio-category widget_categories';
        $this->widget_description = esc_html__( "Portfolio Category Widget", 'g5plus-megatron' );
        $this->widget_id          = 'g5plus-portfolio-category';
        $this->widget_name        = esc_html__( 'G5Plus: Portfolio Category', 'g5plus-megatron' );
        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => 'Categories',
                'label' => esc_html__('Title','g5plus-megatron')
            ),
            'show_post_count' => array(
                'type' => 'checkbox',
                'std' => '1',
                'label' => esc_html__('Show post count','g5plus-megatron')
            ),
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        if ( $this->get_cached_widget( $args ) )
            return;

        if(!class_exists('G5PlusFramework_Portfolio')){
            return;
        }
        extract( $args, EXTR_SKIP );
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $show_post_count = ( ! empty( $instance['show_post_count'] ) ) ? $instance['show_post_count'] : '';
        $term_args = array(
            'orderby'           => 'name',
            'order'             => 'ASC',
            'hide_empty'        => true,
            'pad_counts'        => true,
        );
        $terms = get_terms(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY, $term_args);

        ob_start();
        echo wp_kses_post($before_widget);
        if ($title) {
            echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
        }
	    $g5plus_options = &megatron_get_options_config();
        $archive_link = '#';
        if(isset($g5plus_options['portfolio_archive_page']) && $g5plus_options['portfolio_archive_page']!='')
            $archive_link = $g5plus_options['portfolio_archive_page'];
        else{
            $archive_link = get_post_type_archive_link('portfolio');
        }
        ?>
        <ul>
        <?php foreach($terms as $term){ ?>
            <li class="cat-item cat-item-<?php echo esc_attr($term->term_id) ?>">
                <a href="<?php echo esc_url($archive_link.'?p-cat='.$term->slug) ?>">
                <?php
                    echo wp_kses_post($term->name);
                    if($show_post_count=='1'){
                        echo sprintf(' (%s)',$term->count);
                    }
                ?>
                </a>
            </li>
        <?php } ?>
        </ul>
        <?php
        echo wp_kses_post($args['after_widget']);
        $content =  ob_get_clean();
        echo wp_kses_post($content);
        $this->cache_widget( $args, $content );
    }
}

if (!function_exists('g5plus_register_widget_portfolio_category') ) {
    function g5plus_register_widget_portfolio_category() {
        register_widget('G5Plus_Widget_Portfolio_Category');
    }
    add_action('widgets_init', 'g5plus_register_widget_portfolio_category', 1);
}