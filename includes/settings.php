<?php
/**
 * Admin settings page for Scroll Reminder.
 *
 * @package ScrollReminder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Register admin menu.
add_action( 'admin_menu', function() {
	add_options_page(
		esc_html__( 'Scroll Reminder Settings', 'scroll-reminder-by-eskim' ),
		esc_html__( 'Scroll Reminder', 'scroll-reminder-by-eskim' ),
		'manage_options',
		'scroll-reminder-by-eskim',
		'scroll_reminder_render_settings_page'
	);
});

// Render settings page.
function scroll_reminder_render_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Scroll Reminder – Settings', 'scroll-reminder-by-eskim' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'scroll_reminder_settings_group' );
			do_settings_sections( 'scroll-reminder-by-eskim' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

// Register settings, sections, and fields.
add_action( 'admin_init', function() {
	register_setting( 'scroll_reminder_settings_group', 'scroll_reminder_settings', [
		'sanitize_callback' => 'scroll_reminder_sanitize_settings',
	] );

	$opts = get_option( 'scroll_reminder_settings' );

	add_settings_section(
		'main_settings',
		__( 'Main Settings', 'scroll-reminder-by-eskim' ),
		null,
		'scroll-reminder-by-eskim'
	);

	add_settings_section(
		'progress_bar',
		__( 'Progress Bar Settings', 'scroll-reminder-by-eskim' ),
		null,
		'scroll-reminder-by-eskim'
	);

	add_settings_section(
		'percentage_label',
		__( 'Percentage Label Settings', 'scroll-reminder-by-eskim' ),
		null,
		'scroll-reminder-by-eskim'
	);

	// Main
	add_settings_field(
		'enabled',
		__( 'Enable Plugin', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_checkbox',
		'scroll-reminder-by-eskim',
		'main_settings',
		[
			'id'    => 'enabled',
			'label' => __( 'Enable or disable the Scroll Reminder functionality.', 'scroll-reminder-by-eskim' ),
			'opts'  => $opts
		]
	);

	add_settings_field(
		'hide_on_mobile',
		__( 'Hide on Mobile', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_checkbox',
		'scroll-reminder-by-eskim',
		'main_settings',
		[
			'id'    => 'hide_on_mobile',
			'label' => __( 'Hide the elements on small screens.', 'scroll-reminder-by-eskim' ),
			'opts'  => $opts
		]
	);

	// Progress Bar
	add_settings_field(
		'progress_bar_enabled',
		__( 'Enable Progress Bar', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_checkbox',
		'scroll-reminder-by-eskim',
		'progress_bar',
		[
			'id'    => 'progress_bar_enabled',
			'label' => __( 'Toggle the progress bar visibility.', 'scroll-reminder-by-eskim' ),
			'opts'  => $opts
		]
	);

	add_settings_field(
		'progress_bar_position',
		__( 'Bar Position', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_select',
		'scroll-reminder-by-eskim',
		'progress_bar',
		[
			'id'     => 'progress_bar_position',
			'options'=> [
				'top'    => 'Top',
				'bottom' => 'Bottom'
			],
			'opts'   => $opts
		]
	);

	add_settings_field(
		'progress_bar_color',
		__( 'Bar Color', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_color',
		'scroll-reminder-by-eskim',
		'progress_bar',
		[
			'id'   => 'progress_bar_color',
			'opts' => $opts
		]
	);

	add_settings_field(
		'progress_bar_height',
		__( 'Bar Height', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_text',
		'scroll-reminder-by-eskim',
		'progress_bar',
		[
			'id'   => 'progress_bar_height',
			'opts' => $opts
		]
	);

	add_settings_field(
		'progress_bar_transition_speed',
		__( 'Transition Speed', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_text',
		'scroll-reminder-by-eskim',
		'progress_bar',
		[
			'id'   => 'progress_bar_transition_speed',
			'opts' => $opts
		]
	);

	// Percentage Label
	add_settings_field(
		'percentage_label_enabled',
		__( 'Enable Percentage Label', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_checkbox',
		'scroll-reminder-by-eskim',
		'percentage_label',
		[
			'id'    => 'percentage_label_enabled',
			'label' => __( 'Toggle the percentage indicator.', 'scroll-reminder-by-eskim' ),
			'opts'  => $opts
		]
	);
	
	add_settings_field(
		'percentage_label_shape',
		__( 'Label Shape', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_select',
		'scroll-reminder-by-eskim',
		'percentage_label',
		[
			'id' => 'percentage_label_shape',
			'options' => [
				'rectangle' => __( 'Rectangle', 'scroll-reminder-by-eskim' ),
				'circle' => __( 'Circle', 'scroll-reminder-by-eskim' ),
			],
			'opts' => $opts,
		]
	);
	
	add_settings_field(
		'percentage_label_size',
		__( 'Label Size', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_text',
		'scroll-reminder-by-eskim',
		'percentage_label',
		[ 'id' => 'percentage_label_size', 'opts' => $opts ]
	);
	
	add_settings_field(
		'percentage_label_color',
		__( 'Bar Color', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_color',
		'scroll-reminder-by-eskim',
		'percentage_label',
		[
			'id'   => 'percentage_label_color',
			'opts' => $opts
		]
	);

	add_settings_field(
		'percentage_label_font_size',
		__( 'Font Size', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_text',
		'scroll-reminder-by-eskim',
		'percentage_label',
		[
			'id'   => 'percentage_label_font_size',
			'opts' => $opts
		]
	);

	add_settings_field(
		'percentage_label_font_color',
		__( 'Font Color', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_color',
		'scroll-reminder-by-eskim',
		'percentage_label',
		[
			'id'   => 'percentage_label_font_color',
			'opts' => $opts
		]
	);

	add_settings_field(
		'percentage_label_percent_position',
		__( 'Label Position', 'scroll-reminder-by-eskim' ),
		'scroll_reminder_field_select',
		'scroll-reminder-by-eskim',
		'percentage_label',
		[
			'id'     => 'percentage_label_percent_position',
			'options'=> [
				'top-left'     => 'Top Left',
				'top-right'    => 'Top Right',
				'bottom-left'  => 'Bottom Left',
				'bottom-right' => 'Bottom Right'
			],
			'opts'   => $opts
		]
	);

});

// Sanitization callback.
function scroll_reminder_sanitize_settings( $input ) {
	$fields = [
		'enabled' => 'bool',
		'hide_on_mobile' => 'bool',
		'progress_bar_enabled' => 'bool',
		'progress_bar_position' => 'select',
		'progress_bar_color' => 'color',
		'progress_bar_height' => 'text',
		'progress_bar_transition_speed' => 'text',
		'percentage_label_enabled' => 'bool',
		'percentage_label_color' => 'color',
		'percentage_label_font_size' => 'text',
		'percentage_label_font_color' => 'color',
		'percentage_label_z_index' => 'int',
		'percentage_label_percent_position' => 'select',
		'percentage_label_shape' => 'select',
		'percentage_label_size' => 'text',
	];

	$sanitized = [];
	foreach ( $fields as $key => $type ) {
		switch ( $type ) {
			case 'bool':
				$sanitized[ $key ] = ! empty( $input[ $key ] ) ? 1 : 0;
				break;
			case 'color':
				$sanitized[ $key ] = sanitize_hex_color( $input[ $key ] ?? '' );
				break;
			case 'int':
				$sanitized[ $key ] = absint( $input[ $key ] ?? 0 );
				break;
			case 'select':
				$sanitized[ $key ] = sanitize_text_field( $input[ $key ] ?? '' );
				break;
			default:
				$sanitized[ $key ] = sanitize_text_field( $input[ $key ] ?? '' );
		}
	}
	return $sanitized;
}

// Field renderers.
function scroll_reminder_field_checkbox( $args ) {
	$val = $args['opts'][ $args['id'] ] ?? 0;
	echo '<input type="checkbox" name="scroll_reminder_settings[' . esc_attr( $args['id'] ) . ']" value="1" ' . checked( $val, 1, false ) . '> ';
	if ( ! empty( $args['label'] ) ) {
		echo '<label for="scroll_reminder_settings[' . esc_attr( $args['id'] ) . ']">' . esc_html( $args['label'] ) . '</label>';
	}
}

function scroll_reminder_field_color( $args ) {
	echo '<input type="color" name="scroll_reminder_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $args['opts'][ $args['id'] ] ?? '' ) . '">';
}

function scroll_reminder_field_text( $args ) {
	echo '<input type="text" name="scroll_reminder_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $args['opts'][ $args['id'] ] ?? '' ) . '">';
}

function scroll_reminder_field_number( $args ) {
	echo '<input type="number" name="scroll_reminder_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $args['opts'][ $args['id'] ] ?? '' ) . '">';
}

function scroll_reminder_field_select( $args ) {
	$val = $args['opts'][ $args['id'] ] ?? '';
	echo '<select name="scroll_reminder_settings[' . esc_attr( $args['id'] ) . ']">';
	foreach ( $args['options'] as $key => $label ) {
		echo '<option value="' . esc_attr( $key ) . '" ' . selected( $val, $key, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';
}
