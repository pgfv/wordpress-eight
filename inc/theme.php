<?php

class FourEightTheme {
	private $theme_name;
	private $font_sizes;
	private $font_size_default;

	function init() {
		$this->theme_support();

		add_action( 'init', [ $this, 'init_widgets' ] );
		add_action( 'after_setup_theme', [ $this, 'register_navigation_menus' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_custom_style' ] );
		add_action( 'wp_head', [ $this, 'custom_css_output' ] );
		add_action( 'customize_register', [ $this, 'theme_customizer' ] );
		add_action( 'customize_register', [ $this, 'google_analytics_customizer' ] );
	}

	function __construct() {
		$this->theme_name        = 'four-eight';
		$this->font_size_default = '1rem|1.5rem';
		$this->font_sizes        = array(
			'0.75rem|1rem'     => 'xs',
			'0.875rem|1.25rem' => 'sm',
			'1rem|1.5rem'      => 'base',
			'1.125rem|1.75rem' => 'lg',
			'1.25rem|1.75rem'  => 'xl',
			'1.5rem|2rem'      => '2xl',
			'1.875rem|2.25rem' => '3xl',
			'2.25rem|2.5rem'   => '4xl',
			'3rem|1'           => '5xl',
			'3.75rem|1'        => '6xl',
			'4.5rem|1'         => '7xl',
			'6rem|1'           => '8xl',
			'8rem|1'           => '9xl',
		);
	}

	function theme_support() {
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'title-tag' );
			add_theme_support( 'menus' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'custom-logo' );
		}
	}

	function register_custom_style() {
		$version = wp_get_theme()->version;

		wp_register_style( 'tailwind', get_template_directory_uri() . '/assets/css/style.css', array(), $version, 'all' );
		wp_enqueue_style( 'tailwind' );
	}

	function init_widgets() {
		// header login form
		register_sidebar( array(
			'id'            => 'header_1',
			'name'          => __( 'Header Widget 1', $this->theme_name ),
			'before_widget' => '',
			'after_widget'  => '',
		) );

		// footer widget
		for ( $i = 1; $i <= 4; $i++ ) {
			register_sidebar( array(
				'id'            => "footer_{$i}",
				'name'          => __( "Footer Widget {$i}", $this->theme_name ),
				'before_widget' => '',
				'after_widget'  => '',
			) );
		}
	}

	function register_navigation_menus() {
		register_nav_menus( array(
			'header-menu'        => __( 'Header Menu', $this->theme_name ),
			'header-site-menu'   => __( 'Header Site Menu', $this->theme_name ),
			'mobile-top-menu'    => __( 'Mobile Top Menu', $this->theme_name ),
			'mobile-footer-menu' => __( 'Mobile Footer Menu', $this->theme_name ),
		) );
	}

	function google_analytics_customizer( $wp_customizer ) {
		$wp_customizer->add_section( 'google_analytics_section', array(
			'title'    => __( 'Google Analytics Setting', $this->theme_name ),
			'priority' => 130,
		) );

		$wp_customizer->add_setting( 'google_analytics_setting' );
		$wp_customizer->add_control( 'google_analytics_control', array(
			'label'    => __( 'Measurement ID', $this->theme_name ),
			'section'  => 'google_analytics_section',
			'settings' => 'google_analytics_setting',
			'type'     => 'text',
		) );
	}

