<?php
/**
 * @package DomainRankViewer
 */

namespace Src;

use Src\Includes\Enqueue;
use Src\Pages\Admin\Dashboard;
use Src\Pages\Admin\Settings;
use Src\Includes\SettingLinks;
use Src\Includes\AjaxHandler;
use Src\Includes\Services\ConfigService;

defined('ABSPATH') || exit;

final class Init
{
    private static ConfigService $configService;

    public static function getServices(): array
    {
        $configFilePath = plugin_dir_path(__DIR__) . 'src/configs/config.php';
        $configData = include $configFilePath;
        self::$configService = new ConfigService($configData);

        return [
            AjaxHandler::class => [self::$configService],
            Enqueue::class => [],
            Dashboard::class => [],
            Settings::class => [self::$configService],
            SettingLinks::class => [],
        ];
    }

    public static function registerServices(): void
    {
        foreach (self::getServices() as $class => $args) {
            if (is_array($args)) {
                $service = self::instantiate($class, ...$args);
            } else {
                $service = self::instantiate($class);
            }

            if (method_exists($service, 'register')) {
                $service->register();
            }
        }

        $encryptionKeyDataField = self::$configService->get('encryption_key_data_field');
        self::generateAndStoreEncryptionKey($encryptionKeyDataField);
    }

    private static function instantiate(string $class, ...$args): object
    {
        if (!empty($args)) {
            return new $class(...$args);
        }
        return new $class();
    }

    /**
     * Generate and store encryption key if not already created
     */
    private static function generateAndStoreEncryptionKey(string $encryptionKeyDataField): void
    {
        $encryptionKey = get_option($encryptionKeyDataField);

        if (!$encryptionKey) {
            $encryptionKey = self::generateEncryptionKey();
            update_option($encryptionKeyDataField, $encryptionKey);
        }
    }

    /**
     * Generate a random encryption key
     *
     * @param int $length The length of the key
     */
    private static function generateEncryptionKey($length = 32): string
    {
        return bin2hex(random_bytes($length));
    }
}