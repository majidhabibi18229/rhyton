<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Function to generate reports
function sc_generate_report($type, $series_code = null) {
    global $wpdb;

    // Example logic for different report types
    switch ($type) {
        case 'production':
            // Query for production report
            $results = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}sc_series WHERE series_code = %s",
                    $series_code
                )
            );
            break;

        case 'cost':
            // Query for cost report
            $results = $wpdb->get_results(
                "SELECT * FROM {$wpdb->prefix}sc_materials"
            );
            break;

        case 'waste':
            // Query for waste report
            $results = $wpdb->get_results(
                "SELECT * FROM {$wpdb->prefix}sc_waste"
            );
            break;

        default:
            $results = [];
            break;
    }

    return $results;
}

// Function to display report
function sc_display_report($type, $series_code = null) {
    $report_data = sc_generate_report($type, $series_code);

    if (!$report_data) {
        echo '<p>' . __('No data found for this report.', 'series-constructor') . '</p>';
        return;
    }

    echo '<table border="1" cellpadding="5" cellspacing="0">';
    echo '<thead><tr>';
    foreach ($report_data[0] as $key => $value) {
        echo '<th>' . esc_html($key) . '</th>';
    }
    echo '</tr></thead>';
    echo '<tbody>';
    foreach ($report_data as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . esc_html($cell) . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}