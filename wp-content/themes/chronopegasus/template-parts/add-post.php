<?php
// Check if the form is submitted<?php
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_title']) && isset($_POST['post_content'])) {
    // Get the submitted form data
    $post_title = sanitize_text_field($_POST['post_title']);
    $post_content = wp_kses_post($_POST['post_content']);
    $post_category = intval($_POST['post_category']);
    $post_tags = sanitize_text_field($_POST['post_tags']);
    if (display_user_role() == 'course_manager') {
        $post_type_tobe = 'courses';
    }elseif (display_user_role() == 'company_hr'){
        $post_type_tobe = 'jobs';
    }else{
        $post_type_tobe = 'post';
    }

    // Create a new post
    $new_post = array(
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_type' => $post_type_tobe,
        'post_category' => array($post_category),
        'tags_input' => $post_tags
    );

    // Insert the new post
    $post_id = wp_insert_post($new_post);

    // Handle featured image upload
    if ($post_id && isset($_FILES['featured_image']) && !empty($_FILES['featured_image']['name'])) {
        $attachment_id = media_handle_upload('featured_image', $post_id);
        set_post_thumbnail($post_id, $attachment_id);
    }

    // Redirect to the newly created post
    if ($post_id) {
        $post_permalink = get_permalink($post_id);
        
        $_SESSION['message'] = 'Post added successfully.';
        $_SESSION['status'] = 'success';
        // Reload the page
        $redirect_url = $_SERVER['REQUEST_URI'];
        wp_redirect($redirect_url);
        exit;
    }

}
?>
<!-- Add Post Modal -->
<div class="modal fade"  id="addpostModal" tabindex="-1" aria-labelledby="addpostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addpostModalLabel">Add Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="post_title" class="form-label">Title</label>
                <input type="text" class="form-control" id="post_title" name="post_title" aria-describedby="titleHelp">
            </div>
            
            <div class="mb-3">
                <label for="post_category" class="form-label">Category</label>
                <select class="form-control" id="post_category" name="post_category">
                    <?php 
                    // Get all categories
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'parent'  => 0,
                        'hide_empty' => false
                    ));
                    ?>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="post_content" class="form-label">Content</label>
                <?php
                $content = '';
                $editor_id = 'post_content';

                // Display the WYSIWYG editor
                wp_editor($content, $editor_id, array(
                    'textarea_name' => $editor_id,
                    'media_buttons' => false,
                    'tinymce' => array(
                        'toolbar1' => 'bold italic underline | bullist numlist | link',
                        'toolbar2' => '',
                        'toolbar3' => '',
                    ),
                ));
                ?>
            </div>
            <div class="mb-3">
                <label for="post_tags" class="form-label">Tags</label>
                <input type="text" class="form-control" id="post_tags" name="post_tags" aria-describedby="tagsHelp">
                <div id="tagsHelp" class="form-text">Enter tags separated by commas.</div>
            </div>
            <div class="mb-3">
                <label for="featured_image" class="form-label">Featured Image</label>
                <input type="file" class="form-control" id="featured_image" name="featured_image">
            </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Post</button>
            </div>
        </form>
    </div>
</div>