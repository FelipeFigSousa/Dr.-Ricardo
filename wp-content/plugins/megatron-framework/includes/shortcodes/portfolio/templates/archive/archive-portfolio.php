<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 7/23/15
 * Time: 9:28 PM
 */
$g5plus_options = &megatron_get_options_config();

get_header();

$portfolio_post_type = 'portfolio';
$post_types = get_post_type();
$cat = get_queried_object();

$layout_style = isset($_GET['layout']) ? $_GET['layout'] : '';
if (!in_array($layout_style, array('full', 'container', 'container-fluid'))) {
    $layout_style = isset($g5plus_options['portfolio_archive_layout']) ? $g5plus_options['portfolio_archive_layout'] : '';
}

$sidebar = isset($_GET['sidebar']) ? $_GET['sidebar'] : '';
if (!in_array($sidebar, array('none', 'left', 'right', 'both'))) {
    $sidebar = isset($g5plus_options['portfolio_archive_sidebar']) ? $g5plus_options['portfolio_archive_sidebar'] : '';
}


$sidebar_width = isset($_GET['sidebar_width']) ? $_GET['sidebar_width'] : '';
if (!in_array($sidebar_width, array('small', 'large'))) {
    $sidebar_width = isset($g5plus_options['portfolio_archive_sidebar_width']) ? $g5plus_options['portfolio_archive_sidebar_width'] : '';
}
$left_sidebar = isset($g5plus_options['portfolio_archive_left_sidebar']) ? $g5plus_options['portfolio_archive_left_sidebar'] : '';
$right_sidebar = isset($g5plus_options['portfolio_archive_right_sidebar']) ? $g5plus_options['portfolio_archive_right_sidebar'] : '';

$sidebar_col = 'col-md-3';
if ($sidebar_width == 'large') {
    $sidebar_col = 'col-md-4';
}

$content_col_number = 12;
if (is_active_sidebar($left_sidebar) && (($sidebar == 'both') || ($sidebar == 'left'))) {
    if ($sidebar_width == 'large') {
        $content_col_number -= 4;
    } else {
        $content_col_number -= 3;
    }
}
if (is_active_sidebar($right_sidebar) && (($sidebar == 'both') || ($sidebar == 'right'))) {
    if ($sidebar_width == 'large') {
        $content_col_number -= 4;
    } else {
        $content_col_number -= 3;
    }
}

$content_col = 'col-md-' . $content_col_number;
if (($content_col_number == 12) && ($layout_style == 'full')) {
    $content_col = '';
}

$blog_class = array('blog-inner', 'clearfix');
$blog_wrap_class = array('blog-wrap');

do_action('g5plus_before_archive');
$query_obj = get_queried_object();

$cat_name = isset($query_obj) && isset($query_obj->labels) ? $query_obj->labels->name : '';
$portfolio_archive_layout = isset($_GET['layout']) ? $_GET['layout'] : '';
if (!in_array($portfolio_archive_layout, array('full', 'container', 'container-fluid'))) {
    $portfolio_archive_layout = isset($g5plus_options['portfolio_archive_layout']) ? $g5plus_options['portfolio_archive_layout'] : '';
}
$portfolio_archive_sidebar = isset($_GET['sidebar']) ? $_GET['sidebar'] : '';
if (!in_array($portfolio_archive_sidebar, array('none', 'left', 'right', 'both'))) {
    $portfolio_archive_sidebar = isset($g5plus_options['portfolio_archive_sidebar']) ? $g5plus_options['portfolio_archive_sidebar'] : '';
}
$portfolio_archive_sidebar_width = isset($_GET['sidebar_width']) ? $_GET['sidebar_width'] : '';
if (!in_array($portfolio_archive_sidebar_width, array('small', 'large'))) {
    $portfolio_archive_sidebar_width = isset($g5plus_options['portfolio_archive_sidebar_width']) ? $g5plus_options['portfolio_archive_sidebar_width'] : '';
}
$portfolio_archive_left_sidebar = $g5plus_options['portfolio_archive_left_sidebar'];
$portfolio_archive_right_sidebar = isset($g5plus_options['portfolio_archive_sidebar_width']) ? $g5plus_options['portfolio_archive_sidebar_width'] : '';

