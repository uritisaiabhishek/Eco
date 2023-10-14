<?php
    get_header();
    include 'template-parts/add-post.php';
?>
<section class="search_output my-5">
    <div class="container">
        <?php if (have_posts()) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'your-theme-textdomain'), '<span>' . get_search_query() . '</span>'); ?></h1>
            </header>
            <div class="row">    
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="col-md-4">
                        <div class="card card-body">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            </header>
                            <div class="entry-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
    
            </div>
            <?php the_posts_navigation(); ?>
    
        <?php else : ?>
            <div class="my-5 pt-5 text-center">
                <header class="page-header">
                    <h4 class="page-title"><?php esc_html_e('Nothing Found', 'your-theme-textdomain'); ?></h4>
                </header>
        
                <div class="page-content">
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'your-theme-textdomain'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </div>
    
        <?php endif; ?>
    </div>
</section>

<?php 
    get_footer();
?>