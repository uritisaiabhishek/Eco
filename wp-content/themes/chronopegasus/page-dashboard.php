<?php 
	get_header();
	
	if ( !current_user_can( 'administrator' )  && !is_admin() && (display_user_role() != 'company_profile')) {
		// Redirect to the front-end homepage
		$url = site_url();
		wp_redirect( $url );
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
					<h5 class="text-center m-0">Users List</h5>
					<?php 
						include('template-parts/add-user.php'); 
					?>
				</div>
				<div class="card-body">
					<?php
						if ( ! empty( $users ) ) {
							echo '<table class="table" id="Users_list">';
								echo '<thead>';
									echo '<tr>';
										echo '<th scope="col">#</th>';
										echo '<th scope="col">Username</th>';
										echo '<th scope="col">Edit</th>';
										echo '<th scope="col">Delete</th>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
									$count = 1;
									foreach ( $users as $user ) { 
										echo '<tr>';
											echo '<th scope="row">' . $count . '</th>';
											echo '<td><a target="_blanc" href='. site_url(). '/author/' . $user->display_name .'>' . $user->display_name . '</a></td>';
										?>
											<td>
												<button type="button" class="bg-transparent border-0 w-100 text-start py-2 mx-0 px-0" data-bs-toggle="modal" data-bs-target="#editProfile<?php echo $user -> ID; ?>">Edit</button>
											
												<!-- check if admin or company profile -->
												<!-- if company profile display only that company Hrs  -->
												<div class="modal fade" id="editProfile<?php echo $user -> ID; ?>" tabindex="-1" aria-labelledby="editProfile<?php echo $user -> ID; ?>Label" aria-hidden="true">
													<div class="modal-dialog modal-xl">
														<form method="POST" enctype="multipart/form-data" class="modal-content" >
															<div class="modal-header">
																<h1 class="modal-title fs-5" id="editProfileLabel">Edit Profile</h1>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																<input type="hidden" name="edit_user_id" value="<?php echo $user -> ID; ?>">
																<input type="hidden" name="update_user_profile" value="<?php echo $user -> display_name; ?>">
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="birthday">Birthday</label>
																	<input class="form-control" type="date" name="birthday" id="birthday" value="<?php echo $birthday; ?>">
																</div>
																
																<div class="form-group mb-2 d-flex flex-wrap">
																	<label class="form-label w-100 float-start text-start">Expertise</label>
																	<select name="expertise[]" id="expertise[]" multiple>
																		<option value="dotnet" selected>.NET</option>
																		<option value="java" selected>java</option>
																	</select>
																</div>
																
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="education">education</label>
																	<textarea class="form-control" name="education" id="address"><?php echo $education; ?></textarea>
																</div>
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="address">Address</label>
																	<textarea class="form-control" name="address" id="address"><?php echo $address; ?></textarea>
																</div>
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="how_can_i_help">how_can_i_help</label>
																	<textarea class="form-control" name="how_can_i_help" id="how_can_i_help"><?php echo $how_can_i_help; ?></textarea>
																</div>
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="my_traits">my_traits</label>
																	<textarea class="form-control" name="my_traits" id="my_traits"><?php echo $my_traits; ?></textarea>
																</div>
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="location">Location</label>
																	<input class="form-control" type="text" name="location" id="location" value="<?php echo $location; ?>">
																</div>
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="github_profile">GitHub Profile</label>
																	<input class="form-control" type="text" name="github_profile" id="github_profile" value="<?php echo $github_profile; ?>">
																</div>
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="mobilenumber">Your Mobile Number</label>
																	<input class="form-control" type="text" name="mobilenumber" id="mobilenumber" value="<?php echo $mobilenumber; ?>">
																</div>
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="jobrole">jobrole</label>
																	<input class="form-control" type="text" name="jobrole" id="jobrole" value="<?php echo $jobrole; ?>">
																</div>
																<div class="form-group mb-2">
																	<label class="form-label w-100 float-start text-start" for="company">Company</label>
																	<input class="form-control" type="text" name="company" id="company" value="<?php echo $company; ?>">
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																<input type="submit" class="btn btn-primary" name="profile_edit" value="Update Profile">
															</div>
														</form>
													</div>
												</div> 	
											</td>
											<td>
												<form method="POST">
													<input type="hidden" name="delete_user" value="delete_user" id="delete_user">
													<input type="hidden" value="<?php echo $user->ID; ?>" name="user_id" id="user_id">
													<button type="submit" name="delete_user_form" class="btn btn-sm bg-transperent border-0">
														<i class="fa fa-trash"></i>
													</button>
												</form>
											</td>
										<?php
										echo '</tr>';
										$count++;
									}
								echo '</tbody>';
							echo '</table>';
						} else {
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