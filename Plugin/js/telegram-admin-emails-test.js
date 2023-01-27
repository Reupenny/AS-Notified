jQuery(document).ready(function ($) {
    $("#test-button").click(function () {
        var botToken = $("#telegram_admin_emails_bot_token").val();
        var chatId = $("#telegram_admin_emails_chat_id").val();
        var testMessage = "This is a test message sent from Telegram Admin Emails plugin.";
        var apiUrl = 'https://api.telegram.org/bot' + botToken + '/sendMessage?chat_id=' + chatId + '&text=' + testMessage;
        $.get(apiUrl);
    });
});
