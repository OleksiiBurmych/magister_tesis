<?php

namespace WSChat\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Os;
use WSChat\Migrate;

class User implements Arrayable {

	const SESSION_KEY_COOKIE_NAME = 'wschat_sesion_key';

	const ROLE_ADMIN = 'administrator';
	const ROLE_AGENT = 'wschat_agent';

	protected $attributes = [];

	public function __construct( $attributes = array() ) {
		$this->parseUserData( $attributes );
	}

	public static function getByUserId( $user_id ) {
		$self = new self();

		$user = $self->first(
			array(
				'user_id' => $user_id,
			)
		);

		return $user;
	}

	public static function getBySessionKey( $session_key ) {
		$self = new self();

		$self = $self->first(
			array(
				'session_key' => $session_key,
				'user_id'     => null,
			)
		);

		return $self;
	}

	public function get( $filters = array() ) {
		$users = $this->applyFilters( $filters )->get();
		$users = collect( $users )->transform(
			function ( $user ) {
			return new self( $user );
			}
		);

		return $users;
	}

	public function find( $filters = array() ) {
		$user = $this->applyFilters( $filters )->first();

		if ( null === $user ) {
			return false;
		}

		$this->parseUserData( $user );

		return $this;
	}

	public function findById( $id ) {
		return $this->find(
			array(
				'id' => [ $id ],
			)
		);
	}

	public function applyFilters( $filters = array() ) {
		$query = wpFluent()->table( Migrate::TABLE_CHAT_USERS );

		if ( isset( $filters['id'] ) ) {
			$query->whereIn( 'id', $filters['id'] );
		}

		return $query;
	}

	public static function create( $data = [] ) {
		$self = new self();

		if ( ! isset( $data['user_id'] ) && is_user_logged_in() ) {
			$data['user_id'] = get_current_user_id();
		} else {
			$data['user_id'] = null;
		}

		$data['session_key'] = \Illuminate\Support\Str::random();

		if ( ! isset( $data['meta'] ) ) {
			$data['meta'] = array(
				'name' => __( 'Guest', 'wschat' ),
			);

			if ( is_user_logged_in() ) {
				$data['meta'] = array(
					'name' => wp_get_current_user()->display_name,
				);
			}
		}

		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$data['meta']['ua'] = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );
		}

		$data['meta']['browser'] = ( new Browser() )->getName();
		$data['meta']['device']  = ( new Device() )->getName();
		$data['meta']['os']      = ( new Os() )->getName();

		$data['meta'] = wp_json_encode( $data['meta'] );

		$data['created_at'] = Carbon::now()->toJSON();
		$data['updated_at'] = Carbon::now()->toJSON();

		$data['id'] = wpFluent()->table( Migrate::TABLE_CHAT_USERS )->insert( $data );

		return $self->parseUserData( $data );
	}

	public function updateMeta() {
		$data = $this->attributes;

		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$data['meta']['ua'] = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );
		}

		$data['meta']['browser'] = ( new Browser() )->getName();
		$data['meta']['device']  = ( new Device() )->getName();
		$data['meta']['os']      = ( new Os() )->getName();

		if ( isset( $_REQUEST['current_url'] ) ) {
			$data['meta']['current_url'] = sanitize_text_field( $_REQUEST['current_url'] );
		}

		$data['meta'] = wp_json_encode( $data['meta'] );

		wpFluent()->table( Migrate::TABLE_CHAT_USERS )->where( 'id', $this->id )->update( $data );

		return $this->parseUserData( $data );
	}

	public function update( $data ) {
		$data = array_merge(
			$this->attributes,
			$data
		);

		foreach ( $data as $key => $value ) {
			$data[ $key ] = 'meta' === $key ? wp_json_encode( $value ) : $value;
		};

		wpFluent()->table( Migrate::TABLE_CHAT_USERS )->where( 'id', $this->id )->update( $data );

		return $this->parseUserData( $data );
	}

	public function first( $where = [] ) {
		$query = wpFluent()->table( Migrate::TABLE_CHAT_USERS );

		foreach ( $where as $key => $value ) {
			$query = $query->where( $key, $value );
		}

		$data = $query->first();

		if ( ! $data ) {
			return false;
		}

		return $this->parseUserData( $data );
	}

	public function parseUserData( $data ) {
		$this->attributes = $data;

		$this->attributes['meta'] = [];

		if ( isset( $data['meta'] ) ) {
			$this->attributes['meta'] = json_decode( $data['meta'], true );
		}

		$user_id = Arr::get( $data, 'user_id' );

		if ( $user_id && false === $this->isGuest() ) {
			$this->attributes['meta']['name']   = ( new \WP_User( $user_id ) )->display_name;
			$this->attributes['meta']['avatar'] = get_avatar_url(
				$user_id,
				array(
					'size' => 50,
				)
			);
		}
		if ( $this->isGuest() && Arr::has( $this->attributes, 'meta.name' ) ) {
			$id = ' (' . $this->id . ')';
			if ( false === strpos( Arr::get( $this->attributes, 'meta.name' ), $id ) ) {
				$this->attributes['meta']['name'] .= $id;
			}
		}

		return $this;
	}

	public function __get( $key ) {
		return isset( $this->attributes[ $key ] ) ? $this->attributes[ $key ] : null;
	}

	public function isGuest() {
		return is_null( $this->user_id ) || ! $this->user_id > 0;
	}

	public function type() {
		return $this->isGuest() ? Participant::TYPE_GUEST : Participant::TYPE_USER;
	}

	public function toArray() {
		return $this->attributes;
	}
}
