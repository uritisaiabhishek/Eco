<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile_edit']) ) {
        $current_user = wp_get_current_user();
        $current_user->ID = $current_user->ID;
        $redirect_id = $_POST['edit_user_id'];
        $birthday = sanitize_text_field($_POST['birthday']);
        $address = sanitize_textarea_field($_POST['address']);
        $mobilenumber = sanitize_textarea_field($_POST['mobilenumber']);
        $github_profile = sanitize_textarea_field($_POST['github_profile']);
        $location = sanitize_textarea_field($_POST['location']);
        $company = sanitize_textarea_field($_POST['company']);
        $jobrole = sanitize_textarea_field($_POST['jobrole']);
        $employment = sanitize_textarea_field($_POST['employment']);
        $how_can_i_help = sanitize_textarea_field($_POST['how_can_i_help']);
        $education = sanitize_textarea_field($_POST['education']);
        $my_traits = sanitize_textarea_field($_POST['my_traits']);
        $is_profile_verified = sanitize_textarea_field($_POST['is_profile_verified']);
        if(isset($_POST['expertise'])){
            $expertise = serialize($_POST['expertise']);
        }

        if (isset($_POST['description'])) {
            $new_description = sanitize_textarea_field($_POST['description']);
            update_user_meta($current_user->ID, 'description', $new_description);
        }
        // Update user meta fields
        update_user_meta($current_user->ID, 'employment', $employment);
        update_user_meta($current_user->ID, 'how_can_i_help', $how_can_i_help);
        update_user_meta($current_user->ID, 'my_traits', $my_traits);
        update_user_meta($current_user->ID, 'education', $education);
        update_user_meta($current_user->ID, 'is_profile_verified', $is_profile_verified);
        update_user_meta($current_user->ID, 'expertise', $expertise);
        update_user_meta($current_user->ID, 'birthday', $birthday);
        update_user_meta($current_user->ID, 'address', $address);
        update_user_meta($current_user->ID, 'mobilenumber', $mobilenumber);
        update_user_meta($current_user->ID, 'location', $location);
        update_user_meta($current_user->ID, 'github_profile', $github_profile);
        update_user_meta($current_user->ID, 'company', $company);
        update_user_meta($current_user->ID, 'jobrole', $jobrole);

        $_SESSION['message'] = 'Profile Updated successfully.';
        $_SESSION['status'] = 'success';

        // Reload the page
        $redirect_url = get_author_posts_url($redirect_id);
        wp_redirect($redirect_url);

        exit;
    }
?>