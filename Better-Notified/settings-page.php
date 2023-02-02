<?php

function Better_Notified_admin_scripts()
{
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
}
add_action('admin_enqueue_scripts', 'Better_Notified_admin_scripts');

$admin_colors;
add_action('admin_head', function () {
    global $_wp_admin_css_colors;
    $admin_colors = $_wp_admin_css_colors;
});


//Create settings page
function Better_Notified_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    $Telegram_bot_token = get_option('Telegram_bot_token');
    $Telegram_chat_id = get_option('Telegram_chat_id');
    $Telegram_WooCommerce_chat_id = get_option('Telegram_WooCommerce_chat_id');
    $Telegram_general_chat_id = get_option('Telegram_general_chat_id');

?>
    <style>
        .ui-state-active,
        .ui-widget-content .ui-state-active,
        .ui-widget-header .ui-state-active,
        a.ui-button:active,
        .ui-button:active,
        .ui-button.ui-state-active:hover {

            border: #000000;
            background: #414141;
            -webkit-appearance: none;
        }

        .coffee {
            width: 100%;
            align-items: center;
            align-content: center;
            text-align: center;
            margin: 20px;
            margin-left: 0;
        }

        .coffee_img {
            width: 100%;
            max-width: 500px;
        }
    </style>
    <div class="wrap">
        <h1><?php esc_html_e('Better Notified Settings', 'Better-Notified-option'); ?></h1>
        <div class="tabs-container">
            <ul>
                <li><a href="#general"><?php esc_html_e('General', 'Better-Notified-option'); ?></a></li>
                <li><a href="#telegram"><?php esc_html_e('Telegram', 'Better-Notified-option'); ?></a></li>
            </ul>
            <div id="general">
                <h2><?php esc_html_e('Notifications', 'Better-Notified-option'); ?></h2>

                <form method="post" action="options.php">
                    <?php
                    settings_fields('telegram-admin-emails');
                    do_settings_sections('telegram-admin-emails');
                    ?>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="admin_notifications"><?php esc_html_e('Admin', 'telegram-admin-emails'); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label for="plugin_update_notifications">
                                            <input type="checkbox" name="plugin_update_notifications" id="plugin_update_notifications" value="1" <?php checked(1, get_option('plugin_update_notifications'), true); ?>><?php esc_html_e('Plugin updates', 'telegram-admin-emails'); ?>
                                        </label>
                                        </br>
                                        <label for="core_update_notifications">
                                            <input type="checkbox" name="core_update_notifications" id="core_update_notifications" value="1" <?php checked(1, get_option('core_update_notifications'), true); ?>><?php esc_html_e('WP core updates', 'telegram-admin-emails'); ?>
                                        </label>
                                        </br>
                                        <label for="admin_emails_notifications">
                                            <input type="checkbox" name="admin_emails_notifications" id="admin_emails_notifications" value="1" <?php checked(1, get_option('admin_emails_notifications'), true); ?>><?php esc_html_e('All Admin Emails', 'telegram-admin-emails'); ?>
                                        </label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="general_notifications"><?php esc_html_e('General', 'telegram-admin-emails'); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label for="new_user_notifications">
                                            <input type="checkbox" name="new_user_notifications" id="new_user_notifications" value="1" <?php checked(1, get_option('new_user_notifications'), true); ?>><?php esc_html_e('New users', 'telegram-admin-emails'); ?>
                                        </label>
                                        </br>
                                        <label for="comments_notifications">
                                            <input type="checkbox" name="comments_notifications" id="comments_notifications" value="1" <?php checked(1, get_option('comments_notifications'), true); ?>><?php esc_html_e('New comments', 'telegram-admin-emails'); ?>
                                        </label>
                                        </br>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="woocommerce_notifications"><?php esc_html_e('WooCommerce', 'telegram-admin-emails'); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label for="new_order_notifications">
                                            <input type="checkbox" name="new_order_notifications" id="new_order_notifications" value="1" <?php checked(1, get_option('new_order_notifications'), true); ?>><?php esc_html_e('New orders', 'telegram-admin-emails'); ?>
                                        </label>
                                        </br>
                                        <label for="low_stock_notifications">
                                            <input type="checkbox" name="low_stock_notifications" id="low_stock_notifications" value="1" <?php checked(1, get_option('low_stock_notifications'), true); ?>><?php esc_html_e('Low stock', 'telegram-admin-emails'); ?>
                                        </label>
                                        </br>
                                        <label for="review_notifications">
                                            <input type="checkbox" name="review_notifications" id="review_notifications" value="1" <?php checked(1, get_option('review_notifications'), true); ?>><?php esc_html_e('Product reviews', 'telegram-admin-emails'); ?>
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
            <div id="telegram">
                <h2><?php esc_html_e('Telegram', 'Better-Notified-option'); ?></h2>

                <form method="post" action="options.php">
                    <?php
                    settings_fields('better-notified-telegram-settings');
                    do_settings_sections('better-notified-telegram-settings');
                    ?>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="Telegram_bot_token"><?php esc_html_e('Telegram Bot Token', 'better-notified-telegram-settings'); ?></label>
                                </th>
                                <td>
                                    <input name="Telegram_bot_token" type="text" id="Telegram_bot_token" class="Telegram_bot_token" value="<?php echo esc_attr($Telegram_bot_token); ?>" class="regular-text">
                                    <p class="description" id="Telegram_bot_token-description">
                                        <?php esc_html_e('Enter your Telegram bot token. You can create a new bot and get its token from the Bot Father.', 'better-notified-telegram-settings'); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="Telegram_chat_id"><?php esc_html_e('Telegram Chat ID', 'better-notified-telegram-settings'); ?></label>
                                </th>
                                <td>
                                    <input name="Telegram_chat_id" type="text" id="Telegram_chat_id" class="Telegram_chat_id" value="<?php echo esc_attr($Telegram_chat_id); ?>" class="regular-text">
                                    <p class="description" id="Telegram_chat_id-description">
                                        <?php esc_html_e('Enter the chat ID of the Telegram chat where you want to receive notifications. You can use a group chat ID or a user chat ID.', 'better-notified-telegram-settings'); ?>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h2><?php esc_html_e('Additional Chat IDs', 'Better-Notified-option'); ?></h2>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="Telegram_general_chat_id"><?php esc_html_e('General', 'better-notified-telegram-settings'); ?></label>
                                </th>
                                <td>
                                    <input name="Telegram_general_chat_id" type="text" id="Telegram_general_chat_id" class="Telegram_general_chat_id" value="<?php echo esc_attr($Telegram_general_chat_id); ?>" class="regular-text">
                                    <p class="description" id="Telegram_general_chat_id-description">
                                        <?php esc_html_e('Optional - Enter the Chat ID you want to use to receve general wordpress notifications. (new users, comments etc) You can use a group chat ID or a user chat ID.', 'better-notified-telegram-settings'); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="Telegram_WooCommerce_chat_id"><?php esc_html_e('Woocommerce', 'better-notified-telegram-settings'); ?></label>
                                </th>
                                <td>
                                    <input name="Telegram_WooCommerce_chat_id" type="text" id="Telegram_WooCommerce_chat_id" class="Telegram_WooCommerce_chat_id" value="<?php echo esc_attr($Telegram_WooCommerce_chat_id); ?>" class="regular-text">
                                    <p class="description" id="Telegram_WooCommerce_chat_id-description">
                                        <?php esc_html_e('Optional - Enter the Chat ID you want to use to receve Woocommerce notifications. You can use a group chat ID or a user chat ID.', 'better-notified-telegram-settings'); ?>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h2><?php esc_html_e('User & customer options', 'Better-Notified-option'); ?></h2>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="admin_notifications"><?php esc_html_e('Admin', 'telegram-admin-emails'); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label for="user_telegram_notifications">
                                            <input type="checkbox" name="user_telegram_notifications" id="user_telegram_notifications" value="1" <?php checked(1, get_option('user_telegram_notifications'), true); ?>><?php esc_html_e('Allow Customers/ Users to get Telegram notifications', 'telegram-admin-emails'); ?>
                                        </label>
                                    </fieldset>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php submit_button();
                    register_setting('better-notified-telegram-settings', 'better-notified-telegram-settings', 'better-notified-telegram-settings', 'better-notified-telegram-settings', 'better-notified-telegram-settings', 'better-notified-telegram-settings', 'better-notified-telegram-settings');
                    add_settings_section('better-notified-telegram-settings-section', 'Better Notified yelegram Settings', '', 'better-notified-telegram-settings');
                    ?>
                </form>
            </div>
        </div>
        <div class="coffee"><a href="https://azurestudio.co.nz" target="_blank"><img class="coffee_img" src="https://reupenny.github.io/Better-Notified/public/coffee.png" width=""></a></br>
            <a href="https://github.com/Reupenny/Better-Notified" target="_blank">View GitHub Page</a>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.tabs-container').tabs();
        });
    </script>
<?php
}
