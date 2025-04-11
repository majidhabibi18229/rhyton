<?php
/*
Plugin Name: سری ساخت
Plugin URI: https://example.com/series-constructor
Description: افزونه مدیریت انبار و محاسبه قیمت تمام‌شده محصولات
Version: 1.0.0
Author: Majid Habibi
Author URI: https://example.com
Text Domain: series-constructor
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// بارگذاری فایل‌های موردنیاز
require_once plugin_dir_path(__FILE__) . 'includes/db-init.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-menus.php';
require_once plugin_dir_path(__FILE__) . 'includes/material-inventory.php';
require_once plugin_dir_path(__FILE__) . 'includes/packaging-inventory.php';
require_once plugin_dir_path(__FILE__) . 'includes/final-product-inventory.php';
require_once plugin_dir_path(__FILE__) . 'includes/waste-management.php';
require_once plugin_dir_path(__FILE__) . 'includes/total-cost.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

// بارگذاری استایل‌ها
function sc_enqueue_styles() {
    wp_enqueue_style('sc-styles', plugin_dir_url(__FILE__) . 'assets/styles.css');
}
add_action('admin_enqueue_scripts', 'sc_enqueue_styles');

// تابع فعال‌سازی افزونه
function sc_activate_plugin() {
    // اجرای کدهای مربوط به ایجاد جداول پایگاه داده
    sc_create_tables();
}
register_activation_hook(__FILE__, 'sc_activate_plugin');

// تابع غیرفعال‌سازی افزونه
function sc_deactivate_plugin() {
    // اینجا می‌توانید کدهایی برای پاکسازی یا غیرفعال کردن قابلیت‌ها اضافه کنید
}
register_deactivation_hook(__FILE__, 'sc_deactivate_plugin');

// ترجمه افزونه
function sc_load_textdomain() {
    load_plugin_textdomain('series-constructor', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'sc_load_textdomain');