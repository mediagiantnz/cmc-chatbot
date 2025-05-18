<?php
/**
 * Plugin Name: Automate Ai Chat Widget
 * Description: Adds the n8n chat‑bot widget (Name, Email & Phone) to every public page and provides a settings screen to configure webhook, branding and colours.
 * Author: Automate Ai
 * Version: 1.0.1
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

class GE_Chat_Widget {

	const OPTION_GROUP   = 'ge_chat_widget_options';
	const OPTION_NAME    = 'ge_chat_widget';
	const PAGE_SLUG      = 'ge-chat-widget';

	/**
	 * Boot the hooks.
	 */
	public static function init() {
		add_action( 'admin_menu',        [ __CLASS__, 'register_settings_page' ] );
		add_action( 'admin_init',        [ __CLASS__, 'register_settings'      ] );
		add_action( 'wp_enqueue_scripts',[ __CLASS__, 'enqueue_front_assets'   ] );
	}

	/**
	 * Default option values.
	 */
	public static function defaults() : array {
		return [
			'webhook_url'         => '',
			'webhook_route'       => 'general',
			'branding_logo'       => '',
			'branding_name'       => 'Automate Ai',
			'branding_welcome'    => 'Get instant answers to your questions!',
			'branding_response'   => 'Click the button below to start chatting',
			'primary_color'       => '#c48c4f',
			'secondary_color'     => '#059669',
			'position'            => 'right', // left/right
			'background_color'    => '#ffffff',
			'font_color'          => '#1f2937',
			'suggested_questions' => '', // comma‑separated
		];
	}

	/**
	 * Register the submenu page under Settings.
	 */
	public static function register_settings_page() {
		add_options_page(
			'Chat Widget',
			'Chat Widget',
			'manage_options',
			self::PAGE_SLUG,
			[ __CLASS__, 'render_settings_page' ]
		);
	}

	/**
	 * Settings API registration.
	 */
	public static function register_settings() {
		register_setting( self::OPTION_GROUP, self::OPTION_NAME, [ 'default' => self::defaults() ] );

		add_settings_section( 'ge_chat_main', __( 'Widget Configuration', 'ge-chat' ), '__return_false', self::PAGE_SLUG );

		self::add_field( 'webhook_url',       'Webhook URL',       'url'  );
		self::add_field( 'webhook_route',     'Webhook Route',     'text' );
		self::add_field( 'branding_logo',     'Logo URL',          'url'  );
		self::add_field( 'branding_name',     'Brand Name',        'text' );
		self::add_field( 'branding_welcome',  'Welcome Text',      'text' );
		self::add_field( 'branding_response', 'Response Time Text','text' );
		self::add_field( 'primary_color',     'Primary Color',     'color');
		self::add_field( 'secondary_color',   'Secondary Color',   'color');
		self::add_field( 'background_color',  'Background Color',  'color');
		self::add_field( 'font_color',        'Font Color',        'color');
		self::add_field( 'position',          'Launcher Position (left/right)','select', [ 'left' => 'Left', 'right' => 'Right' ] );
		self::add_field( 'suggested_questions','Suggested Questions (comma separated)','textarea' );
	}

	/**
	 * Helper: add single field.
	 */
	private static function add_field( string $id, string $label, string $type, $args = [] ) {
		add_settings_field( $id, $label, function() use ( $id, $type, $args ) {
			$opts   = get_option( self::OPTION_NAME, self::defaults() );
			$value  = $opts[ $id ] ?? '';

			switch ( $type ) {
				case 'textarea':
					echo '<textarea name="' . esc_attr( self::OPTION_NAME . "[$id]" ) . '" rows="3" class="large-text">' . esc_textarea( $value ) . '</textarea>'; break;
				case 'color':
					echo '<input type="text" class="ge-color-picker" name="' . esc_attr( self::OPTION_NAME . "[$id]" ) . '" value="' . esc_attr( $value ) . '" />'; break;
				case 'select':
					echo '<select name="' . esc_attr( self::OPTION_NAME . "[$id]" ) . '">';
					foreach ( $args as $val => $text ) {
						echo '<option value="' . esc_attr( $val ) . '" ' . selected( $value, $val, false ) . '>' . esc_html( $text ) . '</option>';
					}
					echo '</select>';
					break;
				default:
					echo '<input type="' . esc_attr( $type ) . '" class="regular-text" name="' . esc_attr( self::OPTION_NAME . "[$id]" ) . '" value="' . esc_attr( $value ) . '" />';
			}
		}, 'ge-chat-widget', 'ge_chat_main' );
	}

	/**
	 * Render settings page markup.
	 */
	public static function render_settings_page() {
		echo '<div class="wrap"><h1>Automate Ai – Chat Widget</h1><form method="post" action="options.php">';
		settings_fields( self::OPTION_GROUP );
		do_settings_sections( self::PAGE_SLUG );
		submit_button();
		echo '</form></div>';
		// Enqueue colour picker when this page loads.
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style(  'wp-color-picker' );
		echo '<script>jQuery(function($){$(".ge-color-picker").wpColorPicker();});</script>';
	}

	/**
	 * Enqueue the widget + inline config.
	 */
	public static function enqueue_front_assets() {
		if ( is_admin() ) {
			return;
		}

		$opts = array_merge( self::defaults(), get_option( self::OPTION_NAME, [] ) );

		// Prepare ChatWidgetConfig object.
		$questions = array_filter( array_map( 'trim', explode( ',', $opts['suggested_questions'] ) ) );

		$config = [
			'webhook'  => [ 'url' => $opts['webhook_url'], 'route' => $opts['webhook_route'] ],
			'branding' => [
				'logo'             => $opts['branding_logo'],
				'name'             => $opts['branding_name'],
				'welcomeText'      => $opts['branding_welcome'],
				'responseTimeText' => $opts['branding_response'],
			],
			'style' => [
				'primaryColor'   => $opts['primary_color'],
				'secondaryColor' => $opts['secondary_color'],
				'position'       => $opts['position'],
				'backgroundColor'=> $opts['background_color'],
				'fontColor'      => $opts['font_color'],
			],
			'suggestedQuestions' => $questions,
		];

		// Register and enqueue local copy of chatbot.js (place file in plugin root).
		wp_register_script( 'ge-chatbot', plugin_dir_url( __FILE__ ) . 'chatbot.js', [], '1.0', true );

		// Inline config **before** main JS.
		wp_add_inline_script( 'ge-chatbot', 'window.ChatWidgetConfig = ' . wp_json_encode( $config ) . ';', 'before' );
		wp_enqueue_script( 'ge-chatbot' );
	}
}

GE_Chat_Widget::init();
