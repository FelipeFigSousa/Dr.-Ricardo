<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/4/2015
 * Time: 3:32 PM
 */
?>
<ul class="entry-meta s-font">
    <li class="entry-meta-date">
        <span><?php esc_html_e('Postado:','g5plus-megatron'); ?></span> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"> <?php echo  get_the_date(get_option('date_format'));?> </a>
    </li>

    <li class="entry-meta-author">
        <span><?php esc_html_e('Por:','g5plus-megatron'); ?></span> <?php printf('<a href="%1$s">%2$s</a>',esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),esc_html( get_the_author() )); ?>
    </li>

    <?php if (has_category()): ?>
        <li class="entry-meta-category">
            <span><?php esc_html_e('Categoria:','g5plus-megatron'); ?></span> <?php echo get_the_category_list(' / '); ?>
        </li>
    <?php endif; ?>

    <?php if ( comments_open() || get_comments_number() ) : ?>
        <li class="entry-meta-comment">
            <?php comments_popup_link(wp_kses_post(__('<span>Comentários:</span> 0','g5plus-megatron')) ,wp_kses_post(__('<span>Comentários:</span> 1','g5plus-megatron')),wp_kses_post(__('<span>Comentários:</span> %','g5plus-megatron'))); ?>
        </li>
    <?php endif; ?>
    <?php edit_post_link(esc_html__( 'Editar', 'g5plus-megatron' ), '<li class="edit-link">', '</li>' ); ?>
</ul>