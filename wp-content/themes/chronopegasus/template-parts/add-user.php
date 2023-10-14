<button class="btn btn-sm btn-dark px-3"data-bs-toggle="modal" data-bs-target="#add_user_hr">Add HR</button>

<!-- Modal -->
<div class="modal fade" id="add_user_hr" tabindex="-1" aria-labelledby="add_user_hrLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST">

      <div class="modal-header">
        <h1 class="modal-title fs-5" id="add_user_hrLabel">Add HR</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input class="form-control" placeholder="user name" type="text" value="testuser" name="signup_username">
        <input class="form-control" placeholder="email" type="email" value="test@yopmail.com" name="signup_email">
        <input class="form-control" placeholder="password" type="text" value="test@yopmail.com" name="signup_password">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>

    </form>
  </div>
</div>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['signup_username']) {
      $username = $_POST['signup_username'];
      $email = $_POST['signup_email'];
      $password = $_POST['signup_password'];
  
      if (display_user_role() == 'company_profile') {
          $user_role = 'company_hr';
      } else {
          $user_role = 'Editor';
      }
  
      // Create a new user with the specified role
      $user_id = wp_create_user($username, $password, $email);
      if (!is_wp_error($user_id)) {
          // Generate a unique activation key
          $activation_key = wp_generate_password(20, false);
  
          // Store the activation key in user meta
          update_user_meta($user_id, 'activation_key', $activation_key);
  
          // Send activation email
          $activation_link = site_url("/activate/?key=$activation_key&user=$user_id");
          $subject = 'Activate Your Account';
          $message = "Please click the following link to activate your account:\n\n$activation_link";
  
          wp_mail($email, $subject, $message);
  
          // Redirect to a success page
          $_SESSION['message'] = 'Registration successful. Please check your email to activate your account.';
          $_SESSION['status'] = 'success';
  
          wp_redirect(site_url());
          exit;
      } else {
          $_SESSION['message'] = 'User creation failed. Please try again.';
          $_SESSION['status'] = 'danger';
      }
  }
  
?>