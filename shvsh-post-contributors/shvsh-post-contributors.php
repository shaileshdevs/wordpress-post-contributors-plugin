<?php
/**
 * Post Contributors
 *
 * @package      Shvsh\Post_Contributors
 * @author       Shailesh
 * @copyright    2023 Shailesh
 * @license      GPL v2 or later
 *
 * Plugin Name:       Post Contributors
 * Plugin URI:
 * Description:
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shailesh
 * Author URI:        https://profiles.wordpress.org/shaileshvishwakarma97/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:
 * Text Domain:       shvsh-post-contributors
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE' ) ) {
	define( 'SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE', __FILE__ );
}

// Include the main Post Contributors class.
if ( ! class_exists( 'Shvsh_Post_Contributors\Init', false ) ) {
	require_once dirname( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE ) . '/includes/class-init.php';
	$init = new Shvsh_Post_Contributors\Init();
}

register_activation_hook( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE, array( $init, 'activate_plugin' ) );

register_deactivation_hook( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE, array( $init, 'deactivate_plugin' ) );