	function theme_customizer( $wp_customizer ) {
		// theme main setting
		$wp_customizer->add_panel( 'theme_settings_panel', array(
			'title'       => __( 'Theme Settings', $this->theme_name ),
			'description' => __( 'Main theme customizer', $this->theme_name ),
			'priority'    => 99,
		) );

		// background section
		$wp_customizer->add_section( 'background_settings_section', array(
			'title'       => __( 'Background Settings', $this->theme_name ),
			'description' => __( 'Theme background customizer', $this->theme_name ),
			'panel'       => 'theme_settings_panel',
		) );

		// background color
		$wp_customizer->add_setting( 'background_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'background_color_control', array(
			'label'    => __( 'Background Color', $this->theme_name ),
			'section'  => 'background_settings_section',
			'settings' => 'background_color_setting',
		) ) );

		// background color gradient to
		$wp_customizer->add_setting( 'background_color_gradient_to_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'background_color_gradient_to_control', array(
			'label'    => __( 'Background Gradient To Color', $this->theme_name ),
			'section'  => 'background_settings_section',
			'settings' => 'background_color_gradient_to_setting',
		) ) );

		// background color gradient degree
		$wp_customizer->add_setting( 'background_color_gradient_degree_setting' );
		$wp_customizer->add_control( 'background_color_gradient_degree_control', array(
			'label'       => __( 'Background Gradient Degree', $this->theme_name ),
			'section'     => 'background_settings_section',
			'settings'    => 'background_color_gradient_degree_setting',
			'type'        => 'range',
			'input_attrs' => array(
				'min' => 0,
				'max' => 360,
			),
		) );

		// font section
		$wp_customizer->add_section( 'font_settings_section', array(
			'title'       => __( 'Font Settings', $this->theme_name ),
			'description' => __( 'Theme font customizer', $this->theme_name ),
			'panel'       => 'theme_settings_panel',
		) );

		// font family
		$wp_customizer->add_setting( 'google_fonts_setting' );
		$wp_customizer->add_control( 'google_fonts_control', array(
			'label'    => __( 'Google Fonts URL', $this->theme_name ),
			'section'  => 'font_settings_section',
			'settings' => 'google_fonts_setting',
			'type'     => 'textarea',
		) );

		$wp_customizer->add_setting( 'font_family_setting' );
		$wp_customizer->add_control( 'font_family_control', array(
			'label'    => __( 'Font Family', $this->theme_name ),
			'section'  => 'font_settings_section',
			'settings' => 'font_family_setting',
			'type'     => 'text',
		) );

		// font size
		$wp_customizer->add_setting( 'paragraph_size_setting', array(
			'default' => $this->font_size_default,
		) );
		$wp_customizer->add_control( 'paragraph_size_control', array(
			'label'    => __( 'Paragraph Size', $this->theme_name ),
			'section'  => 'font_settings_section',
			'settings' => 'paragraph_size_setting',
			'type'     => 'select',
			'choices'  => $this->font_sizes,
		) );

		// font color
		$wp_customizer->add_setting( 'paragraph_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'paragraph_color_control', array(
			'label'    => __( 'Paragraph Color', $this->theme_name ),
			'section'  => 'font_settings_section',
			'settings' => 'paragraph_color_setting',
		) ) );

		// strong color
		$wp_customizer->add_setting( 'strong_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'strong_color_control', array(
			'label'    => __( 'Strong Color', $this->theme_name ),
			'section'  => 'font_settings_section',
			'settings' => 'strong_color_setting',
		) ) );

		// heading color
		for ( $i = 1; $i <= 6; $i++ ) {
			$wp_customizer->add_setting( "h{$i}_size_setting" );
			$wp_customizer->add_control( "h{$i}_size_control", array(
				'label'    => __( "H{$i} Size", $this->theme_name ),
				'section'  => 'font_settings_section',
				'settings' => "h{$i}_size_setting",
				'type'     => 'select',
				'choices'  => $this->font_sizes,
			) );

			$wp_customizer->add_setting( "h{$i}_color_setting" );
			$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, "h{$i}_color_control", array(
				'label'    => __( "H{$i} Color", $this->theme_name ),
				'section'  => 'font_settings_section',
				'settings' => "h{$i}_color_setting",
			) ) );
		}

		// header menu section
		$wp_customizer->add_section( 'header_menu_settings_section', array(
			'title'       => __( 'Header Menu Settings', $this->theme_name ),
			'description' => __( 'Header menu customizer', $this->theme_name ),
			'panel'       => 'theme_settings_panel',
		) );

		// header menu background color
		$wp_customizer->add_setting( 'header_menu_background_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_menu_background_control', array(
			'label'    => __( 'Background Color', $this->theme_name ),
			'section'  => 'header_menu_settings_section',
			'settings' => 'header_menu_background_setting',
		) ) );

