<?php
    function university_post_types() {
    
    
    // Event post type

        register_post_type('event', array(
            'capability_type' => 'event',
            'map_meta_cap' => true,
            'supports' => array('title','editor','excerpt','custom-fields'),
            'rewrite' => array('slug' => 'events'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'category' => 'events',
            'labels' => array(
                'name' => 'Events',
                'add_new_item' => 'Add New Event',
                'all_items' => 'All Events',
                'singular_name' => 'Event',
                'edit_item' => 'Edit Event'

            ),
            'menu_icon' => 'dashicons-calendar'
        ));

            
        // Program post type
        register_post_type('program', array(
            'capability_type' => 'program',
            'map_meta_cap' => true,
            'supports' => array('title'),
            'rewrite' => array('slug' => 'programs'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'category' => 'events',
            'labels' => array(
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'all_items' => 'All Programs',
                'singular_name' => 'Program',
                'edit_item' => 'Edit Program'

            ),
            'menu_icon' => 'dashicons-awards'
        ));

        // Professor post type

        register_post_type('professor', array(
            'supports' => array('title','editor','thumbnail'), // adding thumbnail (also has to add to functions.php as post-thumbnail): enables the featured image in custom post types
            'public' => true,
            'show_in_rest' => true,
            'category' => 'professors',
            'labels' => array(
                'name' => 'Professors',
                'add_new_item' => 'Add New Professor',
                'all_items' => 'All Professors',
                'singular_name' => 'Professor',
                'edit_item' => 'Edit Professor'

            ),
            'menu_icon' => 'dashicons-welcome-learn-more'
        ));

         // Campuses post type

         register_post_type('campus', array(
            'capability_type' => 'campus',
            'map_meta_cap' => true,
            'supports' => array('title','editor','thumbnail'), // adding thumbnail (also has to add to functions.php as post-thumbnail): enables the featured image in custom post types
            'public' => true,
            'show_in_rest' => true,
            'category' => 'campuses',
            'has_archive' => true,
            'rewrite' => array('slug' => 'campuses'),
            'labels' => array(
                'name' => 'Campuses',
                'add_new_item' => 'Add New Campus',
                'all_items' => 'All Campuses',
                'singular_name' => 'Campus',
                'edit_item' => 'Edit Campus'

            ),
            'menu_icon' => 'dashicons-location-alt'
        ));

    // Register "note" post type 
    register_post_type('note', array(
        'capability_type' => 'note',
        'map_meta_cap' => true,
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'supports' => array('title','editor','excerpt'),
        'labels' => array(
            'name' => 'Notes',
            'add_new_item' => 'Add New Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note',
            'edit_item' => 'Edit Note'
        ),
        'menu_icon' => 'dashicons-welcome-write-blog'
    ));



     
    // Register "note" post type 
    register_post_type('like', array(
        'public' => false,
        'show_ui' => true,
        'supports' => array('title'),
        'labels' => array(
            'name' => 'Likes',
            'add_new_item' => 'Add New Like',
            'all_items' => 'All Likes',
            'singular_name' => 'Like',
            'edit_item' => 'Edit Like'
        ),
        'menu_icon' => 'dashicons-heart'
    ));

}
    add_action('init', 'university_post_types');
?>