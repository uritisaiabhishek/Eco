<!-- Sidebar comes here -->
<aside class="desktop">
    <ul class="list-unstyled">
        <li>
            <a href="<?php echo site_url(); ?>/jobs">
                All Jobs
            </a>
        </li>
        <li>
            <a href="<?php echo site_url(); ?>/courses">
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