//		// header menu a background color
//		$wp_customizer->add_setting( 'header_menu_a_background_setting' );
//		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_menu_a_background_control', array(
//			'label'    => __( 'Anchor Background Color', $this->theme_name ),
//			'section'  => 'header_menu_settings_section',
//			'settings' => 'header_menu_a_background_setting',
//		) ) );
//
//		$wp_customizer->add_setting( 'header_menu_a_background_gradient_to_setting' );
//		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_menu_a_background_gradient_to_control', array(
//			'label'    => __( 'Anchor Background Color', $this->theme_name ),
//			'section'  => 'header_menu_settings_section',
//			'settings' => 'header_menu_a_background_gradient_to_setting',
//		) ) );

		// footer section
		$wp_customizer->add_section( 'footer_settings_section', array(
			'title' => __( 'Footer Settings', $this->theme_name ),
			'panel' => 'theme_settings_panel',
		) );

		// footer background color
		$wp_customizer->add_setting( 'footer_background_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_background_control', array(
			'label'    => __( 'Background Color', $this->theme_name ),
			'section'  => 'footer_settings_section',
			'settings' => 'footer_background_setting',
		) ) );

		// footer background gradient to
		$wp_customizer->add_setting( 'footer_background_gradient_to_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_menu_a_background_gradient_to_control', array(
			'label'    => __( 'Background Gradient To', $this->theme_name ),
			'section'  => 'footer_settings_section',
			'settings' => 'footer_background_gradient_to_setting',
		) ) );

		// footer mobile menu background color
		$wp_customizer->add_setting( 'footer_mobile_menu_background_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_mobile_menu_background_control', array(
			'label'    => __( 'Mobile Menu Background Color', $this->theme_name ),
			'section'  => 'footer_settings_section',
			'settings' => 'footer_mobile_menu_background_setting',
		) ) );

		// footer mobile menu background gradient to
		$wp_customizer->add_setting( 'footer_mobile_menu_background_gradient_to_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_mobile_menu_background_gradient_to_control', array(
			'label'    => __( 'Mobile Menu Background Color', $this->theme_name ),
			'section'  => 'footer_settings_section',
			'settings' => 'footer_mobile_menu_background_gradient_to_setting',
		) ) );
	}

	function custom_css_output() {
		$css = '';

		// site background
		$css .= $this->css_theme_mod_gradient(
			'body',
			'background_color_setting',
			'background_color_gradient_to_setting',
			'background_color_gradient_degree_setting'
		);

		$font = get_theme_mod( 'font_family_setting' );
		if ( ! empty( $font ) ) {
			$css .= "body{font-family:{$font},sans-serif;}";
		}

		// main content
		$css .= $this->css_theme_mod_generator( '.main-content p,.main-content li,.main-content table', array(
			'color'         => 'paragraph_color_setting',
			'font-size|0'   => 'paragraph_size_setting',
			'line-height|1' => 'paragraph_size_setting',
		) );
		$css .= $this->css_theme_mod_generator( '.main-content strong', array( 'color' => 'strong_color_setting' ) );

		for ( $i = 1; $i <= 6; $i++ ) {
			$css .= $this->css_theme_mod_generator( ".main-content h{$i}", array(
				'color'        => "h{$i}_color_setting",
				'font-size|0!' => "h{$i}_size_setting",
			) );
		}

		// header menu
		$css .= $this->css_theme_mod_generator( '.header-menu', array( 'background-color' => 'header_menu_background_setting' ) );
//		$css .= $this->css_theme_mod_gradient(
//			'.header-menu a',
//			'header_menu_a_background_setting',
//			'header_menu_a_background_gradient_to_setting'
//		);

		// footer
		$css .= $this->css_theme_mod_gradient(
			'footer',
			'footer_background_setting',
			'footer_background_gradient_to_setting'
		);

		$css .= $this->css_theme_mod_gradient(
			'.mobile-footer-menu',
			'footer_mobile_menu_background_setting',
			'footer_mobile_menu_background_gradient_to_setting'
		);

		echo "<style>{$css}</style>";
	}

	function css_theme_mod_generator( $class, $settings = array(), $manuals = array() ) {
		$css = '';
		foreach ( $settings as $attr => $mod ) {
			$value = get_theme_mod( $mod );
			if ( empty( $value ) ) {
				continue;
			}

			// check important flag
			$flag = false;
			if ( strpos( $attr, '!' ) !== false ) {
				$flag = true;

				// remove ! flag from string
				$attr = str_replace( '!', '', $attr );
			}

			// check explode flag
			if ( strpos( $attr, '|' ) !== false ) {
				$exp   = explode( '|', $attr );
				$value = explode( '|', $value )[ $exp[1] ];

				// remove explode flag
				$attr = str_replace( array( '|', $exp[1] ), '', $attr );
			}

			$css .= "{$attr}:{$value}";
			if ( $flag ) {
				$css .= ' !important';
			}
			$css .= ';';
		}

		// manual attributes
		foreach ( $manuals as $attr => $value ) {
			$css .= "{$attr}:{$value};";
		}

		if ( $css == '' ) {
			return '';
		}

		return "{$class}{{$css}}";
	}

	function css_theme_mod_gradient( $class, $settings, $gradient, $degree = '' ) {
		$b = get_theme_mod( $settings );
		$g = get_theme_mod( $gradient );

		if ( empty ( $b ) ) {
			return '';
		}

		if ( ! empty( $g ) && $b != $g ) {
			$output = '';
			if ( $degree != '' ) {
				$d = get_theme_mod( $degree );
				if ( ! empty( $d ) ) {
					$output .= "{$d}deg,";
				}
			}
			$output .= "{$b},{$g}";

			return "{$class}{background-image:linear-gradient({$output});}";
		}

		return "{$class}{background-color:{$b};}";
	}

	public static function header_menu() {
		$html = wp_nav_menu( array(
			'theme_location'  => 'header-menu',
			'container'       => 'nav',
			'container_class' => 'menu-header-menu-container header-menu',
			'items_wrap'      => '<ul id="%1$s" class="%2$s main-container flex flex-row justify-around">%3$s</ul>',
			'echo'            => false,
		) );

		return $html;
	}

	public static function header_mobile_menu() {
		$html = wp_nav_menu( array(
			'theme_location'  => 'mobile-top-menu',
			'container'       => 'div',
			'container_class' => 'menu-header-menu-container mobile-top-menu md:hidden py-3',
			'items_wrap'      => '<ul id="%1$s" class="%2$s grid grid-cols-2 text-center">%3$s</ul>',
			'echo'            => false,
		) );

		return $html;
	}

	public static function header_site_menu() {
		$html = wp_nav_menu( array(
			'theme_location'  => 'header-site-menu',
			'container'       => 'div',
			'container_class' => 'menu-header-site-menu-container header-site-menu py-3 main-container',
			'items_wrap'      => '<ul id="%1$s" class="%2$s grid grid-cols-2 md:grid-cols-4 gap-5 text-center">%3$s</ul>',
			'echo'            => false,
		) );

		return $html;
	}

	public static function footer_mobile_menu() {
		$html = wp_nav_menu( array(
			'theme_location'  => 'mobile-footer-menu',
			'container'       => 'nav',
			'container_class' => 'menu-mobile-footer-menu-container mobile-footer-menu md:hidden py-5 fixed bottom-0 w-full',
			'items_wrap'      => '<ul id="%1$s" class="%2$s grid grid-cols-4 text-center">%3$s</ul>',
			'echo'            => false,
		) );

		return $html;
	}
}
