<?php

// New user register
function Better_Notified_new_user_notification($user_id)
{
    if (get_option('new_user_notifications') == 1) {
        // Send notification code
        $telegram_bot_token = get_option('Telegram_bot_token');
        //check if a different chat id is being used for woocommerce
        if (!empty(get_option('Telegram_general_chat_id'))) {
            $telegram_chat_id = get_option('Telegram_general_chat_id');
        } else {
            $telegram_chat_id = get_option('Telegram_chat_id');
        }
        $user_info = get_userdata($user_id);
        $message = "New user registered: " . $user_info->user_login;
        if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
            $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message) . '&disable_notification=true';
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
        //check if a different chat id is being used for woocommerce
        if (!empty(get_option('Telegram_general_chat_id'))) {
            $telegram_chat_id = get_option('Telegram_general_chat_id');
        } else {
            $telegram_chat_id = get_option('Telegram_chat_id');
        }
        $comment = get_comment($comment_ID);
        $comment_author = $comment->comment_author;
        $comment_content = $comment->comment_content;
        $post_title = get_the_title($comment->comment_post_ID);
        $post_id = $comment->comment_post_ID;
        $post_link = get_permalink($post_id);
        $comment_link = $post_link . "#comment-" . $comment_ID;
        if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
            $message = "New comment by " . $comment_author . "\n" . $comment_content . "\n" . "Comment on: " . $post_title . "\n" . $comment_link;
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

//
// Woocommerce
//



// New Order
function Better_Notified_new_order_notification($order_id)
{
    if (get_option('new_order_notifications') == 1) {
        // Send notification code
        $telegram_bot_token = get_option('Telegram_bot_token');
        //check if a different chat id is being used for woocommerce
        if (!empty(get_option('Telegram_WooCommerce_chat_id'))) {
            $telegram_chat_id = get_option('Telegram_WooCommerce_chat_id');
        } else {
            $telegram_chat_id = get_option('Telegram_chat_id');
        }
        $order = wc_get_order($order_id);
        $order_link = $order->get_edit_order_url();
        $message = "New order received!" . "\n" . "Order #" . $order->get_order_number() . "\n" . "Total: " . $order->get_total() . " \n" . $order_link;
        if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
            $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
            wp_remote_get($telegram_api_url);
        }
    }
}

// Low stock notification
function Better_Notified_low_stock_notification()
{
    if (get_option('low_stock_notifications') == 1) {
        $low_stock_threshold = get_option('low_stock_threshold');
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_stock',
                    'value' => $low_stock_threshold,
                    'compare' => '<=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => '_manage_stock',
                    'value' => 'yes',
                    'compare' => '='
                )
            )
        );
        $low_stock_products = get_posts($args);
        if (!empty($low_stock_products)) {
            $telegram_bot_token = get_option('Telegram_bot_token');
            //check if a different chat id is being used for woocommerce
            if (!empty(get_option('Telegram_WooCommerce_chat_id'))) {
                $telegram_chat_id = get_option('Telegram_WooCommerce_chat_id');
            } else {
                $telegram_chat_id = get_option('Telegram_chat_id');
            }
            $message = "Attention: The following products are low in stock: \n";
            foreach ($low_stock_products as $product) {
                $message .= $product->post_title . ' - ' . get_post_meta($product->ID, '_stock', true) . " in stock \n";
            }
            if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
                $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
                wp_remote_get($telegram_api_url);
            }
        }
    }
}
// New product review
function Better_Notified_new_review_notification($comment_id)
{
    if (get_option('new_review_notifications') == 1) {
        // Send notification code
        $telegram_bot_token = get_option('Telegram_bot_token');
        //check if a different chat id is being used for woocommerce
        if (!empty(get_option('Telegram_WooCommerce_chat_id'))) {
            $telegram_chat_id = get_option('Telegram_WooCommerce_chat_id');
        } else {
            $telegram_chat_id = get_option('Telegram_chat_id');
        }
        $comment = get_comment($comment_id);
        $rating = intval(get_comment_meta($comment_id, 'rating', true));
        $message = "New review received: " . $comment->comment_content . " (rating: " . $rating . " stars)";
        if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
            $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
            wp_remote_get($telegram_api_url);
        }
    }
}


//
//
// CUSTOMERS
//
//


//New Order
function Better_Notified_new_order_notification_user($order_id)
{
    // Send notification code
    $telegram_bot_token = get_option('Telegram_bot_token');
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();
    $telegram_chat_id = get_user_meta($user_id, 'telegram_chat_id', true);
    $order_link = $order->get_view_order_url();
    $status = $order->get_status();
    // Check if the user has a telegram chat ID and if it's not empty
    $message = "Your order has been received!" . "\n" . "Order #" . $order->get_order_number() . "\n" . "Total: " . $order->get_total() . "\n" . "Status: " . $order->get_status() . "\n" . $order_link;
    // ... send the message to Telegram
    if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
        $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
        wp_remote_get($telegram_api_url);
    }
}


// Order Status Changed
function Better_Notified_order_status_change($order_id, $old_status, $new_status)
{
    // Send notification code
    $telegram_bot_token = get_option('Telegram_bot_token');
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();
    $telegram_chat_id = get_user_meta($user_id, 'telegram_chat_id', true);
    $order_link = $order->get_view_order_url();
    // Check if the user has a telegram chat ID and if it's not empty
    $message =  "Your order status has been updated." . "\n" . sprintf('Status: %s', $new_status) . "\n" . "Order #" . $order->get_order_number() . "\n" . $order_link;;
    // ... send the message to Telegram
    if (!empty($telegram_bot_token) && !empty($telegram_chat_id)) {
        $telegram_api_url = 'https://api.telegram.org/bot' . $telegram_bot_token . '/sendMessage?chat_id=' . $telegram_chat_id . '&text=' . urlencode($message);
        wp_remote_get($telegram_api_url);
    }
}
