<?php

namespace WSChat\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use WpFluent\QueryBuilder\QueryBuilderHandler;
use WSChat\Migrate;

class Participant implements Arrayable {


	const TYPE_GUEST = 'guest';

	const TYPE_USER = 'user';

	const TYPE_AGENT = 'agent';

	const ONLINE_DIFF_SECONDS = 10;

	protected $attributes = [];

	protected $conversation_id;

	public function __construct( $conversation_id ) {
		$this->conversation_id = $conversation_id;
	}

	/**
	 * Add a new particpant to the conversation
	 *
	 * @param User|WP_User $user
	 */
	public function add( $user ) {
		$data['conversation_id'] = $this->conversation_id;

		if ( $user instanceof User ) {
			$data['type']    = $user->isGuest() ? self::TYPE_GUEST : self::TYPE_USER;
			$data['user_id'] = $user->id;
		} else {
			$data['user_id'] = $user->ID;
			$data['type']    = self::TYPE_AGENT;
		}

		if ( $this->findByUser( $user ) ) {
			return;
		}

		$data['last_active_at'] = Carbon::now()->toJSON();

		$data['id'] = wpFluent()->table( Migrate::TABLE_CHAT_PARTICIPANTS )->insert( $data );

		return $this->parseData( $data );
	}

	public function get( $filters = array(), $columns = array() ) {
		return $this->applyFilters( $filters )->get();
	}

	/**
	 * Apply filters to the query builder
	 *
	 * @param array $filters
	 *
	 * @return QueryBuilderHandler
	 */
	public function applyFilters( $filters ) {
		$query = wpFluent()->table( Migrate::TABLE_CHAT_PARTICIPANTS );

		if ( isset( $filter['type'] ) ) {
			$query->where( 'type', '=', $filter['type'] );
		}

		if ( isset( $filter['conversation_id'] ) ) {
			if ( is_array( $filters['conversation_id'] ) ) {
				$query->whereIn( 'conversation_id', $filter['conversation_id'] );
			} else {
				$query->where( 'conversation_id', '=', $filter['conversation_id'] );
			}
		}

		return $query;
	}

	public function getStatuses( $filters ) {
		$query = $this->applyFilters( $filters );

		return collect( $query->get() )->map(
			function ( $participant ) {
			return ( new Participant( $participant['conversation_id'] ) )
				->parseData( $participant );
			}
		);
	}

	/**
	 * Make the participant user online
	 *
	 * @param User|WP_User $user
	 */
	public function online( $user = false ) {
		$query = wpFluent()->table( Migrate::TABLE_CHAT_PARTICIPANTS );
		$where = array();

		if ( $user ) {
			if ( $user instanceof User ) {
				$where['type']    = $user->isGuest() ? self::TYPE_GUEST : self::TYPE_USER;
				$where['user_id'] = $user->id;
			} else {
				$where['user_id'] = $user->ID;
				$where['type']    = self::TYPE_AGENT;
			}
		} else {
			$where['type']    = $this->type;
			$where['user_id'] = $this->user_id;
		}

		foreach ( $where as $key => $value ) {
			$query = $query->where( $key, '=', $value );
		}

		$query->where( 'last_active_at', '<=', Carbon::now()->subSeconds( self::ONLINE_DIFF_SECONDS )->toJSON() );

		$query->update( [ 'last_active_at' => Carbon::now()->toJSON() ] );
	}

	public function find( $where = array() ) {
		$query = wpFluent()->table( Migrate::TABLE_CHAT_PARTICIPANTS )
					->where( 'conversation_id', '=', $this->conversation_id );

		foreach ( $where as $key => $value ) {
			$query = $query->where( $key, '=', $value );
		}

		$data = $query->first();

		if ( ! $data ) {
			return false;
		}

		return $this->parseData( $data );
	}

	/**
	 * Find Participant by User|WP_User object in the conversation
	 *
	 * @param User|WP_User $user
	 *
	 * @return self|false
	 */
	public function findByUser( $user ) {
		$where['conversation_id'] = $this->conversation_id;

		if ( $user instanceof User ) {
			$where['type']    = $user->isGuest() ? self::TYPE_GUEST : self::TYPE_USER;
			$where['user_id'] = $user->id;
		} else {
			$where['user_id'] = $user->ID;
			$where['type']    = self::TYPE_AGENT;
		}

		return $this->find( $where );
	}

	public function parseData( $data ) {
		$this->attributes = $data;

		return $this;
	}

	public function __get( $key ) {
		return isset( $this->attributes[ $key ] ) ? $this->attributes[ $key ] : null;
	}

	public function isOnline() {
		return Carbon::now()->diffInSeconds( Carbon::parse( $this->last_active_at ) ) <= self::ONLINE_DIFF_SECONDS;
	}

	public function isAgent() {
		return self::TYPE_AGENT === $this->type;
	}

	public function status() {
		return $this->isOnline() ?
			__( 'Online', 'wschat' ) :
			__( 'Offline', 'wschat' );
	}

	public function toArray() {
		return $this->attributes;
	}
}
