<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Simple_AMP_Helper {

	const MIN_PHP_VERSION = '5.5';


	public static function requirements_check() {
		return version_compare( phpversion(), Simple_AMP_Helper::MIN_PHP_VERSION, '>=' );
	}

	public static function php_version_notice() {
		echo sprintf( '<div class="error"><p>' . __( 'Simple AMP requires PHP version %1$s', 'simple-amp' ) . '</p></div>', self::MIN_PHP_VERSION );
	}

	public static function self_deactivate() {
		if ( ! function_exists( 'deactivate_plugins' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		deactivate_plugins( plugin_basename( SIMPLE_AMP_PLUGIN_DIR . 'simple-amp.php' ) );

		// hide activated message during plugin activation
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

	}


	public static function activate() {
		if ( ! did_action( 'simple_amp_init' ) ) {
			( new Simple_AMP() )->setup();
		}

		flush_rewrite_rules();
	}

	public static function deactivate() {
		// We need to manually remove the amp endpoint
		global $wp_rewrite;
		foreach ( $wp_rewrite->endpoints as $index => $endpoint ) {
			if ( SIMPLE_AMP_QUERY_VAR === $endpoint[1] ) {
				unset( $wp_rewrite->endpoints[ $index ] );
				break;
			}
		}

		flush_rewrite_rules();
	}


	/**
	 * Are we currently on an AMP URL?
	 */
	public static function is_amp_endpoint() {
		return false !== get_query_var( SIMPLE_AMP_QUERY_VAR, false );
	}

}

