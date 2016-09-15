<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/19/15
 * Time: 5:31 PM
 */
$g5plus_options = &megatron_get_options_config();
$p_color = $g5plus_options['primary_color'];

$args = array(
    'offset' => $offset,
    'orderby' =>'post__in',
    'post__in' => explode(",",$portfolio_ids),
    'posts_per_page' => $post_per_page,
    'post_type' => G5PLUS_PORTFOLIO_POST_TYPE,
    'post_status' => 'publish');

if($data_source==''){
    $args = array(
        'offset' => $offset,
        'posts_per_page' => $post_per_page,
        'orderby' => 'post_date',
        'order' => $order,
        'post_type' => G5PLUS_PORTFOLIO_POST_TYPE,
        G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY => strtolower($category),
        'post_status' => 'publish');
}


$posts_array = new WP_Query($args);
$total_post = $posts_array->found_posts;
$paging_style = $show_pagging == 2 ? 'slider' : 'paging';
$data_section_id = uniqid();

$class_wrap = array();
$class_wrap[] = $padding;
$class_wrap[] = $layout_type;
?>
<div
    class="portfolio overflow-hidden <?php echo esc_attr($g5plus_animation . ' ' . $styles_animation . ' ' . $paging_style) ?>"
    id="portfolio-<?php echo esc_attr($data_section_id) ?>">

    <?php if ($show_category != '') { ?>
        <div class="portfolio-tabs <?php echo esc_attr($css_category) ?> <?php if($show_category!=''){ echo 'category ';} if(isset($show_title) && $show_title == 'yes'){ echo ' title';} ?>">
            <?php if (isset($show_title) && $show_title == 'yes') { ?>
                <div class="title-portfolio left s-font">
                    <span><?php echo wp_kses_post($title); ?>&nbsp;</span>
                    <span class="bottom-line p-color-bt"></span>
                </div>
            <?php } ?>

            <?php
            if ($show_category != '') {
                $termIds = array();
                $portfolio_terms = get_terms(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY);
                if ($category != '') {
                    $slugSelected = explode(',', $category);
                    foreach ($portfolio_terms as $term) {
                        if (in_array($term->slug, $slugSelected))
                            $termIds[$term->term_id] = $term->term_id;
                    }
                }
                $array_terms = array(
                    'include' => $termIds
                );
                if($is_archive){
                    $terms = get_terms(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY);
                }else{
                    $terms = get_terms(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY, $array_terms);
                }

                if (count($terms) > 0) {
                    $index = 1;
                    ?>
                    <div
                        class="tab-wrapper line-height-1 <?php echo esc_attr($show_category) ?>">
                        <ul class="magic-line-container">
                            <li class="<?php if($category==''){echo esc_attr('active');} ?> p-color-hover p-font">
                                <a class="isotope-portfolio ladda-button <?php if($category==''){echo esc_attr('active');} ?>"
                                   data-section-id="<?php echo esc_attr($data_section_id) ?>"
                                   data-load-type="<?php echo esc_attr($tab_category_action) ?>"
                                   data-category=""
                                   data-overlay-style="<?php echo esc_attr($overlay_style) ?>"
                                   data-source="<?php echo esc_attr($data_source) ?>"
                                   data-portfolio-ids="<?php echo esc_attr($portfolio_ids) ?>"
                                   data-group="all" data-filter="*"
                                   data-layout-type="<?php echo esc_attr($layout_type) ?>"
                                   data-current-page="1"
                                   data-offset="<?php echo esc_attr($offset) ?>"
                                   data-post-per-page="<?php echo esc_attr($post_per_page) ?>"
                                   data-order="<?php echo esc_attr($order) ?>"
                                   data-column="<?php echo esc_attr($column) ?>"
                                   data-show-paging="<?php echo esc_attr($show_pagging) ?>"
                                   data-show-paging-masonry="<?php echo esc_attr($show_pagging_masonry) ?>"
                                   data-style="zoom-out" data-spinner-color="<?php echo esc_attr($p_color) ?>"
                                   data-bg-overlay = "<?php echo esc_attr($overlay_bg) ?>"
                                   data-effect-overlay = "<?php echo esc_attr($overlay_effect) ?>"
                                   data-responsive = "<?php echo esc_attr($responsive) ?>"
                                   data-table-item = "<?php echo esc_attr($table_item) ?>"
                                   data-small-table-item = "<?php echo esc_attr($small_table_item) ?>"
                                   data-image-size = "<?php echo esc_attr($image_size) ?>"
                                   data-isotope-col-width = ".col-md-3"
                                   href="javascript:;">
                                    <?php echo esc_html__('All projects', 'g5plus-megatron') ?>
                                </a>
                            </li>
                            <?php
                            foreach ($terms as $term) {
                                ?>
                                <li class="p-color-hover p-font <?php if ($index == count($terms)) {
                                    echo "last";
                                } ?> <?php if($category==$term->slug){echo 'active';} ?>">
                                    <a class="isotope-portfolio ladda-button <?php if($category==$term->slug){echo 'active';} ?>"
                                       href="javascript:;" data-section-id="<?php echo esc_attr($data_section_id) ?>"
                                       data-load-type="<?php echo esc_attr($tab_category_action) ?>"
                                       data-category="<?php echo esc_attr($term->slug) ?>"
                                       data-overlay-style="<?php echo esc_attr($overlay_style) ?>"
                                       data-source="<?php echo esc_attr($data_source) ?>"
                                       data-portfolio-ids="<?php echo esc_attr($portfolio_ids) ?>"
                                       data-layout-type="<?php echo esc_attr($layout_type) ?>"
                                       data-current-page="1"
                                       data-offset="<?php echo esc_attr($offset) ?>"
                                       data-post-per-page="<?php echo esc_attr($post_per_page) ?>"
                                       data-column="<?php echo esc_attr($column) ?>"
                                       data-order="<?php echo esc_attr($order) ?>"
                                       data-group="<?php echo preg_replace('/\s+/', '', $term->slug) ?>"
                                       data-show-paging="<?php echo esc_attr($show_pagging) ?>"
                                       data-show-paging-masonry="<?php echo esc_attr($show_pagging_masonry) ?>"
                                       data-filter=".<?php echo esc_attr($term->slug) ?>"
                                       data-style="zoom-out"
                                       data-spinner-color="<?php echo esc_attr($p_color) ?>"
                                       data-bg-overlay = "<?php echo esc_attr($overlay_bg) ?>"
                                       data-effect-overlay = "<?php echo esc_attr($overlay_effect) ?>"
                                       data-responsive = "<?php echo esc_attr($responsive) ?>"
                                       data-table-item = "<?php echo esc_attr($table_item) ?>"
                                       data-small-table-item = "<?php echo esc_attr($small_table_item) ?>"
                                       data-image-size = "<?php echo esc_attr($image_size) ?>"
                                       data-isotope-col-width = ".col-md-3"
                                        >
                                        <?php echo wp_kses_post($term->name) ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="bottom magic-line p-color-bg"></li>
                        </ul>
                        <select class="mobile-category">
                            <option value=""
                                    data-section-id="<?php echo esc_attr($data_section_id) ?>"
                                    data-load-type="<?php echo esc_attr($tab_category_action) ?>"
                                    data-category=""
                                    data-overlay-style="<?php echo esc_attr($overlay_style) ?>"
                                    data-source="<?php echo esc_attr($data_source) ?>"
                                    data-portfolio-ids="<?php echo esc_attr($portfolio_ids) ?>"
                                    data-group="all" data-filter="*"
                                    data-layout-type="<?php echo esc_attr($layout_type) ?>"
                                    data-current-page="1"
                                    data-offset="<?php echo esc_attr($offset) ?>"
                                    data-post-per-page="<?php echo esc_attr($post_per_page) ?>"
                                    data-order="<?php echo esc_attr($order) ?>"
                                    data-column="<?php echo esc_attr($column) ?>"
                                    data-show-paging="<?php echo esc_attr($show_pagging) ?>"
                                    data-show-paging-masonry="<?php echo esc_attr($show_pagging_masonry) ?>"
                                    data-style="zoom-out" data-spinner-color="<?php echo esc_attr($p_color) ?>"
                                    data-bg-overlay = "<?php echo esc_attr($overlay_bg) ?>"
                                    data-effect-overlay = "<?php echo esc_attr($overlay_effect) ?>"
                                    data-responsive = "<?php echo esc_attr($responsive) ?>"
                                    data-table-item = "<?php echo esc_attr($table_item) ?>"
                                    data-small-table-item = "<?php echo esc_attr($small_table_item) ?>"
                                    data-image-size = "<?php echo esc_attr($image_size) ?>"
                                    data-isotope-col-width = ".col-md-3"
                                    <?php if($category==''){echo 'selected';} ?>"
                                ><?php echo esc_html__('All projects', 'g5plus-megatron')?>
                            </option>
                            <?php foreach ($terms as $term) { ?>
                                <option value=""
                                        data-section-id="<?php echo esc_attr($data_section_id) ?>"
                                        data-load-type="<?php echo esc_attr($tab_category_action) ?>"
                                        data-category="<?php echo esc_attr($term->slug) ?>"
                                        data-overlay-style="<?php echo esc_attr($overlay_style) ?>"
                                        data-source="<?php echo esc_attr($data_source) ?>"
                                        data-portfolio-ids="<?php echo esc_attr($portfolio_ids) ?>"
                                        data-layout-type="<?php echo esc_attr($layout_type) ?>"
                                        data-current-page="1"
                                        data-offset="<?php echo esc_attr($offset) ?>"
                                        data-post-per-page="<?php echo esc_attr($post_per_page) ?>"
                                        data-column="<?php echo esc_attr($column) ?>"
                                        data-order="<?php echo esc_attr($order) ?>"
                                        data-group="<?php echo preg_replace('/\s+/', '', $term->slug) ?>"
                                        data-show-paging="<?php echo esc_attr($show_pagging) ?>"
                                        data-show-paging-masonry="<?php echo esc_attr($show_pagging_masonry) ?>"
                                        data-filter=".<?php echo esc_attr($term->slug) ?>"
                                        data-style="zoom-out"
                                        data-spinner-color="<?php echo esc_attr($p_color) ?>"
                                        data-bg-overlay = "<?php echo esc_attr($overlay_bg) ?>"
                                        data-effect-overlay = "<?php echo esc_attr($overlay_effect) ?>"
                                        data-responsive = "<?php echo esc_attr($responsive) ?>"
                                        data-table-item = "<?php echo esc_attr($table_item) ?>"
                                        data-small-table-item = "<?php echo esc_attr($small_table_item) ?>"
                                        data-image-size = "<?php echo esc_attr($image_size) ?>"
                                        data-isotope-col-width = ".col-md-3"
                                        <?php if($category==$term->slug){echo 'selected';} ?>"
                                    ><?php echo wp_kses_post($term->name) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                <?php
                }
            }
            ?>
        </div>
    <?php } ?>

    <div class="portfolio-wrapper <?php echo implode(' ', $class_wrap) ?>>" data-columns="<?php echo esc_attr($column) ?>"
         data-section-id="<?php echo esc_attr($data_section_id) ?>"
         id="portfolio-container-<?php echo esc_attr($data_section_id) ?>"
        >
        <?php
        $index = 0;

        while ($posts_array->have_posts()) : $posts_array->the_post();
            $index++;
            $permalink = get_permalink();
            $title_post = get_the_title();
            $terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY));
            $cat = $cat_filter = '';
            foreach ($terms as $term) {
                $cat_filter .= $term->slug . ' ';
                $cat .= $term->name . ', ';
            }
            $cat = rtrim($cat, ', ');

            ?>

            <?php
                $layout_template = plugin_dir_path(__FILE__) . '/loop/one-page-item.php';
                if(file_exists($layout_template)){
                    include($layout_template);
                }
            ?>
        <?php
        endwhile;
        wp_reset_postdata();
        ?>

    </div>

    <?php if ($show_pagging == '1' && $post_per_page > 0 && $total_post / $post_per_page > 1 && $total_post > ($post_per_page * $current_page)) { ?>
        <div style="clear: both"></div>
        <div class="paging" id="load-more-<?php echo esc_attr($data_section_id) ?>">
            <a href="javascript:;" class="p-font load-more"
               data-source="<?php echo esc_attr($data_source) ?>"
               data-tab-category-action="<?php echo esc_attr($tab_category_action) ?>"
               data-load-type="<?php echo esc_attr($tab_category_action) ?>"
               data-overlay-style="<?php echo esc_attr($overlay_style) ?>"
               data-category="<?php echo esc_attr($category) ?>"
               data-portfolio-ids="<?php echo esc_attr($portfolio_ids) ?>"
               data-section-id="<?php echo esc_attr($data_section_id) ?>"
               data-current-page="<?php echo esc_attr($current_page + 1) ?>"
               data-column="<?php echo esc_attr($column); ?>"
               data-offset="<?php echo esc_attr($offset) ?>"
               data-current-page="<?php echo esc_attr($current_page) ?>"
               data-post-per-page="<?php echo esc_attr($post_per_page) ?>"
               data-show-paging="<?php echo esc_attr($show_pagging) ?>"
               data-show-paging-masonry="<?php echo esc_attr($show_pagging_masonry) ?>"
               data-padding="<?php echo esc_attr($padding) ?>"
               data-layout-type="<?php echo esc_attr($layout_type) ?>"
               data-bg-overlay = "<?php echo esc_attr($overlay_bg) ?>"
               data-effect-overlay = "<?php echo esc_attr($overlay_effect) ?>"
               data-responsive = "<?php echo esc_attr($responsive) ?>"
               data-table-item = "<?php echo esc_attr($table_item) ?>"
               data-small-table-item = "<?php echo esc_attr($small_table_item) ?>"
               data-order="<?php echo esc_attr($order) ?>"
               data-style="zoom-out" data-spinner-color="<?php echo esc_attr($p_color) ?>"
               data-image-size = "<?php echo esc_attr($image_size) ?>"
                ><?php esc_html_e('Load more', 'g5plus-megatron') ?></a>
        </div>
    <?php } ?>

