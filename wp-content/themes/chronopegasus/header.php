<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
      <?php 
        if(is_front_page()){
          echo bloginfo('name');  
        }else{
          echo wp_title();
          echo ' - ';
          echo bloginfo('name'); 
        }
      ?>
    </title>
      <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <?php wp_head(); ?>
</head>
<body>
    <?php 
      if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo '<div id="session_message" class="alert alert-'.$_SESSION['status'].' alert-dismissible fade show">'.$_SESSION['message'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        // Unset the session variable after the alert is closed
        unset($_SESSION['message']);
        unset($_SESSION['status']);
      }

    ?>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="" width="50" height="40">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <form role="search" method="get" class="search_form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'your-theme-textdomain' ); ?></span>
                    <input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'your-theme-textdomain' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit" class="search-submit border-0 bg-transperent">
                        <div class="fa fa-search"></div>
                    </button>
                </form> 
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <?php
                    if (is_user_logged_in()) {
                      // User is logged in
                      $current_user = wp_get_current_user();
                      $username = $current_user->display_name;
                      $author_url = get_author_posts_url($current_user->ID);
                      // Generate logout URL with redirect parameter
                      $redirect_url = home_url( '/log-in' ); // Replace with your desired redirect page URL
                      $logout_url = wp_logout_url( $redirect_url );
                    ?>  
                      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                        <li class="nav-item">
                          <!-- Button trigger modal -->
                          <button type="button" class="btn nav-link bg-none border-0" data-bs-toggle="modal" data-bs-target="#addpostModal">
                              + Add Post
                          </button>
                        </li>                 
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, <?php echo $username; ?>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <?php if (current_user_can('administrator') || (display_user_role() == 'company_profile') ) : ?>
                                <li><a class="dropdown-item" href="<?php echo site_url(); ?>/dashboard">Dashboard</a></li>
                            <?php endif; ?>
                            <?php if ( display_user_role() == 'course_manager') : ?>
                                <li><a class="dropdown-item" href="<?php echo site_url(); ?>/dashboard-courses">Dashboard</a></li>
                            <?php endif; ?>
                            <?php if ( display_user_role() == 'company_hr') : ?>
                                <li><a class="dropdown-item" href="<?php echo site_url(); ?>/dashboard-jobs">Dashboard</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?php echo $author_url; ?>">Profile</a></li>
                            <li>
                                <button type="button" class="bg-none border-0 w-100 text-start py-2 px-3" data-bs-toggle="modal" data-bs-target="#editProfile">
                                    Edit
                                </button>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo esc_url( $logout_url ); ?>">Logout</a></li>
                              

                          </ul>
                        </li>
                        
        <li  class="nav-item tablet">
            <a class="nav-link" href="<?php echo site_url(); ?>/jobs">
                All Jobs
            </a>
        </li>
        <li class="nav-item tablet">
            <a class="nav-link" href="<?php echo site_url(); ?>/courses">
                Courses
            </a>
        </li>
        <?php        
        // Get all categories
        $categories = get_categories(array(
            'orderby' => 'name',
            'parent'  => 0,
            'hide_empty' => false
        ));
        // Loop through the categories
        foreach ($categories as $category) {
            $category_link = get_category_link($category->term_id);
            ?>
                <li class="nav-item tablet">
                    <a class="nav-link" href="<?php echo esc_url($category_link); ?>">
                        <?php echo esc_html($category->name); ?>
                    </a>
                </li>
            <?php
        }
        ?>
                      </ul>
                    <?php
                      include 'template-parts/add-post.php';
                      } else {
                        // User is not logged in
                        wp_nav_menu(
                            array(
                                'theme_location' => 'header-navigation', 
                                'container' => false,
                                'menu_class' => '',
                                'fallback_cb' => '__return_false',
                                'items_wrap' => '<ul id="%1$s" class="navbar-nav ms-auto mb-2 mb-lg-0 %2$s">%3$s</ul>',
                                'depth' => -1,
                                'walker' => new bootstrap_5_wp_nav_menu_walker()
                            )
                        );
                      }
                    ?>
                </div>
            </div>
        </nav>
    </header>
