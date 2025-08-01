<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ));
}

function universitySearchResults($data) {
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor', 'event', 'program'),
        's' => sanitize_text_field($data['term']),
        'posts_per_page' => -1
    ));

    $results = array(
        'generalInfo' => array(),
        'professor' => array(),
        'event' => array(),
        'program' => array()
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if(get_post_type() == 'post' OR get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            ));
        };

        if(get_post_type() == 'professor') {
            array_push($results['professor'], array(
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'authorName' => get_the_author(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
            ));
        };

        if(get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18);
            }

            array_push($results['event'], array(
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'authorName' => get_the_author(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        };

        if(get_post_type() == 'program') {
            array_push($results['program'], array(
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'authorName' => get_the_author(),
                'id' => get_the_id()
            ));
        };
    }

    if ($results['program']) {

        $programsMetaQuery = array(
        'relatiion' => 'OR',
        );

        foreach ($results['program'] as $item) {
            array_push($programsMetaQuery, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"'
            ));
        }

        $programRelationship = new WP_Query(array(
            'post_type' => array('professor', 'event'),
            'meta_query' => $programsMetaQuery
        ));

        while($programRelationship->have_posts()) {
            $programRelationship->the_post();

            if(get_post_type() == 'professor') {
                array_push($results['professor'], array(
                    'title' => get_the_title(),
                    'permalink' => get_permalink(),
                    'authorName' => get_the_author(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                ));
            };

            if(get_post_type() == 'event') {
                $eventDate = new DateTime(get_field('event_date'));
                $description = null;
                if (has_excerpt()) {
                    $description = get_the_excerpt();
                } else {
                    $description = wp_trim_words(get_the_content(), 18);
                }

                array_push($results['event'], array(
                    'title' => get_the_title(),
                    'permalink' => get_permalink(),
                    'authorName' => get_the_author(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'description' => $description
                ));
            };
        }

        $results['professor'] = array_values(array_unique($results['professor'], SORT_REGULAR));
        $results['event'] = array_values(array_unique($results['event'], SORT_REGULAR));
    }

    return $results;
}