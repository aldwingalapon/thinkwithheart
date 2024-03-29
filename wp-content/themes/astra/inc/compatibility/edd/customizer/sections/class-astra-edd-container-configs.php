<?php
/**
 * Easy Digital Downloads Container Options for Astra theme.
 *
 * @package     Astra
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2019, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       Astra 1.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Edd_Container_Configs' ) ) {

	/**
	 * Customizer Sanitizes Initial setup
	 */
	class Astra_Edd_Container_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Astra-Easy Digital Downloads Shop Container Settings.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.5.5
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Shop Page
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-content-layout]',
					'type'     => 'control',
					'control'  => 'select',
					'default'  => astra_get_option( 'edd-content-layout' ),
					'section'  => 'section-container-layout',
					'priority' => 85,
					'title'    => __( 'Container for Easy Digital Downloads', 'astra' ),
					'choices'  => array(
						'default'                 => __( 'Default', 'astra' ),
						'boxed-container'         => __( 'Boxed', 'astra' ),
						'content-boxed-container' => __( 'Content Boxed', 'astra' ),
						'plain-container'         => __( 'Full Width / Contained', 'astra' ),
						'page-builder'            => __( 'Full Width / Stretched', 'astra' ),
					),
				),
			);

			return array_merge( $configurations, $_configs );

		}
	}
}

new Astra_Edd_Container_Configs();

