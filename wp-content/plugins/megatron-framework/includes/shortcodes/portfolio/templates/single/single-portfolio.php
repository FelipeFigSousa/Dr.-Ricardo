<?php
get_header();

if (!function_exists('g5plus_portfolio_nav')) {
    function g5plus_portfolio_nav() {
        include(plugin_dir_path( __FILE__ ).'/portfolio-nav.php');
    }
    add_action('g5plus_after_single_portfolio_content','g5plus_portfolio_nav',1);
}

$g5plus_options = &megatron_get_options_config();
$min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
wp_enqueue_style('megatron-portfolio-css', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/css/portfolio'.$min_suffix.'.css', array(),false);
wp_enqueue_style('megatron-portfolio-single-css', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/css/portfolio-single.css', array(),false);
wp_enqueue_script('megatron-hoverdir', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/js/hoverdir/jquery.hoverdir.js', false, true);
wp_enqueue_script('megatron-portfolio-single', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/js/single' . $min_suffix . '.js', false, true);

if ( have_posts() ) {
    // Start the Loop.
    while ( have_posts() ) : the_post();
        $post_id = get_the_ID();
        $categories = get_the_terms($post_id, G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY);
        $client = get_post_meta($post_id, 'portfolio-client', true );
        $client_site = get_post_meta($post_id, 'portfolio-client-site', true );
        $location = get_post_meta($post_id, 'portfolio-location', true );
        $tags = get_the_terms( $post_id, 'post_tag');
        $meta_values = get_post_meta( get_the_ID(), 'portfolio-format-gallery', false );
        $imgThumbs = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $cat = '';
        $arrCatId = array();
        if($categories){
            foreach($categories as $category) {
                $cat .= $category->name.', ';
                $arrCatId[count($arrCatId)] = $category->term_id;
            }
            $cat = trim($cat, ', ');
        }
        $detail_style =  get_post_meta(get_the_ID(),'portfolio_detail_style',true);
        if (!isset($detail_style) || $detail_style == 'none' || $detail_style == '') {
            $detail_style = $g5plus_options['portfolio-single-style'];
        }

        $detail_template = plugin_dir_path( __FILE__ ).'/'.$detail_style.'.php';
        if(file_exists($detail_template)){
            include($detail_template);
        }
    endwhile;
    }
?>

<?php
    $portfolio_detail_bottom_sidebar = $g5plus_options['portfolio_detail_bottom_sidebar'];
    if(is_active_sidebar($portfolio_detail_bottom_sidebar)) {
        dynamic_sidebar($portfolio_detail_bottom_sidebar);
    }
?>

<script type="text/javascript">
    (function($) {
        $(document).ready(function(){
            if(typeof PortfolioSingle !='undefined'){
                setTimeout(function(){
                    PortfolioSingle.init();
                },500);
            }
        })
    })(jQuery);
</script>

<?php get_footer(); ?>
