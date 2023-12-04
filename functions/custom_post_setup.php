<?php
function cwpai_register_custom_post_type()
{
    $args = array(
        'public' => true,
        'label' => 'FAQ',
        // Add other arguments as needed
    );
    register_post_type('faq', $args);
    $args = array(
        'public' => true,
        'label' => 'Videos',
        // Add other arguments as needed
    );
    register_post_type('videos', $args);
    $args = array(
        'public' => true,
        'label' => 'Partners',
        // Add other arguments as needed
    );
    register_post_type('partners', $args);
    $args = array(
        'public' => true,
        'label' => 'Press Releases',
        // Add other arguments as needed
    );
    register_post_type('pressreleases', $args);
    $args = array(
        'public' => true,
        'label' => 'Pillars',
        // Add other arguments as needed
    );
    register_post_type('pillars', $args);
    $args = array(
        'public' => true,
        'label' => 'Milestones',
        // Add other arguments as needed
    );
    register_post_type('milestones', $args);
}
add_action('init', 'cwpai_register_custom_post_type');