<?php
/*
Plugin Name: LP Stats Dashboard
Description: Thống kê LearnPress
Version: 1.0
Author: Dung
*/

// Tổng khóa học
function lp_total_courses() {
    return wp_count_posts('lp_course')->publish;
}

// Tổng học viên
function lp_total_students() {
    global $wpdb;
    $table = $wpdb->prefix . 'learnpress_user_items';

    return $wpdb->get_var("
        SELECT COUNT(DISTINCT user_id)
        FROM $table
        WHERE item_type = 'lp_course'
    ");
}

// Khóa học hoàn thành
function lp_total_completed() {
    global $wpdb;
    $table = $wpdb->prefix . 'learnpress_user_items';

    return $wpdb->get_var("
        SELECT COUNT(*)
        FROM $table
        WHERE status = 'completed'
        AND item_type = 'lp_course'
    ");
}

// Dashboard Widget
function lp_stats_widget() {
    echo "<h3>LearnPress Stats</h3>";
    echo "<p>Tổng khóa học: " . lp_total_courses() . "</p>";
    echo "<p>Tổng học viên: " . lp_total_students() . "</p>";
    echo "<p>Hoàn thành: " . lp_total_completed() . "</p>";
}

function lp_add_widget() {
    wp_add_dashboard_widget(
        'lp_stats',
        'LearnPress Stats',
        'lp_stats_widget'
    );
}

add_action('wp_dashboard_setup', 'lp_add_widget');

// Shortcode
function lp_stats_shortcode() {
    return "
    <div style='border:1px solid #ccc;padding:10px'>
        <h3>Thống kê LearnPress</h3>
        <p>Tổng khóa học: " . lp_total_courses() . "</p>
        <p>Tổng học viên: " . lp_total_students() . "</p>
        <p>Hoàn thành: " . lp_total_completed() . "</p>
    </div>
    ";
}

add_shortcode('lp_total_stats', 'lp_stats_shortcode');