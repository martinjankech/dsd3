<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5d0cfbebf88838724f1f1fe9dd237751
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Whoops\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5d0cfbebf88838724f1f1fe9dd237751::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5d0cfbebf88838724f1f1fe9dd237751::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5d0cfbebf88838724f1f1fe9dd237751::$classMap;

        }, null, ClassLoader::class);
    }
}
