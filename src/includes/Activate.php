<?php
/**
 * @package DomainRankViewer
 */

 namespace Src\Includes;

 defined('ABSPATH') || exit;

 class Activate
 {
    public static function activate(): void
    {   
        flush_rewrite_rules();
    }
 }