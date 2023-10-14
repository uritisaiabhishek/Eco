<?php 
    get_header();
    include 'template-parts/add-post.php'; 
?>

<div class="container py-4 mt-5">
    <?php include 'template-parts/sidebar/sidebar.php'; ?>

    <main class="">
        <div class="row" data-masonry="{&quot;percentPosition&quot;: true }">

            <?php 
                if (have_posts()) : 
                    while (have_posts()) : the_post();
                        $post_id = get_the_ID();
                        $slug = get_post_field('post_name', $post_id);  
                        // Get the post categories
                        $categories = get_the_category($post_id);
                        // Get all comments for the post
                        $comments = get_comments(
                            array(
                                'post_id' => $post_id,
                                'status' => 'approve', // Only approved comments
                                'count' => true // Retrieve comment count only
                            )
                        ); 
            ?>
                <div class="col-sm-6 col-lg-6 mb-4">
                    <div class="card post_card">
                        <div class="card-body p-4 pt-3">
                            <div class="post_title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </div>
                            <div class="listing__date">
                                <time datetime="<?php the_time('c'); ?>" title="<?php the_time('l, j F, Y \a\t g:i a'); ?>">
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
                            <button class="position-absolute d-none" type="button" id="post_option_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="24" height="24" viewBox="0 0 24 24" class="crayons-icon" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 12a2 2 0 11-4 0 2 2 0 014 0zm7 0a2 2 0 11-4 0 2 2 0 014 0zm5 2a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            </button>
                            <div class="dropdown d-none">
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="post_option_dropdown">
                                    <li><a class="dropdown-item" href="#">Report Abuse</a></li>
                                </ul>
                            </div>
                            <div class="post-content">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="post_author_info">
                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-start">
                                    <img class="author_image" src="<?php echo get_template_directory_uri(); ?>/assets/images/default.jpg" alt="<?php the_author(); ?>" width="32" height="32" loading="lazy">
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
                                    <div class="comments" >
                                        <div class="fa fa-comments me-1"></div>
                                        <span><?php echo $comments; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            else : ?>
                <div class="col mb-4">
                    <div class="card card-body p-4 text-center">
                        <p class="fw-bold fs-3 p-0"><?php esc_html_e('No posts found.'); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </main>
</div>

<?php get_footer(); ?>
