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

		add_filter( 'image_size_names_choose', [ $this, 'image_sizes_name' ] );
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
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive_embeds' );
		}

		add_image_size( 'footer-menu', 40 );
	}

	function image_sizes_name( $sizes ) {
		$sizes['footer-menu'] = __( 'Footer Menu', $this->theme_name );

		return $sizes;
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

        // sticky
        for ( $i = 1; $i <= 4; $i++ ) {
            register_sidebar( array(
                'id' => "sticky_widget_{$i}",
                'name' => __( "Sticky Widget {$i}", $this->theme_name ),
                'before_widget' => '<section id="%1$s" class="sticky-widget">',
                'after_widget' => '</section>',
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

		// anchor color
		$wp_customizer->add_setting( 'anchor_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'anchor_color_control', array(
			'label'    => __( 'Anchor Color', $this->theme_name ),
			'section'  => 'font_settings_section',
			'settings' => 'anchor_color_setting',
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

		// header menu font color
		$wp_customizer->add_setting( 'header_menu_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_menu_color_control', array(
			'label'    => __( 'Font Color', $this->theme_name ),
			'section'  => 'header_menu_settings_section',
			'settings' => 'header_menu_color_setting',
		) ) );

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

		// login form section
		$wp_customizer->add_section( 'login_form_settings_section', array(
			'title'       => __( 'Login Form Settings', $this->theme_name ),
			'description' => __( 'Login form customizer', $this->theme_name ),
			'panel'       => 'theme_settings_panel',
		) );

		// login form background color
		$wp_customizer->add_setting( 'login_form_background_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'login_form_background_control', array(
			'label'    => __( 'Background Color', $this->theme_name ),
			'section'  => 'login_form_settings_section',
			'settings' => 'login_form_background_setting',
		) ) );

		// login form background gradient to
		$wp_customizer->add_setting( 'login_form_background_gradient_to_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'login_form_background_gradient_to_control', array(
			'label'    => __( 'Background Gradient To', $this->theme_name ),
			'section'  => 'login_form_settings_section',
			'settings' => 'login_form_background_gradient_to_setting',
		) ) );

		// login form heading color
		$wp_customizer->add_setting( 'login_form_heading_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'login_form_heading_color_control', array(
			'label'    => __( 'Heading Color', $this->theme_name ),
			'section'  => 'login_form_settings_section',
			'settings' => 'login_form_heading_color_setting',
		) ) );

		// login form heading background color
		$wp_customizer->add_setting( 'login_form_heading_background_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'login_form_heading_background_control', array(
			'label'    => __( 'Heading Background Color', $this->theme_name ),
			'section'  => 'login_form_settings_section',
			'settings' => 'login_form_heading_background_setting',
		) ) );

		// login form button color
		$wp_customizer->add_setting( 'login_form_button_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'login_form_button_color_control', array(
			'label'    => __( 'Button Color', $this->theme_name ),
			'section'  => 'login_form_settings_section',
			'settings' => 'login_form_button_color_setting',
		) ) );

		// login form button background color
		$wp_customizer->add_setting( 'login_form_button_background_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'login_form_button_background_control', array(
			'label'    => __( 'Button Background Color', $this->theme_name ),
			'section'  => 'login_form_settings_section',
			'settings' => 'login_form_button_background_setting',
		) ) );

		// login form button background gradient to
		$wp_customizer->add_setting( 'login_form_button_background_gradient_to_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'login_form_button_background_gradient_to_control', array(
			'label'    => __( 'Button Background Gradient To', $this->theme_name ),
			'section'  => 'login_form_settings_section',
			'settings' => 'login_form_button_background_gradient_to_setting',
		) ) );

		// footer section
		$wp_customizer->add_section( 'footer_settings_section', array(
			'title' => __( 'Footer Settings', $this->theme_name ),
			'panel' => 'theme_settings_panel',
		) );

		// footer paragraph color
