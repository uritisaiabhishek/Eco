<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['signup_username'];
        $email = $_POST['signup_email'];
        $password = $_POST['signup_password'];
        
        $expertise = isset($_POST['expertise']) ? $_POST['expertise'] : array();

        // Create a new user
        $user_id = wp_create_user($username, $password, $email);
        update_user_meta($user_id, 'expertise', $expertise);

        if (!is_wp_error($user_id)) {
            // User creation successful, redirect to a success page
            $credentials = array(
                'user_login'    => $email,
                'user_password' => $password,
                'remember'      => isset($_POST['login_remember']) ? $_POST['login_remember'] : false,
            );

            $user = wp_signon($credentials, false);
            if (!is_wp_error($user)) {
                // Successful login
                $_SESSION['message'] = 'Welcome back! You have successfully logged in.';
                $_SESSION['status'] = 'success';
                wp_redirect(site_url());
                exit;
            }
        } else {
            // User creation failed, display an error message
            echo '<div class="alert alert-danger">User creation failed. Please try again.</div>';
        }
    }
?>