<?php
if (!defined('ABSPATH')) die('-1');

if (!defined('G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY'))
    define('G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY', 'portfolio-category');

if (!defined('G5PLUS_PORTFOLIO_POST_TYPE'))
    define('G5PLUS_PORTFOLIO_POST_TYPE', 'portfolio');

if (!defined('G5PLUS_PORTFOLIO_DIR_PATH'))
    define('G5PLUS_PORTFOLIO_DIR_PATH', plugin_dir_path(__FILE__));

include_once(plugin_dir_path(__FILE__) . 'metaboxes/spec.php');
if (!class_exists('G5PlusFramework_Portfolio')) {
    class G5PlusFramework_Portfolio
    {
        function __construct()
        {
	        $g5plus_options = &megatron_get_options_config();
            $enable_single_style = isset($g5plus_options['portfolio-single-style-enable']) && $g5plus_options['portfolio-single-style-enable']=='0' ? false : true;
            add_action('init', array($this, 'register_taxonomies'), 5);
            add_action('init', array($this, 'register_post_types'), 6);
            add_action( 'init', array($this, 'register_tag_taxonomies'),7 );
            add_shortcode('g5plusframework_portfolio', array($this, 'portfolio_shortcode'));
            add_filter('rwmb_meta_boxes', array($this, 'register_meta_boxes'));
            if($enable_single_style){
                add_filter('single_template', array($this, 'get_portfolio_single_template'));
            }
            add_filter('archive_template',array($this,'get_portfolio_archive_template' ) );

            if (is_admin()) {
                add_filter('manage_edit-' . G5PLUS_PORTFOLIO_POST_TYPE . '_columns', array($this, 'add_portfolios_columns'));
                add_action('manage_' . G5PLUS_PORTFOLIO_POST_TYPE . '_posts_custom_column', array($this, 'set_portfolios_columns_value'), 10, 2);
                add_action('restrict_manage_posts', array($this, 'portfolio_manage_posts'));
                add_filter('parse_query', array($this, 'convert_taxonomy_term_in_query'));
                add_action('admin_menu', array($this, 'addMenuChangeSlug'));
            }
            $this->includes();

        }

        function front_scripts()
        {
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron-portfolio-css', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/css/portfolio'.$min_suffix.'.css', array(),false);
            wp_enqueue_style('megatron-ladda-css', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/js/ladda/dist/ladda-themeless.min.css', array(),false);
            wp_enqueue_script('megatron-ladda-spin', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/js/ladda/dist/spin.min.js', false, true);
            wp_enqueue_script('megatron-ladda', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/js/ladda/dist/ladda.min.js', false, true);
            wp_enqueue_script('megatron-hoverdir', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/js/hoverdir/jquery.hoverdir.js', false, true);
            wp_enqueue_script('megatron-portfolio-ajax-action', plugins_url() . '/megatron-framework/includes/shortcodes/portfolio/assets/js/ajax-action' . $min_suffix . '.js', false, true);
        }

        function register_post_types()
        {

            $post_type = G5PLUS_PORTFOLIO_POST_TYPE;

            if (post_type_exists($post_type)) {
                return;
            }

            $post_type_slug = get_option('g5plus-megatron-' . $post_type . '-config');
            if (!isset($post_type_slug) || !is_array($post_type_slug)) {
                $slug = 'portfolio';
                $name = $singular_name = 'Portfolio';
            } else {
                $slug = $post_type_slug['slug'];
                $name = $post_type_slug['name'];
                $singular_name = $post_type_slug['singular_name'];
            }

            register_post_type($post_type,
                array(
                    'label' => esc_html__('Portfolio', 'g5plus-megatron'),
                    'description' => esc_html__('Portfolio Description', 'g5plus-megatron'),
                    'labels' => array(
                        'name' => $name,
                        'singular_name' => $singular_name,
                        'menu_name' => $name,
                        'parent_item_colon' => esc_html__('Parent Item:', 'g5plus-megatron'),
                        'all_items' => sprintf(esc_html__('All %s', 'g5plus-megatron'), $name),
                        'view_item' => esc_html__('View Item', 'g5plus-megatron'),
                        'add_new_item' => sprintf(esc_html__('Add New  %s', 'g5plus-megatron'), $name),
                        'add_new' => esc_html__('Add New', 'g5plus-megatron'),
                        'edit_item' => esc_html__('Edit Item', 'g5plus-megatron'),
                        'update_item' => esc_html__('Update Item', 'g5plus-megatron'),
                        'search_items' => esc_html__('Search Item', 'g5plus-megatron'),
                        'not_found' => esc_html__('Not found', 'g5plus-megatron'),
                        'not_found_in_trash' => esc_html__('Not found in Trash', 'g5plus-megatron'),
                    ),
                    'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
                    'public' => true,
                    'show_ui' => true,
                    '_builtin' => false,
                    'has_archive' => true,
                    'menu_icon' => 'dashicons-screenoptions',
                    'rewrite' => array('slug' => $slug, 'with_front' => true),
                )
            );
            flush_rewrite_rules();
        }

        function register_tag_taxonomies() {
            register_taxonomy_for_object_type( 'post_tag', G5PLUS_PORTFOLIO_POST_TYPE );
        }

        function register_taxonomies()
        {
            if (taxonomy_exists(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY)) {
                return;
            }

            $post_type = G5PLUS_PORTFOLIO_POST_TYPE;
            $taxonomy_slug = G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY;
            $taxonomy_name = 'Portfolio Categories';

            $post_type_slug = get_option('g5plus-megatron-' . $post_type . '-config');
            if (isset($post_type_slug) && is_array($post_type_slug) &&
                array_key_exists('taxonomy_slug', $post_type_slug) && $post_type_slug['taxonomy_slug'] != ''
            ) {
                $taxonomy_slug = $post_type_slug['taxonomy_slug'];
                $taxonomy_name = $post_type_slug['taxonomy_name'];
            }
            register_taxonomy(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY, G5PLUS_PORTFOLIO_POST_TYPE,
                array('hierarchical' => true,
                    'label' => $taxonomy_name,
                    'query_var' => true,
                    'rewrite' => array('slug' => $taxonomy_slug))
            );
            flush_rewrite_rules();
        }

        function portfolio_shortcode($atts)
        {
            $this->front_scripts();
            $css_category = $responsive = $table_item = $small_table_item = $overlay_bg = $overlay_effect = $data_section_id = $tab_category_action = $show_title = $data_source = $menu_social = $portfolio_ids = $order = $title = $subtitle = $overlay_align = $column_masonry = $image_size = $layout_type = $show_title = $offset = $current_page = $overlay_style = $show_pagging_masonry = $show_pagging = $show_category = $category = $column = $item = $padding = $layout_type = $el_class = $g5plus_animation = $css_animation = $duration = $delay = $styles_animation = '';
            $is_archive = false;
            extract(shortcode_atts(array(
                'layout_type' => 'grid',
                'show_title' => '',
                'title' => '',
                'subtitle' => '',
                'data_source' => '',
                'show_pagging' => '',
                'show_pagging_masonry' => '',
                'show_category' => '',
                'tab_category_action' => 'filter',
                'css_category' => '',
                'category' => '',
                'portfolio_ids' => '',
                'column' => '2',
                'column_masonry' => '3',
                'item' => '',
                'order' => 'DESC',
                'padding' => 'no-padding',
                'image_size' => '585x585',
                'schema_style' => '',
                'overlay_effect' => 'hover-dir',
                'overlay_bg' => 'bg-overlay-ps',
                'overlay_style' => 'title',
                'responsive' => '',
                'table_item' => 'table-one',
                'small_table_item' => 'small-table-one',
                'el_class' => '',
                'css_animation' => '',
                'duration' => '',
                'delay' => '',
                'current_page' => '1',
                'ajax_load' => '0',
                'data_section_id' => ''
            ), $atts));
            if ($show_pagging == '2' || $item=='') {
                $offset = 0;
                $post_per_page = -1;
            } else {
                $post_per_page = $item;
                $offset = ($current_page - 1) * $item;
            }
            $overlay_align = $overlay_style == 'left-title-excerpt-link' ? 'hover-align-left' : 'hover-align-center';
            $overlay_effect = $overlay_style == 'icon' ? 'hover-dir' : $overlay_effect;

            if(array_key_exists('p-cat',$_REQUEST)){
                $category = $_REQUEST['p-cat'];
                $is_archive = true;
            }

            $g5plus_animation .= ' ' . esc_attr($el_class);
            $g5plus_animation .= g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $styles_animation = g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay);
            if ($layout_type == 'masonry' || $layout_type == 'masonry-style-02'
                || $layout_type == 'masonry-style-03' || $layout_type == 'masonry-style-04'
                || $layout_type == 'masonry-classic') {
                $column = $column_masonry;
                $show_pagging = $show_pagging_masonry;
            }
            if ($layout_type == 'one-page' || $layout_type == 'left-menu' || $layout_type == 'masonry-style-05'){
                $show_pagging = $show_pagging_masonry;
            }
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = '';
            switch ($layout_type) {
                case 'one-page':
                {
                    $template_path = $plugin_path . '/templates/listing-onepage.php';
                    break;
                }
                case 'left-menu':{
                    $column = 4;
                    $template_path = $plugin_path . '/templates/listing-left-menu.php';
                    break;
                }
                case 'masonry-style-05':
                case 'masonry-home-portfolio':{
                    $column = 4;
                    $template_path = $plugin_path . '/templates/listing-masonry-style-02.php';
                    break;
                }
                case 'masonry-style-03':
                case 'masonry-style-04':
                case 'masonry-style-02':
                {
                    $column = 3;
                    $template_path = $plugin_path . '/templates/listing-masonry-style-02.php';
                    break;
                }
                case 'masonry-classic':
                {
                    $column = 4;
                    $template_path = $plugin_path . '/templates/listing.php';
                    break;
                }
                case 'short-desc':
                {
                    $column = 1;
                    $template_path = $plugin_path . '/templates/listing.php';
                    break;
                }
                default:
                {
                    $template_path = $plugin_path . '/templates/listing.php';
                }
            }
            ob_start();
            if(file_exists($template_path)){
                include($template_path);
            }
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        function register_meta_boxes($meta_boxes)
        {
            $meta_boxes[] = array(
                'title' => esc_html__('Portfolio Extra', 'g5plus-megatron'),
                'id' => 'megatron-meta-box-portfolio-format-gallery',
                'pages' => array(G5PLUS_PORTFOLIO_POST_TYPE),
                'fields' => array(
                    array(
                        'name' => esc_html__('Link to detail', 'g5plus-megatron'),
                        'id' => 'portfolio-link',
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Client', 'g5plus-megatron'),
                        'id' => 'portfolio-client',
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Client Site', 'g5plus-megatron'),
                        'id' => 'portfolio-client-site',
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Gallery', 'g5plus-megatron'),
                        'id' => 'portfolio-format-gallery',
                        'type' => 'image_advanced',
                    ),
                    array(
                        'name'     => esc_html__( 'View Detail Style', 'g5plus-megatron' ),
                        'id'       => 'portfolio_detail_style',
                        'type'     => 'select',
                        'options'  => array(
                            'none' => esc_html__('Inherit from theme options','g5plus-megatron'),
                            'detail-01' 	=> esc_html__( 'Horizontal slide', 'g5plus-megatron' ),
                            'detail-02' 	=> esc_html__( 'Vertical slide', 'g5plus-megatron' ),
                            'detail-03' 	=> esc_html__( 'Small slide', 'g5plus-megatron' ),
                            'detail-04' 	=> esc_html__( 'Big Slide', 'g5plus-megatron' ),
                            'detail-05' 	=> esc_html__( 'Center Gallery small', 'g5plus-megatron'),
                            'detail-06' 	=> esc_html__( 'Right Gallery small', 'g5plus-megatron'),
                            'detail-07' 	=> esc_html__( 'Full content', 'g5plus-megatron'),
                            ),
                        'multiple'    => false,
                        'std'         => 'none',
                    )
                )
            );
            return $meta_boxes;
        }

        function get_portfolio_single_template($single)
        {
            global $post;
            /* Checks for single template by post type */
            if ($post->post_type == G5PLUS_PORTFOLIO_POST_TYPE) {
                $plugin_path = untrailingslashit(G5PLUS_PORTFOLIO_DIR_PATH);
                $template_path = $plugin_path . '/templates/single/single-portfolio.php';
                if (file_exists($template_path))
                    return $template_path;
            }
            return $single;
        }

        function get_portfolio_archive_template($archive_template) {
            /* Checks for archive template by post type */
            $post_types =  get_post_type();
            if ( is_archive() && isset($post_types) && $post_types==G5PLUS_PORTFOLIO_POST_TYPE  ) {
	            $g5plus_options = &megatron_get_options_config();
                $template_path = $g5plus_options['portfolio_archive_page'];
                if(!isset($template_path) || $template_path==''){
                    $plugin_path =  untrailingslashit( G5PLUS_PORTFOLIO_DIR_PATH );
                    $template_path = $plugin_path . '/templates/archive/archive-portfolio.php';
                    if(file_exists($template_path))
                        return $template_path;
                }else{
                    wp_redirect($template_path);
                }
            }
            return $archive_template;
        }

        function add_portfolios_columns($columns)
        {
            unset(
            $columns['cb'],
            $columns['title'],
            $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__('Name', 'g5plus-megatron')));
            $cols = array_merge($cols, array('thumbnail' => esc_html__('Thumbnail', 'g5plus-megatron')));
            $cols = array_merge($cols, array(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY => esc_html__('Categories', 'g5plus-megatron')));
            $cols = array_merge($cols, array('date' => esc_html__('Date', 'g5plus-megatron')));
            return $cols;
        }

        function set_portfolios_columns_value($column, $post_id)
        {

            switch ($column) {
                case 'id':
                {
                    echo wp_kses_post($post_id);
                    break;
                }
                case 'thumbnail':
                {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
                case G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY:
                {
                    $terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY));
                    $cat = '<ul>';
                    foreach ($terms as $term) {
                        $cat .= '<li><a href="' . get_term_link($term, G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY) . '">' . $term->name . '<a/></li>';
                    }
                    $cat .= '</ul>';
                    echo wp_kses_post($cat);
                    break;
                }
            }
        }

        function portfolio_manage_posts()
        {
            global $typenow;
            if ($typenow == G5PLUS_PORTFOLIO_POST_TYPE) {
                $selected = isset($_GET[G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY]) ? $_GET[G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY] : '';
                $args = array(
                    'show_count' => true,
                    'show_option_all' => esc_html__('Show All Categories', 'g5plus-megatron'),
                    'taxonomy' => G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY,
                    'name' => G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY,
                    'selected' => $selected,

                );
                wp_dropdown_categories($args);
            }
        }

        function convert_taxonomy_term_in_query($query)
        {
            global $pagenow;
            $qv = & $query->query_vars;
            if ($pagenow == 'edit.php' &&
                isset($qv[G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY]) &&
                is_numeric($qv[G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY])
            ) {
                $term = get_term_by('id', $qv[G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY], G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY);
                $qv[G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY] = $term->slug;
            }
        }

        function addMenuChangeSlug()
        {
            add_submenu_page('edit.php?post_type=portfolio', 'Setting', 'Settings', 'edit_posts', wp_basename(__FILE__), array($this, 'initPageSettings'));
        }

        function initPageSettings()
        {
            $template_path = ABSPATH . 'wp-content/plugins/megatron-framework/includes/shortcodes/posttype-settings/settings.php';
            if (file_exists($template_path))
                include_once $template_path;
        }

        private function includes()
        {
            include_once('utils/ajax-action.php');
        }

    }

    new G5PlusFramework_Portfolio();
}