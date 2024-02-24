<?php
/**
 * Class Post_Contributors_Test
 *
 * @package Shvsh\Post_Contributors
 */

use Shvsh_Post_Contributors\Controller\Post_Contributors;

/**
 * Post_Contributors_Test test cases.
 */
class Post_Contributors_Test extends WP_UnitTestCase {

	/**
	 * To test get post contributors ids.
	 *
	 * @return void
	 */
	public function test_set_post_contributors() {
		$post_contributors = Post_Contributors::get_instance();

		$status = $post_contributors->set_post_contributors( 85, array() );
		$this->assertEquals( $status, 0 );

		$status = $post_contributors->set_post_contributors( 85, array( 1, 2 ) );
		$this->assertEquals( $status, 1 );
	}

	/**
	 * To test get post contributors ids.
	 *
	 * @return void
	 */
	public function test_get_post_contributors() {
		$post_contributors = Post_Contributors::get_instance();

		$post_contributors_ids = $post_contributors->get_post_contributors( 85 );
		$this->assertEquals( $post_contributors_ids, array() );

		add_post_meta(
			85,
			'shvsh_post_contributors',
			array( '1', '2' )
		);
		$post_contributors_ids = $post_contributors->get_post_contributors( 85 );
		$this->assertEquals( $post_contributors_ids, array( 1, 2 ) );

		foreach ( $post_contributors_ids as $contributor_id ) {
			$this->assertIsInt( $contributor_id );
		}
	}

	/**
	 * To test remove post contributors.
	 *
	 * @return void
	 */
	public function test_remove_post_contributors() {
		$post_contributors = Post_Contributors::get_instance();

		$post_contributors->set_post_contributors( 85, array( 1, 2 ) );
		$post_contributors_ids = $post_contributors->get_post_contributors( 85 );
		$this->assertEquals( $post_contributors_ids, array( 1, 2 ) );

		$post_contributors->remove_post_contributors( 85 );

		$post_contributors_ids = $post_contributors->get_post_contributors( 85 );
		$this->assertEquals( $post_contributors_ids, array() );
	}
}
