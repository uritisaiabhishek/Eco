<?php
    get_header();
    include 'template-parts/add-post.php';
    include 'template-parts/edit-post.php';
?>
<div class="container py-4 mt-5">
    <?php include 'template-parts/sidebar/sidebar.php'; ?>
    <!-- Main content starts here -->
	<main class="">
		<div class="row"  >
            <?php
                // Query the posts
                $args = array(
                    'post_type'      => 'post',        // Change to your desired post type
                    'posts_per_page' => 10,            // Number of posts to display
                );
                $posts_query = new WP_Query( $args );

                // Check if there are any posts
                if ( $posts_query->have_posts() ) {
                    // Start the loop
                    while ( $posts_query->have_posts() ) {
                        $posts_query->the_post();
                        $post_id = get_the_ID();
                        $slug = get_post_field('post_name', $post_id);
                                        
                        // Get the post categories
                        $categories = get_the_category($post_id);
        
                        $comments = get_comments(array(
                            'post_id' => $post_id,
                            'status' => 'approve', // Only approved comments
                            'count' => true, // Retrieve comment count only
                            'orderby' => 'comment_date', // Order by comment date
                            'order' => 'ASC' // Ascending order
                        ));
                     
                        // Get the post author ID
                        $author_id = get_the_author_meta('ID');?>
                        
                        <article class="col-lg-6 mb-4">
                            <div class="card post_card">
                                <div class="card-body p-4 pt-3">
                                    <div class="post_title">
                                        <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                                    </div>
                                    <div class="listing__date">
                                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" title="<?php echo esc_attr( get_the_date() ); ?>"><?php echo esc_html( get_the_date( 'd M' ) ); ?></time>
                                    </div>
                                    <div class="tags_lists d-flex w-100 flex-wrap mb-3">
                                        <?php
                                            $post_tags = get_the_tags();
                                            if ( $post_tags ) {
                                                foreach ( $post_tags as $tag ) {
                                                    ?>
                                                        <div class="badge bg-secondary me-1 mb-1 d-flex align-items-center"><?php echo esc_html( $tag->name ); ?></div>
                                                    <?php
                                                }
                                            }
                                        ?>   
                                    </div>
                                    <?php if (is_user_logged_in() && (get_current_user_id() == $author_id || current_user_can( 'administrator' ))) : ?>
                                        <button class="position-absolute" type="button"  id="post_option_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="24" height="24" viewBox="0 0 24 24" class="crayons-icon" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 12a2 2 0 11-4 0 2 2 0 014 0zm7 0a2 2 0 11-4 0 2 2 0 014 0zm5 2a2 2 0 100-4 2 2 0 000 4z"></path>
                                            </svg>
                                        </button>
                                        <div class="dropdown">
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="post_option_dropdown">
                                                <li style="padding: 5px 10px;">
                                                    <form method="POST">
                                                        <input type="hidden" name="delete_post_id" value="<?php echo $post_id; ?>">
                                                        <input type="hidden" name="redirect_url" value="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                                                        <button type="submit" name="delete_post_button">Delete Post</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editpostModal<?php echo $post_id; ?>" data-post-id="<?php echo get_the_ID(); ?>">Edit</button>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <div class="post-content">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <div class="post_author_info">
                                    <?php
                                        $author_id = get_the_author_meta('ID');
                                        $author_image = get_template_directory_uri() . '/assets/images/default.jpg';

                                        if ($author_id) {
                                            $author_posts_url = get_author_posts_url($author_id);
                                            $author_name = get_the_author();
                                        } else {
                                            // No author, so set a default author name and use an anonymous image
                                            $author_posts_url = '#'; // You can change this to any URL you prefer
                                            $author_name = 'Anonymous';
                                            $author_image = get_template_directory_uri() . '/assets/images/default.jpg'; // Change the path to your anonymous image
                                        }
                                        ?>

                                        <a href="<?php echo $author_posts_url; ?>" class="float-start">
                                            <img class="author_image" src="<?php echo $author_image; ?>" alt="<?php echo $author_name; ?>" width="32" height="32" loading="lazy">
                                        </a>

                                        <div class="d-flex flex-column ps-2">
                                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="author_name text-dark"><?php the_author(); ?></a>
                                            <?php
                                                // Display the post categories
                                                if (!empty($categories)) {
                                                    foreach ($categories as $category) {
                                                        $category_link = get_category_link($category->term_id);
                                                        echo '<a class="author_tag text-secondary" href="' . esc_url($category_link) . '">' . $category->name . '</a>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="post_reaction mt-3">
                                        <div class="reactions_container d-flex align-items-center">
                                            <div class="likes me-3">
                                                <?php echo do_shortcode('[posts_like_dislike id='.$post_id.']');?>
                                            </div>
                                            <div class="comments" data-bs-toggle="collapse" data-bs-target="#comments_<?php echo $post_id; ?>" aria-expanded="false" aria-controls="comments_<?php echo $post_id; ?>">
                                                <div class="fa fa-comments me-1"></div>
                                                <span><?php echo $comments; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="collapse" id="comments_<?php echo $post_id; ?>">
                                        <hr />
                                        <div class="mt-2">
                                            <h5 class="text-capitalize">Comments</h5>
                                        </div>
                                        <hr />
                                        <?php
                                            // Display all comments for the current post
                                            $comments_args = array(
                                                'post_id' => $post_id,
                                                'status' => 'approve', // Only approved comments
                                            );
                                            $comments_query = new WP_Comment_Query;
                                            $comments = $comments_query->query( $comments_args );

                                            if ( $comments ) :
                                                foreach ( $comments as $comment ) :
                                                    ?>
                                                    <div class="comment">
                                                        <div class="comment-author"><?php echo get_comment_author(); ?></div>
                                    <div class="comment-time"><?php echo get_comment_date() . ' ' . get_comment_time(); ?></div>
                                                        <div class="comment-content"><?php echo get_comment_text(); ?></div><hr />
                                                    </div>
                                                    <?php
                                                endforeach;
                                            else :
                                                echo '<p class="text-center fw-bold">No comments found.</p>';
                                            endif;
                                        ?>
                                        <?php
                                            $commenter = wp_get_current_commenter();
                                            $comment_args = array(
                                                'comment_field' => '<div class="form-group">    
                                                            <input name="redirect_url" value="'.$_SERVER['REQUEST_URI'].'" type="hidden" />
                                                                        <textarea class="form-control" id="comment" name="comment" rows="2" required></textarea>
                                                                    </div>',
                                                'logged_in_as'  => null,
                                                'title_reply'   => __( '' ),
                                                'label_submit'  => __( 'Submit Comment' ),
                                            );
                                            comment_form( $comment_args );
                                        ?>
                                    </div>

                                </div>
                            </div>
                            
                        </article>
                        <!-- Edit Post Modal -->
                        <div class="modal fade" id="editpostModal<?php echo $post_id; ?>" tabindex="-1" aria-labelledby="editpostModal<?php echo $post_id; ?>Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editpostModal<?php echo $post_id; ?>Label">Edit Post</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="card card-body p-4" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                            <div class="mb-3">
                                                <label for="edit_post_title" class="form-label">Title</label>
                                                <input type="text" class="form-control" value="<?php the_title(); ?>" id="edit_post_title" name="edit_post_title" aria-describedby="edit_titleHelp">
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_post_category" class="form-label">Category</label>
                                                <select class="form-control" id="edit_post_category" name="edit_post_category">
                                                    <?php
                                                    $categories = get_categories(array(
                                                        'orderby' => 'name',
                                                        'parent'  => 0,
                                                        'hide_empty' => false
                                                    ));
                                                    foreach ($categories as $category) {
                                                        $selected = ($post_category[0]->term_id == $category->term_id) ? 'selected' : '';
                                                        echo '<option value="' . $category->term_id . '" ' . $selected . '>' . $category->name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_post_content" class="form-label">Content</label>
                                                <?php
                                                    $edit_editor_id = 'edit_post_content';

                                                    // Display the WYSIWYG editor with prepopulated content
                                                    wp_editor(the_content(), $edit_editor_id, array(
                                                        'textarea_name' => $edit_editor_id,
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
                                                <label for="edit_post_tags" class="form-label">Tags</label>
                                                <input type="text" class="form-control" id="edit_post_tags" name="edit_post_tags" aria-describedby="edit_tagsHelp" value="<?php echo $post_tags ? implode(', ', wp_list_pluck($post_tags, 'name')) : ''; ?>">
                                                <div id="edit_tagsHelp" class="form-text">Enter tags separated by commas.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_featured_image" class="form-label">Featured Image</label>
                                                <input type="file" class="form-control" id="edit_featured_image" name="edit_featured_image">
                                                <?php if (has_post_thumbnail()) :
                                                    $featured_image_url = the_post_thumbnail('',array(
                                                        'class' => 'img-fluid'
                                                    )); ?>
                                                <?php endif; ?>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="edit_post_submit">Update Post</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    // Restore original post data
                    wp_reset_postdata();
                } else {
                    ?>
                    <div class="col mb-4">
                        <div class="card card-body p-4 text-center">
                            <p class="fw-bold fs-3 p-0"><?php esc_html_e('No posts found.'); ?></p>
                        </div>
                    </div>
                    <?php
                }
            ?>
           

		</div>
	</main>
</div>
<?php
    get_footer();
?>