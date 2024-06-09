<?php
/**
 * @package DomainRankViewer
 */

namespace Src\Interfaces;

defined('ABSPATH') || exit;

interface RegisterInterface
{
    /**
     * Register the service.
     */
    public function register(): void;
}