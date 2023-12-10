<?php
/**
 * Post contributors list
 *
 * @package      Shvsh\Post_Contributors
 */

?>
<section class="shvsh-post-contributors-list-section">
	<div class="section-label-wrapper">
		<h5 class="section-label"><?php echo esc_html__( 'Contributors', 'shvsh-post-contributors' ); ?></h5>
	</div>
	<div class="post-contributors-list-wrapper">
		<table class="post-contributors-list">
			<?php
			foreach ( $post_contributors_ids as $author_id ) :
				$author_url = get_the_author_meta( 'user_url', $author_id );
				?>
				<tr class="post-contributor-details">
					<td class="gravatar-wrapper">
						<img src="<?php echo esc_url( get_avatar_url( $author_id ) ); ?>" />
					</td>
					<td class="display-name-wrapper">
						<?php
						if ( empty( $author_url ) ) :
							?>
							<span><?php echo esc_html( get_user_by( 'ID', $author_id )->display_name ); ?></span>
							<?php
						else :
							?>
							<a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( get_user_by( 'ID', $author_id )->display_name ); ?></a>
							<?php
						endif;
						?>
					</td>
				</tr>
				<?php
			endforeach;
			?>
		</table>
	</div>
</section>
