<?php
/**
 * Plugin Name:       Scroll Reminder by Eskim
 * Plugin URI:        https://eskim.pl/scroll-reminder-by-eskim-en
 * Description:       Adds a reading progress bar to WordPress articles.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            Eskim
 * Author URI:        https://eskim.pl
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       scroll-reminder-by-eskim
 * Domain Path:       /languages
 *
 * @package ScrollReminder
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define plugin constants.
 */
define( 'SCROLL_REMINDER_VERSION', '1.0.0' );
define( 'SCROLL_REMINDER_DIR', plugin_dir_path( __FILE__ ) );
define( 'SCROLL_REMINDER_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin textdomain for translations.
 */
function scroll_reminder_load_textdomain() {
	load_plugin_textdomain(
		'scroll-reminder-by-eskim',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'plugins_loaded', 'scroll_reminder_load_textdomain' );

/**
 * Add Settings link on the plugin list in wp-admin.
 *
 * @param array $links Existing plugin action links.
 * @return array Modified plugin action links with settings link.
 */
function scroll_reminder_plugin_action_links( $links ) {
	$settings_link = '<a href="' . esc_url( admin_url( 'options-general.php?page=scroll-reminder-by-eskim' ) ) . '">' .
		esc_html__( 'Settings', 'scroll-reminder-by-eskim' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'scroll_reminder_plugin_action_links' );

/**
 * Check PHP and WordPress version requirements on activation.
 */
function scroll_reminder_activate_plugin() {
	global $wp_version;

	if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die(
			esc_html__( 'Scroll Reminder requires PHP 7.4 or higher.', 'scroll-reminder-by-eskim' ),
			esc_html__( 'Plugin Activation Error', 'scroll-reminder-by-eskim' ),
			[ 'back_link' => true ]
		);
	}

	if ( version_compare( $wp_version, '5.0', '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die(
			esc_html__( 'Scroll Reminder requires WordPress 5.0 or higher.', 'scroll-reminder-by-eskim' ),
			esc_html__( 'Plugin Activation Error', 'scroll-reminder-by-eskim' ),
			[ 'back_link' => true ]
		);
	}

	scroll_reminder_set_default_options();
}
register_activation_hook( __FILE__, 'scroll_reminder_activate_plugin' );


/**
 * Set default plugin options.
 */
function scroll_reminder_set_default_options() {
	$defaults = [
		'enabled'                       => true,
		'progress_bar_enabled'          => true,
		'percentage_label_enabled'      => true,
		'hide_on_mobile'                => false,

		// Progress Bar
		'progress_bar_position'         => 'top',
		'progress_bar_color'            => '#2299ee',
		'progress_bar_height'           => '4px',
		'progress_bar_transition_speed' => '0.2s',

		// Percentage Label
		'percentage_label_color'        => '#000000',
		'percentage_label_size'         => '',
		'percentage_label_font_size'    => '12px',
		'percentage_label_font_color'   => '#ffffff',
		'percentage_label_percent_position' => 'bottom-right',
		'percentage_label_shape'        => 'rectangle',

		// Optional
		'post_types'                    => [ 'post' ],
	];

	if ( ! get_option( 'scroll_reminder_settings' ) ) {
		add_option( 'scroll_reminder_settings', $defaults );
	}
}

/**
 * Load plugin dependencies.
 */
require_once SCROLL_REMINDER_DIR . 'includes/settings.php';
require_once SCROLL_REMINDER_DIR . 'includes/frontend.php';
