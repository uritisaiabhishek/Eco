<?php 
    if(display_user_role() == 'administrator'){
        $roles = array('company_profile', 'course_manager', 'company_hr', 'editor');
        $users = get_users(array(
            'role__in' => $roles,
        ));
    }elseif(display_user_role() == 'company_profile'){
        $users = get_users(array('role' => 'company_hr'));	
    }
    
?>


<?php if (current_user_can('administrator') ) : ?>
    <div class="col-md-4">
        <div class="card card-body dashboard-cards">
            <a href="<?php echo site_url(); ?>/dashboard-posts">Posts</a>
            <span><?php echo display_total_post_count(array()); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-body dashboard-cards">
            <a href="<?php echo site_url(); ?>/dashboard-testimonials">Testimonials</a>
            <span><?php echo display_post_count(array('testimonial')); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-body dashboard-cards">
            <a href="<?php echo site_url(); ?>/dashboard-categories">Categories</a>
            <span><?php echo get_categories_count(); ?></span>
        </div>
    </div>
<?php endif; ?>
<?php if (current_user_can('administrator') || current_user_can('company_profile') ) : ?>
    <div class="col-md-4">
        <div class="card card-body dashboard-cards">
            <a href="<?php echo site_url(); ?>/dashboard">Total Users</a>
            <span><?php echo count($users); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-body dashboard-cards">
            <a href="<?php echo site_url(); ?>/dashboard-jobs">Jobs</a>
            <span><?php echo display_post_count(array('jobs')); ?></span>
        </div>
    </div>
<?php endif; ?>
<?php if (current_user_can('administrator') || current_user_can('course_manager') ) : ?>
    <div class="col-md-4">
        <div class="card card-body dashboard-cards">
            <a href="<?php echo site_url(); ?>/dashboard-courses">Courses</a>
            <span><?php echo display_post_count(array('courses')); ?></span>
        </div>
    </div>
<?php endif; ?>



