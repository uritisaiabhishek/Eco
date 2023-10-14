<?php
get_header();
include 'template-parts/add-post.php';
$total_users = count_users();
$total_users_count = $total_users['total_users'];

// Check if the user is already logged in
if (is_user_logged_in()) {
    wp_redirect(site_url());
    exit;
}

// Handle the login form submission
if (isset($_POST['login_email']) && isset($_POST['login_password'])) {
    $credentials = array(
        'user_login'    => $_POST['login_email'],
        'user_password' => $_POST['login_password'],
        'remember'      => isset($_POST['login_remember']) ? $_POST['login_remember'] : false,
    );

    $user = wp_signon($credentials, false);

    if (!is_wp_error($user)) {
        // Successful login
        $_SESSION['message'] = 'Welcome back! You have successfully logged in.';
        $_SESSION['status'] = 'success';
        wp_redirect(site_url());
        exit;
    } else {
        $_SESSION['message'] = 'Invalid username or password.';
        $_SESSION['status'] = 'danger';
        wp_redirect(site_url().'/log-in');
        exit;
    }
}
?>

<div class="container py-4 mt-5">
    <main class="">
        <div class="login_card card">
            <div class="card-body">
                <div class="social_logins">
                    <h2>Welcome to <?php echo bloginfo('name'); ?> Community</h2> 
                    <p><a href="<?php echo site_url(); ?>">This is a community of <?php echo 'Total number of users: ' . $total_users_count; ?> Experts Connected Online </a></p>
                </div>
                <hr>
                <form method="POST">
                    <div class="form-group mb-3">
                        <label for="login_email" class="form-label">Email</label>
                        <input type="email" name="login_email" id="login_email" class="form-control" placeholder="Email Address" required />
                    </div>
                    <div class="form-group mb-3">
                        <label for="login_password" class="form-label">Password</label>
                        <input type="password" name="login_password" id="login_password" class="form-control" placeholder="Your password" required />
                    </div>
                    <div class="form-group mb-3">
                        <input type="checkbox" class="form-checkbox" name="login_remember" id="login_remember" />
                        <label for="login_remember" class="form-label">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <small class="d-none"><a href="#">I forgot my password</a></small>
                </form>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>
