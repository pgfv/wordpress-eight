<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<?php
	$google_font = get_theme_mod( 'google_fonts_setting' );
	if ( ! empty( $google_font ) ) {
		echo $google_font;
	}
	?>

	<?php wp_head(); ?>
	<?php
	$id = get_theme_mod( 'google_analytics_setting' );
	if ( ! empty( $id ) ): ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $id; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '<?php echo $id; ?>');
        </script>
	<?php endif; ?>
</head>
<body <?php body_class(); ?>>

<!-- wrapper -->
<section class="flex flex-col min-h-screen">
    <header>
		<?php echo FourEightTheme::header_mobile_menu(); ?>
        <section class="main-container flex flex-row justify-between my-10">
            <div>
				<?php the_custom_logo(); ?>
            </div>
            <div>
				<?php dynamic_sidebar( 'header_1' ); ?>
            </div>
        </section>
		<?php echo FourEightTheme::header_menu(); ?>
		<?php echo FourEightTheme::header_site_menu(); ?>
    </header>
    <main role="main" class="flex-1 main-container my-10">
