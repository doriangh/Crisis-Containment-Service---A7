<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd68fab4755e14704669c1678a2c7a3fb
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd68fab4755e14704669c1678a2c7a3fb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd68fab4755e14704669c1678a2c7a3fb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
