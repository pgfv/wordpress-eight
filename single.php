<?php get_header(); ?>
<section class="prose max-w-none main-content">
    <?php the_content(); ?>

    <?php if ( function_exists( 'mt_author_box' ) ) {
    mt_author_box( $post->post_author, array(
        'theme'              => 'tabbed',
        'profileAvatarShape' => 'round',
    ) );
    } ?>
</section>
<?php get_footer(); ?>
