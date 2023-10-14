<?php 
	get_header();
	
	if ( !current_user_can( 'administrator' )  && !is_admin()) {
		// Redirect to the front-end homepage
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
					<h5 class="text-center m-0">Categories List</h5>
					<?php include ('template-parts/manage-category.php'); ?>
				</div>
				<div class="card-body">
					<?php
						$categories = get_categories(array(
							'hide_empty' => false
						));
						if ($categories) {
							echo '<table class="table" id="Users_list">';
								echo '<thead>';
									echo '<tr>';
										echo '<th scope="col">#</th>';
										echo '<th scope="col">Category</th>';
										echo '<th scope="col">Edit</th>';
										echo '<th scope="col">Delete</th>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
									$count = 1;
									foreach ($categories as $category) {
										echo '<tr>';
											echo '<th scope="row">' . $count . '</th>';
											echo '<td><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></td>';
											echo '<td>Edit</td>';
											?>
												<td>
													<form method="post" class="d-flex align-items-center">
														<input type="hidden" name="delete_category_id" value="<?php echo $category->term_id; ?>" class="m-0 rounded-0" />
														<input type="hidden" name="delete_category_name" value="<?php echo $category->name; ?>" class="m-0 rounded-0" />
														<button class="bg-transparent border-0" type="submit">Delete</button>
													</form>
												</td>
											<?php
										echo '</tr>';
									}
								echo '</tbody>';
							echo '</table>';
						} else {
							echo 'No categories found.';
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