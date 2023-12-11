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
			$this->include_files();
		}

		/**
		 * Include the necessary files.
		 *
		 * @return void
		 */
		public function include_files() {
			// Include the post contributor class for frontend and backend.
			require_once plugin_dir_path( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE ) . 'includes/controller/class-post-contributors.php';
			\Shvsh_Post_Contributors\Controller\Post_Contributors::get_instance();

			if ( is_admin() ) {
				// If admin backend then include the files.
				require_once plugin_dir_path( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE ) . 'includes/admin/class-post-contributors-metabox.php';
				\Shvsh_Post_Contributors\Admin\Post_Contributors_Metabox::get_instance();
			} else {
				// If frontend then include the files.
				require_once plugin_dir_path( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE ) . 'includes/frontend/class-post-contributors-display.php';
				\Shvsh_Post_Contributors\Frontend\Post_Contributors_Display::get_instance();
			}
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
