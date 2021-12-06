<?php

namespace WSChat;

use Illuminate\Support\Arr;

class WSSettings {

	public static $settings = null;

	public static function init() {
	}

	public static function get_widget_settings( $hide_sensitive = false ) {
		if ( self::$settings ) {
			return self::$settings;
		}

		$settings_option_key = 'wschat_site_settings';

		$wschat_options = array(
			'enable_live_chat'        => 'on',
			'widget_status'           => 'online',
			'header_online_text'      => 'Online',
			'header_offline_text'     => 'Offline',
			'offline_auto_reply_text' => 'We are offline now.',
			'header_text'             => __( 'Chat with us!', 'wschat' ),
			'font_family'             => '',
			'alert_tone'              => 'messenger',
			'alert_tone_url'          => Utils::get_resource_url( '/resources/tones/messenger.wav' ),
			'colors'                  => array(
				'--wschat-bg-primary'     => '74b9ff',
				'--wschat-bg-secondary'   => 'eeeeee',
				'--wschat-text-primary'   => 'ffffff',
				'--wschat-text-secondary' => '333333',
				'--wschat-icon-color'     => '808080',
				'--wschat-text-gray'      => '808080',
			),
			'communication_protocol'  => 'http',
			'pusher'                  => array(
				'app_key'    => '',
				'secret_key' => '',
				'app_id'     => '',
				'cluster'    => '',
			),
		);

		$settings = get_option( $settings_option_key, $wschat_options );

		self::$settings = $settings;

		if ( true === $hide_sensitive ) {
			$settings = Arr::except(
				$settings,
				array(
					'pusher.secret_key',
					'pusher.app_id',
				)
			);
		}

		return $settings;
	}

	public function admin_settings() {
		$fonts = array( 'sans-serif', 'monospace', 'fantasy', 'Roboto', 'cursive' );

		$tones = $this->getTones();

		if ( isset( $_REQUEST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( $_REQUEST['_wpnonce'] ) ) ) {
			die();
		}

		if ( isset( $_POST['submit'] ) ) {
			$wschat_options = $this->save_settings();
			do_action( 'wschat_after_settings_saved', $wschat_options );
		} else {
			$wschat_options = self::get_widget_settings();
		}

		include_once dirname( __DIR__ ) . '/resources/views/admin/settings.php';
	}

	public function getTones() {
		$files = glob( dirname( __DIR__ ) . '/resources/tones/*' );

		return array_map(
			function ( $file ) {
			return Arr::only(
				pathinfo( $file ),
				array(
					'basename',
					'filename',
				)
			);
			},
			$files
		);
	}

	public function save_settings() {
		if ( ! isset( $_POST['wschat_settings_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( $_POST['wschat_settings_nonce'] ), 'wschat_save_settings' ) ) {
			Utils::abort();
		}

		global $wschat;

		$settings_option_key = 'wschat_site_settings';
		$wschat_options      = Utils::get_widget_settings();

		array_walk_recursive( $_POST, 'sanitize_text_field' );

		$new_options = Arr::only( $_POST, array_keys( $wschat_options ) );

		if ( ! isset( $new_options['enable_live_chat'] ) ) {
			$new_options['enable_live_chat'] = false;
		}

		if ( ! isset( $new_options['widget_status'] ) ) {
			$new_options['widget_status'] = 'offline';
		} else {
			$new_options['widget_status'] = 'online';
		}

		if ( isset( $new_options['alert_tone'] ) ) {
			$new_options['alert_tone_url'] = plugins_url( dirname( $wschat->plugin_basename ) ) . '/resources/tones/' . $new_options['alert_tone'];
		}

		$wschat_options = array_merge( $wschat_options, $new_options );

		update_option( $settings_option_key, $wschat_options );

		self::$settings = $wschat_options;

		return $wschat_options;
	}
}
