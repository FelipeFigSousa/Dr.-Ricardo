<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/18/2015
 * Time: 2:07 PM
 */
class G5Plus_Widget_Twitter extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-feeds';
        $this->widget_description =  esc_html__( "Display your latest tweets", 'g5plus-megatron' );
        $this->widget_id          = 'g5plus-twitter';
        $this->widget_name        = esc_html__( 'G5Plus: Twitter', 'g5plus-megatron' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title', 'g5plus-megatron' )
            ),
            'user_name' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'User Name', 'g5plus-megatron' )
            ),
            'consumer_key' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Consumer Key', 'g5plus-megatron' )
            ),
            'consumer_secret' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Consumer Secret', 'g5plus-megatron' )
            ),
            'access_token' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Access Token', 'g5plus-megatron' )
            ),
            'access_token_secret' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Access Token Secret', 'g5plus-megatron' )
            ),
            'time_to_store' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Time To Store', 'g5plus-megatron' )
            ),
            'total_feed' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Total Feed', 'g5plus-megatron' )
            )
        );
        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_twitter', array($this, 'vc_widget'));
        }
        parent::__construct();
    }
    function widget($args, $instance) {

        if ( $this->get_cached_widget( $args ) )
            return;
        require_once('twitter/twitterclient.php');
        extract( $args, EXTR_SKIP );

        $title = (!empty( $instance['title'] ) ) ? $instance['title'] : '';
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $user_name = (!empty( $instance['user_name'] ) ) ? $instance['user_name'] : '';
        $consumer_key = (!empty( $instance['consumer_key'] ) ) ? $instance['consumer_key'] : '';
        $consumer_secret = (!empty( $instance['consumer_secret'] ) ) ? $instance['consumer_secret'] : '';
        $access_token = (!empty( $instance['access_token'] ) ) ? $instance['access_token'] : '';
        $access_token_secret = (!empty( $instance['access_token_secret'] ) ) ? $instance['access_token_secret'] : '';
        $time_to_store = (!empty( $instance['time_to_store'] ) ) ? $instance['time_to_store'] : '';
        $total_feed = (!empty( $instance['total_feed'] ) ) ? $instance['total_feed'] : '';

        $transient_feed_tweet = 'transient_feed_tweet';
        if(!empty($time_to_store) && is_numeric($time_to_store)) {
            $fetchedTweets = get_transient($transient_feed_tweet);
        } else {
            delete_transient($transient_feed_tweet);
        }

        $twitterClient = new TwitterClient(trim($consumer_key), trim($consumer_secret), trim($access_token), trim($access_token_secret));

        if(!isset($fetchedTweets) || !$fetchedTweets){
            $fetchedTweets = $twitterClient->getTweet(trim($user_name),$total_feed);
            if(!empty($time_to_store)  && is_numeric($time_to_store)) {
                set_transient($transient_feed_tweet, $fetchedTweets, 60 * $time_to_store);
            }
        }
        ob_start();
        $limitToDisplay = 0;
        if (!empty($fetchedTweets)) {
            $limitToDisplay = min($total_feed, count($fetchedTweets));
        }
        if ($limitToDisplay > 0) {

            ?>
            <?php echo wp_kses_post($args['before_widget']); ?>
            <?php if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            } ?>
            <?php
            for($i= 0; $i < $limitToDisplay; $i++) {
                $tweet = $fetchedTweets[$i];
                $text = $twitterClient->sanitize_links($tweet);
                $time = $tweet->created_at;
                $time = date_parse($time);
                $uTime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);
                ?>
                <div class="widget-twitter-item">
                    <i class="fa fa-twitter s-color"></i>
                    <div class="twitter-content">
                        <?php echo wp_kses_post($text);?>
                        <span class="twitter-time s-font"><?php $twitterClient->get_the_time($uTime) ?></span>
                    </div>

                </div>
            <?php } ?>


            <?php echo wp_kses_post($args['after_widget']); ?>
        <?php
        }
        $content =  ob_get_clean();
        echo wp_kses_post($content);
        $this->cache_widget( $args, $content );
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_twitter', $atts );
        $args = array();
        $args['widget_id'] = 'g5plus-twitter';
        the_widget('G5Plus_Widget_Twitter',$attributes,$args);
    }
}


if (!function_exists('g5plus_register_widget_twitter')) {
    function g5plus_register_widget_twitter() {
        register_widget('G5Plus_Widget_Twitter');

        if(function_exists('vc_map')){
            vc_map( array(
                'name' => esc_html__( 'G5Plus Twitter', 'g5plus-megatron' ),
                'base' => 'g5plusframework_widget_twitter',
                'icon' => 'fa fa-twitter',
                'category' => esc_html__( 'Megatron Widgets', 'g5plus-megatron' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'Twitter feed for your site', 'g5plus-megatron' ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'g5plus-megatron' ),
                        'param_name' => 'title'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'User name', 'g5plus-megatron' ),
                        'param_name' => 'user_name'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Consumer Key', 'g5plus-megatron' ),
                        'param_name' => 'consumer_key'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Consumer Secret', 'g5plus-megatron' ),
                        'param_name' => 'consumer_secret'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Access Token', 'g5plus-megatron' ),
                        'param_name' => 'access_token'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Access Token Secret', 'g5plus-megatron' ),
                        'param_name' => 'access_token_secret'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Time To Store (cache)', 'g5plus-megatron' ),
                        'param_name' => 'time_to_store'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Total Feed', 'g5plus-megatron' ),
                        'param_name' => 'total_feed'
                    ),
                )
            ) );
        }
    }
    add_action('widgets_init', 'g5plus_register_widget_twitter', 1);
}