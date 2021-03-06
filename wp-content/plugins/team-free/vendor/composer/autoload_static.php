<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf433bfe77a05aba6323742df5014a373
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'ShapedPlugin\\WPTeam\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ShapedPlugin\\WPTeam\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf433bfe77a05aba6323742df5014a373::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf433bfe77a05aba6323742df5014a373::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf433bfe77a05aba6323742df5014a373::$classMap;

        }, null, ClassLoader::class);
    }
}
