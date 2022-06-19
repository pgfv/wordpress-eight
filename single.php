<?php get_header(); ?>
<section class="prose max-w-none main-content">
    <?php the_content(); ?>

    <?php
    $author_id = $post->post_author;
    mt_profile_img( $author_id, array(
        'size' => 'thumbnail',
        'attr' => array( 'alt' => 'Alternative Text' ),
        'echo' => true )
    );
    ?>

    <?php if ( function_exists( 'mt_author_box' ) ) {
    mt_author_box( $post->post_author, array(
        'theme'              => 'tabbed',
        'profileAvatarShape' => 'round',
    ) );
    } ?>
</section>
<?php get_footer(); ?>
