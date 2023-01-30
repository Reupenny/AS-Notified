<?php

//Create settings page
function Better_Notified_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    $Telegram_bot_token = get_option('Telegram_bot_token');
    $Telegram_chat_id = get_option('Telegram_chat_id');
    $Telegram_WooCommerce_chat_id = get_option('Telegram_WooCommerce_chat_id');

?>
    <div class="wrap">
        <h1><?php esc_html_e('Better Notified Settings', 'Better-Notified-option'); ?></h1>
        <h2><?php esc_html_e('Telegram', 'Better-Notified-option'); ?></h2>

        <form method="post" action="options.php">
            <?php
            settings_fields('telegram-admin-emails');
            do_settings_sections('telegram-admin-emails');
            ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="Telegram_bot_token"><?php esc_html_e('Telegram Bot Token', 'telegram-admin-emails'); ?></label>
                        </th>
                        <td>
                            <input name="Telegram_bot_token" type="text" id="Telegram_bot_token" class="Telegram_bot_token" value="<?php
                                                                                                                                    echo esc_attr($Telegram_bot_token); ?>" class="regular-text">
                            <p class="description" id="Telegram_bot_token-description">
                                <?php esc_html_e('Enter your Telegram bot token. You can create a new bot and get its token from the Bot Father.', 'telegram-admin-emails'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="Telegram_chat_id"><?php esc_html_e('Telegram Chat ID', 'telegram-admin-emails'); ?></label>
                        </th>
                        <td>
                            <input name="Telegram_chat_id" type="text" id="Telegram_chat_id" class="Telegram_chat_id" value="<?php echo esc_attr($Telegram_chat_id); ?>" class="regular-text">
                            <p class="description" id="Telegram_chat_id-description">
                                <?php esc_html_e('Enter the chat ID of the Telegram chat where you want to receive admin emails. You can use a group chat ID or a user chat ID.', 'telegram-admin-emails'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="admin_notifications"><?php esc_html_e('Notifications types', 'telegram-admin-emails'); ?></label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="new_user_notifications">
                                    <input type="checkbox" name="new_user_notifications" id="new_user_notifications" value="1" <?php checked(1, get_option('new_user_notifications'), true); ?>><?php esc_html_e('New users', 'telegram-admin-emails'); ?>
                                </label>
                                </br>
                                <label for="plugin_update_notifications">
                                    <input type="checkbox" name="plugin_update_notifications" id="plugin_update_notifications" value="1" <?php checked(1, get_option('plugin_update_notifications'), true); ?>><?php esc_html_e('Plugin updates', 'telegram-admin-emails'); ?>
                                </label>
                                </br>
                                <label for="core_update_notifications">
                                    <input type="checkbox" name="core_update_notifications" id="core_update_notifications" value="1" <?php checked(1, get_option('core_update_notifications'), true); ?>><?php esc_html_e('WP core updates', 'telegram-admin-emails'); ?>
                                </label>
                                </br>
                                <label for="comments_notifications">
                                    <input type="checkbox" name="comments_notifications" id="comments_notifications" value="1" <?php checked(1, get_option('comments_notifications'), true); ?>><?php esc_html_e('New comments', 'telegram-admin-emails'); ?>
                                </label>
                                </br>
                                <label for="admin_emails_notifications">
                                    <input type="checkbox" name="admin_emails_notifications" id="admin_emails_notifications" value="1" <?php checked(1, get_option('admin_emails_notifications'), true); ?>><?php esc_html_e('All Admin Emails', 'telegram-admin-emails'); ?>
                                </label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <h2><?php esc_html_e('Woocommerce - Telegram', 'Better-Notified-option'); ?></h2>
                        <th scope="row">
                            <label for="Telegram_WooCommerce_chat_id"><?php esc_html_e('Telegram Bot Token', 'telegram-admin-emails'); ?></label>
                        </th>
                        <td>
                            <input name="Telegram_WooCommerce_chat_id" type="text" id="Telegram_WooCommerce_chat_id" class="Telegram_WooCommerce_chat_id" value="<?php
                                                                                                                                                                    echo esc_attr($Telegram_WooCommerce_chat_id); ?>" class="regular-text">
                            <p class="description" id="Telegram_WooCommerce_chat_id-description">
                                <?php esc_html_e('Optional - Enter your Telegram chat id you want to use to receve Woocommerce notifications.', 'telegram-admin-emails'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="woocommerce_notifications"><?php esc_html_e('Woocommerce Notifications', 'telegram-admin-emails'); ?></label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="new_order_notifications">
                                    <input type="checkbox" name="new_order_notifications" id="new_order_notifications" value="1" <?php checked(1, get_option('new_order_notifications'), true); ?>><?php esc_html_e('New order', 'telegram-admin-emails'); ?>
                                </label>
                                </br>
                                <label for="low_stock_notifications">
                                    <input type="checkbox" name="low_stock_notifications" id="low_stock_notifications" value="1" <?php checked(1, get_option('low_stock_notifications'), true); ?>><?php esc_html_e('Low stock', 'telegram-admin-emails'); ?>
                                </label>
                            </fieldset>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button();
            register_setting('telegram-admin-emails', 'telegram-admin-emails', 'telegram-admin-emails', 'telegram-admin-emails', 'telegram-admin-emails', 'telegram-admin-emails', 'telegram-admin-emails');
            add_settings_section('telegram-admin-emails-section', 'Telegram Admin Emails Settings', '', 'telegram-admin-emails');
            ?>
        </form>
    </div>


<?php
}