$portfolio_archive_item_column = $portfolio_archive_item_masonry_column = isset($_GET['columns']) ? $_GET['columns'] : '';
if (!in_array($portfolio_archive_item_column, array('2', '3', '4', '5', '6'))) {
    $portfolio_archive_item_column = isset($g5plus_options['portfolio_archive_item_column']) ? $g5plus_options['portfolio_archive_item_column'] : '';
    $portfolio_archive_item_masonry_column = isset($g5plus_options['portfolio_archive_item_masonry_column']) ? $g5plus_options['portfolio_archive_item_masonry_column'] : '';
}

$portfolio_archive_item_style = isset($g5plus_options['portfolio_archive_item_style']) ? $g5plus_options['portfolio_archive_item_style'] : '';
$portfolio_archive_padding_item = isset($g5plus_options['portfolio_archive_padding_item']) ? $g5plus_options['portfolio_archive_padding_item'] : '';
$portfolio_archive_item_per_page = isset($g5plus_options['portfolio_archive_item_per_page']) ? $g5plus_options['portfolio_archive_item_per_page'] : '';
$portfolio_archive_padding_item = isset($g5plus_options['portfolio_archive_padding_item']) ? $g5plus_options['portfolio_archive_padding_item'] : '';
$portfolio_archive_item_image_size = isset($g5plus_options['portfolio_archive_item_image_size']) ? $g5plus_options['portfolio_archive_item_image_size'] : '';
$portfolio_archive_overlay = isset($g5plus_options['portfolio_archive_overlay']) ? $g5plus_options['portfolio_archive_overlay'] : '';
$portfolio_archive_overlay_effect =  isset($g5plus_options['portfolio_archive_overlay_effect']) ? $g5plus_options['portfolio_archive_overlay_effect'] : 'hover-dir';
$portfolio_archive_filter = isset($g5plus_options['portfolio_archive_filter']) ? $g5plus_options['portfolio_archive_filter'] : 'ajax';
$portfolio_archive_css = isset($g5plus_options['portfolio_archive_css']) ? $g5plus_options['portfolio_archive_css'] : '';
$portfolio_archive_category_on_top = isset($g5plus_options['portfolio_archive_category_on_top']) ? $g5plus_options['portfolio_archive_category_on_top'] : '';
$show_category = '';
if(isset($g5plus_options['portfolio_archive_category_on_top'])&& $g5plus_options['portfolio_archive_category_on_top']=='1'){
    $show_category = 'center';
}

?>

    <main class="site-content-archive <?php echo esc_attr($portfolio_archive_css) ?>">
        <?php if ($layout_style != 'full'): ?>
        <div class="<?php echo esc_attr($layout_style) ?> clearfix">
            <?php endif; ?>
            <?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
            <div class="row clearfix">
                <?php endif; ?>
                <?php if (is_active_sidebar($left_sidebar) && (($sidebar == 'left') || ($sidebar == 'both'))): ?>
                    <div
                        class="sidebar left-sidebar <?php echo esc_attr($sidebar_col) ?> hidden-sm hidden-xs sidebar-<?php echo esc_attr($sidebar_width); ?>">
                        <?php dynamic_sidebar($left_sidebar); ?>
                    </div>
                <?php endif; ?>
                <div class="site-content-archive-inner <?php echo esc_attr($content_col) ?>">

                    <?php
                    $short_code = sprintf('[g5plusframework_portfolio  show_category="%s" column="%s" column_masonry="%s" item="%s" order="DESC" show_pagging="1" show_pagging_masonry="1"
                                    padding="%s" image_size="%s" overlay_style="%s" layout_type="%s"
                                    category="" overlay_effect="%s" tab_category_action ="%s"]',
                        $show_category,
                        $portfolio_archive_item_column,
                        $portfolio_archive_item_masonry_column,
                        $portfolio_archive_item_per_page,
                        $portfolio_archive_padding_item,
                        $portfolio_archive_item_image_size,
                        $portfolio_archive_overlay,
                        $portfolio_archive_item_style,
                        $portfolio_archive_overlay_effect,
                        $portfolio_archive_filter
                    );
                    echo do_shortcode($short_code);
                    ?>

                </div>
                <?php if (is_active_sidebar($right_sidebar) && (($sidebar == 'right') || ($sidebar == 'both'))): ?>
                    <div
                        class="sidebar right-sidebar <?php echo esc_attr($sidebar_col) ?> hidden-sm hidden-xs sidebar-<?php echo esc_attr($sidebar_width); ?>">
                        <?php dynamic_sidebar($right_sidebar); ?>
                    </div>
                <?php endif; ?>
                <?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
            </div>
        <?php endif; ?>
            <?php if ($layout_style != 'full'): ?>
        </div>
    <?php endif; ?>
    </main>
<?php
get_footer();
?>