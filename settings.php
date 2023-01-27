function Better-Notified_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    $Better-Notified_bot_token = get_option('Better-Notified_bot_token');
    $Better-Notified_chat_id = get_option('Better-Notified_chat_id');

    function Better-Notified_enqueue_scripts()
    {
        if (isset($_GET['page']) && $_GET['page'] === 'telegram-admin-emails-settings') {
            wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', true);
            wp_enqueue_script('telegram-admin-emails-test', plugin_dir_url(__FILE__) . 'js/telegram-admin-emails-test.js', array('jquery'), '1.0', true);
        }
    }
    add_action('admin_enqueue_scripts', 'Better-Notified_enqueue_scripts');


?>
    <div class="wrap">
        <h1><?php esc_html_e('Telegram Admin Emails Settings', 'telegram-admin-emails'); ?></h1>

        <form method="post" action="options.php">
            <?php
            settings_fields('telegram-admin-emails');
            do_settings_sections('telegram-admin-emails');
            ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="Better-Notified_bot_token"><?php esc_html_e('Telegram Bot Token', 'telegram-admin-emails'); ?></label>
                        </th>
                        <td>
                            <input name="Better-Notified_bot_token" type="text" id="Better-Notified_bot_token" value="<?php
                                                                                                                                    echo esc_attr($Better-Notified_bot_token); ?>" class="regular-text">
                            <p class="description" id="Better-Notified_bot_token-description">
                                <?php esc_html_e('Enter your Telegram bot token. You can create a new bot and get its token from the Bot Father.', 'telegram-admin-emails'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="Better-Notified_chat_id"><?php esc_html_e('Telegram Chat ID', 'telegram-admin-emails'); ?></label>
                        </th>
                        <td>
                            <input name="Better-Notified_chat_id" type="text" id="Better-Notified_chat_id" value="<?php echo esc_attr($Better-Notified_chat_id); ?>" class="regular-text">
                            <p class="description" id="Better-Notified_chat_id-description">
                                <?php esc_html_e('Enter the chat ID of the Telegram chat where you want to receive admin emails. You can use a group chat ID or a user chat ID.', 'telegram-admin-emails'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <input type="button" id="Better-Notified_test_button" value="Test Telegram Connection" onclick="testTelegramConnection()">
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