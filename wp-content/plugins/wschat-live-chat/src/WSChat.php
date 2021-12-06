<?php

namespace WSChat;

class WSChat {

	const VERSION = '2.0.0';

	public $plugin_basename;

	public function withBasename( $basename ) {
		$this->plugin_basename = $basename;

		return $this;
	}

	public function boot() {
		add_action( 'activate_' . $this->plugin_basename, array( $this, 'migrate' ) );
		add_filter( 'plugin_action_links_' . $this->plugin_basename, array( $this, 'actionLink' ) );
		add_action( 'init', array( $this, 'load_language' ) );
		add_action( 'init', array( $this, 'enqueue_scripts' ) );
		add_action( 'init', array( $this, 'add_menu' ) );
		add_action( 'init', array( $this, 'register_routes' ) );

		add_action( 'admin_init', array( $this, 'enqueue_admin_scripts' ) );

		add_action( 'wp_footer', array( $this, 'load_widget' ) );
	}

	public function load_widget() {
		$settings = Utils::get_widget_settings();

		if ( false === $settings['enable_live_chat'] ) {
			return;
		}

		wp_enqueue_script( 'wschat', plugins_url( dirname( $this->plugin_basename ) . '/resources/dist/user-chat.js' ), array( 'jquery' ), self::VERSION, true );
		$this->localize_script();

		include_once dirname( __DIR__ ) . '/resources/views/user/live-chat.php';
	}

	public function register_routes() {
		WSConversation::init();
		WSMessage::init();
		WSSettings::init();
		WSPusher::init();
	}

	public function add_menu() {
		if ( Utils::isAgent() === false ) {
			return;
		}

		// TODO: Admin bar menu item with real count
		//add_action('admin_bar_menu', array($this, 'add_admin_bar_links'), 900);

		add_action( 'admin_menu', array( $this, 'add_admin_main_menu' ) );
	}

	public function migrate() {
		Migrate::run();
	}

	public function enqueue_admin_scripts() {
		$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';

		if ( 'wschat_settings' === $page ) {
			wp_enqueue_script( 'wschat', plugins_url( dirname( $this->plugin_basename ) . '/resources/js/jscolor.js' ), array( 'jquery' ), self::VERSION );
		}

		if ( 'wschat_chat' !== $page ) {
			return;
		}

		wp_enqueue_script( 'wschat', plugins_url( dirname( $this->plugin_basename ) . '/resources/dist/admin-chat.js' ), array( 'jquery' ), self::VERSION );

		$this->localize_script();
	}

	public function localize_script() {
		wp_localize_script(
			'wschat',
			'wschat_ajax_obj',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'wschat-ajax-nonce' ),
				'settings' => Utils::get_widget_settings( true ),
			)
		);
	}

	public function enqueue_scripts() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		wp_enqueue_style( 'wschat', plugins_url( dirname( $this->plugin_basename ) . '/resources/dist/base.css' ), array(), self::VERSION );
		wp_enqueue_style( 'wschat-icons', 'https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css', array(), '3.0.1' );
	}

	public function load_language() {
		load_plugin_textdomain( 'wschat', false, __DIR__ . '/../lang' );
	}

	public function add_admin_bar_links( $wp_admin_bar ) {
		$live_visitors = 0;

		$admin_bar_args = array(
			'id'    => 'wschat_visitors',
			'href'  => admin_url( 'admin.php?page=wschat_chat' ),
			'title' => 'WSChat <span class="wschat_menu_badge">' . $live_visitors . '</span>',
		);

		$wp_admin_bar->add_node( $admin_bar_args );

		$admin_bar_args = array(
			'id'     => 'live_chat',
			'parent' => 'site-name',
			'href'   => admin_url( 'admin.php?page=wschat_chat' ),
			'title'  => __( 'Live Chat', 'wschat' ),
		);

		$wp_admin_bar->add_node( $admin_bar_args );
	}

	public function add_admin_main_menu() {
		$parent_slug = 'wschat_chat';

		$cap = 'wschat_crm_role';

		if ( is_super_admin() ) {
			$cap = 'administrator';
		}

		add_menu_page(
			__( 'Live Chat', 'wschat' ),
			__( 'WSChat', 'wschat' ),
			$cap,
			$parent_slug,
			array( $this, 'admin_live_chat' ),
			'dashicons-format-chat',
			25
		);

		add_submenu_page( $parent_slug, __( 'Live Chat', 'wschat' ), __( 'Live Chat', 'wschat' ), $cap, 'wschat_chat', array( $this, 'admin_live_chat' ) );
		add_submenu_page( $parent_slug, __( 'Settings', 'wschat' ), __( 'Settings', 'wschat' ), 'administrator', 'wschat_settings', array( new WSSettings(), 'admin_settings' ) );
	}

	public function actionLink( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=wschat_chat' ) . '">' . __( 'Chats', 'wschat' ) . '</a>',
			'<a href="' . admin_url( 'admin.php?page=wschat_settings' ) . '">' . __( 'Settings', 'wschat' ) . '</a>',
		);

		if ( array_key_exists( 'deactivate', $links ) ) {
			$links['deactivate'] = str_replace( '<a', '<a class="wschat-deactivate-link"', $links['deactivate'] );
		}

		return array_merge( $plugin_links, $links );
	}

	public function admin_live_chat() {
		include_once dirname( __DIR__ ) . '/resources/views/admin/live-chat.php';
	}
}
