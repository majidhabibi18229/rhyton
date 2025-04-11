<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// نمایش صفحه مدیریت انبار محصولات نهایی
function sc_final_product_inventory_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sc_products';

    // افزودن محصول نهایی جدید
    if (isset($_POST['add_product'])) {
        $name = sanitize_text_field($_POST['name']);
        $unit = sanitize_text_field($_POST['unit']);
        $details = sanitize_textarea_field($_POST['details']);

        $wpdb->insert($table_name, [
            'name' => $name,
            'unit' => $unit,
            'details' => $details,
        ]);
    }

    // حذف محصول نهایی
    if (isset($_GET['delete_product'])) {
        $id = intval($_GET['delete_product']);
        $wpdb->delete($table_name, ['id' => $id]);
    }

    // دریافت لیست محصولات نهایی
    $products = $wpdb->get_results("SELECT * FROM $table_name");

    ?>
    <div class="wrap">
        <h1><?php _e('مدیریت انبار محصولات نهایی', 'series-constructor'); ?></h1>

        <h2><?php _e('افزودن محصول نهایی جدید', 'series-constructor'); ?></h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th><label for="name"><?php _e('نام محصول', 'series-constructor'); ?></label></th>
                    <td><input type="text" name="name" id="name" required /></td>
                </tr>
                <tr>
                    <th><label for="unit"><?php _e('واحد', 'series-constructor'); ?></label></th>
                    <td><input type="text" name="unit" id="unit" required /></td>
                </tr>
                <tr>
                    <th><label for="details"><?php _e('جزئیات', 'series-constructor'); ?></label></th>
                    <td><textarea name="details" id="details" rows="5" required></textarea></td>
                </tr>
            </table>
            <p><input type="submit" name="add_product" class="button button-primary" value="<?php _e('افزودن', 'series-constructor'); ?>" /></p>
        </form>

        <h2><?php _e('لیست محصولات نهایی', 'series-constructor'); ?></h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e('شناسه', 'series-constructor'); ?></th>
                    <th><?php _e('نام محصول', 'series-constructor'); ?></th>
                    <th><?php _e('واحد', 'series-constructor'); ?></th>
                    <th><?php _e('جزئیات', 'series-constructor'); ?></th>
                    <th><?php _e('عملیات', 'series-constructor'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo esc_html($product->id); ?></td>
                        <td><?php echo esc_html($product->name); ?></td>
                        <td><?php echo esc_html($product->unit); ?></td>
                        <td><?php echo esc_html($product->details); ?></td>
                        <td>
                            <a href="<?php echo add_query_arg('delete_product', $product->id); ?>" class="button button-danger" onclick="return confirm('<?php _e('آیا مطمئن هستید؟', 'series-constructor'); ?>')">
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