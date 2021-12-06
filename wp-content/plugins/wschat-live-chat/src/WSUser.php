<?php

namespace WSChat;

use WSChat\Models\User;

class WSUser {

	public function init() {
	}

	public function get_user( $create = true ) {
		$user   = false;
		$cookie = null;

		if ( isset( $_COOKIE[ User::SESSION_KEY_COOKIE_NAME ] ) ) {
			$cookie = sanitize_text_field( $_COOKIE[ User::SESSION_KEY_COOKIE_NAME ] );
		}

		if ( is_user_logged_in() ) {
			$user = User::getByUserId( get_current_user_id() );
		} else {

			if ( false === $user && null !== $cookie ) {
				$user = User::getBySessionKey( $cookie );
			}
		}

		if ( true === $create && false === $user ) {
			$user = $this->create_user();
			@setcookie( User::SESSION_KEY_COOKIE_NAME, $user->session_key );
		}

		return $user;
	}

	public function create_user() {
		$user = User::create();

		do_action( 'wschat_new_chat_user', $user );

		return $user;
	}
}
