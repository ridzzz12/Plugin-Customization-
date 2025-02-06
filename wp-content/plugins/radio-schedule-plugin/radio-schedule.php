<?php
/**
 * Plugin Name: Radio Schedule Plugin
 * Description: A custom plugin to manage and display radio program schedules.
 * Version: 1.0
 * Author: Your Name
 * Text Domain: radio-schedule
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register Custom Post Type 'Program'
function register_program_post_type() {
    $labels = array(
        'name'               => 'Programs',
        'singular_name'      => 'Program',
        'menu_name'          => 'Programs',
        'name_admin_bar'     => 'Program',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Program',
        'new_item'           => 'New Program',
        'edit_item'          => 'Edit Program',
        'view_item'          => 'View Program',
        'all_items'          => 'All Programs',
        'search_items'       => 'Search Programs',
        'parent_item_colon'  => 'Parent Programs:',
        'not_found'          => 'No programs found.',
        'not_found_in_trash' => 'No programs found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 20,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'has_archive'        => true,
        'show_in_rest'       => true,
        'rewrite'            => array('slug' => 'programs'),
    );

    register_post_type('program', $args);
}
add_action('init', 'register_program_post_type');

// Add meta boxes for Program custom post type
function add_program_meta_boxes() {
    add_meta_box(
        'program_details',  // Meta box ID
        'Program Details',   // Meta box title
        'program_meta_box_callback',  // Callback function to display the meta box
        'program',           // Post type
        'normal',            // Context (normal means main editor area)
        'high'               // Priority (high means at the top of the editor area)
    );
}
add_action('add_meta_boxes', 'add_program_meta_boxes');

// Callback function to display the fields inside the meta box
function program_meta_box_callback($post) {
    // Nonce field for security
    wp_nonce_field('save_program_meta', 'program_meta_nonce');

    // Retrieve existing values from the post meta, or use default values
    $start_date = get_post_meta($post->ID, '_program_start_date', true);
    $end_date = get_post_meta($post->ID, '_program_end_date', true);
    $broadcast_schedule = get_post_meta($post->ID, '_broadcast_schedule', true);

    // Display the input fields
    echo '<div class="program-meta-box">';
    echo '<label for="program_start_date">Start Date:</label>';
    echo '<input type="date" id="program_start_date" name="program_start_date" value="' . esc_attr($start_date) . '" /><br>';

    echo '<label for="program_end_date">End Date:</label>';
    echo '<input type="date" id="program_end_date" name="program_end_date" value="' . esc_attr($end_date) . '" /><br>';

    echo '<label for="broadcast_schedule">Broadcast Schedule (JSON):</label>';
    echo '<textarea id="broadcast_schedule" name="broadcast_schedule" rows="5" cols="50">' . esc_textarea($broadcast_schedule) . '</textarea>';
    echo '</div>';
}

// Save the meta box data when the program post is saved
function save_program_meta_data($post_id) {
    // Check if nonce is valid to prevent unauthorized saves
    if (!isset($_POST['program_meta_nonce']) || !wp_verify_nonce($_POST['program_meta_nonce'], 'save_program_meta')) {
        return;
    }

    // Check if user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the custom fields
    if (isset($_POST['program_start_date'])) {
        update_post_meta($post_id, '_program_start_date', sanitize_text_field($_POST['program_start_date']));
    }

    if (isset($_POST['program_end_date'])) {
        update_post_meta($post_id, '_program_end_date', sanitize_text_field($_POST['program_end_date']));
    }

    if (isset($_POST['broadcast_schedule'])) {
        $schedule = sanitize_textarea_field($_POST['broadcast_schedule']);
        // Validate JSON before saving
        if (json_decode($schedule) !== null) {
            update_post_meta($post_id, '_broadcast_schedule', $schedule);
        } else {
            error_log('Invalid JSON in broadcast schedule for post ID: ' . $post_id);
        }
    }
}
add_action('save_post', 'save_program_meta_data');

// Display the radio schedule
function display_radio_schedule() {
    // Fetch all programs
    $args = array(
        'post_type' => 'program',
        'posts_per_page' => -1,  // Fetch all programs
        'post_status' => 'publish',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="program-schedule">';
        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $broadcast_schedule = '{"Mon": "08:00", "Tue": "09:00", "Wed": "10:00"}'; // Hardcoded JSON for testing

            // Display the program info
            echo '<div class="program">';
            echo '<h2>' . get_the_title() . '</h2>';
            echo '<p>' . get_the_content() . '</p>';

            // Fetch and display start & end dates
            $start_date = get_post_meta($post_id, '_program_start_date', true);
            $end_date = get_post_meta($post_id, '_program_end_date', true);
            echo '<p><strong>Start Date:</strong> ' . esc_html($start_date) . '</p>';
            echo '<p><strong>End Date:</strong> ' . esc_html($end_date) . '</p>';

            if (!empty($broadcast_schedule)) {
                // Decode the JSON schedule
                $schedule = json_decode($broadcast_schedule, true);

                if ($schedule && is_array($schedule)) {
                    echo '<p><strong>Broadcast Schedule:</strong></p><ul>';
                    foreach ($schedule as $day => $time) {
                        echo '<li>' . ucfirst($day) . ' at ' . esc_html($time) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p><strong>Invalid Broadcast Schedule JSON!</strong></p>';
                }
            } else {
                echo '<p>No broadcast schedule available.</p>';
            }

            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No programs available at the moment.</p>';
    }
}
// Register the [program_schedule] shortcode to display the schedule
function register_program_schedule_shortcode() {
    add_shortcode('program_schedule', 'display_radio_schedule');
}
add_action('init', 'register_program_schedule_shortcode');