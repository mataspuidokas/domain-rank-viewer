<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitaeed3a6829f9c7c7e3bcf25adabd4c9a
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitaeed3a6829f9c7c7e3bcf25adabd4c9a', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitaeed3a6829f9c7c7e3bcf25adabd4c9a', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitaeed3a6829f9c7c7e3bcf25adabd4c9a::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
