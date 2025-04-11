<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// نمایش صفحه مدیریت انبار مواد اولیه
function sc_material_inventory_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sc_materials';

    // افزودن ماده اولیه جدید
    if (isset($_POST['add_material'])) {
        $name = sanitize_text_field($_POST['name']);
        $unit = sanitize_text_field($_POST['unit']);
        $price = floatval($_POST['price']);
        $purchase_date = sanitize_text_field($_POST['purchase_date']);
        $source = sanitize_text_field($_POST['source']);

        $wpdb->insert($table_name, [
            'name' => $name,
            'unit' => $unit,
            'price' => $price,
            'purchase_date' => $purchase_date,
            'source' => $source,
        ]);
    }

    // حذف ماده اولیه
    if (isset($_GET['delete_material'])) {
        $id = intval($_GET['delete_material']);
        $wpdb->delete($table_name, ['id' => $id]);
    }

    // دریافت لیست مواد اولیه
    $materials = $wpdb->get_results("SELECT * FROM $table_name");

    ?>
    <div class="wrap">
        <h1><?php _e('مدیریت انبار مواد اولیه', 'series-constructor'); ?></h1>

        <h2><?php _e('افزودن ماده اولیه جدید', 'series-constructor'); ?></h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th><label for="name"><?php _e('نام ماده', 'series-constructor'); ?></label></th>
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
                <tr>
                    <th><label for="purchase_date"><?php _e('تاریخ خرید', 'series-constructor'); ?></label></th>
                    <td><input type="date" name="purchase_date" id="purchase_date" required /></td>
                </tr>
                <tr>
                    <th><label for="source"><?php _e('منبع', 'series-constructor'); ?></label></th>
                    <td><input type="text" name="source" id="source" required /></td>
                </tr>
            </table>
            <p><input type="submit" name="add_material" class="button button-primary" value="<?php _e('افزودن', 'series-constructor'); ?>" /></p>
        </form>

        <h2><?php _e('لیست مواد اولیه', 'series-constructor'); ?></h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e('شناسه', 'series-constructor'); ?></th>
                    <th><?php _e('نام ماده', 'series-constructor'); ?></th>
                    <th><?php _e('واحد', 'series-constructor'); ?></th>
                    <th><?php _e('قیمت', 'series-constructor'); ?></th>
                    <th><?php _e('تاریخ خرید', 'series-constructor'); ?></th>
                    <th><?php _e('منبع', 'series-constructor'); ?></th>
                    <th><?php _e('عملیات', 'series-constructor'); ?></th>
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
                        <td>
                            <a href="<?php echo add_query_arg('delete_material', $material->id); ?>" class="button button-danger" onclick="return confirm('<?php _e('آیا مطمئن هستید؟', 'series-constructor'); ?>')">
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