//		$wp_customizer->add_setting( 'footer_paragraph_color_setting' );
//		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_paragraph_color_control', array(
//			'label'    => __( 'Paragraph Color', $this->theme_name ),
//			'section'  => 'footer_settings_section',
//			'settings' => 'footer_paragraph_color_setting',
//		) ) );

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
			'label'    => __( 'Mobile Menu Background Gradient To', $this->theme_name ),
			'section'  => 'footer_settings_section',
			'settings' => 'footer_mobile_menu_background_gradient_to_setting',
		) ) );

		// footer anchor color
		$wp_customizer->add_setting( 'footer_anchor_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_anchor_color_control', array(
			'label'    => __( 'Anchor Color', $this->theme_name ),
			'section'  => 'footer_settings_section',
			'settings' => 'footer_anchor_color_setting',
		) ) );

		// footer bullet color
		$wp_customizer->add_setting( 'footer_list_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_list_color_control', array(
			'label'    => __( 'Bullet list Color', $this->theme_name ),
			'section'  => 'footer_settings_section',
			'settings' => 'footer_list_color_setting',
		) ) );

		// footer mobile menu anchor color
		$wp_customizer->add_setting( 'footer_mobile_menu_anchor_color_setting' );
		$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_mobile_menu_anchor_color_control', array(
			'label'    => __( 'Mobile Menu Anchor Color', $this->theme_name ),
			'section'  => 'footer_settings_section',
			'settings' => 'footer_mobile_menu_anchor_color_setting',
		) ) );

		// sticky widget
		$wp_customizer->add_panel( 'sticky_widget_panel', array(
			'title'       => __( 'Sticky Widget Settings', $this->theme_name ),
			'description' => __( 'Sticky widget customizer', $this->theme_name ),
			'priority'    => 99,
		) );
	
		for ( $i = 1; $i <= 4; $i ++ ) {
			$wp_customizer->add_section( "sticky_widget_{$i}_section", array(
				'title'       => __( "Sticky Widget {$i}", $this->theme_name ),
				'description' => __( 'Sticky widget customizer', $this->theme_name ),
				'panel'       => 'sticky_widget_panel',
			) );
	
			// sticky widget position horizontal
			$wp_customizer->add_setting( "sticky_widget_{$i}_position_horizontal_setting", array(
				'default' => 'right',
			) );
	
			$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer,
				"sticky_widget_{$i}_position_horizontal_control", array(
					'label'    => 'Horizontal Alignment',
					'section'  => "sticky_widget_{$i}_section",
					'settings' => "sticky_widget_{$i}_position_horizontal_setting",
					'type'     => 'radio',
					'choices'  => array(
						'right' => 'Right',
						'left'  => 'Left',
					),
				) ) );
	
			// sticky widget position vertical
			$wp_customizer->add_setting( "sticky_widget_{$i}_position_vertical_setting", array(
				'default' => 'top',
			) );
	
			$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer,
				"sticky_widget_{$i}_position_vertical_control", array(
					'label'    => 'Vertical Alignment',
					'section'  => "sticky_widget_{$i}_section",
					'settings' => "sticky_widget_{$i}_position_vertical_setting",
					'type'     => 'radio',
					'choices'  => array(
						'top'    => 'Top',
						'bottom' => 'Bottom',
					),
				) ) );
	
			// hide on pc
			$wp_customizer->add_setting( "sticky_widget_{$i}_hide_pc_setting", array(
				'default' => false,
			) );
	
			$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, "sticky_widget_{$i}_hide_pc_control",
				array(
					'label'    => 'Hide On PC',
					'section'  => "sticky_widget_{$i}_section",
					'settings' => "sticky_widget_{$i}_hide_pc_setting",
					'type'     => 'checkbox',
				) ) );
	
			// hide on mobile
			$wp_customizer->add_setting( "sticky_widget_{$i}_hide_mobile_setting", array(
				'default' => false,
			) );
	
			$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, "sticky_widget_{$i}_hide_mobile_control",
				array(
					'label'    => 'Hide On Mobile',
					'section'  => "sticky_widget_{$i}_section",
					'settings' => "sticky_widget_{$i}_hide_mobile_setting",
					'type'     => 'checkbox',
				) ) );
		}
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
		$css .= $this->css_theme_mod_generator( '.main-content a', array( 'color' => 'anchor_color_setting' ) );

		for ( $i = 1; $i <= 6; $i++ ) {
			$css .= $this->css_theme_mod_generator( ".main-content h{$i}", array(
				'color'        => "h{$i}_color_setting",
				'font-size|0!' => "h{$i}_size_setting",
			) );

			// footer
			$css .= $this->css_theme_mod_generator( "footer h{$i}", array(
				'color'        => "h{$i}_color_setting",
				'font-size|0!' => "h{$i}_size_setting",
			) );
		}

		// header menu
		$css .= $this->css_theme_mod_generator( '.header-menu', array(
			'background-color' => 'header_menu_background_setting',
			'color'            => 'header_menu_color_setting',
		) );

		// login-form
		$css .= $this->css_theme_mod_gradient(
			'.login-form',
			'login_form_background_setting',
			'login_form_background_gradient_to_setting'
		);
		$css .= $this->css_theme_mod_generator( '.login-form .heading', array(
			'color'            => 'login_form_heading_color_setting',
			'background-color' => 'login_form_heading_background_setting',
		) );
		$css .= $this->css_theme_mod_generator( '.login-form .button', array( 'color' => 'login_form_button_color_setting' ) );
		$css .= $this->css_theme_mod_gradient(
			'.login-form .button',
			'login_form_button_background_setting',
			'login_form_button_background_gradient_to_setting'
		);

		// footer
		$css .= $this->css_theme_mod_gradient(
			'footer',
			'footer_background_setting',
			'footer_background_gradient_to_setting'
		);
		$css .= $this->css_theme_mod_generator( 'footer p', array( 'color' => 'paragraph_color_setting' ) );
		$css .= $this->css_theme_mod_generator( 'footer a', array( 'color!' => 'footer_anchor_color_setting' ) );
		$css .= $this->css_theme_mod_generator( 'footer li::marker', array( 'color!' => 'footer_list_color_setting' ) );
		$css .= $this->css_theme_mod_generator( '.mobile-footer-menu span', array( 'color!' => 'footer_mobile_menu_anchor_color_setting' ) );
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
			'container_id'    => 'menu-header-main',
			'container'       => 'nav',
			'container_class' => 'menu-header-menu-container header-menu hidden md:flex',
			'items_wrap'      => '<ul id="%1$s" class="%2$s main-container grid md:grid-cols-5 space-y-5 md:space-y-0 text-center w-full">%3$s</ul>',
			'echo'            => false,
		) );

		return $html;
	}

	public static function header_mobile_menu() {
		$html = wp_nav_menu( array(
			'theme_location'  => 'mobile-top-menu',
			'container'       => 'div',
			'container_class' => 'menu-header-menu-container mobile-top-menu md:hidden py-3',
			'items_wrap'      => '<ul id="%1$s" class="%2$s grid grid-cols-2 gap-1 text-center">%3$s</ul>',
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
			'container_class' => 'menu-mobile-footer-menu-container mobile-footer-menu md:hidden py-3 fixed bottom-0 w-full',
			'items_wrap'      => '<ul id="%1$s" class="%2$s grid grid-cols-4 gap-1 text-center">%3$s</ul>',
			'echo'            => false,
		) );

		return $html;
	}

	public static function retrieve_ufa_viewstate() {
		$response = wp_remote_get( 'https://ufacurlapi.theautob.com/ufa_login' );
		$body     = wp_remote_retrieve_body( $response );
		$obj      = json_decode( $body );

		return array(
			'viewstate'          => $obj->{'data'}->{'viewstate'},
			'viewstategenerator' => $obj->{'data'}->{'viewstategenerator'},
		);
	}

	public static function sticky_widget_style( $horizontal, $vertical, $hide_mobile = false, $hide_pc = false ) {
		$rtn = '';
		switch ( $horizontal ) {
			case 'right':
				$rtn .= 'right-5 ';
				break;
			case 'left':
				$rtn .= 'left-5 ';
				break;
		}
	
		switch ( $vertical ) {
			case 'top':
				$rtn .= 'top-5 ';
				break;
			case 'bottom':
				$rtn .= 'bottom-5 ';
				break;
		}
	
		$rtn .= 'flex md:flex ';
		if ( $hide_mobile ) {
			$rtn .= 'hidden ';
		}
		if ( $hide_pc ) {
			$rtn .= 'md:hidden ';
		}
	
		return $rtn;
	}
}
