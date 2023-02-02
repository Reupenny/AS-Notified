<?php

// Check if Admin wants users to get telegram notifications
if (get_option('user_telegram_notifications') == 1) {
    // Add a new section to the plugin settings page
    add_action('admin_init', 'Better_Notified_telegram_section');
    function Better_Notified_telegram_section()
    {
        add_settings_section(
            'better_notified_telegram_section',
            'Telegram Notifications',
            'Better_Notified_telegram_section_callback',
            'better_notified_options'
        );
    }

    // Callback function for the Telegram section
    function Better_Notified_telegram_section_callback()
    {
        echo '<p>Configure your Telegram settings here.</p>';
    }


    // Add fields for the customer to input their Telegram chat ID and bot token
    add_action('admin_init', 'Better_Notified_telegram_fields');
    function Better_Notified_telegram_fields()
    {
        add_settings_field(
            'telegram_chat_id',
            'Telegram Chat ID',
            'Better_Notified_telegram_chat_id_callback',
            'better_notified_options',
            'better_notified_telegram_section'
        );
    }

    // Callback function for the Telegram Chat ID field
    function Better_Notified_telegram_chat_id_callback()
    {
        $telegram_chat_id = get_option('telegram_chat_id');
        echo '<input type="text" name="telegram_chat_id" value="' . esc_attr($telegram_chat_id) . '" />';
    }

    // Save the customer's Telegram settings when they update their user settings
    add_action('personal_options_update', 'Better_Notified_telegram_settings_save');
    add_action('edit_user_profile_update', 'Better_Notified_telegram_settings_save');
    function Better_Notified_telegram_settings_save($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) {
            return;
        }
        update_user_meta($user_id, 'telegram_chat_id', sanitize_text_field($_POST['telegram_chat_id']));
    }

    function Better_Notified_telegram_settings_field($user)
    {
        $telegram_chat_id = get_user_meta($user->ID, 'telegram_chat_id', true);
?>
        <table class="form-table">
            <tr>
                <th>
                    <label for="telegram_chat_id">Telegram Chat ID</label>
                </th>
                <td>
                    <input type="text" name="telegram_chat_id" id="telegram_chat_id" value="<?php echo esc_attr($telegram_chat_id); ?>" class="regular-text">
                    <p class="description">Enter your Telegram Chat ID to receive notifications via Telegram.</p>
                </td>
            </tr>
        </table>
        <?php
    }

    function Better_Notified_telegram_notification_field()
    {
        add_action('show_user_profile', 'Better_Notified_telegram_settings_field');
        add_action('edit_user_profile', 'Better_Notified_telegram_settings_field');
        add_action('personal_options_update', 'Better_Notified_telegram_settings_save');
        add_action('edit_user_profile_update', 'Better_Notified_telegram_settings_save');
    }
    add_action('admin_init', 'Better_Notified_telegram_notification_field');
}

// Add shortcode to display favorite posts list
// [better_notified_user_settings]
add_shortcode('better_notified_user_settings', 'better_notified_shortcode');
function better_notified_shortcode()
{
    if (get_option('user_telegram_notifications') == 1) {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $telegram_chat_id = get_user_meta($current_user->ID, 'telegram_chat_id', true);

            ob_start(); ?>
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="update_telegram_id">
                <input type="hidden" name="user_id" value="<?php echo esc_attr($current_user->ID); ?>">
                <label for="telegram_chat_id">Telegram Chat ID:</label>
                <input type="text" name="telegram_chat_id" class="input-text" id="telegram_chat_id" value="<?php echo esc_attr($telegram_chat_id); ?>">
                <p class="description">Enter your Telegram Chat ID to receive notifications via Telegram.</p>
                <input class="button wp-element-button" type="submit" value="Update Telegram ID">
            </form>
<?php
            return ob_get_clean();
        } else {
            return 'You must be logged in to edit your Telegram ID.';
        }
    }
}
function update_telegram_id()
{
    if (isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);
        $telegram_chat_id = sanitize_text_field($_POST['telegram_chat_id']);
        update_user_meta($user_id, 'telegram_chat_id', $telegram_chat_id);
    }
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit;
}
add_action('admin_post_update_telegram_id', 'update_telegram_id');



/*
function woo_my_account_menu_notifications($items)
{
    $items['better-notifications-account-page'] = 'Notifications';
    return $items;
}
add_filter('woocommerce_account_menu_items', 'woo_my_account_menu_notifications');

function better_notified_telegram_endpoint()
{
    add_rewrite_endpoint('better-notifications-account-page', EP_ROOT | EP_PAGES);
}
add_action('init', 'better_notified_telegram_endpoint');


add_action('woocommerce_account_custom-page_endpoint', 'better_notified_telegram_shortcode');




function custom_my_account_menu_item($items)
{
    $items['custom-page'] = 'Custom Page';
    return $items;
}
add_filter('woocommerce_account_menu_items', 'custom_my_account_menu_item');

function custom_endpoint()
{
    add_rewrite_endpoint('custom-page', EP_ROOT | EP_PAGES);
}
add_action('init', 'custom_endpoint');

function custom_my_account_endpoint_content()
{
    include 'path/to/custom-page.php';
}
add_action('woocommerce_account_custom-page_endpoint', 'custom_my_account_endpoint_content');

*/