</div>

<?php if (isset($ajax_load) && $ajax_load == '0') { ?>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            <?php if($show_pagging!='2') {?>
            $(document).ready(function () {
                <?php if(isset($tab_category_action) && $tab_category_action=='filter') { ?>
                var $tab_container = jQuery('#portfolio-<?php echo esc_attr($data_section_id); ?>');
                $('.portfolio-tabs .isotope-portfolio', $tab_container).off();
                $('.portfolio-tabs .isotope-portfolio', $tab_container).click(function () {
                    $('.portfolio-tabs .isotope-portfolio', $tab_container).removeClass('active');
                    $('.portfolio-tabs li', $tab_container).removeClass('active');
                    $(this).addClass('active');
                    $(this).parent().addClass('active');
                    var dataSectionId = $(this).attr('data-section-id');
                    var filter = $(this).attr('data-filter');
                    var $container = jQuery('div[data-section-id="' + dataSectionId + '"]').isotope({ filter: filter}).isotope('layout');
                });
                var $container = jQuery('div[data-section-id="<?php echo esc_attr($data_section_id); ?>"]');
                $container.imagesLoaded(function () {
                    $container.isotope({
                        itemSelector: '.portfolio-item',
                        percentPosition: true,
                        masonry: {
                            columnWidth: '.col-md-3'
                        }
                    });
                });
                $(window).resize(function(){
                    var $window_width = $(window).width();
                    var $masonry_col_width = '.col-md-3';
                    if($window_width >=600 && $window_width <=991 ){
                        $masonry_col_width = '.col-sm-6';
                    }
                    if($window_width <600){
                        $masonry_col_width = '.col-xs-12';
                    }
                    $container.isotope({
                        masonry: { columnWidth: $masonry_col_width }
                    });
                });
                <?php } ?>
            });

            <?php } ?>

            $(document).ready(function () {

                $('.portfolio-item.hover-dir > div.thumb-wrap').hoverdir();

                PortfolioAjaxAction.init('<?php echo esc_url(get_site_url() . '/wp-admin/admin-ajax.php') ?>', '<?php echo esc_attr($tab_category_action) ?>', '<?php echo esc_attr($data_section_id)?>');
            })

        })(jQuery);
    </script>
<?php } ?>


