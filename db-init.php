<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

function sc_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $table_materials = $wpdb->prefix . 'sc_materials';
    $sql_materials = "CREATE TABLE $table_materials (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        unit VARCHAR(50) NOT NULL,
        price FLOAT NOT NULL,
        purchase_date DATE NOT NULL,
        source VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql_materials);

    $table_packaging = $wpdb->prefix . 'sc_packaging';
    $sql_packaging = "CREATE TABLE $table_packaging (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        unit VARCHAR(50) NOT NULL,
        price FLOAT NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql_packaging);

    $table_products = $wpdb->prefix . 'sc_products';
    $sql_products = "CREATE TABLE $table_products (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        unit VARCHAR(50) NOT NULL,
        details TEXT NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql_products);

    $table_inventory_transactions = $wpdb->prefix . 'sc_inventory_transactions';
    $sql_inventory_transactions = "CREATE TABLE $table_inventory_transactions (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        item_id BIGINT(20) UNSIGNED NOT NULL,
        item_type ENUM('material', 'packaging', 'product') NOT NULL,
        quantity FLOAT NOT NULL,
        transaction_type ENUM('in', 'out') NOT NULL,
        transaction_date DATE NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql_inventory_transactions);

    $table_waste = $wpdb->prefix . 'sc_waste';
    $sql_waste = "CREATE TABLE $table_waste (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        item_id BIGINT(20) UNSIGNED NOT NULL,
        item_type ENUM('material', 'packaging', 'product') NOT NULL,
        quantity FLOAT NOT NULL,
        reason TEXT NOT NULL,
        waste_date DATE NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql_waste);

    $table_total_cost = $wpdb->prefix . 'sc_total_cost';
    $sql_total_cost = "CREATE TABLE $table_total_cost (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        product_id BIGINT(20) UNSIGNED NOT NULL,
        material_cost FLOAT NOT NULL,
        packaging_cost FLOAT NOT NULL,
        labor_cost FLOAT NOT NULL,
        overhead_cost FLOAT NOT NULL,
        total_cost FLOAT NOT NULL,
        calculation_date DATE NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql_total_cost);
}

register_activation_hook(__FILE__, 'sc_create_tables');