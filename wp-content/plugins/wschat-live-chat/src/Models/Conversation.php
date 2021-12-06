<?php

namespace WSChat\Models;

use Carbon\Carbon;
use WSChat\Migrate;

class Conversation {

	protected $attributes = [];

	public static function findByChatUserId( $chat_user_id ) {
		$self = new self();

		$conversation = $self->find(
			array(
				'chat_user_id' => $chat_user_id,
			)
		);

		return $conversation;
	}

	public function get( $filters = array() ) {
		return $this->applyFilters( $filters )->get();
	}

	public function applyFilters( $filters ) {
		$subQuery = wpFluent()->table( Migrate::TABLE_CHAT_MESSAGES )->select( 'conversation_id' )
			->getQuery()->getRawSql();

		$query = wpFluent()->table( Migrate::TABLE_CHAT_CONVERSATIONS )
			->where( \DB::raw( 'id in (' . $subQuery . ')' ) )
			->orderBy( 'updated_at', 'desc' );
		return $query;
	}

	public static function create( $chat_user_id, $meta = [] ) {
		if ( 0 == $chat_user_id ) {
			return false;
		}
		$self = new self();

		$data = [];

		$data['chat_user_id'] = $chat_user_id;

		$data['created_at'] = Carbon::now()->toJSON();
		$data['updated_at'] = Carbon::now()->toJSON();

		$data['meta'] = wp_json_encode( $meta );

		$data['id'] = wpFluent()->table( Migrate::TABLE_CHAT_CONVERSATIONS )->insert( $data );

		return $self->parseData( $data );
	}

	public function participants() {
		return new Participant( $this->id );
	}

	public function messages() {
		return new Message( $this->id );
	}

	public function chatUser() {
		return ( new User() )->findById( $this->chat_user_id );
	}

	public function findById( $id ) {
		return $this->find(
			array(
				'id' => $id,
			)
		);
	}

	public function find( $where = [] ) {
		$query = wpFluent()->table( Migrate::TABLE_CHAT_CONVERSATIONS );

		foreach ( $where as $key => $value ) {
			$query = $query->where( $key, '=', $value );
		}

		$data = $query->first();

		if ( ! $data ) {
			return false;
		}

		return $this->parseData( $data );
	}

	public function touch( $id ) {
		wpFluent()->table( Migrate::TABLE_CHAT_CONVERSATIONS )
		  ->where( 'id', '=', $id )
		  ->update( [ 'updated_at' => Carbon::now()->toJSON() ] );
	}

	public function parseData( $data ) {
		$this->attributes         = $data;
		$this->attributes['meta'] = json_decode( $data['meta'] );

		return $this;
	}


	public function __get( $key ) {
		return isset( $this->attributes[ $key ] ) ? $this->attributes[ $key ] : null;
	}

	public function toArray() {
		return $this->attributes;
	}
}
