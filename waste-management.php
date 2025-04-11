<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// نمایش صفحه مدیریت ضایعات
function sc_waste_management_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sc_waste';
    $material_table = $wpdb->prefix . 'sc_materials';
    $packaging_table = $wpdb->prefix . 'sc_packaging';
    $product_table = $wpdb->prefix . 'sc_products';

    // افزودن ضایعات جدید
    if (isset($_POST['add_waste'])) {
        $item_id = intval($_POST['item_id']);
        $item_type = sanitize_text_field($_POST['item_type']);
        $quantity = floatval($_POST['quantity']);
        $reason = sanitize_textarea_field($_POST['reason']);
        $waste_date = sanitize_text_field($_POST['waste_date']);

        $wpdb->insert($table_name, [
            'item_id' => $item_id,
            'item_type' => $item_type,
            'quantity' => $quantity,
            'reason' => $reason,
            'waste_date' => $waste_date,
        ]);
    }

    // حذف ضایعات
    if (isset($_GET['delete_waste'])) {
        $id = intval($_GET['delete_waste']);
        $wpdb->delete($table_name, ['id' => $id]);
    }

    // دریافت لیست ضایعات
    $wastes = $wpdb->get_results("SELECT * FROM $table_name");

    // دریافت آیتم‌ها برای فرم افزودن
    $materials = $wpdb->get_results("SELECT id, name FROM $material_table");
    $packaging = $wpdb->get_results("SELECT id, name FROM $packaging_table");
    $products = $wpdb->get_results("SELECT id, name FROM $product_table");

    ?>
    <div class="wrap">
        <h1><?php _e('مدیریت ضایعات', 'series-constructor'); ?></h1>

        <h2><?php _e('افزودن ضایعات جدید', 'series-constructor'); ?></h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th><label for="item_type"><?php _e('نوع آیتم', 'series-constructor'); ?></label></th>
                    <td>
                        <select name="item_type" id="item_type" required>
                            <option value="material"><?php _e('مواد اولیه', 'series-constructor'); ?></option>
                            <option value="packaging"><?php _e('ملزومات بسته‌بندی', 'series-constructor'); ?></option>
                            <option value="product"><?php _e('محصول نهایی', 'series-constructor'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="item_id"><?php _e('آیتم', 'series-constructor'); ?></label></th>
                    <td>
                        <select name="item_id" id="item_id" required>
                            <?php foreach ($materials as $material) : ?>
                                <option value="<?php echo esc_attr($material->id); ?>"><?php echo esc_html($material->name); ?> (<?php _e('مواد اولیه', 'series-constructor'); ?>)</option>
                            <?php endforeach; ?>
                            <?php foreach ($packaging as $package) : ?>
                                <option value="<?php echo esc_attr($package->id); ?>"><?php echo esc_html($package->name); ?> (<?php _e('ملزومات بسته‌بندی', 'series-constructor'); ?>)</option>
                            <?php endforeach; ?>
                            <?php foreach ($products as $product) : ?>
                                <option value="<?php echo esc_attr($product->id); ?>"><?php echo esc_html($product->name); ?> (<?php _e('محصول نهایی', 'series-constructor'); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="quantity"><?php _e('مقدار', 'series-constructor'); ?></label></th>
                    <td><input type="number" step="0.01" name="quantity" id="quantity" required /></td>
                </tr>
                <tr>
                    <th><label for="reason"><?php _e('دلیل ضایعات', 'series-constructor'); ?></label></th>
                    <td><textarea name="reason" id="reason" rows="5" required></textarea></td>
                </tr>
                <tr>
                    <th><label for="waste_date"><?php _e('تاریخ ضایعات', 'series-constructor'); ?></label></th>
                    <td><input type="date" name="waste_date" id="waste_date" required /></td>
                </tr>
            </table>
            <p><input type="submit" name="add_waste" class="button button-primary" value="<?php _e('افزودن', 'series-constructor'); ?>" /></p>
        </form>

        <h2><?php _e('لیست ضایعات', 'series-constructor'); ?></h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e('شناسه', 'series-constructor'); ?></th>
                    <th><?php _e('نوع آیتم', 'series-constructor'); ?></th>
                    <th><?php _e('آیتم', 'series-constructor'); ?></th>
                    <th><?php _e('مقدار', 'series-constructor'); ?></th>
                    <th><?php _e('دلیل', 'series-constructor'); ?></th>
                    <th><?php _e('تاریخ', 'series-constructor'); ?></th>
                    <th><?php _e('عملیات', 'series-constructor'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wastes as $waste) : ?>
                    <tr>
                        <td><?php echo esc_html($waste->id); ?></td>
                        <td><?php echo esc_html($waste->item_type); ?></td>
                        <td>
                            <?php
                            switch ($waste->item_type) {
                                case 'material':
                                    $item = $wpdb->get_row("SELECT name FROM $material_table WHERE id = $waste->item_id");
                                    break;
                                case 'packaging':
                                    $item = $wpdb->get_row("SELECT name FROM $packaging_table WHERE id = $waste->item_id");
                                    break;
                                case 'product':
                                    $item = $wpdb->get_row("SELECT name FROM $product_table WHERE id = $waste->item_id");
                                    break;
                            }
                            echo esc_html($item->name);
                            ?>
                        </td>
                        <td><?php echo esc_html($waste->quantity); ?></td>
                        <td><?php echo esc_html($waste->reason); ?></td>
                        <td><?php echo esc_html($waste->waste_date); ?></td>
                        <td>
                            <a href="<?php echo add_query_arg('delete_waste', $waste->id); ?>" class="button button-danger" onclick="return confirm('<?php _e('آیا مطمئن هستید؟', 'series-constructor'); ?>')">
                                <?php _e('حذف', 'series-constructor'); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}