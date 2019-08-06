<?php
/**
 * Customizer Control: typography.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2019, Astra
 * @link        https://wpastra.com/
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Typography control.
 */
final class Astra_Control_Typography extends WP_Customize_Control {

	/**
	 * Used to connect controls to each other.
	 *
	 * @since 1.0.0
	 * @var bool $connect
	 */
	public $connect = false;

	/**
	 * Used to connect variant controls to each other.
	 *
	 * @since 1.5.2
	 * @var bool $variant
	 */
	public $variant = false;

	/**
	 * Used to set the mode for code controls.
	 *
	 * @since 1.0.0
	 * @var bool $mode
	 */
	public $mode = 'html';

	/**
	 * Used to set the default font options.
	 *
	 * @since 1.0.8
	 * @var string $ast_inherit
	 */
	public $ast_inherit = '';

	/**
	 * All font weights
	 *
	 * @since 1.0.8
	 * @var string $ast_inherit
	 */
	public $ast_all_font_weight = array();

	/**
	 * If true, the preview button for a control will be rendered.
	 *
	 * @since 1.0.0
	 * @var bool $preview_button
	 */
	public $preview_button = false;

	/**
	 * Set the default font options.
	 *
	 * @since 1.0.8
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Default parent's arguments.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->ast_inherit         = __( 'Inherit', 'astra' );
		$this->ast_all_font_weight = array(
			'100'       => __( 'Thin 100', 'astra' ),
			'100italic' => __( '100 Italic', 'astra' ),
			'200'       => __( 'Extra-Light 200', 'astra' ),
			'200italic' => __( '200 Italic', 'astra' ),
			'300'       => __( 'Light 300', 'astra' ),
			'300italic' => __( '300 Italic', 'astra' ),
			'400'       => __( 'Normal 400', 'astra' ),
			'italic'    => __( '400 Italic', 'astra' ),
			'500'       => __( 'Medium 500', 'astra' ),
			'500italic' => __( '500 Italic', 'astra' ),
			'600'       => __( 'Semi-Bold 600', 'astra' ),
			'600italic' => __( '600 Italic', 'astra' ),
			'700'       => __( 'Bold 700', 'astra' ),
			'700italic' => __( '700 Italic', 'astra' ),
			'800'       => __( 'Extra-Bold 800', 'astra' ),
			'800italic' => __( '800 Italic', 'astra' ),
			'900'       => __( 'Ultra-Bold 900', 'astra' ),
			'900italic' => __( '900 Italic', 'astra' ),
		);
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Renders the content for a control based on the type
	 * of control specified when this class is initialized.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render_content() {

		switch ( $this->type ) {

			case 'ast-font-family':
				$this->render_font( $this->ast_inherit );
				break;

			case 'ast-font-variant':
				$this->render_font_variant( $this->ast_inherit );
				break;

			case 'ast-font-weight':
				$this->render_font_weight( $this->ast_inherit );
				break;
		}
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		$js_uri  = ASTRA_THEME_URI . 'inc/customizer/custom-controls/typography/';
		$css_uri = ASTRA_THEME_URI . 'inc/customizer/custom-controls/typography/';
		$js_uri  = ASTRA_THEME_URI . 'inc/customizer/custom-controls/typography/';
		wp_enqueue_style( 'astra-select-woo-style', $css_uri . 'selectWoo.css', null, ASTRA_THEME_VERSION );
		wp_enqueue_style( 'astra-typography-style', $css_uri . 'typography.css', null, ASTRA_THEME_VERSION );
		wp_enqueue_script( 'astra-select-woo-script', $js_uri . 'selectWoo.js', array( 'jquery' ), ASTRA_THEME_VERSION, true );

		wp_enqueue_script( 'astra-typography', $js_uri . 'typography.js', array( 'jquery', 'customize-base' ), ASTRA_THEME_VERSION, true );
		$astra_typo_localize = $this->ast_all_font_weight;

		wp_localize_script( 'astra-typography', 'astraTypo', $astra_typo_localize );
	}
	/**
	 * Renders the title and description for a control.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render_content_title() {
		if ( ! empty( $this->label ) ) {
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		}
		if ( ! empty( $this->description ) ) {
			echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
		}
	}

	/**
	 * Renders the connect attribute for a connected control.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render_connect_attribute() {
		if ( $this->connect ) {
			echo ' data-connected-control="' . esc_attr( $this->connect ) . '"';
			echo ' data-inherit="' . esc_attr( $this->ast_inherit ) . '"';
		}
		if ( $this->variant ) {
			echo ' data-connected-variant="' . esc_attr( $this->variant ) . '"';
			echo ' data-inherit="' . esc_attr( $this->ast_inherit ) . '"';
		}
	}

	/**
	 * Renders a font control.
	 *
	 * @since 1.0.16 Added the action 'astra_customizer_font_list' to support custom fonts.
	 * @since 1.0.0
	 * @param  string $default Inherit/Default.
	 * @access protected
	 * @return void
	 */
	protected function render_font( $default ) {
		echo '<label>';
		$this->render_content_title();
		echo '</label>';
		echo '<select ';
		$this->link();
		$this->render_connect_attribute();
		echo '>';
		echo '<option value="inherit" ' . selected( 'inherit', $this->value(), false ) . '>' . esc_attr( $default ) . '</option>';
		echo '<optgroup label="Other System Fonts">';

		foreach ( Astra_Font_Families::get_system_fonts() as $name => $variants ) {
			echo '<option value="' . esc_attr( $name ) . '" ' . selected( $name, $this->value(), false ) . '>' . esc_attr( $name ) . '</option>';
		}

		// Add Custom Font List Into Customizer.
		do_action( 'astra_customizer_font_list', $this->value() );

		echo '<optgroup label="Google">';

		foreach ( Astra_Font_Families::get_google_fonts() as $name => $single_font ) {
			$variants = astra_get_prop( $single_font, '0' );
			$category = astra_get_prop( $single_font, '1' );
			echo '<option value="\'' . esc_attr( $name ) . '\', ' . esc_attr( $category ) . '" ' . selected( $name, $this->value(), false ) . '>' . esc_attr( $name ) . '</option>';
		}

		echo '</select>';
	}

