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

if ( ! class_exists( 'Astra_Footer_Layout_Configs' ) ) {

	/**
	 * Register Footer Layout Configurations.
	 */
	class Astra_Footer_Layout_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Footer Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Footer Bar Layout
				 */

				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-sml-layout]',
					'type'     => 'control',
					'control'  => 'ast-radio-image',
					'default'  => astra_get_option( 'footer-sml-layout' ),
					'section'  => 'section-footer-small',
					'priority' => 5,
					'title'    => __( 'Footer Bar Layout', 'astra' ),
					'choices'  => array(
						'disabled'            => array(
							'label' => __( 'Disabled', 'astra' ),
							'path'  => ASTRA_THEME_URI . 'assets/images/disabled-footer-76x48.png',
						),
						'footer-sml-layout-1' => array(
							'label' => __( 'Footer Bar Layout 1', 'astra' ),
							'path'  => ASTRA_THEME_URI . 'assets/images/footer-layout-1-76x48.png',
						),
						'footer-sml-layout-2' => array(
							'label' => __( 'Footer Bar Layout 2', 'astra' ),
							'path'  => ASTRA_THEME_URI . 'assets/images/footer-layout-2-76x48.png',
						),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[section-ast-small-footer-layout-info]',
					'control'  => 'ast-divider',
					'type'     => 'control',
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-sml-layout]', '!=', 'disabled' ),
					'section'  => 'section-footer-small',
					'priority' => 10,
					'settings' => array(),
				),

				/**
				 *  Section: Section 1
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-sml-section-1]',
					'control'  => 'select',
					'default'  => astra_get_option( 'footer-sml-section-1' ),
					'type'     => 'control',
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-sml-layout]', '!=', 'disabled' ),
					'section'  => 'section-footer-small',
					'priority' => 15,
					'title'    => __( 'Section 1', 'astra' ),
					'choices'  => array(
						''       => __( 'None', 'astra' ),
						'menu'   => __( 'Footer Menu', 'astra' ),
						'custom' => __( 'Custom Text', 'astra' ),
						'widget' => __( 'Widget', 'astra' ),
					),
				),
				/**
				 * Option: Section 1 Custom Text
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[footer-sml-section-1-credit]',
					'default'   => astra_get_option( 'footer-sml-section-1-credit' ),
					'type'      => 'control',
					'control'   => 'textarea',
					'transport' => 'postMessage',
					'section'   => 'section-footer-small',
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[footer-sml-section-1]', '==', array( 'custom' ) ),
						),
					),
					'priority'  => 20,
					'title'     => __( 'Section 1 Custom Text', 'astra' ),
					'choices'   => array(
						''       => __( 'None', 'astra' ),
						'menu'   => __( 'Footer Menu', 'astra' ),
						'custom' => __( 'Custom Text', 'astra' ),
						'widget' => __( 'Widget', 'astra' ),
					),
					'partial'   => array(
						'selector'            => '.ast-small-footer-section-1',
						'container_inclusive' => false,
						'render_callback'     => array( 'Astra_Customizer_Partials', '_render_footer_sml_section_1_credit' ),
					),
				),

				/**
				 * Option: Section 2
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-sml-section-2]',
					'type'     => 'control',
					'control'  => 'select',
					'default'  => astra_get_option( 'footer-sml-section-2' ),
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-sml-layout]', '!=', 'disabled' ),
					'section'  => 'section-footer-small',
					'priority' => 25,
					'title'    => __( 'Section 2', 'astra' ),
					'choices'  => array(
						''       => __( 'None', 'astra' ),
						'menu'   => __( 'Footer Menu', 'astra' ),
						'custom' => __( 'Custom Text', 'astra' ),
						'widget' => __( 'Widget', 'astra' ),
					),
				),

				/**
				 * Option: Section 2 Custom Text
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-sml-section-2-credit]',
					'type'     => 'control',
					'control'  => 'textarea',
					'default'  => astra_get_option( 'footer-sml-section-2-credit' ),
					'section'  => 'section-footer-small',
					'priority' => 30,
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-sml-section-2]', '==', 'custom' ),
					'title'    => __( 'Section 2 Custom Text', 'astra' ),
					'partials' => array(
						'selector'            => '.ast-small-footer-section-2',
						'container_inclusive' => false,
						'render_callback'     => array( 'Astra_Customizer_Partials', '_render_footer_sml_section_2_credit' ),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[section-ast-small-footer-typography]',
					'control'  => 'ast-divider',
					'type'     => 'control',
					'section'  => 'section-footer-small',
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-sml-layout]', '!=', 'disabled' ),
					'priority' => 35,
					'settings' => array(),
				),

				/**
				 * Option: Footer Top Border
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[footer-sml-divider]',
					'type'        => 'control',
					'control'     => 'number',
					'default'     => astra_get_option( 'footer-sml-divider' ),
					'section'     => 'section-footer-small',
					'priority'    => 40,
					'required'    => array( ASTRA_THEME_SETTINGS . '[footer-sml-layout]', '!=', 'disabled' ),
					'title'       => __( 'Footer Bar Top Border', 'astra' ),
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 600,
					),
				),

				/**
				 * Option: Footer Top Border Color
				 */

				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-sml-divider-color]',
					'section'  => 'section-footer-small',
					'default'  => '#7a7a7a',
					'type'     => 'control',
					'control'  => 'ast-color',
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-sml-divider]', '>=', 1 ),
					'priority' => 45,
					'title'    => __( 'Footer Bar Top Border Color', 'astra' ),
				),

				/**
				 * Option: Header Width
				 */

				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-layout-width]',
					'type'     => 'control',
					'control'  => 'select',
					'default'  => astra_get_option( 'footer-layout-width' ),
					'section'  => 'section-footer-small',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[site-layout]', '!=', 'ast-box-layout' ),
							array( ASTRA_THEME_SETTINGS . '[site-layout]', '!=', 'ast-fluid-width-layout' ),
							array( ASTRA_THEME_SETTINGS . '[footer-sml-layout]', '!=', 'disabled' ),
						),
					),
					'priority' => 35,
					'title'    => __( 'Footer Bar Width', 'astra' ),
					'choices'  => array(
						'full'    => __( 'Full Width', 'astra' ),
						'content' => __( 'Content Width', 'astra' ),
					),
				),

				/**
				 * Option: Footer Widgets Layout Layout
				 */
				array(
					'name'    => ASTRA_THEME_SETTINGS . '[footer-adv]',
					'type'    => 'control',
					'control' => 'ast-radio-image',
					'default' => astra_get_option( 'footer-adv' ),
					'label'   => __( 'Footer Widgets Layout', 'astra' ),
					'section' => 'section-footer-adv',
					'choices' => array(
						'disabled' => array(
							'label' => __( 'Disable', 'astra' ),
							'path'  => ASTRA_THEME_URI . '/assets/images/no-adv-footer-115x48.png',
						),
						'layout-4' => array(
							'label' => __( 'Layout 4', 'astra' ),
							'path'  => ASTRA_THEME_URI . '/assets/images/layout-4-115x48.png',
						),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-adv-border-style]',
					'control'  => 'ast-divider',
					'type'     => 'control',
					'section'  => 'section-footer-adv',
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-adv]', '!=', 'disabled' ),
					'priority' => 35,
					'settings' => array(),
				),

				/**
				 * Option: Footer Top Border
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[footer-adv-border-width]',
					'type'        => 'control',
					'control'     => 'number',
					'transport'   => 'postMessage',
					'section'     => 'section-footer-adv',
					'default'     => astra_get_option( 'footer-adv-border-width' ),
					'priority'    => 40,
					'required'    => array( ASTRA_THEME_SETTINGS . '[footer-adv]', '!=', 'disabled' ),
					'title'       => __( 'Footer Widgets Top Border', 'astra' ),
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 600,
					),
				),

				/**
				 * Option: Footer Top Border Color
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[footer-adv-border-color]',
					'section'   => 'section-footer-adv',
					'type'      => 'control',
					'transport' => 'postMessage',
					'control'   => 'ast-color',
					'default'   => astra_get_option( 'footer-adv-border-color' ),
					'required'  => array( ASTRA_THEME_SETTINGS . '[footer-adv]', '!=', 'disabled' ),
					'priority'  => 45,
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			// Learn More link if Astra Pro is not activated.
			if ( ! defined( 'ASTRA_EXT_VER' ) ) {

				$config = array(
					/**
					 * Option: Divider
					 */
					array(
						'name'     => ASTRA_THEME_SETTINGS . '[ast-footer-widget-more-feature-divider]',
						'type'     => 'control',
						'control'  => 'ast-divider',
						'section'  => 'section-footer-adv',
						'priority' => 999,
						'settings' => array(),
					),

					/**
					 * Option: Learn More about Footer Widget
					 */
					array(
						'name'     => ASTRA_THEME_SETTINGS . '[ast-footer-widget-more-feature-description]',
						'type'     => 'control',
						'control'  => 'ast-description',
						'section'  => 'section-footer-adv',
						'priority' => 999,
						'label'    => '',
						'help'     => '<p>' . __( 'More Options Available for Footer Widgets in Astra Pro!', 'astra' ) . '</p><a href="' . astra_get_pro_url( 'https://wpastra.com/docs/footer-widgets-astra-pro/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'astra' ) . '</a>',
						'settings' => array(),
					),

				);

				$configurations = array_merge( $configurations, $config );
			}

			return $configurations;

		}
	}
}


new Astra_Footer_Layout_Configs;





