<?php
/**
 * Uninstall Scroll Reminder
 *
 * @package ScrollReminder
 */

// Exit if accessed directly or called outside of WordPress uninstall process.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Remove plugin settings
delete_option( 'scroll_reminder_settings' );

// If you had any other options, custom tables, or user meta – usuń je też tutaj
