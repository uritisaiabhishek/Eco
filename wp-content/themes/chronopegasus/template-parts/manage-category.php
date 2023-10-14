<?php
    if (isset($_POST['delete_category_name'])) {
        $category_name = $_POST['delete_category_name'];
        // Check if category exists
        $existing_category = get_category_by_slug(sanitize_title($category_name));
        if (!$existing_category) {
            $_SESSION['message'] = $category_name . ' Does not exists.';
            $_SESSION['status'] = 'danger';
        } else {
            $category_id = $existing_category->term_id;
            
            $result = wp_delete_category($category_id, true);
            if ($result !== false) {
                $_SESSION['message'] = $category_name . ' deleted successfully.';
                $_SESSION['status'] = 'success';
            } else {
                $_SESSION['message'] = 'Error deleting category: ' . $category_id->get_error_message();
                $_SESSION['status'] = 'danger';
            }
        }
        wp_redirect(site_url() . '/dashboard-categories');
        exit;
    }

    if (isset($_POST['category_name'])) {
        $category_name = $_POST['category_name'];
        // Check if category exists
        $existing_category = get_category_by_slug(sanitize_title($category_name));
        if ($existing_category) {
            $_SESSION['message'] = $category_name . ' already exists.';
            $_SESSION['status'] = 'danger';
        } else {
            // Prepare category data
            $category_data = array(
                'cat_name' => $category_name,
                'category_description' => '',
                'category_nicename' => sanitize_title($category_name),
                'category_parent' => 0,
                'taxonomy' => 'category'
            );
            $category_id = wp_insert_term( $category_name, 'category' );
            if (!is_wp_error($category_id)) {
                $_SESSION['message'] = $category_name . ' added successfully.';
                $_SESSION['status'] = 'success';
            } else {
                $_SESSION['message'] = 'Error adding category: ' . $category_id->get_error_message();
                $_SESSION['status'] = 'danger';
            }
        }
        wp_redirect(site_url() . '/dashboard-categories');
        exit;
    }
?>
<form method="post" class="d-flex align-items-center">
    <input type="text" name="category_name" class="m-0 rounded-0" placeholder="Category" />
    <input type="submit" class="btn btn-sm btn-dark m-0 rounded-0" value="Add" />
</form>
