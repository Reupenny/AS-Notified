<?php
// Plugin update
function Better_Notified_send_webhook_update_notification()
{
    if (get_option('plugin_update_notifications') == 1) {
        $webhook_url = get_option('webhook_url');
        $plugins = get_plugin_updates();
        if (!empty($plugins)) {
            $message = array(
                'text' => "The following plugins have updates available:\n",
                'attachments' => array()
            );
            foreach ($plugins as $plugin) {
                $message['attachments'][] = array(
                    'title' => $plugin->Name,
                    'text' => "Version " . $plugin->update->new_version
                );
            }
            if (!empty($webhook_url)) {
                $options = array(
                    'method' => 'POST',
                    'timeout' => 30,
                    'sslverify' => false,
                    'body' => json_encode($message)
                );
                wp_remote_post($webhook_url, $options);
            }
        }
    }
}
