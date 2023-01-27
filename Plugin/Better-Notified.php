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
// Include files.
require_once ADMIN_NOTICES_MANAGER_INC . 'settings.php';


add_action('wp_mail_failed', 'Better-Notified_redirect', 10, 1);



function Better-Notified_redirect($error)
{
    $telegram_bot_token = get_option('Better-Notified_bot_token');
    $telegram_chat_id = get_option('Better-Notified_chat_id');
    $message = $error->get_error_message();
    if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
        $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . $message;
        wp_remote_get($telegram_api_url);
    }
}


add_action('admin_menu', 'Better-Notified_create_menu');

function Better-Notified_create_menu()
{
    register_setting('telegram-admin-emails', 'Better-Notified_bot_token');
    register_setting('telegram-admin-emails', 'Better-Notified_chat_id');

    add_options_page(
        'Telegram Admin Emails',
        'Telegram Admin Emails',
        'manage_options',
        'telegram-admin-emails-settings',
        'Better-Notified_settings_page'
    );
}

add_action('network_admin_menu', 'Better-Notified_create_network_menu');

function Better-Notified_create_network_menu()
{
    register_setting('telegram-admin-emails', 'Better-Notified_bot_token');
    register_setting('telegram-admin-emails', 'Better-Notified_chat_id');

    add_submenu_page(
        'settings.php',
        'Telegram Admin Emails',
        'Telegram Admin Emails',
        'manage_options',
        'telegram-admin-emails-settings',
        'Better-Notified_settings_page'
    );
}

add_action('user_register', 'Better-Notified_new_user_notification', 10, 1);



function Better-Notified_new_user_notification($user_id)
{
    $telegram_bot_token = get_option('Better-Notified_bot_token');
    $telegram_chat_id = get_option('Better-Notified_chat_id');
    $user_info = get_userdata($user_id);
    $message = "New user registered: " . $user_info->user_login;
    if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
        $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . $message;
        wp_remote_get($telegram_api_url);
    }
}

//Send admin emails to Telegram

add_action('wp_mail_failed', 'Better-Notified_send_message');
add_action('wp_mail_failed', 'Better-Notified_send_message_error');

function Better-Notified_send_message($wp_error)
{
    $Better-Notified_bot_token = get_option('Better-Notified_bot_token');
    $Better-Notified_chat_id = get_option('Better-Notified_chat_id');

    if (empty($Better-Notified_bot_token) || empty($Better-Notified_chat_id)) {
        return;
    }

    $message = sprintf(
        __('An error occurred while trying to send an email: %s', 'telegram-admin-emails'),
        $wp_error->get_error_message()
    );

    $telegram_api_url = 'https://api.telegram.org/bot' . $Better-Notified_bot_token . '/sendMessage?chat_id=' . $Better-Notified_chat_id . '&text=' . urlencode($message);
    wp_remote_get($telegram_api_url);
}
// Send admin emails to Telegram


add_action('admin_bar_menu', 'multisite_notifications_admin_bar', 999);

function multisite_notifications_admin_bar($wp_admin_bar)
{
    $wp_admin_bar->add_menu(array(
        'id'    => 'multisite_notifications',
        'title' => 'Notifications',
        'href'  => '#',
    ));
    /*
    // Check for Wordpress updates
    if (current_user_can('update_core')) {
        $update_data = check_for_update();
        if ($update_data->updates[0]->response === 'upgrade') {
            $wp_admin_bar->add_menu(array(
                'parent' => 'multisite_notifications',
                'id'     => 'wordpress_update',
                'title'  => 'WordPress Update Available (' . $update_data->updates[0]->current . ')',
                'href'   => admin_url('update-core.php'),
                'meta'   => array('class' => 'wordpress-update'),
            ));
        }
    }

    // Check for plugin updates
    if (current_user_can('update_plugins')) {
        $update_plugins = get_site_transient('update_plugins');
        if (!empty($update_plugins->response)) {
            $wp_admin_bar->add_menu(array(
                'parent' => 'multisite_notifications',
                'id'     => 'plugin_updates',
                'title'  => 'Plugin Updates Available',
                'href'   => admin_url('update-core.php'),
                'meta'   => array('class' => 'plugin-updates'),
            ));
        }
    }

    // Check for admin emails
    global $wpdb;
    $unread_emails = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}admin_emails WHERE status = 'unread'");
    if ($unread_emails > 0) {
        $wp_admin_bar->add_menu(array(
            'parent' => 'multisite_notifications',
            'id'     => 'admin_emails',
            'title'  => 'Admin Emails (' . $unread_emails . ')',
            'href'   => admin_url('admin.php?page=admin_emails'),
            'meta'   => array('class' => 'admin-emails'),
        ));
    }*/
}
