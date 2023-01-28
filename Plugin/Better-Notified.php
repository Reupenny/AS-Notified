<?php

/**
 * Plugin Name: Better Notified
 * Description: A Wordpress plugin to keep you notified of the important things.
 * Version:     0.1.0 beta
 * Author:      Azure Studio
 * Author URI:  https://azurestudio.co.nz
 * Plugin URI:  https://azurestudio.co.nz/plugins/
 * Text Domain: Better-Notified
 */

// Update Core.
require("plugin-update-checker/plugin-update-checker.php");
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://reupenny.github.io/Better-Notified/update.json',
    __FILE__,
    'Better-Notified'
);

add_action('wp_mail_failed', 'Better_Notified_admin_emails', 10, 1);
add_action('admin_menu', 'Better_Notified_create_menu');
add_action('user_register', 'Better_Notified_new_user_notification', 10, 1);
add_action('wp_update_plugins', 'Better_Notified_plugin_update_notification');
add_action('wp_version_check', 'Better_Notified_core_update_notification');
add_action('comment_post', 'Better_Notified_comments_notification', 10, 2);
add_action('network_admin_menu', 'Better_Notified_create_network_menu');

//Create menus
function Better_Notified_create_menu()
{
    register_setting('telegram-admin-emails', 'Telegram_bot_token');
    register_setting('telegram-admin-emails', 'Telegram_chat_id');
    register_setting('telegram-admin-emails', 'new_user_notifications', 'intval');
    register_setting('telegram-admin-emails', 'plugin_update_notifications', 'intval');
    register_setting('telegram-admin-emails', 'core_update_notifications', 'intval');
    register_setting('telegram-admin-emails', 'comments_notifications', 'intval');
    register_setting('telegram-admin-emails', 'admin_emails_notifications');


    add_options_page(
        'Better Notified',
        'Better Notified',
        'manage_options',
        'telegram-admin-emails-settings',
        'Better_Notified_settings_page'
    );
}
function Better_Notified_create_network_menu()
{
    add_submenu_page(
        'settings.php',
        'Better Notified',
        'Better Notified',
        'manage_options',
        'telegram-admin-emails-settings',
        'Better_Notified_settings_page'
    );
}
require_once(plugin_dir_path(__FILE__) . 'settings-page.php');
require_once(plugin_dir_path(__FILE__) . 'services.php');
