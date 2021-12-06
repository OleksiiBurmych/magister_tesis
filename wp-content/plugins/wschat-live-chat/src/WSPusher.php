<?php

namespace WSChat;

use Illuminate\Support\Arr;

class WSPusher {

	public static $pusher = null;

	public static function init() {
		$self = new self();
		add_action( 'wschat_after_settings_saved', array( $self, 'validate_pusher_config' ) );
		add_action( 'wschat_on_send_message', array( $self, 'send_message' ) );
	}

	public function send_message( $payload ) {
		if ( false === $this->is_pusher_enabled() ) {
			return false;
		}

		$pusher = self::get_pusher();

		$message             = $payload['message']->toArray();
		$message['is_agent'] = $payload['participant']->isAgent();

		$data['messages'][]   = $message;
		$data['unread_count'] = $payload['message']->unreadCount( $payload['participant'] );

		$pusher->trigger( 'presence-conversation_' . $payload['message']->conversation_id, 'message', $data );
	}

	/**
	 * Get Pusher server instance
	 *
	 * @return \Pusher\Pusher
	 */
	public static function get_pusher() {
		if ( self::$pusher ) {
			return self::$pusher;
		}

		$settings = Utils::get_widget_settings();

		$options = array(
			'cluster' => Arr::get( $settings, 'pusher.cluster' ),
			'useTLS'  => true,
		);

		self::$pusher = new \Pusher\Pusher(
			Arr::get( $settings, 'pusher.app_key' ),
			Arr::get( $settings, 'pusher.secret_key' ),
			Arr::get( $settings, 'pusher.app_id' ),
			$options
		);

		return self::$pusher;
	}

	public function is_pusher_enabled() {
		$settings = Utils::get_widget_settings();

		return 'pusher' === Arr::get( $settings, 'communication_protocol' );
	}

	public static function can_connect_to_pusher() {
		$pusher = self::get_pusher();

		$response = $pusher->get( '/channels' );

		return is_array( $response ) && 200 === $response['status'];
	}

	public function validate_pusher_config( $wschat_settings ) {
		if ( 'pusher' !== Arr::get( $wschat_settings, 'communication_protocol' ) ) {
			return true;
		}

		if ( true === self::can_connect_to_pusher() ) {
			return true;
		}

		add_action( 'wschat_admin_settings_notices', array( $this, 'invalid_config_notice' ) );
	}

	public function invalid_config_notice() {
		?>
		<div class="notice notice-error is-dismissible">
			<p><?php echo esc_attr__( 'Error: WSchat - Unable to connect to the pusher. Please validate the credentials and try again', 'wschat' ); ?></p>
		</div>
		<?php
	}
}
