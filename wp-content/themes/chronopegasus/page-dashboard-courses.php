<?php 
	get_header();
	
	if ( 
		(!current_user_can( 'administrator' )  && !is_admin() ) &&
		(display_user_role() != 'course_manager')
		) {
		wp_redirect( home_url() );
		exit;
	}
	include ('template-parts/add-post.php');
?>

<div class="container-fluid my-5">
	<div class="row g-2">
		<?php include('template-parts/dashboard-statistics.php'); ?>
		<div class="col-md-12">
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="text-center m-0">Courses</h5>
				</div>
				<div class="card-body">
					<?php
						// Query the posts
						$args = array(
							'post_type'      => 'courses',        // Change to your desired post type
							'posts_per_page' => 10,            // Number of posts to display
						);
						$posts_query = new WP_Query( $args );

						// Check if there are any posts
						if ( $posts_query->have_posts() ) {
							?>
								<table class="table">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Course Name</th>
											<th scope="col">Edit</th>
											<th scope="col">Delete</th>
										</tr>
									</thead>
									<tbody>
							<?php
							
							$count = 1;
							// Start the loop
							while ( $posts_query->have_posts() ) {
								$posts_query->the_post();
								$post_id = get_the_ID();
								$slug = get_post_field('post_name', $post_id);
								?>
									<tr>
										<td><?php echo $count; ?></td>
										<td><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></td>
										<td>Edit</td>
										<td>Delete</td>
									</tr>
								<?php 
								$count++;
							}
							?>
								</tbody>
							</table>
							<?php
						}else{
							echo 'No users found in organization.'; 
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