<?php 
	get_header();
	
	if ( !current_user_can( 'administrator' )  && !is_admin() && (display_user_role() != 'company_profile')) {
		// Redirect to the front-end homepage
		wp_redirect( home_url() );
		exit;
	}
	include ('template-parts/add-post.php');
	include ('template-parts/delete-user.php');	
    include ('template-parts/edit-profile.php');
	?>

<div class="container-fluid my-5">
	<div class="row g-2">
		<?php include('template-parts/dashboard-statistics.php'); ?>
		<div class="col-md-12">
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="text-center m-0">Posts List</h5>
				</div>
				<div class="card-body">
					<?php
						$posts = get_posts();

						if (count($posts) > 0) {
							echo '<table class="table" id="Posts_list">';
							echo '<thead>';
							echo '<tr>';
							echo '<th scope="col">#</th>';
							echo '<th scope="col">Title</th>';
							echo '<th scope="col">Edit</th>';
							echo '<th scope="col">Delete</th>';
							echo '</tr>';
							echo '</thead>';
							echo '<tbody>';

							$count = 1;
							foreach ($posts as $post) : setup_postdata($post);
								$post_id = $post->ID;
								$post_title = get_the_title($post_id);
								$post_content = get_the_content($post_id);
								$post_permalink = get_permalink($post_id);
								
								?>
									<tr>
										<th scope="row"><?php echo $count; ?></th>
										<td><a href="<?php echo $post_permalink; ?>"><?php echo $post_title; ?></a></td>
										<td>Edit</td>
										<td>Delete</td>
									</tr>
								<?php
								$count++;
							endforeach;
							wp_reset_postdata();

							echo '</tbody>';
							echo '</table>';
						} else {
							echo 'No posts available.';
						}

					?>
				</div> 
			</div>
		</div>
	</div>
</div>
<!-- display a table with users with role editor
add filter the users with option to filter based on skill, date and all other fileds -->
<?php get_footer(); ?>