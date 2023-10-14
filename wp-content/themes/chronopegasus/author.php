<?php 
    get_header(); 
    include('template-parts/add-post.php');
    include('template-parts/edit-profile.php');

    $current_user = wp_get_current_user();
    $user_id = get_the_author_meta('ID');
    $author_display_name = get_the_author_meta('display_name');
    $author_description = get_the_author_meta('description');
    $birthday = get_user_meta($current_user->ID, 'birthday', true);
    $user_info = get_userdata($current_user->ID);
    $email_id = $current_user->user_email;
    $profile_icon = get_avatar_url($current_user->user_email, ['size' => 32]);
    $background_image = get_user_meta($current_user->ID, 'birthday', true);
    $address = get_user_meta($current_user->ID, 'address', true);
    $how_can_i_help = get_user_meta($current_user->ID, 'how_can_i_help', true);
    $my_traits = get_user_meta($current_user->ID, 'my_traits', true);
    $is_profile_verified = get_user_meta($current_user->ID, 'is_profile_verified', true);
    $location = get_user_meta($current_user->ID, 'location', true);
    $education = get_user_meta($current_user->ID, 'education', true);
    $github_profile = get_user_meta($current_user->ID, 'github_profile', true);
    $jobrole = get_user_meta($current_user->ID, 'jobrole', true);
    $company = get_user_meta($current_user->ID, 'company', true);
    $mobilenumber = get_user_meta($current_user->ID, 'mobilenumber', true);
    $expertise = get_user_meta($current_user->ID, 'expertise', true);
    $expertise = unserialize($expertise);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_feedback'])) {
        $testimonials_author = $current_user->ID;
        $testimonials_user = $user_id;
        $testimonials_title = $_POST['testimonials_title'];
        $testimonials_message = $_POST['testimonials_message'];
    
        // Create a new testimonial post
        $testimonial_data = array(
            'post_title'   => $testimonials_title,
            'post_content' => $testimonials_message,
            'post_type'    => 'testimonial',
            'post_status'  => 'publish',
            'meta_input'   => array(
                'testimony_author' => $testimonials_author,
                'testimony_user'   => $testimonials_user,
            ),
        );
    
        $testimonial_id = wp_insert_post($testimonial_data);
    
        if ($testimonial_id) {
            $_SESSION['message'] = 'Testimonial added successfully.';
            $_SESSION['status'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to add testimonial.';
            $_SESSION['status'] = 'error';
        }
    
        // Redirect to the author page
        $redirect_url = get_author_posts_url($testimonials_user);
        wp_redirect($redirect_url);
        exit;
    }
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
    
