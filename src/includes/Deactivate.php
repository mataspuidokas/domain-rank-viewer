<?php
/**
 * @package DomainRankViewer
 */

 namespace Src\Includes;

 defined('ABSPATH') || exit;
 
 class Deactivate
 {
    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }
 }