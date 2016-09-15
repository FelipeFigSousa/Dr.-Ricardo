<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/4/15
 * Time: 2:41 PM
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Post') && (function_exists('g5plus_post_thumbnail'))):
    class g5plusFramework_Shortcode_Post
    {
        function __construct()
        {
            add_shortcode('megatron_post', array($this, 'post_shortcode'));
        }

        function post_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $category
             * @var $display
             * @var $item_amount
             * @var $layout_style
             * @var $column
             * @var $is_slider
             * @var $nav
             * @var $dots
             * @var $autoplaytimeout
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $category = $display = $item_amount = $layout_style= $column = $is_slider = $dots = $nav = $autoplaytimeout= $el_class = $css_animation = $duration = $delay = '';
            $atts = vc_map_get_attributes('megatron_post', $atts);
            extract($atts);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            if($layout_style=='style2')
            {
                $item_amount=4;
            }
            $query['posts_per_page'] = $item_amount;
            $query['no_found_rows'] = true;
            $query['post_status'] = 'publish';
            $query['ignore_sticky_posts'] = true;
            $query['post_type'] = 'post';
            if (!empty($category)) {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio'),
                        'operator' => 'NOT IN'
                    ),
                    array(
                        'taxonomy' => 'category',
                        'terms' => explode(',', $category),
                        'field' => 'slug',
                        'operator' => 'IN'
                    )
                );
            } else {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio'),
                        'operator' => 'NOT IN'
                    )
                );
            }
            if ($display == 'random') {
                $query['orderby'] = 'rand';
            } elseif ($display == 'popular') {
                $query['orderby'] = 'comment_count';
            } elseif ($display == 'recent') {
                $query['orderby'] = 'post_date';
                $query['order'] = 'DESC';
            } else {
                $query['orderby'] = 'post_date';
                $query['order'] = 'ASC';
            }
            $r = new WP_Query($query);
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_post_css', plugins_url('megatron-framework/includes/shortcodes/post/assets/css/post' . $min_suffix_css . '.css'), array(), false);
            ob_start();
            if ($r->have_posts()) :
                ?>
                <div class="m-post <?php echo esc_attr($layout_style.$g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                    <?php if($layout_style=='style1'):
                        if ($is_slider) :
                        $dots = ($dots == 'yes') ? 'true' : 'false';
                        $nav = ($nav == 'yes') ? 'true' : 'false';
                        $data_carousel = '"autoplay": true,"loop":true,"center":false,"margin":30,"autoplayHoverPause":true,"autoplayTimeout":'.$autoplaytimeout.', "items":' . $column . ',"dots":' . $dots . ', "nav":' . $nav;
                        $data_carousel .= ',"responsive": {"0":{"items": 1},"600":{"items": 1},"768":{"items": 2},"980":{"items": 3},"1200":{"items": ' . $column . '}}';
                        ?>
                            <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}' class="owl-g5plus-shortcode owl-carousel">
                            <?php while ($r->have_posts()) : $r->the_post(); ?>
                                <div class="post-item">
                                    <?php
                                    $thumbnail = g5plus_post_thumbnail('blog-related');
                                    if (!empty($thumbnail)) : ?>
                                        <div class="post-image">
                                            <?php echo wp_kses_post($thumbnail); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="post-content">
                                        <h6><a href="<?php the_permalink(); ?>"
                                               rel="bookmark"
                                               title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>

                                        <div class="post-entry-meta">
                                            <span><?php echo get_the_date(get_option('date_format')); ?></span>&nbsp;/&nbsp;
                                            <?php printf('<a href="%1$s">%2$s</a>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author())); ?>&nbsp;/&nbsp;
                                            <?php
                                            $cate = get_the_category();
                                            if (is_array($cate)) {
                                                $cat_list='';
                                                foreach ($cate as $cat) {
                                                    $cat_list.='<a href="'.get_category_link($cat->cat_ID).'">' . $cat->cat_name  . '</a> - ';
                                                }
                                                if($cat_list!='')
                                                {
                                                    $cat_list=rtrim($cat_list,' - ');
                                                    echo wp_kses_post($cat_list);
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php else:?>
                            <div class="row column-equal-height">
                                <?php while ($r->have_posts()) : $r->the_post(); ?>
                                <div class="col-md-<?php echo(12 / esc_attr($column)) ?> col-sm-6 margin-bottom-55">
                                    <div class="post-item">
                                        <?php
                                        $thumbnail = g5plus_post_thumbnail('blog-related');
                                        if (!empty($thumbnail)) : ?>
                                            <div class="post-image">
                                                <?php echo wp_kses_post($thumbnail); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="post-content">
                                            <h6><a href="<?php the_permalink(); ?>"
                                                   rel="bookmark"
                                                   title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>

                                            <div class="post-entry-meta">
                                                <span><?php echo get_the_date(get_option('date_format')); ?></span>&nbsp;/
                                                <?php printf('<a href="%1$s">%2$s</a>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author())); ?>&nbsp;/
                                                <?php
                                                $cate = get_the_category();
                                                if (is_array($cate)) {
                                                    $cat_list='';
                                                    foreach ($cate as $cat) {
                                                        $cat_list.='<a href="'.get_category_link($cat->cat_ID).'">' . $cat->cat_name  . '</a> - ';
                                                    }
                                                    if($cat_list!='')
                                                    {
                                                        $cat_list=rtrim($cat_list,' - ');
                                                        echo wp_kses_post($cat_list);
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile;?>
                            </div>
                        <?php endif;
                    else:?>
                        <div class="row">
                            <?php
                            $html_1=$html_2='';$i=0;
                            while ($r->have_posts()) : $r->the_post();
                                $cat_list='';
                                $cate = get_the_category();
                                if (is_array($cate)) {
                                    foreach ($cate as $cat) {
                                        $cat_list.='<a href="'.get_category_link($cat->cat_ID).'">' . $cat->cat_name  . '</a> - ';
                                    }
                                    if($cat_list!='')
                                    {
                                        $cat_list=rtrim($cat_list,' - ');
                                    }
                                }
                                $excerpt = get_the_excerpt();
                                $i++;
                                if($i==1)
                                {
                                    $thumbnail = g5plus_post_thumbnail('post-large');
                                    if (!empty($thumbnail))
                                    {
                                        $html_1.='<div class="post-image">'.wp_kses_post($thumbnail).'</div>';
                                        $html_1.='<div class="post-content">
                                                    <h6><a href="'. get_the_permalink().'" rel="bookmark" title="'. get_the_title().'">'. get_the_title().'</a></h6>
                                                    <div class="post-entry-meta">
                                                        <span>'. get_the_date(get_option('date_format')).'</span>&nbsp;/
                                                        <a href="'. esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.esc_html(get_the_author()).'</a>&nbsp;/';
                                        $html_1.=       $cat_list.'
                                                    </div>
                                                    <p>'.g5plusFramework_Shortcodes::substr($excerpt, 214, ' ...').'</p>
                                                 </div>';
                                    }
                                }
                                else
                                {
                                    $thumbnail = g5plus_post_thumbnail('post-small');
                                    if (!empty($thumbnail))
                                    {
                                        $html_2.='<div class="post-small">';
                                        $html_2.=   '<div class="post-image">'.wp_kses_post($thumbnail).'</div>';
                                        $html_2.=   '<div class="post-content">
                                                        <h6><a href="'. get_the_permalink().'" rel="bookmark" title="'. get_the_title().'">'. get_the_title().'</a></h6>
                                                        <div class="post-entry-meta">
                                                            <span>'. get_the_date(get_option('date_format')).'</span>&nbsp;/
                                                            <a href="'. esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.esc_html(get_the_author()).'</a>&nbsp;/';
                                        $html_2.=           $cat_list.'
                                                        </div>
                                                        <p>'.$excerpt.'</p>
                                                    </div>
                                                 </div>';
                                    }
                                }
                            endwhile;?>
                            <div class="col-lg-6 col-md-12 col-sm-12 post-large md-margin-bottom-50">
                                <?php echo wp_kses_post($html_1);  ?>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <?php echo wp_kses_post($html_2);  ?>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
                <?php
            endif;
            wp_reset_postdata();
            g5plus_archive_loop_reset();
            $content = ob_get_clean();
            return $content;
        }
    }

    new g5plusFramework_Shortcode_Post();
endif;