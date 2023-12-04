<?php
/**
 * Initialize the plugin.
 *
 * @package      Shvsh\Post_Contributors
 */

namespace Shvsh_Post_Contributors;

if ( ! class_exists( 'Shvsh_Post_Contributors\Init' ) ) {
	/**
	 * Initialize the plugin.
	 */
	class Init {
		/**
		 * Constructor.
		 */
		public function __construct() {
		}

		/**
		 * Perform some actions on plugin activation.
		 *
		 * @return void
		 */
		public function activate_plugin() {
			// Perform some actions when plugin is activated.
		}

		/**
		 * Perform some actions on plugin deactivation.
		 *
		 * @return void
		 */
		public function deactivate_plugin() {
			// Perform some actions when plugin is deactivated.
		}
	}
}
