<?php
/**
 * Bottom Footer Options for Astra Theme.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2019, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Site_Identity_Configs' ) ) {

	/**
	 * Register Astra Customizerr Site identity Customizer Configurations.
	 */
	class Astra_Site_Identity_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Astra Customizerr Site identity Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Different retina logo
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[different-retina-logo]',
					'type'     => 'control',
					'control'  => 'checkbox',
					'section'  => 'title_tagline',
					'title'    => __( 'Different Logo for retina devices?', 'astra' ),
					'default'  => false,
					'priority' => 5,
				),
				/**
				 * Option: Retina logo selector
				 */
				array(
					'name'           => ASTRA_THEME_SETTINGS . '[ast-header-retina-logo]',
					'default'        => astra_get_option( 'ast-header-retina-logo' ),
					'type'           => 'control',
					'control'        => 'image',
					'section'        => 'title_tagline',
					'required'       => array( ASTRA_THEME_SETTINGS . '[different-retina-logo]', '!=', 0 ),
					'priority'       => 5,
					'title'          => __( 'Retina Logo', 'astra' ),
					'library_filter' => array( 'gif', 'jpg', 'jpeg', 'png', 'ico' ),
				),

				/**
				 * Option: Inherit Desktop logo
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[different-mobile-logo]',
					'type'     => 'control',
					'control'  => 'checkbox',
					'default'  => false,
					'section'  => 'title_tagline',
					'title'    => __( 'Different Logo for mobile devices?', 'astra' ),
					'priority' => 5,
				),

				/**
				 * Option: Mobile header logo
				 */
				array(
					'name'           => ASTRA_THEME_SETTINGS . '[mobile-header-logo]',
					'default'        => astra_get_option( 'mobile-header-logo' ),
					'type'           => 'control',
					'control'        => 'image',
					'required'       => array( ASTRA_THEME_SETTINGS . '[different-mobile-logo]', '==', '1' ),
					'section'        => 'title_tagline',
					'priority'       => 5,
					'title'          => __( 'Mobile Logo (optional)', 'astra' ),
					'library_filter' => array( 'gif', 'jpg', 'jpeg', 'png', 'ico' ),
				),

				/**
				 * Option: Logo Width
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[ast-header-responsive-logo-width]',
					'type'        => 'control',
					'control'     => 'ast-responsive-slider',
					'section'     => 'title_tagline',
					'transport'   => 'postMessage',
					'default'     => array(
						'desktop' => '',
						'tablet'  => '',
						'mobile'  => '',
					),
					'priority'    => 5,
					'title'       => __( 'Logo Width', 'astra' ),
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 600,
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[ast-site-logo-divider]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'section'  => 'title_tagline',
					'priority' => 5,
					'settings' => array(),
				),

				/**
				 * Option: Display Title
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[display-site-title]',
					'type'     => 'control',
					'control'  => 'checkbox',
					'default'  => astra_get_option( 'display-site-title' ),
					'section'  => 'title_tagline',
					'title'    => __( 'Display Site Title', 'astra' ),
					'priority' => 6,
				),

				/**
				 * Option: Display Tagline
				 */
				array(
					'name'    => ASTRA_THEME_SETTINGS . '[display-site-tagline]',
					'type'    => 'control',
					'control' => 'checkbox',
					'default' => astra_get_option( 'display-site-tagline' ),
					'section' => 'title_tagline',
					'title'   => __( 'Display Site Tagline', 'astra' ),
				),

				array(
					'name'     => ASTRA_THEME_SETTINGS . '[logo-title-inline]',
					'default'  => astra_get_option( 'logo-title-inline' ),
					'type'     => 'control',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[display-site-title]', '!=', 0 ),
							array( 'custom_logo', '!=', '' ),
							array( ASTRA_THEME_SETTINGS . '[ast-header-retina-logo]', '!=', '' ),
							array( ASTRA_THEME_SETTINGS . '[display-site-tagline]', '!=', 0 ),
						),
						'operator'   => 'OR',
					),
					'control'  => 'checkbox',
					'section'  => 'title_tagline',
					'title'    => __( 'Inline Logo & Site Title', 'astra' ),
					'priority' => 10,
				),

				/**
				 * Option: Divider
				*/
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[ast-site-icon-divider]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'section'  => 'title_tagline',
					'priority' => 50,
					'settings' => array(),
				),
			);

			$configurations = array_merge( $configurations, $_configs );
			return $configurations;

		}
	}
}


new Astra_Site_Identity_Configs;





