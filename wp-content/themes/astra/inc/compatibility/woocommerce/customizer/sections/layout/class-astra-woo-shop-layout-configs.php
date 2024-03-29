<?php
/**
 * WooCommerce Options for Astra Theme.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2019, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Woo_Shop_Layout_Configs' ) ) {

	/**
	 * Customizer Sanitizes Initial setup
	 */
	class Astra_Woo_Shop_Layout_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Astra-WooCommerce Shop Layout Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Shop Columns
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-grids]',
					'type'        => 'control',
					'control'     => 'ast-responsive-slider',
					'section'     => 'section-woo-shop',
					'default'     => array(
						'desktop' => 4,
						'tablet'  => 3,
						'mobile'  => 2,
					),
					'priority'    => 10,
					'title'       => __( 'Shop Columns', 'astra' ),
					'input_attrs' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 6,
					),
				),

				/**
				 * Option: Products Per Page
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-no-of-products]',
					'type'        => 'control',
					'section'     => 'section-woo-shop',
					'title'       => __( 'Products Per Page', 'astra' ),
					'default'     => astra_get_option( 'shop-no-of-products' ),
					'control'     => 'number',
					'priority'    => 15,
					'input_attrs' => array(
						'min'  => 1,
						'step' => 1,
						'max'  => 100,
					),
				),

				/**
				 * Option: Product Hover Style
				 */

				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-hover-style]',
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-woo-shop',
					'default'  => astra_get_option( 'shop-hover-style' ),
					'priority' => 20,
					'title'    => __( 'Product Image Hover Style', 'astra' ),
					'choices'  => apply_filters(
						'astra_woo_shop_hover_style',
						array(
							''     => __( 'None', 'astra' ),
							'swap' => __( 'Swap Images', 'astra' ),
						)
					),
				),

				/**
				 * Option: Single Post Meta
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-product-structure]',
					'type'     => 'control',
					'control'  => 'ast-sortable',
					'section'  => 'section-woo-shop',
					'default'  => astra_get_option( 'shop-product-structure' ),
					'priority' => 30,
					'title'    => __( 'Shop Product Structure', 'astra' ),
					'choices'  => array(
						'title'      => __( 'Title', 'astra' ),
						'price'      => __( 'Price', 'astra' ),
						'ratings'    => __( 'Ratings', 'astra' ),
						'short_desc' => __( 'Short Description', 'astra' ),
						'add_cart'   => __( 'Add To Cart', 'astra' ),
						'category'   => __( 'Category', 'astra' ),
					),
				),

				/**
				 * Option: Woocommerce Shop Archive Content Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-archive-width-divider]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'section'  => 'section-woo-shop',
					'priority' => 220,
					'settings' => array(),
				),

				/**
				 * Option: Shop Archive Content Width
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-archive-width]',
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-woo-shop',
					'default'  => astra_get_option( 'shop-archive-width' ),
					'priority' => 220,
					'title'    => __( 'Shop Archive Content Width', 'astra' ),
					'choices'  => array(
						'default' => __( 'Default', 'astra' ),
						'custom'  => __( 'Custom', 'astra' ),
					),
				),

				/**
				 * Option: Enter Width
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-archive-max-width]',
					'type'        => 'control',
					'control'     => 'ast-slider',
					'section'     => 'section-woo-shop',
					'default'     => 1200,
					'priority'    => 225,
					'required'    => array( ASTRA_THEME_SETTINGS . '[shop-archive-width]', '===', 'custom' ),
					'title'       => __( 'Enter Width', 'astra' ),
					'suffix'      => '',
					'input_attrs' => array(
						'min'  => 768,
						'step' => 1,
						'max'  => 1920,
					),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}

new Astra_Woo_Shop_Layout_Configs;

