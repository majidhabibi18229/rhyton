<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// نمایش صفحه مدیریت انبار ملزومات بسته‌بندی
function sc_packaging_inventory_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sc_packaging';

    // افزودن ملزومات بسته‌بندی جدید
    if (isset($_POST['add_packaging'])) {
        $name = sanitize_text_field($_POST['name']);
        $unit = sanitize_text_field($_POST['unit']);
        $price = floatval($_POST['price']);

        $wpdb->insert($table_name, [
            'name' => $name,
            'unit' => $unit,
            'price' => $price,
        ]);
    }

    // حذف ملزومات بسته‌بندی
    if (isset($_GET['delete_packaging'])) {
        $id = intval($_GET['delete_packaging']);
        $wpdb->delete($table_name, ['id' => $id]);
    }

    // دریافت لیست ملزومات بسته‌بندی
    $packaging_items = $wpdb->get_results("SELECT * FROM $table_name");

    ?>
    <div class="wrap">
        <h1><?php _e('مدیریت انبار ملزومات بسته‌بندی', 'series-constructor'); ?></h1>

        <h2><?php _e('افزودن ملزومات بسته‌بندی جدید', 'series-constructor'); ?></h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th><label for="name"><?php _e('نام ملزومات', 'series-constructor'); ?></label></th>
                    <td><input type="text" name="name" id="name" required /></td>
                </tr>
                <tr>
                    <th><label for="unit"><?php _e('واحد', 'series-constructor'); ?></label></th>
                    <td><input type="text" name="unit" id="unit" required /></td>
                </tr>
                <tr>
                    <th><label for="price"><?php _e('قیمت', 'series-constructor'); ?></label></th>
                    <td><input type="number" step="0.01" name="price" id="price" required /></td>
                </tr>
            </table>
            <p><input type="submit" name="add_packaging" class="button button-primary" value="<?php _e('افزودن', 'series-constructor'); ?>" /></p>
        </form>

        <h2><?php _e('لیست ملزومات بسته‌بندی', 'series-constructor'); ?></h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e('شناسه', 'series-constructor'); ?></th>
                    <th><?php _e('نام ملزومات', 'series-constructor'); ?></th>
                    <th><?php _e('واحد', 'series-constructor'); ?></th>
                    <th><?php _e('قیمت', 'series-constructor'); ?></th>
                    <th><?php _e('عملیات', 'series-constructor'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packaging_items as $item) : ?>
                    <tr>
                        <td><?php echo esc_html($item->id); ?></td>
                        <td><?php echo esc_html($item->name); ?></td>
                        <td><?php echo esc_html($item->unit); ?></td>
                        <td><?php echo esc_html($item->price); ?></td>
                        <td>
                            <a href="<?php echo add_query_arg('delete_packaging', $item->id); ?>" class="button button-danger" onclick="return confirm('<?php _e('آیا مطمئن هستید؟', 'series-constructor'); ?>')">
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