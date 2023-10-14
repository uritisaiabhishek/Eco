<?php
/**
 * Template Name: Post Individual Page
 * Template Post Type: post
 * 
 * This template displays an individual post.
 */

get_header();
include 'template-parts/add-post.php';
?>

<div class="container py-4 mt-5">
    <aside class="ms-3 float-end">
        <input type="search" class="form-control" placeholder="search..." />
        <div class="card mb-2">
            <div class="card-body">
                <div class="post_author_info">
                    <?php
                    $post_id = get_the_ID();
                    // Get the post author details
                    $author_id = get_post_field('post_author', $post_id);
                    $author_name = get_the_author_meta('display_name', $author_id);
                    $author_url = get_author_posts_url($author_id);
                    $author_avatar = get_avatar_url(get_the_author_meta('user_email', $author_id), array('size' => 32));
                    ?>
                    <a href="<?php echo esc_url($author_url); ?>" class="float-start">
                        <img class="author_image" src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" width="32" height="32" loading="lazy">
                    </a>
                    <div class="d-flex flex-column ps-2">
                        <a href="<?php echo esc_url($author_url); ?>" class="author_name text-dark">
                            <?php echo esc_html($author_name); ?>
                        </a>
                        <a href="<?php echo esc_url($author_url); ?>" class="author_tag text-secondary">forhire</a>
                    </div>
                </div>

            </div>
        </div>
        <ul class="list-unstyled">
            <?php
            // Get the top-level categories
            $categories = get_categories(array(
                'orderby' => 'name',
                'parent'  => 0,
                'hide_empty' => false
            ));
            // Loop through the categories
            foreach ($categories as $category) {
                $category_link = get_category_link($category->term_id);
                ?>
                    <li>
                        <a href="<?php echo esc_url($category_link); ?>">
                            <?php echo esc_html($category->name); ?>
                        </a>
                    </li>
                <?php
            }
            ?>
        </ul>
    </aside>
    <main class="">
        <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    // Get the post ID
                    $post_id = get_the_ID();
                    $slug = get_post_field('post_name', $post_id);
                    // Get all comments for the post
                    $comments = get_comments(array(
                        'post_id' => $post_id,
                        'status' => 'approve', // Only approved comments
                        'count' => true, // Retrieve comment count only
                        'orderby' => 'comment_date', // Order by comment date
                        'order' => 'ASC' // Ascending order
                    ));
                    ?>

                    <div class="card post_card">
                        <div class="card-body p-4 pt-3">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="featured-image">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                            <?php endif; ?>
                            <div class="post_title">
                                <strong><?php the_title(); ?></strong>
                            </div>
                            <div class="listing__date">
                                <time datetime="<?php the_time('c'); ?>" title="<?php the_time('l, F j, Y \a\t g:i A'); ?>">
                                    <?php the_time('j M'); ?>
                                </time>
                            </div>
                            <div class="tags_lists d-flex w-100 flex-wrap mb-3">
                                <?php
                                    $post_tags = get_the_tags();
                                    if ($post_tags) {
                                        foreach ($post_tags as $tag) {
                                            echo '<div class="badge bg-secondary me-1 mb-1 d-flex align-items-center">' . $tag->name . '</div>';
                                        }
                                    }
                                ?>
                            </div>
                            <div>
                                <?php the_content(); ?>
                            </div>
                            
                            <div class="post_reaction mt-3">
                                <div class="reactions_container d-flex align-items-center">
                                    <div class="likes me-3">
                                        <?php echo do_shortcode('[posts_like_dislike id='.$post_id.']');?>
                                    </div>
                                    <div class="comments" >
                                        <div class="fa fa-comments me-1"></div>
                                        <span><?php echo $comments; ?></span>
                                    </div>
                                </div>
                            </div>
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
                                            <div class="comment-content"><?php echo get_comment_text(); ?></div>
                                            <hr />
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
                            <div class="post_author_info h-100 my-2">
                                <?php
                                // Display the total number of comments
                                if ($comments <= 0) {
                                    echo '<div class="card card-body"><p class="m-0">No comments yet.</p></div>';
                                }

                                // Loop through each comment
                                $comment_args = array(
                                    'post_id' => $post_id, 
                                    'orderby' => 'comment_date', // Order by comment date
                                    'order' => 'ASC' // Ascending order
                                );
                                $comments_query = new WP_Comment_Query($comment_args);
                                if ($comments_query->have_comments()) {
                                    echo 'inside if';
                                    while ($comments_query->have_comments()) {
                                        echo 'inside wile';
                                        $comments_query->the_comment();
                                        // Get the author details and comment content
                                        $author_name = get_comment_author();
                                        $author_url = get_comment_author_url();
                                        $author_avatar = get_avatar_url(get_comment_author_email(), array('size' => 32));
                                        $comment_content = get_comment_text();
                                        ?>
                                        <a href="<?php echo esc_url($author_url); ?>" class="float-start mt-2">
                                            <img class="author_image" src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" width="32" height="32" loading="lazy">
                                        </a>
                                        <div class="d-flex flex-column ps-2">
                                            <div class="comment_card card">
                                                <div class="card-body">
                                                    <strong>
                                                        <a href="<?php echo esc_url($author_url); ?>" class="author_name text-dark text-capitalize"><?php echo esc_html($author_name); ?></a>
                                                    </strong>
                                                    <div class="mt-1"><?php echo esc_html($comment_content); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div> 
                        </div>
                    </div>

                    <?php
                }
            }
        ?>
    </main>
</div>


<?php
get_footer();
?>