?>
  <main class="profile">
    <style>
        section{
            min-height: 90vh;
            max-height: 90vh;
            height: 90vh;
            overflow-y: auto;
        }
        
    .autoplay-progress {
      position: absolute;
      right: 16px;
      bottom: 16px;
      z-index: 10;
      width: 48px;
      height: 48px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: var(--swiper-theme-color);
    }

    .autoplay-progress svg {
      --progress: 0;
      position: absolute;
      left: 0;
      top: 0px;
      z-index: 10;
      width: 100%;
      height: 100%;
      stroke-width: 4px;
      stroke: var(--swiper-theme-color);
      fill: none;
      stroke-dashoffset: calc(125.6 * (1 - var(--progress)));
      stroke-dasharray: 125.6;
      transform: rotate(-90deg);
    }
    </style>
    <aside>
      <?php if($is_profile_verified === '1'){echo '<i class="fa fa-check"></i>';}; ?>  
      <ul class="regular-menu">
        <li class="menu-item" >
            <div class="profile_image d-none">
                <?php
                    if ($profile_icon) {
                        echo '<img src="' . $profile_icon . '" alt="'.esc_html($author_display_name).'" width="150" height="150">';
                    } else {
                        echo '<img src="https://dummyimage.com/16:16x150/" alt="'.esc_html($author_display_name).'" width="150" height="150">';
                    }
                ?>
            </div>
        </li>
        <li class="menu-item" id="hero">Profile</li>
        <li class="menu-item" id="about">About</li>
        <li class="menu-item" id="education">Education</li>
        <li class="menu-item" id="activity">Activity</li>
        <li class="menu-item" id="testimonials">Testimonials</li>
        <li class="menu-item" id="skills">Skills</li>
      </ul>
    </aside>
    <div class="about_content">
        <section class="hero d-lg-block">
            <div class="hero-area horizontal clearfix">
                <div class="hero-content">
                    <h5>Hello I'm</h5>
                    <h2 style="font-size: 3rem;"><?php echo esc_html($author_display_name); ?></h2>
                    <h3 style="font-size: 2rem;" class="mb-4">
                        <?php 
                            if(isset($jobrole) && !empty($jobrole)){
                                echo $jobrole;
                            } 
                        ?>
                    </h3>
                    <div class="row">
                        <?php
                            if(isset($mobilenumber) && $mobilenumber != ''){
                                ?>
                                  <div class="col-md-4 mb-2">
                                    <a href="<?php echo 'tel:'.$mobilenumber; ?>"  class="d-flex align-items-center">
                                        <div class="fa fa-phone me-2"></div>
                                        <?php echo $mobilenumber; ?>
                                    </a>
                                    </div>
                                    <?php
                                }
                            ?>
    
                            <?php
                                if(isset($email_id) && $email_id != ''){
                                    ?>
                        <div class="col-md-4 mb-2">
                                    <a href="<?php echo 'mailto:'.$email_id; ?>"  class="d-flex align-items-center">
                                        <div class="fa fa-envelope me-2"></div>
                                        <?php echo $email_id; ?>
                                    </a>
                        </div>
                                    <?php
                                }
                            ?>
                            <?php if (!empty($location)) { ?>
                        <div class="col-md-4 mb-2 d-flex align-items-center">
                                <div class="fa fa-map-marker me-2"></div>
                                Location :<?php echo $location; ?>
                            </div>
                            <?php } ?>
                            <?php if (!empty($github_profile)) { ?>
                        <div class="col-md-4 mb-2 d-flex align-items-center">
                                <div class="fab fa-github me-2"></div>
                                Github :<?php echo $github_profile; ?>
                            </div>
                            <?php } ?>
                    </div>

                </div> 
            </div>
        </section>
        <section class="skills card m-3 d-lg-none">
            <div class="container"> 
                <div class="card-body">
                    <h4>My skills</h4>
                    <style>
                        .skill_card{
                            height: 10rem;
                            width: 10rem;
                            margin: 1rem;
                            
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            border-radius: 50%;
                            border : 0.6rem solid #000;
                        }
                    </style>
                    <div class="d-flex flex-wrap">
                        <?php
                            if(!empty($expertise)){
                                foreach ($expertise as $skill){
                                ?>
                                    <div class="skill_card"><?php echo $skill; ?></div>
                                <?php
                                }
                            }else{
                                echo '<span>No expertise selected</span>';
                            }
                        ?>

                    </div>
                </div>
            </div>
        </section>
        
        <section class="about card m-3 d-lg-none">
            <div class="container mb-5">
                <div class=" py-5 card-body">
                    <h4>About Me</h4>
                    <?php echo get_user_meta( $current_user-> ID )['description'][0]; ?></div>
                </div>
        </section>
        <section class="education d-lg-none">
            <div class="container"> 
                <?php if(isset($education) && !empty($education)){ ?>
                    <div class="card profile_left_card mb-2">
                        <div class="card-header fw-bold">Education</div>
                        <div class="card-body">
                            <p><?php echo $education; ?></p>
                        </div>
                    </div>
                <?php } ?>
                <?php if(isset($how_can_i_help) && !empty($how_can_i_help)){ ?>
                    <div class="card profile_left_card mb-2">
                        <div class="card-header fw-bold">How can i help</div>
                        <div class="card-body">
                            <ul>
                                <?php 
                                    $how_can_i_help = explode(',', $how_can_i_help);
                                    foreach ($how_can_i_help as $value) {
                                        echo '<li>'.$value . '</li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                <?php if(isset($my_traits) && !empty($my_traits)){ ?>
                <div class="card profile_left_card mb-2">
                    <div class="card-header fw-bold">My traits</div>
                    <div class="card-body">
                        <ul>
                            <?php 
                                $my_traits = explode(',', $my_traits);
                                foreach ($my_traits as $value) {
                                    echo '<li>'.$value . '</li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
      <section class="testimonials card m-3 d-lg-none">
        <div class="container">
            
        <?php 
                $args = array(
                    'post_type' => 'testimonial', // Replace 'your_post_type' with the actual post type you want to query
                    'meta_query' => array(
                        'relation' => 'AND', // Use 'AND' for an AND condition, or 'OR' for an OR condition
                        array(
                            'key' => 'testimony_user', // Replace 'meta_key_1' with the first meta key you want to check
                            'value' => $user_id, // Replace 'value_1' with the value you want to check for meta_key_1
                            'compare' => '=', // Use '=' for exact match
                        ),
                        array(
                            'key' => 'testimony_author', // Replace 'meta_key_2' with the second meta key you want to check
                            'value' => $current_user->ID, // Replace 'value_2' with the value you want to check for meta_key_2
                            'compare' => '=', // Use '=' for exact match
                        ),
                    ),
                );
                $query = new WP_Query( $args ); 
            ?>
            <?php if($user_id != $current_user->ID && !($query->have_posts())){ ?>
                <div class="col-12">
                    <form method="POST" class="card">
                        <div class="card-body">
                            <div class="form-roup mb-2">
                                <input class="form-control" type="text" name="testimonials_title" value="test title" />
                            </div>
                            <div class="form-roup mb-2">
                                <textarea class="form-control" name="testimonials_message" id="testimonials_message" cols="30" rows="3"></textarea>
                            </div>
                            <input class="btn btn-primary w-100" type="submit" value="Add" name="add_feedback" />
                        </div>
                    </form>
                </div>
            <?php } ?>
            <?php
                $args = array(
                    'post_type'      => 'testimonial',
                    'posts_per_page' => 10,
                    'meta_query'     => array(
                        array(
                            'key'     => 'testimony_user',
                            'value'   => $user_id,
                            'compare' => '=',
                        ),
                    ),
                );
                $testimonials = new WP_Query( $args );
                if ( $testimonials->have_posts() ) {
                    ?>
                    <div class="swiper testimonials_slider">
                        <div class="swiper-wrapper">

                            
                            <?php
                            while ( $testimonials->have_posts() ) {
                                $testimonials->the_post();
                                // those who give feedback
                                $testimony_author = get_field( 'testimony_author');
                                $testimony_user   = get_field( 'testimony_user' );
                                if($user_id == $testimony_user){ 
                                    ?> 
                                    
                                    
                                    <div class="swiper-slide">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4><?php the_title(); ?></h4>
                                                <p><?php the_content(); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <?php
                    wp_reset_postdata();
                } else {
                    ?> 
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-center m-0 p-0">No Testimonials yet</h5> 
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
      </section>
      <section class="activity d-lg-none">
        <div class="container">
          <div class="card post_card my-2">
              <div class="card-body p-4 pt-3 profile_activity">
                  <!-- Display the author's activity -->
                  <h2><?php echo $author_display_name; ?>'s Activity</h2>
                  <?php 
                  // Get Author's Posts
                      $author_posts_args = array(
                          'author' => $user_id,
                          'post_status' => 'publish',
                          'posts_per_page' => -1,
                      );
                      $author_posts = new WP_Query($author_posts_args);

                      // Get Author Comments
                      $author_comments_args = array(
                          'user_id' => $user_id,
                          'number' => -1, // Limit the number of comments shown, change as needed
                      );
                      $author_comments = get_comments($author_comments_args);
                      $interactions = array();

                      // Get Author's Posts
                      while ($author_posts->have_posts()) {
                          $author_posts->the_post();
                          $interaction = new stdClass();
                          $interaction->type = 'post';
                          $interaction->timestamp = get_the_time('U');
                          $interaction->title = get_the_title();
                          $interactions[] = $interaction;
                      }
                      wp_reset_postdata();

                      // Get Author's Comments
                      foreach ($author_comments as $comment) {
                          $interaction = new stdClass();
                          $interaction->type = 'comment';
                          $interaction->timestamp = get_comment_time('U', true);
                          $interaction->title = get_the_title($comment->comment_post_ID);
                          $interaction->content = $comment->comment_content;
                          $interactions[] = $interaction;
                      }

                      // Sort the interactions by date
                      usort($interactions, function ($a, $b) {
                          return $b->timestamp - $a->timestamp;
                      });

                      // Display the interactions
                      if (!empty($interactions)) {
                          echo '<ul>';
                          foreach ($interactions as $interaction) {
                              echo '<li>';
                              if ($interaction->type === 'post') {
                                  echo get_the_time('Y-m-d H:i:s', $interaction->timestamp) . ' - Post: <a href="' . get_permalink() . '">' . $interaction->title . '</a>';
                              } else {
                                  echo get_comment_time('Y-m-d H:i:s', true, $interaction->comment_ID) . ' - Comment on Post: <a href="' . get_permalink($interaction->comment_post_ID) . '">' . $interaction->title . '</a><br>' . $interaction->content;
                              }
                              echo '</li>';
                          }
                          echo '</ul>';
                      } else {
                          echo '<p>No interactions yet.</p>';
                      }
                  ?>
              </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <?php
                    // check the this page user id
                    $author_slug = get_query_var('author_name');
                    if ($author_slug) { 
                        $author_id =$current_user->ID; 
                    }
                    if (is_user_logged_in() && get_current_user_id() == $author_id) : 
                ?>
                    <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <form method="POST" enctype="multipart/form-data" class="modal-content" >
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editProfileLabel">Edit Profile</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="edit_user_id" value="<?php echo $author_id; ?>">
                                    <input type="hidden" name="update_user_profile" value="<?php echo $author_slug; ?>">
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="birthday">Birthday</label>
                                        <input class="form-control" type="date" name="birthday" id="birthday" value="<?php echo $birthday; ?>">
                                    </div>
                                    
                                    <div class="form-group mb-2 d-flex flex-wrap text-dark">
                                        <label class="form-label w-100 float-start text-start">Expertise</label>
                                        <?php
                                            foreach ($expertise_options as $value => $label) {  
                                                if( !empty($expertise) ){
                                                    if(in_array($value, $expertise)){
                                                        $checked = 'checked';
                                                    }
                                                    else{
                                                        $checked = '';
                                                    }
                                                }                                       
                                                else{
                                                    $checked = '';
                                                }
                                                ?>
                                                <div class="form-check me-3 mb-2">
                                                    <input class="form-check-input" type="checkbox" name="expertise[]" id="<?php echo 'expertise-' . $value; ?>" value="<?php echo $value; ?>" <?php echo $checked; ?>>
                                                    <label class="form-check-label" for="<?php echo 'expertise-' . $value; ?>">
                                                        <?php echo $label; ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="description">Description</label>
                                        <textarea class="form-control" name="description" id="description"><?php echo esc_textarea(get_user_meta($current_user->ID, 'description', true)); ?></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="education">education</label>
                                        <textarea class="form-control" name="education" id="address"><?php echo $education; ?></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="address">Address</label>
                                        <textarea class="form-control" name="address" id="address"><?php echo $address; ?></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="how_can_i_help">how_can_i_help</label>
                                        <textarea class="form-control" name="how_can_i_help" id="how_can_i_help"><?php echo $how_can_i_help; ?></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="my_traits">my_traits</label>
                                        <textarea class="form-control" name="my_traits" id="my_traits"><?php echo $my_traits; ?></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="location">Location</label>
                                        <input class="form-control" type="text" name="location" id="location" value="<?php echo $location; ?>">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="github_profile">GitHub Profile</label>
                                        <input class="form-control" type="text" name="github_profile" id="github_profile" value="<?php echo $github_profile; ?>">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="mobilenumber">Your Mobile Number</label>
                                        <input class="form-control" type="text" name="mobilenumber" id="mobilenumber" value="<?php echo $mobilenumber; ?>">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="jobrole">jobrole</label>
                                        <input class="form-control" type="text" name="jobrole" id="jobrole" value="<?php echo $jobrole; ?>">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label w-100 float-start text-start" for="company">Company</label>
                                        <input class="form-control" type="text" name="company" id="company" value="<?php echo $company; ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" name="profile_edit" value="Update Profile">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const header = document.querySelector('header');
        const hero = document.querySelector('.hero');
        const menuItems = document.querySelectorAll('.menu-item');
        const sections = document.querySelectorAll('.about_content section');
        const mainSection = document.querySelector('main');
        const heightofSection = (100 - (header.clientHeight * 100 / window.innerHeight)) + "vh";
        mainSection.style.marginTop = header.clientHeight + 'px';
        // Set the height for all section tags
        hero.style.height = heightofSection;
        menuItems.forEach((menuItem) => {
            menuItem.addEventListener('click', function () {
                // Show the corresponding section and hide others
                const targetSectionClass = menuItem.id;
                pageSelectInner(targetSectionClass);
            });
        });
        function pageSelectInner(targetSectionClass) {
            sections.forEach((section) => {
                if (section.classList.contains(targetSectionClass)) {
                    section.classList.add('d-lg-block');
                    section.classList.remove('d-lg-none');
                } else {
                    section.classList.add('d-lg-none');
                    section.classList.remove('d-lg-block');
                }
            });
        }
    });

    </script>    
    <?php wp_footer(); ?> 
    
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".testimonials_slider", {
            slidesPerView: 2,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                renderBullet: function (index, className) {
                return '<span class="' + className + '">' + (index + 1) + "</span>";
                },
            },
            on: {
                autoplayTimeLeft(s, time, progress) {
                progressCircle.style.setProperty("--progress", 1 - progress);
                progressContent.textContent = `${Math.ceil(time / 1000)}s`;
                }
            }
        });
    </script> 
</body>
</html>