	/**
	 * Renders a font weight control.
	 *
	 * @since 1.0.0
	 * @param  string $default Inherit/Default.
	 * @access protected
	 * @return void
	 */
	protected function render_font_weight( $default ) {
		echo '<label>';
		$this->render_content_title();
		echo '</label>';
		echo '<select ';
		$this->link();
		$this->render_connect_attribute();
		echo '>';
		if ( 'normal' == $this->value() ) {
			echo '<option value="normal" ' . selected( 'normal', $this->value(), false ) . '>' . esc_attr( $default ) . '</option>';
		} else {
			echo '<option value="inherit" ' . selected( 'inherit', $this->value(), false ) . '>' . esc_attr( $default ) . '</option>';
		}
		$selected       = '';
		$selected_value = $this->value();
		$all_fonts      = $this->ast_all_font_weight;

		foreach ( $all_fonts as $key => $value ) {
			if ( $key == $selected_value ) {
				$selected = ' selected = "selected" ';
			} else {
				$selected = '';
			}
			// Exclude all italic values.
			if ( strpos( $key, 'italic' ) === false ) {
				echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $value ) . '</option>';
			}
		}
		echo '</select>';
	}

	/**
	 * Renders a font variant control.
	 *
	 * @since 1.5.2
	 * @param  string $default Inherit/Default.
	 * @access protected
	 * @return void
	 */
	protected function render_font_variant( $default ) {
		echo '<label>';
		$this->render_content_title();
		echo '</label>';
		echo '<select ';
		$this->link();
		$this->render_connect_attribute();
		echo ' multiple >';
		$values = explode( ',', $this->value() );
		foreach ( $values as $key => $value ) {
			echo '<option value="' . esc_attr( $value ) . '" selected="selected" >' . esc_html( $value ) . '</option>';
		}
		echo '<input class="ast-font-variant-hidden-value" type="hidden" value="' . esc_attr( $this->value() ) . '">';
		echo '</select>';
	}
}
