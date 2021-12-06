<?php

namespace WSChat;

use Illuminate\Support\Arr;
use WSChat\Models\Conversation;
use WSChat\Models\Message;
use WSChat\Models\User;

class WSMessage {

	public static function init() {
		$self = new self();

		// Get messages
		add_action( 'wp_ajax_nopriv_wschat_get_messages', array( $self, 'user_router' ) );
		add_action( 'wp_ajax_wschat_get_messages', array( $self, 'user_router' ) );
		add_action( 'wp_ajax_wschat_admin_get_messages', array( $self, 'admin_router' ) );

		// Send a message
		add_action( 'wp_ajax_nopriv_wschat_send_message', array( $self, 'user_router' ) );
		add_action( 'wp_ajax_wschat_send_message', array( $self, 'user_router' ) );
		add_action( 'wp_ajax_wschat_admin_send_message', array( $self, 'admin_router' ) );

		// Send a message
		add_action( 'wp_ajax_nopriv_wschat_read_all', array( $self, 'user_router' ) );
		add_action( 'wp_ajax_wschat_read_all', array( $self, 'user_router' ) );
		add_action( 'wp_ajax_wschat_admin_read_all', array( $self, 'admin_router' ) );
	}

	public function user_router() {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );

		$user         = ( new WSUser() )->get_user( false );
		$conversation = ( new WSConversation() )->get_conversation( $user );

		if ( ! $user instanceof User ) {
			return wp_send_json_error( array(), 404 );
		}

		$method = isset( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : Utils::abort();

		$method = str_replace( 'wschat_', '', $method );

		return call_user_func_array( array( $this, $method ), array( $user, $conversation ) );
	}

	public function admin_router() {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );
		Utils::abort_unless_agent();

		$user = wp_get_current_user();

		if ( isset( $_POST['conversation_id'] ) === false ) {
			return wp_send_json_error( array(), 404 );
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? sanitize_text_field( $_POST['conversation_id'] ) : Utils::abort();

		$conversation = ( new Conversation() )->findById( $conversation_id );

		$method = isset( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : Utils::abort();

		$method = str_replace( 'wschat_admin_', '', $method );

		if ( false === $conversation || ! method_exists( $this, $method ) ) {
			Utils::abort();
		}

		return call_user_func_array(
			array( $this, $method ),
			array( $user, $conversation )
		);
	}

	/**
	 * Get messages
	 *
	 * @param User|WP_User $user
	 * @param Conversation $conversation
	 */
	public function get_messages( $user, $conversation ) {
		// TODO: Authorize the user that he access to the conversation
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );

		$participant = $conversation->participants()->findByUser( $user );

		Utils::abort_unless( $participant );

		$participant->online(); // Just to make sure that this takes more time compared to read

		if ( $user instanceof User ) {
			$chatUser = $participant;
		} else {
			$chatUser = $conversation->participants()->findByUser( $conversation->chatUser() );
		}

		$message = $conversation->messages();

		$messages = $message->get( $_POST );

		$messages = array_map(
			function ( $message ) use ( $participant, $chatUser ) {
			$message             = ( new Message( 0 ) )->parseData( $message )->toArray();
			$message['is_me']    = Arr::get( $message, 'participant_id' ) === $participant->id ? true : false;
			$message['is_agent'] = Arr::get( $message, 'participant_id' ) !== $chatUser->id ? true : false;

			return $message;
			},
			$messages
		);

		wp_send_json_success(
			array(
				'messages'     => $messages,
				'unread_count' => $message->unreadCount( $participant ),
				'status'       => $chatUser ? $chatUser->status() : __( 'Offline', 'wschat' ),
				'is_online'    => $chatUser ? $chatUser->isOnline() : false,
			)
		);
	}

	/**
	 * Get messages
	 *
	 * @param User|WP_User $user
	 * @param Conversation $conversation
	 */
	public function send_message( $user, $conversation ) {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );
		$participant = $conversation->participants()->findByUser( $user );

		Utils::abort_unless( $participant );

		$data['type'] = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : Utils::abort();
		$data['body'] = array();

		$text         = isset( $_POST['content']['text'] ) ? sanitize_text_field( $_POST['content']['text'] ) : '';
		$data['body'] = array(
			'text' => $text,
		);

		if ( isset( $_FILES['attachments']['name'] ) ) {
			$data['body']['attachments'] = [];

			$count = count( $_FILES['attachments']['name'] );

			for ( $index = 0; $index < $count; $index++ ) {
				if ( ! isset( $_FILES['attachments']['tmp_name'][ $index ] ) || ! isset( $_FILES['attachments']['name'][ $index ] ) ) {
					continue;
				}

				$name = sanitize_text_field( $_FILES['attachments']['name'][ $index ] );

				$res = wp_upload_bits(
					$name,
					null,
					file_get_contents( sanitize_text_field( $_FILES['attachments']['tmp_name'][ $index ] ) )
				);

				// Need to check allowed mime types or add custom mime types
				if ( false === $res['error'] ) {
					$res['name']                   = $name;
					$data['body']['attachments'][] = Arr::except( $res, 'file' );
				}
			}
		}

		$message = $conversation->messages()->add( $participant, $data );

		do_action(
			'wschat_on_send_message',
			array(
				'message'      => $message,
				'conversation' => $conversation,
				'participant'  => $participant,
			)
		);

		$response = array(
			'id'      => $message->id,
			'message' => __( 'Message has been sent', 'wschat' ),
		);

		$settings = get_option( 'wschat_site_settings', [] );

		if ( isset( $settings['widget_status'] ) && 'online' !== $settings['widget_status'] ) {
			$response['offline_reply'] = __( $settings['offline_auto_reply_text'], 'wschat' );
		}

		wp_send_json_success( $response );
	}

	/**
	 * Read all the unred messages on the logged in user
	 *
	 * @param User|WP_User $user
	 * @param Conversation $conversation
	 */
	public function read_all( $user, $conversation ) {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );
		$participant = $conversation->participants()->findByUser( $user );

		if ( false === $participant ) {
			wp_json_send_error( array(), 403 );
			return false;
		}

		$conversation->messages()->readAll( $participant );

		wp_send_json_success(
			array(
				'message' => __( 'Messages has been marked as read', 'wschat' ),
			)
		);
	}
}
