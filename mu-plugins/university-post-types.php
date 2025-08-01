<?php

    function register_university_post_types() {
        // Register the 'University' custom post type
        register_post_type("event", array(
            'labels' => array(
                'name' => 'Events',
                'singular_name' => 'Event',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events',
            ),
            'public' => true,
            'show_in_rest' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'events'),
            'supports' => array('title', 'editor', 'excerpt'),
            'menu_icon' => 'dashicons-calendar',
            'capability_type' => 'event',
            'map_meta_cap' => true,
        ));

        register_post_type("program", array(
            'labels' => array(
                'name' => 'Programs',
                'singular_name' => 'Program',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs',
            ),
            'public' => true,
            'show_in_rest' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'programs'),
            'supports' => array('title'),
            'menu_icon' => 'dashicons-awards',
        ));

        register_post_type("professor", array(
            'labels' => array(
                'name' => 'Professors',
                'singular_name' => 'Professor',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                'all_items' => 'All Professors',
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-welcome-learn-more',
        ));

        register_post_type("note", array(
            'labels' => array(
                'name' => 'Notes',
                'singular_name' => 'Note',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes',
            ),
            'capability_type' => 'note',
            'map_meta_cap' => true,
            'public' => false,
            'show_ui' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor'),
            'menu_icon' => 'dashicons-welcome-write-blog',
        ));

        register_post_type("like", array(
            'labels' => array(
                'name' => 'Likes',
                'singular_name' => 'Like',
                'add_new_item' => 'Add New Like',
                'edit_item' => 'Edit Like',
                'all_items' => 'All Likes',
            ),
            'public' => false,
            'show_ui' => true,
            'supports' => array('title'),
            'menu_icon' => 'dashicons-heart',
        ));
    }

    add_action('init', 'register_university_post_types');