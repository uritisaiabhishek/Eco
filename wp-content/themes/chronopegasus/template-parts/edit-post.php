
<?php
// Check if the Edit Post form is submitted
if (isset($_POST['edit_post_submit'])) {
    // Get the submitted form data
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $post_title = isset($_POST['edit_post_title']) ? sanitize_text_field($_POST['edit_post_title']) : '';
    $post_category = isset($_POST['edit_post_category']) ? intval($_POST['edit_post_category']) : 0;
    $post_content = isset($_POST['edit_post_content']) ? wp_kses_post($_POST['edit_post_content']) : '';
    $post_tags = isset($_POST['edit_post_tags']) ? sanitize_text_field($_POST['edit_post_tags']) : '';

    // Perform necessary validation on the submitted data

    // Update the post
    $post_data = array(
        'ID' => $post_id,
        'post_title' => $post_title,
        'post_category' => array($post_category), // Assuming single category selection
        'post_content' => $post_content,
        'tags_input' => $post_tags,
    );
    wp_update_post($post_data);

    // Handle the featured image upload (if applicable)
    if (!empty($_FILES['edit_featured_image']['name'])) {
        $upload_file = wp_upload_bits($_FILES['edit_featured_image']['name'], null, file_get_contents($_FILES['edit_featured_image']['tmp_name']));
        if (!$upload_file['error']) {
            $file_path = $upload_file['file'];
            $attachment = array(
                'post_mime_type' => $upload_file['type'],
                'post_title' => sanitize_file_name($upload_file['file']),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment($attachment, $file_path, $post_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
            wp_update_attachment_metadata($attach_id, $attach_data);
            set_post_thumbnail($post_id, $attach_id);
        }
    }

    // Redirect or display success message
    // ...
}
?>
