<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit469675c6f521911e367590953af5b4c3
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TwoFAS\\Light\\' => 13,
            'TwoFAS\\Encryption\\' => 18,
        ),
        'E' => 
        array (
            'Endroid\\QrCode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TwoFAS\\Light\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'TwoFAS\\Encryption\\' => 
        array (
            0 => __DIR__ . '/..' . '/twofas/encryption/src',
            1 => __DIR__ . '/..' . '/twofas/encryption/tests',
        ),
        'Endroid\\QrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/endroid/qr-code/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit469675c6f521911e367590953af5b4c3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit469675c6f521911e367590953af5b4c3::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit469675c6f521911e367590953af5b4c3::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}