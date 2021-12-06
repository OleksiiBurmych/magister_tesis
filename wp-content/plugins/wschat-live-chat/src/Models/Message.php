<?php

namespace WSChat\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use WSChat\Migrate;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Message implements Arrayable {

	protected $attributes = [];

	protected $conversation_id;

	public function __construct( $conversation_id ) {
		$this->conversation_id = $conversation_id;
	}

	public function get( $filter = array() ) {
		$page  = 0;
		$limit = 25;

		if ( isset( $filter['page'] ) ) {
			$page = $filter['page'];
		}

		$query = $this->applyFilter( $filter );

		$query = $query->limit( $limit )
			->offset( $page * $limit )
			->orderBy( 'id', 'desc' );

		$messages = $query->get();

		return $messages;
	}

	public function count( $filter ) {
		return $this->applyFilter( $filter )->count();
	}

	public function unreadCount( $participant ) {
		$query = wpFluent()->table( Migrate::TABLE_CHAT_MESSAGE_NOTIFICATIONS )->whereNull( 'seen_at' );

		$query->where( 'participant_id', '=', $participant->id );

		$query->where( 'conversation_id', $this->conversation_id );
		$query->where( 'is_sender', 0 );

		return $query->count();
	}

	public function applyFilter( $filter ) {
		$query = wpFluent()->table( Migrate::TABLE_CHAT_MESSAGES );
		if ( $this->conversation_id ) {
			$query->where( 'conversation_id', $this->conversation_id );
		}

		if ( isset( $filter['after'] ) && $filter['after'] ) {
			$query->where( 'id', '>', $filter['after'] );
		}

		if ( isset( $filter['before'] ) && $filter['before'] ) {
			$query->where( 'id', '<', $filter['before'] );
		}

		if ( isset( $filter['participant_id'] ) ) {
			$query->where( 'participant_id', '=', $filter['participant_id'] );
		}

		$conversation = Arr::get( $filter, 'conversation_id' );

		if ( $conversation ) {
			if ( is_array( $conversation ) ) {
				$query->whereIn( 'conversation_id', $conversation );
			} else {
				$query->where( 'conversation_id', '=', $conversation );
			}
		}

		return $query;
	}

	/**
	 * Add a new message to the conversation
	 *
	 * @param Participant $participant
	 * @param array $data
	 *
	 * @return self
	 */
	public function add( $participant, $data ) {
		$message = [
			'conversation_id' => $this->conversation_id,
			'participant_id'  => $participant->id,
			'type'            => $data['type'],
			// TODO: Parse the data based on the type
			'body'            => wp_json_encode( $data['body'] ),
			'created_at'      => Carbon::now()->toJSON(),
			'updated_at'      => Carbon::now()->toJSON(),
		];

		$message['id'] = wpFluent()->table( Migrate::TABLE_CHAT_MESSAGES )->insert( $message );

		$this->parseData( $message );

		$this->notify( $participant );

		( new Conversation() )->touch( $this->conversation_id );

		return $this;
	}

	public function parseData( $attributes ) {
		$this->attributes = $attributes;

		$this->attributes['id']   = (int) $attributes['id'];
		$this->attributes['body'] = json_decode( $attributes['body'] );

		return $this;
	}

	public function notify( $participant ) {
		$notifications = array();
		$filter        = array(
			'conversation_id' => $this->conversation_id,
		);

		foreach ( $participant->get( $filter ) as $chat_participant ) {
			$notifications[] = [
				'conversation_id' => $this->conversation_id,
				'participant_id'  => $chat_participant['id'],
				'is_sender'       => ( $chat_participant['id'] === $participant->id ),
				'created_at'      => Carbon::now()->toJSON(),
				'updated_at'      => Carbon::now()->toJSON(),
			];
		}

		wpFluent()->table( Migrate::TABLE_CHAT_MESSAGE_NOTIFICATIONS )->insert( $notifications );
	}

	/**
	 * Read all unread messages
	 *
	 * @param Participant $participant
	 */
	public function readAll( $participant ) {
		$filter = [];

		$filter['conversation_id'] = $this->conversation_id;
		$filter['participant_id']  = $participant->id;

		$query = wpFluent()->table( Migrate::TABLE_CHAT_MESSAGE_NOTIFICATIONS );

		foreach ( $filter as $key => $value ) {
			$query->where( $key, '=', $value );
		}

		$query->whereNull( 'seen_at' );

		$query->update(
			array(
				'seen_at' => Carbon::now()->toJSON(),
			)
		);
	}

	/**
	 * Get recent messages per conversation_id
	 *
	 * @param array $filters
	 *
	 * @return Collection<self>
	 */
	public function getRecentMessage( $fitlers ) {
		$subQuery = $this->applyFilter( $fitlers )->select( \DB::raw( 'max(id) as id' ) );
		$subQuery->groupBy( 'conversation_id' );

		$query = wpFluent()->table( \DB::subQuery( $subQuery, 'wp_recent_messages' ) )
						   ->join( Migrate::TABLE_CHAT_MESSAGES, Migrate::TABLE_CHAT_MESSAGES . '.id', '=', 'recent_messages.id' );
		return collect( $query->get() )->map(
			function ( $message ) {
			return ( new self( $message['conversation_id'] ) )->parseData( $message );
			}
		);
	}

	/**
	 * Get all the unread count of a participant in a given conversation
	 *
	 * @var array $participants array of participant ids
	 * @var array $conversations array of ids
	 *
	 * @return Collection
	 */
	public function getAllUnreadCount( $participants, $conversations ) {
		if ( 0 === count( $participants ) ) {
			return collect();
		}
		$query = wpFluent()->table( Migrate::TABLE_CHAT_MESSAGE_NOTIFICATIONS );

		$query->whereIn( 'conversation_id', $conversations )
			->whereIn( 'participant_id', $participants )
			->whereNull( 'seen_at' )
			->where( 'is_sender', '=', 0 )
			->groupBy( 'conversation_id' )
			->groupBy( 'participant_id' )
			->select( \DB::raw( 'count(id) as unread_count, conversation_id, participant_id' ) );

		return collect( $query->get() )->groupBy( 'conversation_id' )->map(
			function ( $counts ) {
			return collect( $counts )->pluck( 'unread_count', 'participant_id' );
			}
		);
	}

	public function toArray() {
		return $this->attributes;
	}

	public function __get( $key ) {
		return Arr::get( $this->attributes, $key );
	}
}
