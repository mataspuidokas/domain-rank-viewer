<?php
/**
 * @package DomainRankViewer
 */

namespace Src;

use Src\Includes\Enqueue;
use Src\Pages\Admin\Dashboard;
use Src\Pages\Admin\Settings;
use Src\Includes\SettingLinks;

defined('ABSPATH') || exit;

final class Init
{
    /**
     * Store all init classes inside of an array
     */
    public static function getServices(): array
    {
        return [
            Enqueue::class,
            Dashboard::class,
            Settings::class,
            SettingLinks::class,
        ];
    }

    public static function registerServices(): void
    {
        foreach(self::getServices() as $class){
            $service = self::instantiate( $class );

            if( method_exists( $service, 'register' ) ){
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     */
    private static function instantiate(string $class): object
    {
        return new $class();
    }

}