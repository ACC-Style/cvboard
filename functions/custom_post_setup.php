<?php
function cwpai_register_custom_post_type()
{
    $args = array(
        'public' => true,
        'label' => 'FAQ',
        'menu_icon' => 'dashicons-feedback',
        // Add other arguments as needed
    );
    register_post_type('faq', $args);
    $args = array(
        'public' => true,
        'label' => 'Videos',
        'menu_icon' => 'dashicons-format-video',
        // Add other arguments as needed
    );
    register_post_type('videos', $args);
    $args = array(
        'public' => true,
        'label' => 'Quotes',
        'menu_icon' => 'dashicons-format-chat',
        // Add other arguments as needed
    );
    register_post_type('quotes', $args);
    $args = array(
        'public' => true,
        'label' => 'Partners',
        'supports' => array('title'), 
        'menu_icon' => 'dashicons-bank',

        // Add other arguments as needed
    );
    register_post_type('partners', $args);
    $args = array(
        'public' => true,
        'label' => 'Press Releases',
        'menu_icon' => 'dashicons-media-text',
        // Add other arguments as needed
    );
    register_post_type('pressreleases', $args);
    $args = array(
        'public' => true,
        'label' => 'Pillars',
        'menu_icon' => 'dashicons-star-filled',
        // Add other arguments as needed
    );
    register_post_type('pillars', $args);
    $args = array(
        'public' => true,
        'label' => 'Milestones',
        'menu_icon' => 'dashicons-location',
        // Add other arguments as needed
    );
    register_post_type('milestones', $args);
    $args = array(
        'public' => true,
        'label' => 'Hero Slides',
        'supports' => array('title'), 
        'menu_icon' => 'dashicons-slides',
        'menu_position' => 6,
        // Add other arguments as needed
    );
    register_post_type('heroslides', $args);
}
add_action('init', 'cwpai_register_custom_post_type');

