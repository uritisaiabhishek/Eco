<?php 

    function register_my_session() {
        if( !session_id() )
            session_start();
    }

    add_action('init', 'register_my_session');

    function my_theme_enqueue_styles() {
        // Enqueue Bootstrap stylesheet
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '1.0', 'all' );

        // Enqueue Font Awesome stylesheet
        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/vendor/fontawesome/css/all.min.css', array(), '1.0', 'all' );

        // Enqueue Theme stylesheet
        wp_enqueue_style( 'theme-styles', get_template_directory_uri() . '/assets/css/theme.css', array(), '1.0', 'all' );
    }
    // Add the function to the wp_enqueue_scripts action
    add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

    function my_theme_scripts() {

        // Enqueue Bootstrap JS
        wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '5.0.0', true );
        //   wp_enqueue_script('jquery');
        // Enqueue masonry JS
        wp_enqueue_script( 'masonry-js', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', array( 'jquery' ), '1.0.0', true );
        // Enqueue Custom JS
        wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ), '1.0.0', true );

    }
    add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );

    function mytheme_setup() {
        add_theme_support( 'custom-logo' );
    }
    add_action( 'after_setup_theme', 'mytheme_setup' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );

    function register_my_menus() {
        register_nav_menus(
            array(
                'header-navigation' => __( 'Header Menu' ),
                'footer-about' => __( 'Footer About Menu' ),
                'footer-quick-links' => __( 'Footer Quick Links Menu' ),
            )
        );
    }

    add_action( 'init', 'register_my_menus' ); 

    /* --------------------------------------
                Bootstrap 5 navwalker
    ----------------------------------------*/
    class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu{
        private $current_item;
        private $dropdown_menu_alignment_values = [
        'dropdown-menu-start',
        'dropdown-menu-end',
        'dropdown-menu-sm-start',
        'dropdown-menu-sm-end',
        'dropdown-menu-md-start',
        'dropdown-menu-md-end',
        'dropdown-menu-lg-start',
        'dropdown-menu-lg-end',
        'dropdown-menu-xl-start',
        'dropdown-menu-xl-end',
        'dropdown-menu-xxl-start',
        'dropdown-menu-xxl-end'
        ];
    
        function start_lvl(&$output, $depth = 0, $args = null)
        {
        $dropdown_menu_class[] = '';
        foreach($this->current_item->classes as $class) {
            if(in_array($class, $this->dropdown_menu_alignment_values)) {
            $dropdown_menu_class[] = $class;
            }
        }
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " dropdown-menu-start depth_$depth\">\n ";
        }
    
        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
        {
        $this->current_item = $item;
    
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
    
        $li_attributes = '';
        $class_names = $value = '';
    
        $classes = empty($item->classes) ? array() : (array) $item->classes;
    
        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = 'nav-item';
        $classes[] = 'nav-item-' . $item->ID;
        if ($depth && $args->walker->has_children) {
            $classes[] = 'dropdown-menu dropdown-menu-end';
        }
    
        $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';
    
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
    
        $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';
    
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
    
        $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
        $nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
        $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';
    
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
    
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    add_filter('template_redirect', function () {
        ob_start(null, 0, 0);
    });
    /* Prevent ob_end_flush() notice when in debug mode */
    if (WP_DEBUG) {
        remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
        add_action( 'shutdown', function() {
        while ( @ob_end_flush() );
        } );
    }
  

    function hide_admin_bar_for_specific_roles() {
        return false;
    }
    
    if (is_user_logged_in() && ! current_user_can( 'administrator' ) ) {
        add_filter('show_admin_bar', 'hide_admin_bar_for_specific_roles');
    }
    
    function keep_my_links($text) {
        global $post;
      if ( '' == $text ) {
          $text = get_the_content('');
          $text = apply_filters('the_content', $text);
          $text = str_replace('\]\]\>', ']]&gt;', $text);
          $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
          $text = strip_tags($text, '<a>');
        }
        return $text;
      }
      remove_filter('get_the_excerpt', 'wp_trim_excerpt');
      add_filter('get_the_excerpt', 'keep_my_links');
    // Add custom fields to user profile
    function custom_user_profile_fields($user) {
        ?>
        <h3><?php _e('Additional Profile Information', 'textdomain'); ?></h3>

        <table class="form-table">
            <tr>
                <th><label for="birthday"><?php _e('Birthday', 'textdomain'); ?></label></th>
                <td>
                    <input type="date" name="birthday" id="birthday" value="<?php echo esc_attr(get_the_author_meta('birthday', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Please enter your birthday.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="address"><?php _e('Address', 'textdomain'); ?></label></th>
                <td>
                    <textarea name="address" id="address" rows="4" class="regular-text"><?php echo esc_textarea(get_the_author_meta('address', $user->ID)); ?></textarea>
                    <span class="description"><?php _e('Please enter your address.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="education"><?php _e('education', 'textdomain'); ?></label></th>
                <td>
                    <textarea name="education" id="education" rows="4" class="regular-text"><?php echo esc_textarea(get_the_author_meta('education', $user->ID)); ?></textarea>
                    <span class="description"><?php _e('Please enter your education.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="location"><?php _e('Location', 'textdomain'); ?></label></th>
                <td>
                    <input type="text" name="location" id="location" value="<?php echo esc_attr(get_the_author_meta('location', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Please enter your location.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="is_profile_verified"><?php _e('Is Verified', 'textdomain'); ?></label></th>
                <td>
                    <select name="is_profile_verified" id="is_profile_verified">
                        <option value="">Select</option>
                        <option value="1" <?php if (esc_attr(get_the_author_meta('is_profile_verified', $user->ID)) == 1){echo 'selected';}; ?>>Verified</option>
                        <option value="0" <?php if (esc_attr(get_the_author_meta('is_profile_verified', $user->ID)) == 0){echo 'selected';}; ?>>No</option>
                    </select>
                    <span class="description"><?php _e('Please enter your location.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="expertise"><?php _e('Expertise', 'textdomain'); ?></label></th>
                <td>
                    <?php
                        $expertise = get_the_author_meta('expertise', $user->ID); // Get the selected values
                        $expertise_options = array(
                            'dotnet' => '.NET',
                            'java' => 'Java',
                            'c++' => 'C++',
                            'sql' => 'SQL',
                            'python' => 'Python',
                            'r' => 'R',
                            'html' => 'HTML',
                            'ladder' => 'Ladder',
                            'javascript' => 'JavaScript',
                            'spark' => 'SPARK',
                            'sas' => 'SAS',
                            'ruby' => 'Ruby',
                            'big_data_analysis' => 'Big Data Analysis',
                            'algorithms' => 'Algorithms',
                            'analytical_skills' => 'Analytical Skills',
                            'big_data' => 'Big Data',
                            'calculating' => 'Calculating',
                            'compiling_statistics' => 'Compiling Statistics',
                            'data_analytics' => 'Data Analytics',
                            'data_mining' => 'Data Mining',
                            'database_design' => 'Database Design',
                            'database_management' => 'Database Management',
                            'documentation' => 'Documentation',
                            'modeling' => 'Modeling',
                            'modification' => 'Modification',
                            'needs_analysis' => 'Needs Analysis',
                            'quantitative_research' => 'Quantitative Research',
                            'quantitative_reports' => 'Quantitative Reports',
                            'statistical_analysis' => 'Statistical Analysis',
                            'coding_and_programming' => 'Coding and Programming',
                            'network_architecture' => 'Network Architecture',
                            'network_security' => 'Network Security',
                            'networking' => 'Networking',
                            'new_technologies' => 'New Technologies',
                            'operating_systems' => 'Operating Systems',
                            'servers' => 'Servers',
                            'software' => 'Software',
                            'solution_delivery' => 'Solution Delivery',
                            'storage' => 'Storage',
                            'structures' => 'Structures',
                            'systems_analysis' => 'Systems Analysis',
                            'technical_support' => 'Technical Support',
                            'technology' => 'Technology',
                            'testing' => 'Testing',
                            'tools' => 'Tools',
                            'training' => 'Training',
                            'troubleshooting' => 'Troubleshooting',
                            'usability' => 'Usability',
                            'project_management' => 'Project Management',
                            'benchmarking' => 'Benchmarking',
                            'budget_planning' => 'Budget Planning',
                            'engineering' => 'Engineering',
                            'fabrication' => 'Fabrication',
                            'following_specifications' => 'Following Specifications',
                            'operations' => 'Operations',
                            'performance_review' => 'Performance Review',
                            'project_planning' => 'Project Planning',
                            'quality_assurance' => 'Quality Assurance',
                            'quality_control' => 'Quality Control',
                            'scheduling' => 'Scheduling',
                            'task_delegation' => 'Task Delegation',
                            'task_management' => 'Task Management',
                            'social_media_management' => 'Social Media Management',
                            'digital_marketing' => 'Digital Marketing',
                            'content_management_systems' => 'Content Management Systems (CMS)',
                            'blogging' => 'Blogging',
                            'digital_photography' => 'Digital Photography',
                            'digital_media' => 'Digital Media',
                            'networking' => 'Networking',
                            'search_engine_optimization' => 'Search Engine Optimization (SEO)',
                            'search_engine_marketing' => 'Search Engine Marketing (SEM)',
                            'web_analytics' => 'Web Analytics',
                            'automated_marketing_software' => 'Automated Marketing Software',
                            'technical_writing' => 'Technical Writing',
                            'information_security' => 'Information Security',
                            'microsoft_office_certifications' => 'Microsoft Office Certifications',
                            'video_creation' => 'Video Creation',
                            'customer_relationship_management' => 'Customer Relationship Management (CRM)',
                            'productivity_software' => 'Productivity Software',
                            'cloud_saas_services' => 'Cloud/SaaS Services',
                            'database_management' => 'Database Management',
                            'telecommunications' => 'Telecommunications',
                            'human_resources_software' => 'Human Resources Software',
                            'accounting_software' => 'Accounting Software',
                            'enterprise_resource_planning_software' => 'Enterprise Resource Planning (ERP) Software',
                            'database_software' => 'Database Software',
                            'query_software' => 'Query Software',
                            'blueprint_design' => 'Blueprint Design',
                            'medical_billing' => 'Medical Billing',
                            'medical_coding' => 'Medical Coding',
                            'sonography' => 'Sonography',
                            'structural_analysis' => 'Structural Analysis',
                            'artificial_intelligence' => 'Artificial Intelligence (AI)',
                            'mechanical_maintenance' => 'Mechanical Maintenance',
                            'manufacturing' => 'Manufacturing',
                            'inventory_management' => 'Inventory Management',
                            'numeracy' => 'Numeracy',
                            'information_management' => 'Information Management',
                            'hardware_verification_tools_techniques' => 'Hardware Verification Tools and Techniques',
                            'hardware_description_language' => 'Hardware Description Language (HDL)',
                            'music' => 'Music',
                            'dance' => 'Dance',
                            'art' => 'Art',
                            'martial_arts' => 'Martial Arts',
                            'football' => 'Football',
                            'cricket' => 'Cricket',
                            'chess' => 'Chess',
                            'caroms' => 'Caroms',
                        );
                        
                        foreach ($expertise_options as $value => $label) {
                            $checked = (is_array($expertise) && in_array($value, $expertise)) ? 'checked="checked"' : '';
                            ?>
                            <label>
                                <input type="checkbox" name="expertise" value="<?php echo esc_attr($value); ?>" <?php echo $checked; ?>>
                                <?php echo esc_html($label); ?>
                            </label><br>
                            <?php
                        }
                    ?>
                    <span class="description"><?php _e('Please select your expertise.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="mobilenumber"><?php _e('Mobile Number', 'textdomain'); ?></label></th>
                <td>
                    <input type="text" name="mobilenumber" id="mobilenumber" value="<?php echo esc_attr(get_the_author_meta('mobilenumber', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Please enter your mobilenumber.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="github_profile"><?php _e('Github Link', 'textdomain'); ?></label></th>
                <td>
                    <input type="text" name="github_profile" id="github_profile" value="<?php echo esc_attr(get_the_author_meta('github_profile', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Please enter your social media links.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="jobrole"><?php _e('jobrole', 'textdomain'); ?></label></th>
                <td>
                    <input type="text" name="jobrole" id="jobrole" value="<?php echo esc_attr(get_the_author_meta('jobrole', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Please enter your job title.', 'textdomain'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="company"><?php _e('Company', 'textdomain'); ?></label></th>
                <td>
                    <input type="text" name="company" id="company" value="<?php echo esc_attr(get_the_author_meta('company', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Please enter your company name.', 'textdomain'); ?></span>
                </td>
            </tr>
            <!-- Remove the following code for the language file field -->
            <!-- <tr>
                <th><label for="language_file"><?php _e('Language File', 'textdomain'); ?></label></th>
                <td>
                    <input type="text" name="language_file" id="language_file" value="<?php echo esc_attr(get_the_author_meta('language_file', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Please enter your language file.', 'textdomain'); ?></span>
                </td>
            </tr> -->
        </table>
        <?php
    }
    add_action('show_user_profile', 'custom_user_profile_fields');
    add_action('edit_user_profile', 'custom_user_profile_fields');

    // Save custom fields
    function save_custom_user_profile_fields($user_id) {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

        $fields = array(
            'birthday',
            'address',
            'mobilenumber',
            'github_profile',
            'location',
            'company',
            'jobrole',
            'employment',
            'how_can_i_help',
            'education',
            'my_traits',
            'expertise',
            'is_profile_verified'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                if (is_array($_POST[$field])) {
                    $value = array_map('sanitize_text_field', $_POST[$field]);
                } else {
                    $value = sanitize_text_field($_POST[$field]);
                }
                update_user_meta($user_id, $field, $value);
            } else {
                delete_user_meta($user_id, $field);
            }
        }
    }

    add_action('personal_options_update', 'save_custom_user_profile_fields');
    add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

    function hide_submenus_for_non_admins() {
        // Check if the current user is not an administrator
        if ( ! current_user_can( 'administrator' ) ) {
            // Hide the Pages submenu
            remove_menu_page( 'edit.php?post_type=page', 'edit.php?post_type=page' );
            // Hide the Tools submenu
            remove_menu_page( 'tools.php', 'tools.php' );
            // Hide the Comments submenu
            remove_menu_page( 'edit-comments.php', 'edit-comments.php' );
            // Hide the Comments submenu
            remove_menu_page( 'upload.php', 'upload.php' );
            // Hide the Comments submenu
            remove_menu_page( 'index.php', 'index.php' );
        }
    }
    add_action( 'admin_menu', 'hide_submenus_for_non_admins', 999 );

    function redirect_non_admin_dashboard() {
        // Check if the current user is not an administrator
        if ( !current_user_can( 'administrator' ) || !is_admin() ) {
            // Redirect to the front-end homepage
            wp_redirect( home_url() );
            exit;
        }
    }
    add_action( 'admin_init', 'redirect_non_admin_dashboard' );

    function restrict_category_creation() {
        $user = wp_get_current_user();

        // Check if the user is not an administrator
        if ( !current_user_can( 'administrator' ) ) {
            // Remove the capability to create new categories
            $user->remove_cap( 'manage_categories' );
        }
    }
    add_action( 'admin_init', 'restrict_category_creation' );

    function delete_post_action() {
        if (isset($_POST['delete_post_button'])) {
            $post_id = isset($_POST['delete_post_id']) ? intval($_POST['delete_post_id']) : 0;
            $current_user_id = get_current_user_id();
            $post_author_id = get_post_field('post_author', $post_id);
            $redirect_url = $_POST['redirect_url'];

            if (has_post_thumbnail($post_id)) {
                // Get the attachment ID of the featured image
                $attachment_id = get_post_thumbnail_id($post_id);
                
                // Get all the image sizes of the attachment
                $image_sizes = get_intermediate_image_sizes();
                
                // Loop through each image size and delete the corresponding image file
                foreach ($image_sizes as $size) {
                    // Get the file path of the image size
                    $file_path = get_attached_file($attachment_id, $size);
                    
                    // Delete the file from the server
                    if (file_exists($file_path)) {
                        wp_delete_file($file_path);
                    }
                }
                
                // Delete the original featured image
                wp_delete_attachment($attachment_id, true);
            }

            if (($current_user_id == $post_author_id) || current_user_can( 'administrator' )) {
                wp_delete_post($post_id, true);
                // Set your desired session message
                $_SESSION['message'] = 'Post Deleted successfully.';
                $_SESSION['status'] = 'success';
                // Redirect to a desired page after deleting the post
                wp_redirect($redirect_url);
                exit;
            }
        }
    }
    add_action('init', 'delete_post_action');
    
    // Add the following code to your theme's functions.php file or a custom plugin

    function create_testimonials_post_type() {
        $labels = array(
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'menu_name'          => 'Testimonials',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Testimonial',
            'edit'               => 'Edit',
            'edit_item'          => 'Edit Testimonial',
            'new_item'           => 'New Testimonial',
            'view'               => 'View',
            'view_item'          => 'View Testimonial',
            'search_items'       => 'Search Testimonials',
            'not_found'          => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in trash',
            'parent'             => 'Parent Testimonial'
        );
        
        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'testimonial' ),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => null,
            'supports'            => array( 'title', 'editor' ) // Customize the supported features
        );
        
        register_post_type( 'testimonial', $args );
    }
    add_action( 'init', 'create_testimonials_post_type' );
    function redirect_wp_admin_login() {
        // Check if the requested URL is the wp-login.php file
        if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
            // Redirect to your desired page
            wp_redirect(site_url().'/log-in');
            exit;
        }
    }
    if (!is_user_logged_in() || !current_user_can( 'administrator' )) {
        add_action('login_init', 'redirect_wp_admin_login');
    }
    
    
function redirect_after_comment_submission() {
    if (isset($_POST['submit'])) {
        $redirect_url = $_POST['redirect_url'];
        wp_redirect($redirect_url);
        exit();
    }
}
add_action('comment_post_redirect', 'redirect_after_comment_submission');



function add_custom_user_role($role, $display_name, $capabilities) {
    // Add the custom role
    add_role($role, $display_name, $capabilities);
}

function add_custom_roles() {
    // Add Course Manager role
    $course_manager_capabilities = array(
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => true,
        // Add additional capabilities as needed for course managers
    );
    add_custom_user_role('course_manager', 'Course Manager', $course_manager_capabilities);

    // Add Company Profile role
    $company_profile_capabilities = array(
        'read' => true,
        'edit_posts' => false,
        'delete_posts' => false,
        // Add additional capabilities as needed for company profiles
    );
    add_custom_user_role('company_profile', 'Company Profile', $company_profile_capabilities);

    // Add Company HR role
    $company_hr_capabilities = array(
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => true,
        // Add additional capabilities as needed for company HR
    );
    add_custom_user_role('company_hr', 'Company HR', $company_hr_capabilities);
}

add_action('init', 'add_custom_roles');

function display_post_count($post_types = array()) {
    $args = array(
        'post_type' => $post_types,  // Replace with the desired post type
        'posts_per_page' => -1, // Set the number of posts to display (-1 for all)
    );
    
    $query = new WP_Query($args);
    
    $post_count = $query->found_posts;
    
    echo $post_count;
}

function display_total_post_count($exclude_post_types = array()) {
    $args = array(
        'post_type' => 'post',  // Replace with the desired post type
        'posts_per_page' => -1, // Set the number of posts to display (-1 for all)
    );
    $query = new WP_Query($args);
    $post_count = $query->found_posts;    
    echo $post_count;
}

function display_user_role() {
    $current_user = wp_get_current_user();
    if ($current_user && !empty($current_user->roles)) {
        $user_role = $current_user->roles[0]; // Assuming the user has only one role
        return $user_role;
    } else {
        return false;
    }
}

function get_categories_count() {
    $category_count = wp_count_terms('category'); // Replace 'category' with your desired taxonomy
    return $category_count;
}

function count_posts_in_category($category_slug) {
    $category = get_category_by_slug($category_slug); // Get category object by slug
    if ($category) {
        $category_id = $category->term_id; // Get category ID
        $post_count = wp_count_posts()->publish; // Get total published post count

        $category_post_count = 0;
        if ($post_count > 0) {
            $category_post_count = wp_count_posts('post')->{"category_$category_id"}; // Get post count in the specific category
        }

        return $category_post_count;
    }
}
// Register Courses post type
function register_courses_post_type() {
    $labels = array(
        'name'               => 'Courses',
        'singular_name'      => 'Course',
        'menu_name'          => 'Courses',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Course',
        'edit'               => 'Edit',
        'edit_item'          => 'Edit Course',
        'new_item'           => 'New Course',
        'view'               => 'View',
        'view_item'          => 'View Course',
        'search_items'       => 'Search Courses',
        'not_found'          => 'No courses found',
        'not_found_in_trash' => 'No courses found in trash',
        'parent_item_colon'  => 'Parent Course:',
        'all_items'          => 'All Courses',
        'archives'           => 'Course Archives',
        'insert_into_item'   => 'Insert into course',
        'uploaded_to_this_item' => 'Uploaded to this course',
        'featured_image'        => 'Course Featured Image',
        'set_featured_image'    => 'Set course featured image',
        'remove_featured_image' => 'Remove course featured image',
        'use_featured_image'    => 'Use as course featured image',
        'filter_items_list'     => 'Filter courses list',
        'items_list_navigation' => 'Courses list navigation',
        'items_list'            => 'Courses list'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'courses' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
        'supports'            => array( 'title', 'editor', 'thumbnail' ) // Customize the supported features
    );

    register_post_type( 'courses', $args );
}
add_action( 'init', 'register_courses_post_type' );


// Register Jobs post type
function register_jobs_post_type() {
    $labels = array(
        'name'               => 'Jobs',
        'singular_name'      => 'Job',
        'menu_name'          => 'Jobs',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Job',
        'edit'               => 'Edit',
        'edit_item'          => 'Edit Job',
        'new_item'           => 'New Job',
        'view'               => 'View',
        'view_item'          => 'View Job',
        'search_items'       => 'Search Jobs',
        'not_found'          => 'No jobs found',
        'not_found_in_trash' => 'No jobs found in trash',
        'parent_item_colon'  => 'Parent Job:',
        'all_items'          => 'All Jobs',
        'archives'           => 'Job Archives',
        'insert_into_item'   => 'Insert into job',
        'uploaded_to_this_item' => 'Uploaded to this job',
        'featured_image'        => 'Job Featured Image',
        'set_featured_image'    => 'Set job featured image',
        'remove_featured_image' => 'Remove job featured image',
        'use_featured_image'    => 'Use as job featured image',
        'filter_items_list'     => 'Filter jobs list',
        'items_list_navigation' => 'Jobs list navigation',
        'items_list'            => 'Jobs list'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'jobs' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
        'supports'            => array( 'title', 'editor', 'thumbnail' ) // Customize the supported features
    );

    register_post_type( 'jobs', $args );
}
add_action( 'init', 'register_jobs_post_type' );

function custom_excerpt_length($length) {
    return 20; // You can adjust this number to control the length of the excerpt in words.
}

add_filter('excerpt_length', 'custom_excerpt_length');
function reassign_posts_on_user_delete( $user_id ) {
    if ( is_numeric( $user_id ) ) {
        $args = array(
            'author' => $user_id,
            'posts_per_page' => -1,
            'post_type' => 'post',
        );

        $user_posts = get_posts( $args );

        foreach ( $user_posts as $post ) {
            // Assign the posts to UserID 1 (or any other desired UserID)
            wp_update_post( array(
                'ID' => $post->ID,
                'post_author' => 1, // Change this to the desired UserID
            ) );
        }
    }
}
add_action( 'delete_user', 'reassign_posts_on_user_delete' );
// Hook into the publish_post action
add_action('publish_post', 'send_email_on_new_post', 10, 2);

function send_email_on_new_post($ID, $post) {
    // Get the list of users to notify
    $user_query = new WP_User_Query(array(
        'role' => 'subscriber', // Change this to the role of users you want to notify
    ));

    if (!empty($user_query->results)) {
        $subject = 'New Post Alert: ' . $post->post_title;
        $message = 'A new post has been published on our website. Check it out here: ' . get_permalink($ID);

        foreach ($user_query->results as $user) {
            // Send email to each user
            wp_mail($user->user_email, $subject, $message);
        }
    }
}

?>