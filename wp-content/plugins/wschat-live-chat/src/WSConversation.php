<?php

namespace WSChat;

use WSChat\Models\Conversation;
use WSChat\Models\Message;
use WSChat\Models\Participant;
use WSChat\Models\User;

class WSConversation {
	public static function init() {
		$self = new self();
		add_action( 'wp_ajax_nopriv_wschat_start_conversation', array( $self, 'start_conversation' ) );
		add_action( 'wp_ajax_wschat_start_conversation', array( $self, 'start_conversation' ) );

		add_action( 'wp_ajax_wschat_admin_get_conversations', array( $self, 'get_conversations' ) );
		add_action( 'wp_ajax_wschat_admin_join_conversation', array( $self, 'join_conversation' ) );

		add_action( 'wp_ajax_nopriv_wschat_pusher_auth', array( $self, 'pusher_auth' ) );
		add_action( 'wp_ajax_wschat_pusher_auth', array( $self, 'pusher_auth' ) );

		add_action( 'wp_ajax_wschat_admin_pusher_auth', array( $self, 'admin_pusher_auth' ) );
	}

	/**
	 * Pusher auth response
	 */
	public function admin_pusher_auth() {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );

		if ( ! isset( $_POST['channel_name'] ) || ! isset( $_POST['socket_id'] ) || false === Utils::isAgent() ) {
			Utils::abort( array(), 403 );
		}

		$pusher = WSPusher::get_pusher();

		$channel_name = sanitize_text_field( $_POST['channel_name'] );
		$socket_id    = sanitize_text_field( $_POST['socket_id'] );

		list($channel_prefix, $conversation_id) = explode( '_', $channel_name );

		$conversation = ( new Conversation() )->find(
			array(
				'id' => $conversation_id,
			)
		);

		if ( false === $conversation ) {
			Utils::abort( array(), 403 );
		}

		$participant = $conversation->participants()->findByUser( wp_get_current_user() );

		$res = $pusher->presence_auth(
			$channel_name,
			$socket_id,
			$participant->id,
			array(
				'type' => $participant->type,
			)
		);

