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

        <section class="main-container flex flex-col md:flex-row justify-between my-10">
            <div class="flex justify-between">
                <div class="md:hidden">button</div>
                <div class="w-1/2">
					<?php the_custom_logo(); ?>
                </div>
            </div>
            <div class="mt-2 md:mt-0">
                <form id="form2" name="form2" method="post" action="https://www.usa2468.com/Default8.aspx?lang=EN-GB"
                      rel="nofollow" class="login-form flex flex-col">
                    <div class="hidden">
                        <input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value="btnLogin"/>
                        <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value=""/>

						<?php $ufa = FourEightTheme::retrieve_ufa_viewstate(); ?>
                        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="<?php echo $ufa['viewstate'] ?>"/>
                        <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="<?php echo $ufa['viewstategenerator'] ?>"/>
                    </div>

                    <p class="heading">Login</p>
                    <div class="flex flex-row space-x-1">
                        <input id="txtUserName" name="txtUserName" type="text" placeholder="ชื่อผู้ใช้" class="text-box"/>
                        <input id="password" name="password" type="password" placeholder="รหัสผ่าน" class="text-box"/>
                    </div>
                    <input type="submit" value="เข้าสู่ระบบ" class="button"/>
                </form>
            </div>
        </section>

		<?php echo FourEightTheme::header_menu(); ?>
		<?php echo FourEightTheme::header_site_menu(); ?>
    </header>
    <main role="main" class="flex-1 main-container my-10">
