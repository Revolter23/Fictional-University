<?php

    get_header(); 
    pageBanner(array(
        'title' => "All Events",
        'subtitle' => "See the latest events here.",
    ));
    ?>

    <div class="container container--narrow page-section">
        <?php
            while(have_posts()) {
                the_post(); 
                get_template_part("templates/content", "event");
            }
            echo paginate_links();
        ?>

        <hr class="section-break">
        <p>Looking for past events? <a href="<?php echo site_url('/past-events'); ?>">Click here</a> to view our past events.</p>

    </div>

    <?php get_footer();

?>