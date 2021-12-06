<?php

namespace WSChat;

use Illuminate\Support\Arr;
use WSChat\Models\User;

class Utils {
	public static function abort( $data = array(), $code = 404 ) {
		wp_send_json_error( $data, $code );
		die;
	}

	public static function abort_if( $boolean, $data, $code ) {
		if ( ! $boolean ) {
			return false;
		}

		return self::abort( $data, $code );
	}

	public static function abort_unless( $boolean, $data = array(), $code = 403 ) {
		return self::abort_if( false === $boolean, $data, $code );
	}

	public static function isAgent( $user = false ) {
		$user = false === $user ? wp_get_current_user() : $user;

		if ( $user instanceof \WP_User ) {
			if ( in_array( User::ROLE_ADMIN, $user->roles, true ) || in_array( User::ROLE_AGENT, $user->roles, true ) ) {
				return true;
			}
		}

		return false;
	}

	public static function abort_unless_agent() {
		self::abort_unless(
			self::isAgent( wp_get_current_user() ),
			array(
				'message' => __( 'Unauthorized', 'wschat' ),
			),
			403
		);
	}

	public static function get_url( $page ) {
		return admin_url( 'admin.php?page=' . $page );
	}

	public static function get_widget_settings( $hide_sensitive = false ) {
		if ( WSSettings::$settings ) {
			return WSSettings::$settings;
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
			'alert_tone_url'          => self::get_resource_url( '/resources/tones/messenger.wav' ),
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
				'auth_key'   => '',
				'secret_key' => '',
				'app_id'     => '',
				'cluster'    => '',
			),
		);

		$settings = get_option( $settings_option_key, $wschat_options );

		WSSettings::$settings = $settings;

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

	public static function is_widget_online() {
		$settings = self::get_widget_settings();

		if ( 'on' === Arr::get( $settings, 'enable_live_chat' ) && 'online' === Arr::get( $settings, 'widget_status' ) ) {
			return true;
		}

		return false;
	}

	public static function get_resource_url( $path = '' ) {
		return plugins_url(
			dirname( plugin_basename( __DIR__ ) )
		) . $path;
	}
}

