<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function sc_register_admin_menus() {
    add_menu_page(
        __('سری ساخت', 'series-constructor'),
        __('سری ساخت', 'series-constructor'),
        'manage_options',
        'series-constructor',
        'sc_main_admin_page',
        'dashicons-admin-tools',
        6
    );

    add_submenu_page(
        'series-constructor',
        __('انبار مواد اولیه', 'series-constructor'),
        __('انبار مواد اولیه', 'series-constructor'),
        'manage_options',
        'sc-material-inventory',
        'sc_material_inventory_page'
    );

    add_submenu_page(
        'series-constructor',
        __('انبار ملزومات بسته‌بندی', 'series-constructor'),
        __('انبار ملزومات بسته‌بندی', 'series-constructor'),
        'manage_options',
        'sc-packaging-inventory',
        'sc_packaging_inventory_page'
    );

    add_submenu_page(
        'series-constructor',
        __('انبار محصولات نهایی', 'series-constructor'),
        __('انبار محصولات نهایی', 'series-constructor'),
        'manage_options',
        'sc-final-product-inventory',
        'sc_final_product_inventory_page'
    );

    add_submenu_page(
        'series-constructor',
        __('مدیریت ضایعات', 'series-constructor'),
        __('مدیریت ضایعات', 'series-constructor'),
        'manage_options',
        'sc-waste-management',
        'sc_waste_management_page'
    );

    add_submenu_page(
        'series-constructor',
        __('قیمت تمام‌شده', 'series-constructor'),
        __('قیمت تمام‌شده', 'series-constructor'),
        'manage_options',
        'sc-total-cost',
        'sc_total_cost_page'
    );
}
add_action('admin_menu', 'sc_register_admin_menus');

function sc_main_admin_page() {
    echo '<div class="wrap"><h1>' . __('مدیریت سری ساخت', 'series-constructor') . '</h1>';
    echo '<p>' . __('به افزونه سری ساخت خوش آمدید.', 'series-constructor') . '</p></div>';
}