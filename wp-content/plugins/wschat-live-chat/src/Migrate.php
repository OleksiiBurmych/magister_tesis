<?php

namespace WSChat;

class Migrate {


	const MIGRATION_BATCH_KEY = 'WSCHAT_MIGRATION_BATCH';

	const TABLE_CHAT_USERS = 'wschat_users';

	const TABLE_CHAT_CONVERSATIONS = 'wschat_conversations';

	const TABLE_CHAT_PARTICIPANTS = 'wschat_participants';

	const TABLE_CHAT_MESSAGES = 'wschat_messages';

	const TABLE_CHAT_MESSAGE_NOTIFICATIONS = 'wschat_message_notifications';

	private $current_batch = 1;

	private $batch;

	public static function run() {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$self = new self();


		if ( is_multisite() === false ) {
			$self->up();
			return;
		}

		// Get all blogs in the network and activate plugin on each one
		global $wpdb;
		$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

		foreach ( $blog_ids as $blog_id ) {
			switch_to_blog( $blog_id );
			$self->up();
			restore_current_blog();
		}
	}

	public function up() {
		$this->batch = get_option( self::MIGRATION_BATCH_KEY, 0 );

		while ( $this->batch < $this->current_batch ) {
			$this->batch++;
			$method = 'upgrage_' . $this->batch;

			if ( method_exists( $this, $method ) ) {
				$this->{$method}();
			}
		}

		update_option( self::MIGRATION_BATCH_KEY, $this->current_batch );
	}

	public function upgrage_1() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		// chat_users table
		$table_name  = $wpdb->prefix . self::TABLE_CHAT_USERS;
		$sql_tickets = "CREATE TABLE $table_name
                (   `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
                    `session_key` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
			        `meta` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
					`created_at` TIMESTAMP NOT NULL,
					`updated_at` TIMESTAMP NOT NULL,
                    PRIMARY KEY (`id`)
                ) $charset_collate;";
		dbDelta( $sql_tickets );

		// chat_conversations table
		$table_name  = $wpdb->prefix . self::TABLE_CHAT_CONVERSATIONS;
		$sql_tickets = "CREATE TABLE $table_name
                (   `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
                    `chat_user_id` BIGINT UNSIGNED NOT NULL,
			        `meta` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
					`created_at` TIMESTAMP NOT NULL,
					`updated_at` TIMESTAMP NOT NULL,
                    PRIMARY KEY (`id`)
                ) $charset_collate;";
		dbDelta( $sql_tickets );

		// chat_participants table
		$table_name  = $wpdb->prefix . self::TABLE_CHAT_PARTICIPANTS;
		$sql_tickets = "CREATE TABLE $table_name
                (   `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
                    `conversation_id` BIGINT UNSIGNED NOT NULL,
                    `user_id` BIGINT UNSIGNED NOT NULL,
                    `type` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                    `last_active_at` TIMESTAMP NOT NULL,
                    PRIMARY KEY (`id`)
                ) $charset_collate;";
		dbDelta( $sql_tickets );

		// chat_messages table
		$table_name  = $wpdb->prefix . self::TABLE_CHAT_MESSAGES;
		$sql_tickets = "CREATE TABLE $table_name
                (   `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
                    `conversation_id` BIGINT UNSIGNED NOT NULL,
                    `participant_id` BIGINT UNSIGNED NOT NULL,
			        `body` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
                    `type` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
					`created_at` TIMESTAMP NOT NULL,
					`updated_at` TIMESTAMP NOT NULL,
                    PRIMARY KEY (`id`)
                ) $charset_collate;";
		dbDelta( $sql_tickets );

		// chat_message_notifications table
		$table_name  = $wpdb->prefix . self::TABLE_CHAT_MESSAGE_NOTIFICATIONS;
		$sql_tickets = "CREATE TABLE $table_name
                (   `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
                    `conversation_id` BIGINT UNSIGNED NOT NULL,
                    `participant_id` BIGINT UNSIGNED NOT NULL,
					`seen_at` TIMESTAMP NULL DEFAULT NULL,
					`is_sender` BOOLEAN NOT NULL DEFAULT FALSE,
					`created_at` TIMESTAMP NOT NULL,
					`updated_at` TIMESTAMP NOT NULL,
                    PRIMARY KEY (`id`)
                ) $charset_collate;";
		dbDelta( $sql_tickets );

		// Add Agent Role
		global $wp_roles;
		$user_roles        = $wp_roles->role_names;
		$user_roles_create = array(
			'wschat_agent' => 'WSChat Agents',
		);

		foreach ( $user_roles_create as $role_slug => $user_role ) {
			if ( ! isset( $user_roles[ $role_slug ] ) ) {
				add_role(
					$role_slug,
					$user_role,
					array(
						'wschat_crm_role'      => true,
						'read'                 => true,
						'view_admin_dashboard' => true,
					)
				);
			}
		}

		// Add pre chat form settings
		$wschat_settings['pre_chat_form']        = 'yes';
		$wschat_settings['pre_chat_form_fields'] = array(
			array(
				'status'     => 'activate',
				'predefined' => 'yes',
				'type'       => 'textbox',
				'name'       => __( 'Name', 'wschat' ),
				'required'   => true,
			),
			array(
				'status'     => 'activate',
				'predefined' => 'yes',
				'type'       => 'email',
				'name'       => __( 'E-mail', 'wschat' ),
				'required'   => true,
			),
			array(
				'status'     => 'activate',
				'predefined' => 'yes',
				'type'       => 'number',
				'name'       => __( 'Phone number', 'wschat' ),
				'required'   => true,
			),
		);

		update_option( 'wschat_settings', $wschat_settings );
	}
}
