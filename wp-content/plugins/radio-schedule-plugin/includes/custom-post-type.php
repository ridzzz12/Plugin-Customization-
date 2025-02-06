<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function register_program_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Programs',
            'singular_name' => 'Program',
        ),
        'public' => true,
        'show_ui' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'programs'),
    );
    register_post_type('program', $args);
}

add_action('init', 'register_program_post_type');
