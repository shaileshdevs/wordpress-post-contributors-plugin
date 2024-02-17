<?php
/**
 * Post Contributors
 *
 * @package      Shvsh\Post_Contributors
 */

namespace Shvsh_Post_Contributors\Controller;

if ( ! class_exists( 'Shvsh_Post_Contributors\Controller\Post_Contributors' ) ) {
	/**
	 * To process post contributors data.
	 */
	class Post_Contributors {
		/**
		 * The singleton instance of the class.
		 *
		 * @var Post_Contributors
		 */
		protected static $instance = null;

		/**
		 * Constructor.
		 */
		public function __construct() {
		}

		/**
		 * Return the singleton instance of the class Post_Contributors.
		 *
		 * @return Post_Contributors Return the instance of the class.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new Post_Contributors();
			}

			return self::$instance;
		}

		/**
		 * Set the post conrtributors for given post id.
		 *
		 * @param int   $post_id The post id.
		 * @param array $post_contributors_ids The array containing contributors ids.
		 *
		 * @return int Return 0 if contributors are removed. Return 1 if contributors are added or updated.
		 */
		public function set_post_contributors( $post_id, $post_contributors_ids ) {
			$post_contributors_ids = array_values( array_unique( $post_contributors_ids ) );

			if ( empty( $post_contributors_ids ) ) {
				$this->remove_post_contributors( $post_id );
				return 0;
			} else {
				update_post_meta( $post_id, 'shvsh_post_contributors', $post_contributors_ids );
				return 1;
			}
		}

		/**
		 * Return the post contributors.
		 *
		 * @param int $post_id The post id.
		 *
		 * @return array Return array containing the post contributors ids.
		 */
		public function get_post_contributors( $post_id ) {
			$post_contributors_ids = array();

			$post_contributors_ids = get_post_meta( $post_id, 'shvsh_post_contributors', true );

			if ( empty( $post_contributors_ids ) ) {
				$post_contributors_ids = array();
			} else {
				$post_contributors_ids = array_map( 'intval', $post_contributors_ids );
			}

			return $post_contributors_ids;
		}

		/**
		 * Remove post contributors for given post id.
		 *
		 * @param int $post_id The post id.
		 *
		 * @return bool Return true on success false on failure.
		 */
		public function remove_post_contributors( $post_id ) {
			return delete_post_meta( $post_id, 'shvsh_post_contributors' );
		}
	}
}
