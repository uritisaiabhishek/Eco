<?php
    get_header();
    include 'template-parts/add-post.php';
?>
<div class="container py-4 mt-5">
    <?php include 'template-parts/sidebar/sidebar.php'; ?>
    <!-- Main content starts here -->
	<main class="">
		<div class="row" data-masonry="{&quot;percentPosition&quot;: true }">
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
                        ?>
                        <article class="col-sm-6 col-lg-6 mb-4">
                            <div class="card post_card">
                                <div class="card-body p-4 pt-3">
                                    <div class="post_title">
                                        <a href="#"><?php the_title(); ?></a>
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
                                    <button class="position-absolute" type="button"  id="post_option_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="24" height="24" viewBox="0 0 24 24" class="crayons-icon" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 12a2 2 0 11-4 0 2 2 0 014 0zm7 0a2 2 0 11-4 0 2 2 0 014 0zm5 2a2 2 0 100-4 2 2 0 000 4z"></path>
                                        </svg>
                                    </button>
                                    <div class="dropdown">
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="post_option_dropdown">
                                            <li><a class="dropdown-item" href="#">Report Abuse</a></li>
                                        </ul>
                                    </div>
                                    <div class="post-content">
                                        <?php the_content(); ?>
                                    </div>
                                    <div class="post_author_info">
                                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-start">
                                        <img class="author_image" src="https://res.cloudinary.com/practicaldev/image/fetch/s--Yx3j7D69--/c_fill,f_auto,fl_progressive,h_90,q_auto,w_90/https://dev-to-uploads.s3.amazonaws.com/uploads/user/profile_image/669994/3d16dc0e-6d1f-4d30-a489-9d6b916d7297.jpg" alt="Atharva Shirdhankar" width="32" height="32" loading="lazy">
                                        </a>
                                        <div class="d-flex flex-column ps-2">
                                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="author_name text-dark"><?php the_author(); ?></a>
                                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="author_tag text-secondary">forhire</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
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