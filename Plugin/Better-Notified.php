<?php

/**
 * Plugin Name: Better Notified
 * Description: A Wordpress plugin to better handle all Wordpress notifications and keep you notified of the important things.
 * Version:     0.0.2 alpha
 * Author:      Azure Studio
 * Author URI:  https://azurestudio.co.nz
 * Plugin URI:  https://azurestudio.co.nz/plugins/
 * Text Domain: Better-Notified
 */

// Update Core.
require("plugin-update-checker/plugin-update-checker.php");
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://reupenny.github.io/Better-Notified/update.json',
    __FILE__, //Full path to the main plugin file or functions.php.
    'Better-Notified'
);

add_action('wp_mail_failed', 'Better_Notified_redirect', 10, 1);



function Better_Notified_redirect($error)
{
    $telegram_bot_token = get_option('Telegram_bot_token');
    $telegram_chat_id = get_option('Telegram_chat_id');
    $message = $error->get_error_message();
    if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
        $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . $message;
        wp_remote_get($telegram_api_url);
    }
}


add_action('admin_menu', 'Better_Notified_create_menu');

function Better_Notified_create_menu()
{
    register_setting('telegram-admin-emails', 'Telegram_bot_token');
    register_setting('telegram-admin-emails', 'Telegram_chat_id');

    add_options_page(
        'Better Notified',
        'Better Notified',
        'manage_options',
        'telegram-admin-emails-settings',
        'Better_Notified_settings_page'
    );
}

add_action('network_admin_menu', 'Better_Notified_create_network_menu');

function Better_Notified_create_network_menu()
{
    register_setting('telegram-admin-emails', 'Telegram_bot_token');
    register_setting('telegram-admin-emails', 'Telegram_chat_id');

    add_submenu_page(
        'settings.php',
        'Better Notified',
        'Better Notified',
        'manage_options',
        'telegram-admin-emails-settings',
        'Better_Notified_settings_page'
    );
}

add_action('user_register', 'Better_Notified_new_user_notification', 10, 1);
add_action('wp_update_plugins', 'Better_Notified_plugin_update_notification');
add_action('wp_version_check', 'Better_Notified_core_update_notification');

function Better_Notified_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    $Telegram_bot_token = get_option('Telegram_bot_token');
    $Telegram_chat_id = get_option('Telegram_chat_id');

    function Better_Notified_enqueue_scripts()
    {
        if (isset($_GET['page']) && $_GET['page'] === 'telegram-admin-emails-settings') {
            wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', true);
            wp_enqueue_script('telegram-admin-emails-test', plugin_dir_url(__FILE__) . 'js/telegram-admin-emails-test.js', array('jquery'), '1.0', true);
        }
    }
    add_action('admin_enqueue_scripts', 'Better_Notified_enqueue_scripts');


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
                            <input name="Telegram_bot_token" type="text" id="Telegram_bot_token" value="<?php
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
                            <input name="Telegram_chat_id" type="text" id="Telegram_chat_id" value="<?php echo esc_attr($Telegram_chat_id); ?>" class="regular-text">
                            <p class="description" id="Telegram_chat_id-description">
                                <?php esc_html_e('Enter the chat ID of the Telegram chat where you want to receive admin emails. You can use a group chat ID or a user chat ID.', 'telegram-admin-emails'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <input type="button" id="Better_Notified_test_button" value="Test Telegram Connection" onclick="testTelegramConnection()">
                        </td>
                    </tr>

                </tbody>
            </table>
            <?php submit_button();
            register_setting('telegram-admin-emails', 'telegram-admin-emails');
            add_settings_section('telegram-admin-emails-section', 'Telegram Admin Emails Settings', '', 'telegram-admin-emails');

            ?>
        </form>

    </div>

<?php
}

// New user register
function Better_Notified_new_user_notification($user_id)
{
    $telegram_bot_token = get_option('Telegram_bot_token');
    $telegram_chat_id = get_option('Telegram_chat_id');
    $user_info = get_userdata($user_id);
    $message = "New user registered: " . $user_info->user_login;
    if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
        $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
        wp_remote_get($telegram_api_url);
    }
}
// plugin updates
function Better_Notified_plugin_update_notification()
{
    $telegram_bot_token = get_option('Telegram_bot_token');
    $telegram_chat_id = get_option('Telegram_chat_id');
    $plugins = get_plugin_updates();
    if (!empty($plugins)) {
        $message = "The following plugins have updates available:\n";
        foreach ($plugins as $plugin) {
            $message .= "- " . $plugin->Name . " (version " . $plugin->update->new_version . ")\n";
        }
        if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
            $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
            wp_remote_get($telegram_api_url);
        }
    }
}
// core updates
function Better_Notified_core_update_notification()
{
    $telegram_bot_token = get_option('Telegram_bot_token');
    $telegram_chat_id = get_option('Telegram_chat_id');
    $updates = wp_get_update_data();
    if ($updates['counts']['total'] > 0) {
        $message = "WordPress has " . $updates['counts']['total'] . " update(s) available.\n";
    }
    if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
        $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
        wp_remote_get($telegram_api_url);
    }
}


//Send admin emails to Telegram

add_action('wp_mail_failed', 'Better_Notified_send_message');
add_action('wp_mail_failed', 'Better_Notified_send_message_error');

function Better_Notified_send_message($wp_error)
{
    $Telegram_bot_token = get_option('Telegram_bot_token');
    $Telegram_chat_id = get_option('Telegram_chat_id');

    if (empty($Telegram_bot_token) || empty($Telegram_chat_id)) {
        return;
    }

    $message = sprintf(
        __('An error occurred while trying to send an email: %s', 'telegram-admin-emails'),
        $wp_error->get_error_message()
    );

    $telegram_api_url = 'https://api.telegram.org/bot' . $Telegram_bot_token . '/sendMessage?chat_id=' . $Telegram_chat_id . '&text=' . urlencode($message);
    wp_remote_get($telegram_api_url);
}
