<?php
/**
 * Plugin Name:     Simple AMP
 * Plugin URI:      https://github.com/mustafauysal/simple-amp
 * Description:     A simple plugin that generates AMP pages based on current template.
 * Author:          Mustafa Uysal
 * Author URI:      http://uysalmustafa.com
 * Text Domain:     simple-amp
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         Simple_AMP
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'SIMPLE_AMP_VERSION', '0.1.1' );


define( 'SIMPLE_AMP_QUERY_VAR', apply_filters( 'simple_amp_query_var', 'amp' ) );

if ( ! defined( 'SIMPLE_AMP_PLUGIN_FILE' ) ) {
	define( 'SIMPLE_AMP_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'SIMPLE_AMP_PLUGIN_DIR' ) ) {
	define( 'SIMPLE_AMP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'SIMPLE_AMP_PLUGIN_URL' ) ) {
	define( 'SIMPLE_AMP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}


require_once 'includes/class-simple-amp-helper.php';
register_activation_hook( __FILE__, array( 'Simple_AMP_Helper', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Simple_AMP_Helper', 'deactivate' ) );

if ( Simple_AMP_Helper::requirements_check() ) {
	require_once SIMPLE_AMP_PLUGIN_DIR . 'vendor/autoload.php';
	require_once SIMPLE_AMP_PLUGIN_DIR . 'includes/class-simple-amp.php';
} else {
	add_action( 'admin_notices', array( 'Simple_AMP_Helper', 'php_version_notice' ) );
	add_action( 'admin_init', array( 'Simple_AMP_Helper', 'self_deactivate' ) );
}