		header( 'Content-type:application/json;charset=utf-8' );
		die( wp_json_encode( json_decode( $res ) ) );
	}

	public function pusher_auth() {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );

		if ( ! isset( $_POST['channel_name'] ) || ! isset( $_POST['socket_id'] ) ) {
			Utils::abort( array(), 403 );
		}

		$pusher = WSPusher::get_pusher();

		$channel_name = sanitize_text_field( $_POST['channel_name'] );
		$socket_id    = sanitize_text_field( $_POST['socket_id'] );

		$user = ( new WSUser() )->get_user( false );

		if ( false === $user ) {
			Utils::abort( array(), 403 );
		}

		list($channel_prefix, $conversation_id) = explode( '_', $channel_name );

		$conversation = ( new Conversation() )->find(
			array(
				'chat_user_id' => $user->id,
				'id'           => $conversation_id,
			)
		);

		if ( false === $conversation ) {
			Utils::abort( array(), 403 );
		}

		$participant = $conversation->participants()->findByUser( $user );

		$res = $pusher->presence_auth(
			$channel_name,
			$socket_id,
			$participant->id,
			array(
				'type' => $participant->type,
			)
		);

		header( 'Content-type:application/json;charset=utf-8' );
		die( wp_json_encode( json_decode( $res ) ) );
	}
	/**
	 * Start a conversation as a Guest or User
	 */
	public function start_conversation() {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );

		$user = ( new WSUser() )->get_user();

		$conversation = $this->get_conversation( $user );

		$conversation = $conversation->toArray();

		$conversation['user'] = $user;

		if ( $conversation['user'] ) {

			$user->updateMeta();

			$conversation['user'] = $conversation['user']->toArray();
		}

		do_action(
			'wschat_user_start_conversation',
			array(
				'conversation' => $conversation,
				'user'         => $user,
			)
		);

		wp_send_json_success( $conversation );

		return $conversation;
	}

	/**
	 * Get conversation from a Chat User
	 *
	 * @param User $user
	 *
	 * @return Conversation
	 */
	public function get_conversation( $user ) {
		$conversation = Conversation::findByChatUserId( $user->id );

		if ( false === $conversation ) {
			$conversation = Conversation::create( $user->id );
			$conversation->participants()->add( $user );

			do_action(
				'wschat_create_new_conversation',
				array(
					'user'         => $user,
					'conversation' => $conversation,
				)
			);
		}

		return $conversation;
	}

	/**
	 * Join to a conversation as an Agent
	 */
	public function join_conversation() {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );

		Utils::abort_unless_agent();

		if ( ! isset( $_POST['conversation_id'] ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid Conversation ID', 'wschat' ),
				),
				412
			);
		}

		$id = sanitize_text_field( $_POST['conversation_id'] );

		$conversation = ( new Conversation() )->find(
			array(
				'id' => $id,
			)
		);

		// TODO: validate agent before join to a conversation

		$participant  = $conversation->participants()->add( wp_get_current_user() );
		$conversation = $conversation->toArray();

		$conversation['user'] = ( new User() )->findById( $conversation['chat_user_id'] );
		if ( $conversation['user'] ) {
			$conversation['user'] = $conversation['user']->toArray();
		}

		do_action(
			'wschat_on_agent_join_conversation',
			array(
				'conversation' => $conversation,
				'participant'  => $participant,
			)
		);

		wp_send_json_success( $conversation );
	}

	public function get_conversations() {
		check_ajax_referer( 'wschat-ajax-nonce', 'wschat_ajax_nonce' );
		Utils::abort_unless_agent();

		$conversations = collect( ( new Conversation() )->get() );
		if ( $conversations->count() === 0 ) {

			wp_send_json_success( $conversations );
			return;
		}

		$conversation_ids = $conversations->pluck( 'id' )->toArray();

		$users = ( new User() )->get(
			array(
				'id' => $conversations->pluck( 'chat_user_id' )->toArray(),
			)
		)->keyBy(
			function ( $user ) {
				return $user->id;
			}
		);

		$participants = ( new Participant( 0 ) )->getStatuses(
			array(
				'conversation_id' => $conversation_ids,
			)
		);

		$logged_in_user_participant_ids = $participants->filter(
			function ( $participant ) {
			return get_current_user_id() === (int) $participant->user_id && Participant::TYPE_AGENT === $participant->type;
			}
		)->map(
			function ( $participant ) {
				return [
					'conversation_id' => $participant->conversation_id,
					'participant_id'  => $participant->id,
				];
			}
		)->pluck( 'participant_id', 'conversation_id' );

		$participants = $participants->groupBy(
			function ( $participant ) {
			return $participant->conversation_id;
			}
		);

		$recentMessages = ( new Message( 0 ) )->getRecentMessage(
			array(
				'conversation_id' => $conversation_ids,
			)
		)->keyBy(
			function ( $message ) {
				return $message->conversation_id;
			}
		);

		$unreadCounts = ( new Message( 0 ) )->getAllUnreadCount(
			$logged_in_user_participant_ids->toArray(),
			$conversation_ids
		);

		$conversations->transform(
			function ( $conversation ) use ( $users, $participants, $recentMessages, $unreadCounts, $logged_in_user_participant_ids ) {
			$conversation['user'] = $users->get( $conversation['chat_user_id'] );
				if ( $conversation['user'] ) {
					$conversation['user'] = $conversation['user']->toArray();
				}

				if ( $participants->has( $conversation['id'] ) ) {
					$conversation['participants'] = $participants->get( $conversation['id'] );

					$conversation['is_user_online'] = $conversation['participants']->filter(
						function ( $participant ) {
						return Participant::TYPE_AGENT !== $participant->type && $participant->isOnline();
						}
					)->count() > 0;

					$conversation['is_agent_online'] = $conversation['participants']->filter(
						function ( $participant ) {
						return Participant::TYPE_AGENT === $participant->type && $participant->isOnline();
						}
					)->count() > 0;

					$conversation['recent_message'] = $recentMessages->get( $conversation['id'] );
					if ( $conversation['recent_message'] ) {
						$conversation['recent_message'] = $conversation['recent_message']->toArray();
					}
				}

				if ( $unreadCounts->has( $conversation['id'] ) ) {
					$conversation['unread_count'] = $unreadCounts->get( $conversation['id'] )->get( $logged_in_user_participant_ids->get( $conversation['id'] ) );
				}

			return $conversation;
			}
		);

		wp_send_json_success( $conversations );
	}
}
