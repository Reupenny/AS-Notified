# Better Notified 🔔

<a target="_blank" href="https://github.com/Reupenny/Better-Notified"><img alt="GitHub tag (latest by date)" src="https://img.shields.io/github/v/tag/Reupenny/Better-notified?label=version"></a> <a target="_blank" href="https://github.com/Reupenny/Better-Notified"><img alt="GitHub last commit (by committer)" src="https://img.shields.io/github/last-commit/Reupenny/Better-Notified"></a> <a target="_blank" href="https://github.com/Reupenny/Better-Notified"><img alt="GitHub commits since latest release (by date including pre-releases)" src="https://img.shields.io/github/commits-since/Reupenny/Better-Notified/v0.2.0-beta?include_prereleases"></a> <a target="_blank" href="https://github.com/Reupenny/Better-Notified"><img alt="GitHub file size in bytes on a specified ref (branch/commit/tag)" src="https://img.shields.io/github/size/Reupenny/Better-Notified/versions/Better-Notified-0.2.0b.zip?label=Plugin%20size"></a> <a target="_blank" href="https://github.com/Reupenny/Better-Notified"><img alt="GitHub issues" src="https://img.shields.io/github/issues/Reupenny/Better-notified"></a>

<div align="center" width="100%">
    <img src="./public/icon.svg" width="150" alt="" />
</div>

A Wordpress plugin to keep you notified of the important things.

Better Notified helps you stay informed about important events on your website. This plugin allows you to receive notifications about failed emails, new user registrations, plugin updates, core updates, and new comments in real-time through Telegram.

Please note this is my first plugin for wordpress and I am new to PHP.

If you use and enjoy Better Notified consider Making a donation to support its development [Donate here](https://azurestudio.co.nz)

## Features

🔷 Failed email notifications:
Get notified immediately when an email fails to send.

🔷 New user registration notifications:
Be informed when a new user registers on your website.

🔷 Plugin update notifications:
Stay up-to-date with the latest plugin versions and ensure the security of your website.

🔷 Core update notifications:
Keep track of Wordpress updates and make sure your website is always running the latest version.

🔷 Comments notifications:
Stay informed about new comments on your website.

🔷 User notifications:
Allow your users & customers to get order updaytes through telegram

🔷 Shortcocde to allow users & custmers to add/ edit their telegram ID [better_notified_user_settings]

🔷 Plugin Update Checker is being used to push updates. [GitHub](https://github.com/YahnisElsts/plugin-update-checker)

<div align="center" width="100%">
    <img src="public/Screenshot_1.png" alt="" />
</div>

## To Do List for V1 Release

🔲 Add setting toggle to disable emails for selected notifications

🔲 Add setting toggle to enable/disable silent notifications

🔲 Create uninstall.php

🔲 Set up Plugin Update Checker to pull from GitHub releases

🔲 Finish install and useage documentation

🔲 finsinsh adding notification types

## In consideration

🔲 Create a multisite instance

## Complete

🟩 Add options in settings to disable and enable each notification type.

🟩 Seperate out the single PHP file into different files such as a setting.php.

🟩 Multiple Telegram Chat IDs for different notifications, so developers can get notifications about the WP install and business owners can get notifications about Comments and the likes.

🟩 Add Woocommerce integration, new orders, reviews & low stock

🟩 Allow users to add there own notification service instead of emails
    changeable in user settings and also via a shortcode to be accessable on the front end

## Version 2

🔲 Add Discord, Slack, Pushover, Gotify Notification Options

🔲 Create optiosn in settings to allow admins to edit default messages

## Version 3

🔲 Intergrate licencing to unlock new features that are added with version 3.

🔲 Add a notification center to hide all the annoying notifications that clutter the admin dashboard.

## Screenshots

<div align="center" width="100%">
    <img src="public/Screenshot_1.png" alt="" />
</div>

## Additional notificascation types to add

🔷 "upgrader_process_complete" - This action hook is triggered when an update for a plugin, theme or core is complete. You can use this hook to send notifications when the update process is complete.

🔷 "admin_notices" - This action hook is triggered when an admin notice is displayed on the WordPress dashboard. You can use this hook to receive notifications when an admin notice is displayed.

🔷 "woocommerce_product_sold_out" - triggered when a product is sold out in WooCommerce. This can be used to send a notification to the site administrator or the customer about the product being out of stock.

🔷 "woocommerce_order_status_changed" - triggered when an order's status is changed in WooCommerce. This can be used to send a notification to the customer or the site administrator about the change in order status.

🔷 "wp_upgrade_failed" - that can be used to send notifications in case of a failed plugin update.

🔷 "transition_post_status" - for when new posts are published The function should have 3 parameters: $new_status, $old_status, and $post. These parameters represent the new post status, the old post status, and the post object, respectively.
