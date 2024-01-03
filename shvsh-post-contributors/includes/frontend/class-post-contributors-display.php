<?php
/**
 * Post Contributors for Frontend
 *
 * @package      Shvsh\Post_Contributors
 */

namespace Shvsh_Post_Contributors\Frontend;

use Shvsh_Post_Contributors\Controller\Post_Contributors;

if ( ! class_exists( 'Shvsh_Post_Contributors\Post_Contributors_Display' ) ) {
	/**
	 * Display Post Contributors.
	 */
	class Post_Contributors_Display {
		/**
		 * The singleton instance of the class.
		 *
		 * @var Post_Contributors_Display
		 */
		protected static $instance = null;

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_filter( 'the_content', array( $this, 'display_post_contributors' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
		}

		/**
		 * Return the singleton instance of the class Post_Contributors_Display.
		 *
		 * @return Post_Contributors_Display Return the instance of the class.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new Post_Contributors_Display();
			}

			return self::$instance;
		}

		/**
		 * Return the HTML to display post contributors.
		 *
		 * @param string $content The post content.
		 *
		 * @return string Return the HTML to display post contributors.
		 */
		public function display_post_contributors( $content ) {
			if ( is_singular() && in_the_loop() && is_main_query() ) {
				global $post;
				$post_contributors     = new Post_Contributors();
				$post_contributors_ids = $post_contributors->get_post_contributors( $post->ID );

				if ( ! empty( $post_contributors_ids ) ) {
					ob_start();
					include dirname( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE ) . '/templates/frontend/post-contributors-list.php';
					$content .= ob_get_clean();

					// Enqueue the stylesheet for post contributors list on post.
					wp_enqueue_style( 'shvsh-post-contributors-list-css' );
				}
			}

			return $content;
		}

		/**
		 * Register styles.
		 *
		 * @return void
		 */
		public function register_styles() {
			// Register the stylesheet for post contributors list displayed on post.
			wp_register_style( 'shvsh-post-contributors-list-css', plugin_dir_url( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE ) . 'assets/css/frontend/post-contributors-list.css', array(), filemtime( plugin_dir_path( SHVSH_POST_CONTRIBUTORS_PLUGIN_FILE ) . 'assets/css/frontend/post-contributors-list.css' ) );
		}
	}
}
