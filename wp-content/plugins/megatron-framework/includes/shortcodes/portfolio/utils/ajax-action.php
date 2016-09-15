<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/20/15
 * Time: 4:53 PM
 */

add_action("wp_ajax_nopriv_g5plusframework_portfolio_load_more", "g5plusframework_portfolio_load_more");
add_action("wp_ajax_g5plusframework_portfolio_load_more", "g5plusframework_portfolio_load_more");
function g5plusframework_portfolio_load_more()
{
    $current_page = $_REQUEST['current_page'];
    $offset = $_REQUEST['offset'];
    $category = $_REQUEST['category'];
    $portfolioIds = $_REQUEST['portfolioIds'];
    $dataSource = $_REQUEST['dataSource'];
    $posts_per_page = $_REQUEST['postsPerPage'];
    $layout_type = $_REQUEST['layoutType'];
    $overlay_style = $_REQUEST['overlayStyle'];
    $column = $_REQUEST['columns'];
    $padding = $_REQUEST['colPadding'];
    $order = $_REQUEST['order'];
    $image_size = $_REQUEST['imageSize'];
    $short_code = sprintf('[g5plusframework_portfolio show_category=""  column="%s" column_masonry="%s" item="%s" show_pagging="1" show_pagging_masonry="1" overlay_style="%s" layout_type="%s" padding="%s" current_page="%s" order="%s" data_source="%s" category="%s" portfolio_ids ="%s" item="%s" image_size="%s"]', $column, $column, $posts_per_page, $overlay_style, $layout_type, $padding, $current_page, $order, $dataSource, $category, $portfolioIds, $posts_per_page, $image_size);
    echo do_shortcode($short_code);
    die();
}

add_action("wp_ajax_nopriv_g5plusframework_portfolio_load_by_category", "g5plusframework_portfolio_load_by_category");
add_action("wp_ajax_g5plusframework_portfolio_load_by_category", "g5plusframework_portfolio_load_by_category");
function g5plusframework_portfolio_load_by_category()
{
    $current_page = $_REQUEST['current_page'];
    $overlay_style = $_REQUEST['overlay_style'];
    $dataSource = $_REQUEST['data_source'];
    $dataSectionId = $_REQUEST['data_section_id'];
    $show_paging = $_REQUEST['data_show_paging'];
    $show_paging_masonry = $_REQUEST['data_show_paging_masonry'];
    $portfolioIds = $_REQUEST['portfolioIds'];
    $posts_per_page = $_REQUEST['postsPerPage'];
    $layout_type = $_REQUEST['layoutType'];
    $column = $_REQUEST['columns'];
    $padding = $_REQUEST['colPadding'];
    $category = array_key_exists('category',$_REQUEST) ? $_REQUEST['category'] : '' ;
    $order = $_REQUEST['order'];
    $bg_overlay = $_REQUEST['bg_overlay'];
    $bg_effect_overlay = $_REQUEST['bg_effect_overlay'];
    $data_responsive = $_REQUEST['data_responsive'];
    $data_table_item = $_REQUEST['data_table_item'];
    $data_small_table_item = $_REQUEST['data_small_table_item'];
    $image_size = $_REQUEST['imageSize'];

    $short_code = sprintf('[g5plusframework_portfolio category="%s" column="%s" item="%s" show_pagging="%s" layout_type="%s" padding="%s" current_page="%s"
                            order="%s" data_source="%s" portfolio_ids ="%s" ajax_load="1" overlay_style="%s" data_section_id="%s" overlay_effect="%s"
                            overlay_bg="%s" responsive="%s"  table_item="%s" small_table_item="%s" show_pagging_masonry="%s" image_size="%s"]',
                            $category, $column, $posts_per_page, $show_paging, $layout_type, $padding, $current_page, $order,
                            $dataSource, $portfolioIds,  $overlay_style, $dataSectionId, $bg_effect_overlay, $bg_overlay, $data_responsive, $data_table_item,
                            $data_small_table_item, $show_paging_masonry, $image_size);
    error_log($short_code);
    echo do_shortcode($short_code);
    die();
}

add_action("wp_ajax_nopriv_g5plus_framework_portfolio_search", "g5plus_framework_portfolio_search");
add_action("wp_ajax_g5plus_framework_portfolio_search", "g5plus_framework_portfolio_search");

function g5plus_framework_portfolio_search()
{

    function g5plus_framework_portfolio_search_title_filter($where, &$wp_query)
    {
        global $wpdb;
        if ($keyword = $wp_query->get('search_prod_title')) {
            $where .= ' AND ((' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like($keyword) . '%\'))';
        }
        return $where;
    }

    $keyword = $_REQUEST['keyword'];
    if ($keyword) {
        $search_query = array(
            'search_prod_title' => $keyword,
            'order' => 'DESC',
            'orderby' => 'date',
            'post_status' => 'publish',
            'post_type' => array('portfolio'),
            'nopaging' => true,
        );
        add_filter('posts_where', 'g5plus_framework_portfolio_search_title_filter', 10, 2);
        $search = new WP_Query($search_query);
        remove_filter('posts_where', 'g5plus_framework_portfolio_search_title_filter', 10, 2);

        $new_data = array();
        if ($search && isset($search->post) && count($search->post) > 0) {
            foreach ($search->posts as $post) {
                $new_data[] = array(
                    'id' => $post->ID,
                    'title' => $post->post_title,
                    'date' => mysql2date('M d Y', $post->post_date)
                );
            }
        } else {
            $new_data[] = array(
                'id' => -1,
                'title' => esc_html__('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'g5plus-megatron'),
                'date' => null
            );
        }
        wp_reset_postdata();
        echo json_encode($new_data);
    }
    die(); // this is required to return a proper result
}
