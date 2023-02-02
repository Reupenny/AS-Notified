<?php

/**
 * Plugin Name: Better Notified
 * Description: A Wordpress plugin to keep you notified of the important things.
 * Version:     0.2.0 beta
 * Author:      Azure Studio
 * Author URI:  https://azurestudio.co.nz
 * Plugin URI:  https://azurestudio.co.nz/plugins/
 * Text Domain: Better-Notified
 */

// Update Core.
require 'plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://reupenny.github.io/Better-Notified/update.json',
    __FILE__, //Full path to the main plugin file or functions.php.
    'Better-Notified'
);
//Menus
add_action('admin_menu', 'Better_Notified_create_menu');
add_action('network_admin_menu', 'Better_Notified_create_network_menu');

//Admin general
add_action('wp_mail_failed', 'Better_Notified_admin_emails', 10, 1);
add_action('wp_update_plugins', 'Better_Notified_plugin_update_notification');
add_action('wp_version_check', 'Better_Notified_core_update_notification');

//Owner general
add_action('user_register', 'Better_Notified_new_user_notification', 10, 1);
add_action('comment_post', 'Better_Notified_comments_notification', 10, 2);

//Woocommerce
add_action('woocommerce_new_order', 'Better_Notified_new_order_notification', 10, 1);
add_action('woocommerce_low_stock_notification', 'Better_Notified_low_stock_notification');
add_action('woocommerce_product_review_added', 'Better_Notified_new_product_review_notification');

//Customers
add_action('woocommerce_order_status_changed', 'Better_Notified_order_status_change', 10, 3);
add_action('woocommerce_new_order', 'Better_Notified_new_order_notification_user', 10, 1);


//Create menus
function Better_Notified_create_menu()
{
    register_setting('better-notified-telegram-settings', 'Telegram_bot_token');
    register_setting('better-notified-telegram-settings', 'Telegram_chat_id');
    register_setting('better-notified-telegram-settings', 'Telegram_WooCommerce_chat_id');
    register_setting('better-notified-telegram-settings', 'Telegram_general_chat_id');
    register_setting('better-notified-telegram-settings', 'user_telegram_notifications');
    register_setting('telegram-admin-emails', 'new_user_notifications', 'intval');
    register_setting('telegram-admin-emails', 'plugin_update_notifications', 'intval');
    register_setting('telegram-admin-emails', 'core_update_notifications', 'intval');
    register_setting('telegram-admin-emails', 'comments_notifications', 'intval');
    register_setting('telegram-admin-emails', 'new_order_notifications', 'intval');
    register_setting('telegram-admin-emails', 'low_stock_notifications', 'intval');
    register_setting('telegram-admin-emails', 'review_notifications', 'intval');
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
require_once(plugin_dir_path(__FILE__) . 'customers.php');
