<?php
/**
 * Styling Options for Astra Theme.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2019, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.15
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Header_Typo_Configs' ) ) {

	/**
	 * Customizer Sanitizes Initial setup
	 */
	class Astra_Header_Typo_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Header Typography Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Divider
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[divider-section-header-typo-title]',
					'type'      => 'control',
					'control'   => 'ast-divider',
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[display-site-title]', '==', '1' ),
							array( ASTRA_THEME_SETTINGS . '[display-sticky-site-title]', '==', '1' ),
						),
						'operator'   => 'OR',
					),
					'section'   => 'section-primary-header-typo',
					'priority'  => 5,
					'title'     => __( 'Site Title', 'astra' ),
					'settings'  => array(),
					'separator' => false,
				),

				/**
				 * Option: Site Title Font Size
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[font-size-site-title]',
					'type'        => 'control',
					'control'     => 'ast-responsive',
					'section'     => 'section-primary-header-typo',
					'default'     => astra_get_option( 'font-size-site-title' ),
					'transport'   => 'postMessage',
					'required'    => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[display-site-title]', '==', '1' ),
							array( ASTRA_THEME_SETTINGS . '[display-sticky-site-title]', '==', '1' ),
						),
						'operator'   => 'OR',
					),
					'priority'    => 10,
					'title'       => __( 'Font Size', 'astra' ),
					'input_attrs' => array(
						'min' => 0,
					),
					'units'       => array(
						'px' => 'px',
						'em' => 'em',
					),
				),

				/**
				 * Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[divider-section-header-typo-tagline]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'section'  => 'section-primary-header-typo',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[display-site-tagline]', '==', '1' ),
							array( ASTRA_THEME_SETTINGS . '[display-sticky-site-tagline]', '==', '1' ),
						),
						'operator'   => 'OR',
					),
					'priority' => 15,
					'title'    => __( 'Site Tagline', 'astra' ),
					'settings' => array(),
				),

				/**0
				 * Option: Site Tagline Font Size
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[font-size-site-tagline]',
					'type'        => 'control',
					'control'     => 'ast-responsive',
					'required'    => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[display-site-tagline]', '==', '1' ),
							array( ASTRA_THEME_SETTINGS . '[display-sticky-site-tagline]', '==', '1' ),
						),
						'operator'   => 'OR',
					),
					'section'     => 'section-primary-header-typo',
					'default'     => astra_get_option( 'font-size-site-tagline' ),
					'transport'   => 'postMessage',
					'priority'    => 20,
					'title'       => __( 'Font Size', 'astra' ),
					'input_attrs' => array(
						'min' => 0,
					),
					'units'       => array(
						'px' => 'px',
						'em' => 'em',
					),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			// Learn More link if Astra Pro is not activated.
			if ( ! defined( 'ASTRA_EXT_VER' ) ) {

				$_configs = array(

					/**
					 * Option: Divider
					 */
					array(
						'name'     => ASTRA_THEME_SETTINGS . '[ast-header-typography-more-feature-divider]',
						'type'     => 'control',
						'control'  => 'ast-divider',
						'section'  => 'section-header-typo',
						'priority' => 999,
						'settings' => array(),
					),

					/**
					 * Option: Learn More about Typography
					 */
					array(
						'name'     => ASTRA_THEME_SETTINGS . '[ast-header-typography-more-feature-description]',
						'type'     => 'control',
						'control'  => 'ast-description',
						'section'  => 'section-header-typo',
						'priority' => 999,
						'title'    => '',
						'help'     => '<p>' . __( 'More Options Available for Typography in Astra Pro!', 'astra' ) . '</p><a href="' . astra_get_pro_url( 'https://wpastra.com/docs/typography-module/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'astra' ) . '</a>',
						'settings' => array(),
					),
				);

				$configurations = array_merge( $configurations, $_configs );
			}

			return $configurations;
		}
	}
}

new Astra_Header_Typo_Configs();


