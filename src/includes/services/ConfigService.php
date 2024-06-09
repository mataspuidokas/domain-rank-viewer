<?php
/**
 * @package DomainRankViewer
 */

namespace Src\Includes\Services;

defined( 'ABSPATH' ) || exit;

class ConfigService
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}