<?php
    get_header();
    include 'template-parts/add-post.php';
    include 'template-parts/user-signup.php';
?>

<div class="container py-4 mt-5">
    <main class="">
        <div class="signup_card card">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group mb-3">
                        <label for="signup_username" class="form-label">Username</label>
                        <input type="text" name="signup_username" id="signup_username" class="form-control" placeholder="User name" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="signup_email" class="form-label">Email</label>
                        <input type="email" name="signup_email" id="signup_email" class="form-control" placeholder="Email Address" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="current_organization" class="form-label">Current Organization</label>
                        <input type="text" name="current_organization" id="current_organization" class="form-control" placeholder="Your current organization" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="years_of_experience" class="form-label">Years of Experience</label>
                        <input type="number" name="years_of_experience" id="years_of_experience" class="form-control" placeholder="Years of experience" />
                    </div>
                    <div class="form-group mb-2 d-flex flex-wrap">
                        <label class="form-label w-100 float-start text-start">Expertise</label>
                        <select name="expertise[]" id="expertise[]" multiple>
                            <option value="dotnet" selected>.NET</option>
                            <option value="java" selected>java</option>
                        </select>
                    </div> 

                    <div class="form-group mb-3">
                        <label for="signup_password" class="form-label">Password</label>
                        <input type="password" name="signup_password" id="signup_password" class="form-control" placeholder="Your password" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_signup_password" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_signup_password" id="confirm_signup_password" class="form-control" placeholder="Confirm your password" />
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>
