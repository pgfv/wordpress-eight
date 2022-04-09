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

    <script type="text/javascript">
        function toggleMenu() {
            let menu = document.getElementById("menu-header-main");
            let show = document.getElementById("show-button");
            let hide = document.getElementById("hide-button");
            if (menu.style.display === "flex") {
                menu.style.display = "none";
                show.style.display = "flex";
                hide.style.display = "none";
            } else {
                menu.style.display = "flex";
                show.style.display = "none";
                hide.style.display = "flex";
            }
        }
    </script>
</head>
<body <?php body_class(); ?>>

<section>
	<?php for ( $i = 1; $i <= 4; $i ++ ) :
		if ( is_active_sidebar( "sticky_widget_{$i}" ) ):
			$hw = get_theme_mod( "sticky_widget_{$i}_position_horizontal_setting", 'right' );
			$vw = get_theme_mod( "sticky_widget_{$i}_position_vertical_setting", 'top' );
			$hide_mobile = get_theme_mod( "sticky_widget_{$i}_hide_mobile_setting", false );
			$hide_pc = get_theme_mod( "sticky_widget_{$i}_hide_pc_setting", false );
			?>
            <div id="sticky-widget-<?php echo $i; ?>"
                 class="fixed z-10 flex-col <?php echo FourEightTheme::sticky_widget_style( $hw, $vw, $hide_mobile, $hide_pc ); ?>">
                <button class="text-sm text-right text-red-700"
                        onclick="document.getElementById('sticky-widget-<?php echo $i; ?>').style.display = 'none';">
                    close
                </button>
				<?php dynamic_sidebar( "sticky_widget_{$i}" ); ?>
            </div>
		<?php endif; ?>
	<?php endfor; ?>
</section>

<!-- wrapper -->
<section class="flex flex-col min-h-screen">
    <header>
		<?php echo FourEightTheme::header_mobile_menu(); ?>

        <section class="main-container flex flex-col md:flex-row justify-between my-5">
            <div class="flex justify-between">
                <div class="md:hidden flex self-center">
                    <label id="show-button" onclick="toggleMenu();" class="text-white">
                        <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu Open</title>
                            <path d="M0 3h20v2H0V3z m0 6h20v2H0V9z m0 6h20v2H0V0z"/>
                        </svg>
                    </label>
                    <label id="hide-button" onclick="toggleMenu()" class="text-white hidden">
                        <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu Close</title>
                            <polygon points="11 9 22 9 22 11 11 11 11 22 9 22 9 11 -2 11 -2 9 9 9 9 -2 11 -2"
                                    transform="rotate(45 10 10)" />
                        </svg>
                    </label>      
                </div>
                <div class="w-1/3 md:w-1/2">
					<?php the_custom_logo(); ?>
                </div>
            </div>
            <div class="mt-2 md:mt-0">
                <?php 
                    $domain = get_site_url(); 
                    $domain = str_replace( "https://", "", $domain );
                    $domain = str_replace( "www.", "", $domain );
                    $domain = str_replace( ".com", "", $domain );
                ?>
                <script type="text/javascript">
                    function loginSubmit() {
                        const win = window.open("", "_blank");
                        fetch("https://ufa8888customerapi.lucky-d.com/customer/login_get_token", {
                            method: "POST",
                            headers: {"Content-Type": "application/json"},
                            body: JSON.stringify({
                                username: document.getElementById("username").value,
                                password: document.getElementById("password").value,
                                selected_agent: "ufa",
                                agent_name: "8888",
                                money_site_name: "<?php echo $domain; ?>"
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.code !== "200") {
                                console.error("login error:", data.message)
                                return
                            }
                            win.location = data.data.url;
                            win.focus();
                        })
                        .catch(error => {
                            console.error("error:", error);
                        });
                    }
                </script>
                <div id="login-form" class="login-form flex flex-col">
                    <p class="heading">Login</p>
                    <div class="flex flex-row space-x-1">
                        <input id="username" name="username" type="text" placeholder="ชื่อผู้ใช้" class="text-box" />
                        <input id="password" name="password" type="password" placeholder="รหัสผ่าน" class="text-box" />
                    </div>
                    <button class="button" onclick="loginSubmit()">เข้าสู่ระบบ ฝาก-ถอน</button>
                </div>

                <!-- <form id="form2" name="form2" method="post" action="https://www.usa2468.com/Default8.aspx?lang=EN-GB"
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
                </form> -->
            </div>
        </section>

		<?php echo FourEightTheme::header_menu(); ?>
		<?php echo FourEightTheme::header_site_menu(); ?>
    </header>
    <main role="main" class="flex-1 main-container my-10">
