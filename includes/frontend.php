<?php
/**
 * Frontend display logic for Scroll Reminder.
 *
 * @package ScrollReminder
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue frontend styles and scripts for Scroll Reminder.
 *
 * @return void
 */
function scroll_reminder_enqueue_assets() {
    $opts = get_option( 'scroll_reminder_settings' );

    // Check if the plugin is enabled
    if ( empty( $opts['enabled'] ) ) {
        return;
    }

    wp_enqueue_style(
        'scroll-reminder-by-eskim',
        SCROLL_REMINDER_URL . 'assets/css/scroll-reminder-by-eskim.css',
        [],
        SCROLL_REMINDER_VERSION
    );

    wp_enqueue_script(
        'scroll-reminder-by-eskim',
        SCROLL_REMINDER_URL . 'assets/js/scroll-reminder-by-eskim.js',
        [],
        SCROLL_REMINDER_VERSION,
        true
    );

    wp_localize_script(
        'scroll-reminder-by-eskim',
        'ScrollReminderSettings',
        $opts
    );
}
add_action( 'wp_enqueue_scripts', 'scroll_reminder_enqueue_assets' );

/**
 * Output the progress bar HTML in the footer.
 *
 * @return void
 */
function scroll_reminder_output_progress_bar() {
    if ( ! is_singular() ) {
        return;
    }

    $opts = get_option( 'scroll_reminder_settings' );

    if ( empty( $opts['enabled'] ) ) {
        return;
    }

    if ( !empty( $opts['progress_bar_enabled'] ) ) {
        echo '<div id="scroll-reminder-by-eskim-bar"></div>';
    }
    
    if ( !empty( $opts['percentage_label_enabled'] ) ) {
        echo '<div id="scroll-reminder-by-eskim-percent"></div>';
    }
    
}
add_action( 'wp_footer', 'scroll_reminder_output_progress_bar' );
