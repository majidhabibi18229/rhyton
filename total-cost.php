<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// نمایش صفحه محاسبه قیمت تمام‌شده
function sc_total_cost_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sc_total_cost';
    $product_table = $wpdb->prefix . 'sc_products';

    // محاسبه قیمت تمام‌شده
    if (isset($_POST['calculate_cost'])) {
        $product_id = intval($_POST['product_id']);
        $material_cost = floatval($_POST['material_cost']);
        $packaging_cost = floatval($_POST['packaging_cost']);
        $labor_cost = floatval($_POST['labor_cost']);
        $overhead_cost = floatval($_POST['overhead_cost']);
        $total_cost = $material_cost + $packaging_cost + $labor_cost + $overhead_cost;
        $calculation_date = current_time('mysql');

        $wpdb->insert($table_name, [
            'product_id' => $product_id,
            'material_cost' => $material_cost,
            'packaging_cost' => $packaging_cost,
            'labor_cost' => $labor_cost,
            'overhead_cost' => $overhead_cost,
            'total_cost' => $total_cost,
            'calculation_date' => $calculation_date,
        ]);
    }

    // دریافت لیست محصولات
    $products = $wpdb->get_results("SELECT id, name FROM $product_table");

    // دریافت لیست قیمت‌های تمام‌شده
    $costs = $wpdb->get_results("SELECT * FROM $table_name");

    ?>
    <div class="wrap">
        <h1><?php _e('محاسبه قیمت تمام‌شده', 'series-constructor'); ?></h1>

        <h2><?php _e('محاسبه جدید', 'series-constructor'); ?></h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th><label for="product_id"><?php _e('محصول', 'series-constructor'); ?></label></th>
                    <td>
                        <select name="product_id" id="product_id" required>
                            <?php foreach ($products as $product) : ?>
                                <option value="<?php echo esc_attr($product->id); ?>"><?php echo esc_html($product->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="material_cost"><?php _e('هزینه مواد اولیه', 'series-constructor'); ?></label></th>
                    <td><input type="number" step="0.01" name="material_cost" id="material_cost" required /></td>
                </tr>
                <tr>
                    <th><label for="packaging_cost"><?php _e('هزینه بسته‌بندی', 'series-constructor'); ?></label></th>
                    <td><input type="number" step="0.01" name="packaging_cost" id="packaging_cost" required /></td>
                </tr>
                <tr>
                    <th><label for="labor_cost"><?php _e('هزینه نیروی انسانی', 'series-constructor'); ?></label></th>
                    <td><input type="number" step="0.01" name="labor_cost" id="labor_cost" required /></td>
                </tr>
                <tr>
                    <th><label for="overhead_cost"><?php _e('هزینه سربار', 'series-constructor'); ?></label></th>
                    <td><input type="number" step="0.01" name="overhead_cost" id="overhead_cost" required /></td>
                </tr>
            </table>
            <p><input type="submit" name="calculate_cost" class="button button-primary" value="<?php _e('محاسبه', 'series-constructor'); ?>" /></p>
        </form>

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
    </div>
    <?php
}