<?php

// New user register
function Better_Notified_new_user_notification($user_id)
{
    if (get_option('new_user_notifications') == 1) {
        // Send notification code
        $telegram_bot_token = get_option('Telegram_bot_token');
        $telegram_chat_id = get_option('Telegram_chat_id');
        $user_info = get_userdata($user_id);
        $message = "New user registered: " . $user_info->user_login;
        if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
            $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
            wp_remote_get($telegram_api_url);
        }
    }
}
// plugin updates
function Better_Notified_plugin_update_notification()
{
    if (get_option('plugin_update_notifications') == 1) {
        // Send notification code
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
}
// core updates
function Better_Notified_core_update_notification()
{
    if (get_option('core_update_notifications') == 1) {
        // Send notification code
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
}
// new comments
function Better_Notified_comments_notification($comment_ID, $comment_approved)
{
    if (get_option('comments_notifications') == 1) {
        // Send notification code
        $telegram_bot_token = get_option('Telegram_bot_token');
        $telegram_chat_id = get_option('Telegram_chat_id');
        $comment = get_comment($comment_ID);
        $comment_author = $comment->comment_author;
        $comment_content = $comment->comment_content;
        $post_title = get_the_title($comment->comment_post_ID);
        $post_id = $comment->comment_post_ID;
        $post_link = get_permalink($post_id);
        $comment_link = $post_link . "#comment-" . $comment_ID;
        if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
            $message = "New comment by " . $comment_author . "\n" . $comment_content . "\n" . "Comment on: " . $post_title . "\n\n\n " . $comment_link;
            $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message) . '&parse_mode=HTML';
            wp_remote_get($telegram_api_url);
        }
    }
}
//admin emails
function Better_Notified_admin_emails($error)
{
    if (get_option('admin_emails_notifications') == 1) {
        // Send notification code
        $telegram_bot_token = get_option('Telegram_bot_token');
        $telegram_chat_id = get_option('Telegram_chat_id');
        $message = $error->get_error_message();
        if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
            $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . $message;
            wp_remote_get($telegram_api_url);
        }
    }
}
