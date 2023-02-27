<?php
/**
 * Template Name: БЛОГ запись
 * Template Post type: Post
 */

get_header();
?>
<div class="blog-zapis-article">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;

        if ( 'post' === get_post_type() ) :
            ?>
            <div class="entry-meta">
                <?php
                bost_miks_posted_on();
                bost_miks_posted_by();
                ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php bost_miks_post_thumbnail(); ?>

    <div class="entry-content">МОЖЕИТ УТТ
        <?php
        the_content(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'bost-miks' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            )
        );

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bost-miks' ),
                'after'  => '</div>',
            )
        );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php bost_miks_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</div>

<div class="blog-zapis-sidebar">
    <?php
    $all_categories = get_categories('hide_empty=0');
$category_link_array = array();
foreach( $all_categories as $single_cat ){
    $category_link_array[] = '<a href="' . get_category_link($single_cat->term_id) . '">' . $single_cat->name . '</a>';
}
echo implode(',', $category_link_array);
?>
</div>

<?php
get_footer();