<?php
/**
 * Post Contributors Meta Box
 *
 * @package      Shvsh\Post_Contributors
 */

namespace Shvsh_Post_Contributors\Admin;

use WP_User;
use Shvsh_Post_Contributors\Controller\Post_Contributors;

if ( ! class_exists( 'Shvsh_Post_Contributors\Admin\Post_Contributors_Metabox' ) ) {
	/**
	 * Display post contributor meta box and save.
	 */
	class Post_Contributors_Metabox {
		/**
		 * The singleton instance of the class.
		 *
		 * @var Post_Contributors_Metabox
		 */
		protected static $instance = null;

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'add_meta_boxes_post', array( $this, 'register_post_contributors_meta_box' ) );
			add_action( 'save_post_post', array( $this, 'save_post_contributors_postmeta' ) );
		}
		/**
		 * Return the singleton instance of the class Post_Contributors_Metabox.
		 *
		 * @return Post_Contributors_Metabox Return the instance of the class.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new Post_Contributors_Metabox();
			}

			return self::$instance;
		}

		/**
		 * To add meta boxes.
		 *
		 * @return void
		 */
		public function register_post_contributors_meta_box() {
			add_meta_box(
				'shvsh_post_contributors_meta_box',
				__( 'Contributors', 'shvsh-post-contributors' ),
				array( $this, 'render_post_contributors_meta_box' )
			);
		}

		/**
		 * To render post contributors meta box.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function render_post_contributors_meta_box( $post ) {
			if ( ! $this->user_has_post_contributor_configuration_access( get_current_user_id(), $post->ID ) ) {
				return;
			}

			$authors = get_users(
				array(
					'fields' => array( 'ID', 'display_name' ),
				)
			);

			$post_contributors_ids = Post_Contributors::get_instance()->get_post_contributors( $post->ID );

			wp_nonce_field( 'shvsh_post_contributors_mb_' . $post->ID, 'shvsh_post_contributors_mb' );
			?>
			<table>
				<tbody>
					<?php
					foreach ( $authors as $author ) {
						$checked = in_array( $author->ID, $post_contributors_ids ) ? 'checked' : '';
						?>
						<tr>
							<td>
								<input type="checkbox" name="shvsh_post_contributors[]" value="<?php echo esc_attr( $author->ID ); ?>" <?php echo esc_attr( $checked ); ?>/>
							</td>
							<td>
								<?php echo esc_html( $author->display_name ); ?>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<?php
		}

		/**
		 * To save the post contributors.
		 *
		 * @param int $post_id The post id.
		 *
		 * @return void
		 */
		public function save_post_contributors_postmeta( $post_id ) {
			if ( false !== check_admin_referer( 'shvsh_post_contributors_mb_' . $post_id, 'shvsh_post_contributors_mb' ) ) {
				$post_contributors_ids = $this->get_post_contributors_from_post_request( $_POST, $post_id );

				Post_Contributors::get_instance()->set_post_contributors( $post_id, $post_contributors_ids );
			}
		}

		/**
		 * To get the post contributors from $_POST when post is saved or updated.
		 *
		 * @param array $global_post The $_POST.
		 * @param int   $post_id The post id.
		 *
		 * @return array Return array containing the post contributors ids. Return empty array if there is no post contributor.
		 */
		public function get_post_contributors_from_post_request( $global_post, $post_id ) {
			$post_contributors_ids = isset( $global_post['shvsh_post_contributors'] ) ? array_map( 'intval', $global_post['shvsh_post_contributors'] ) : array();

			/**
			 * This filter can be used to modify the post contributors.
			 *
			 * @param array $post_contributors_ids The post contributors ids.
			 * @param int $post_id The post id.
			 */
			$post_contributors_ids = apply_filters( 'shvsh_post_contributors_from_post_request', $post_contributors_ids, $post_id );

			return $post_contributors_ids;
		}

		/**
		 * To check the if the user has access to configure the post contributor.
		 *
		 * @param int $user_id The user id.
		 * @param int $post_id The post id.
		 *
		 * @return bool Return true if user has access. Return false if user has no access.
		 */
		public function user_has_post_contributor_configuration_access( $user_id, $post_id ) {
			$user          = new WP_User( $user_id );
			$allowed_roles = array( 'author', 'editor', 'administrator' );
			$has_access    = false;

			if ( ! empty( $user->roles ) && is_array( $user->roles ) ) {
				$has_access = empty( array_intersect( $allowed_roles, $user->roles ) ) ? false : true;
			}

			/**
			 * This filter can be used to change who can have the access to configure the post contributors.
			 *
			 * @param bool $has_access True if user has access, false otherwise.
			 * @param int $user_id User Id.
			 * @param int $post_id Post Id.
			 */
			$has_access = apply_filters( 'shvsh_has_post_contributors_configuration_access', $has_access, $user_id, $post_id );

			return $has_access;
		}
	}
}
