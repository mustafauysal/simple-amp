<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Simple_Amp
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/simple-amp.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

//$status = activate_plugin( 'simple-amp/simple-amp.php' );
$status = activate_plugin( 'easy-digital-downloads/easy-digital-downloads.php' );
Simple_AMP_Helper::activate();