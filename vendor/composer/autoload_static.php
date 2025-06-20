<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9bf5792f56c0fabb99ed8bbadd36f0e0
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tea\\PurchaseHistory\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tea\\PurchaseHistory\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'teapurchasehistory' => __DIR__ . '/../..' . '/teapurchasehistory.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9bf5792f56c0fabb99ed8bbadd36f0e0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9bf5792f56c0fabb99ed8bbadd36f0e0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9bf5792f56c0fabb99ed8bbadd36f0e0::$classMap;

        }, null, ClassLoader::class);
    }
}
