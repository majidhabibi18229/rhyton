<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Security function to sanitize inputs
function sc_sanitize_input($input) {
    if (is_array($input)) {
        return array_map('sc_sanitize_input', $input);
    }
    return sanitize_text_field($input);
}

// Security function to verify user capabilities
function sc_verify_user_capabilities($capability = 'manage_options') {
    if (!current_user_can($capability)) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'series-constructor'));
    }
}

// Security function to prevent SQL injection in custom queries
function sc_safe_query($query, $params) {
    global $wpdb;
    return $wpdb->prepare($query, $params);
}

// Security function to enforce nonces
function sc_verify_nonce($nonce, $action) {
    if (!wp_verify_nonce($nonce, $action)) {
        wp_die(__('Security check failed.', 'series-constructor'));
    }
}

// Example usage of security functions in admin pages
function sc_check_admin_access() {
    sc_verify_user_capabilities();
    $nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';
    sc_verify_nonce($nonce, 'sc_admin_action');
}