<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// شرت‌کد برای نمایش لیست مواد اولیه
function sc_shortcode_materials($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sc_materials';

    $materials = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    ?>
    <h2><?php _e('لیست مواد اولیه', 'series-constructor'); ?></h2>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('شناسه', 'series-constructor'); ?></th>
                <th><?php _e('نام', 'series-constructor'); ?></th>
                <th><?php _e('واحد', 'series-constructor'); ?></th>
                <th><?php _e('قیمت', 'series-constructor'); ?></th>
                <th><?php _e('تاریخ خرید', 'series-constructor'); ?></th>
                <th><?php _e('منبع', 'series-constructor'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materials as $material) : ?>
                <tr>
                    <td><?php echo esc_html($material->id); ?></td>
                    <td><?php echo esc_html($material->name); ?></td>
                    <td><?php echo esc_html($material->unit); ?></td>
                    <td><?php echo esc_html($material->price); ?></td>
                    <td><?php echo esc_html($material->purchase_date); ?></td>
                    <td><?php echo esc_html($material->source); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}
add_shortcode('sc_materials', 'sc_shortcode_materials');

// شرت‌کد برای نمایش لیست محصولات نهایی
function sc_shortcode_products($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sc_products';

    $products = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    ?>
    <h2><?php _e('لیست محصولات نهایی', 'series-constructor'); ?></h2>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('شناسه', 'series-constructor'); ?></th>
                <th><?php _e('نام', 'series-constructor'); ?></th>
                <th><?php _e('واحد', 'series-constructor'); ?></th>
                <th><?php _e('جزئیات', 'series-constructor'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo esc_html($product->id); ?></td>
                    <td><?php echo esc_html($product->name); ?></td>
                    <td><?php echo esc_html($product->unit); ?></td>
                    <td><?php echo esc_html($product->details); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}
add_shortcode('sc_products', 'sc_shortcode_products');

// شرت‌کد برای نمایش قیمت تمام‌شده محصولات
function sc_shortcode_total_cost($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sc_total_cost';
    $product_table = $wpdb->prefix . 'sc_products';

    $costs = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    ?>
    <h2><?php _e('لیست قیمت‌های تمام‌شده', 'series-constructor'); ?></h2>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('شناسه', 'series-constructor'); ?></th>
                <th><?php _e('محصول', 'series-constructor'); ?></th>
                <th><?php _e('هزینه مواد اولیه', 'series-constructor'); ?></th>
                <th><?php _e('هزینه بسته‌بندی', 'series-constructor'); ?></th>
                <th><?php _e('هزینه نیروی انسانی', 'series-constructor'); ?></th>
                <th><?php _e('هزینه سربار', 'series-constructor'); ?></th>
                <th><?php _e('قیمت تمام‌شده', 'series-constructor'); ?></th>
                <th><?php _e('تاریخ محاسبه', 'series-constructor'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($costs as $cost) : ?>
                <tr>
                    <td><?php echo esc_html($cost->id); ?></td>
                    <td>
                        <?php
                        $product = $wpdb->get_row("SELECT name FROM $product_table WHERE id = $cost->product_id");
                        echo esc_html($product->name);
                        ?>
                    </td>
                    <td><?php echo esc_html($cost->material_cost); ?></td>
                    <td><?php echo esc_html($cost->packaging_cost); ?></td>
                    <td><?php echo esc_html($cost->labor_cost); ?></td>
                    <td><?php echo esc_html($cost->overhead_cost); ?></td>
                    <td><?php echo esc_html($cost->total_cost); ?></td>
                    <td><?php echo esc_html($cost->calculation_date); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}
add_shortcode('sc_total_cost', 'sc_shortcode_total_cost');