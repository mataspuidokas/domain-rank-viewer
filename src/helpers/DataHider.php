<?php
/**
 * @package DomainRankViewer
 */

namespace Src\Helpers;

defined( 'ABSPATH' ) || exit;

class DataHider
{
    /*
    * Hide sensitive data by replacing most characters with asterisks,
    * leaving only the last few visible.
    *
    * @param string $data The sensitive data to hide.
    */
   public static function hide(string $data): string
   {
       $length = strlen($data);
        if ($length <= 4) {
         
        return str_repeat('*', 4);
       }
       
       $visibleChars = min(4, $length);
       $visiblePart = substr($data, -$visibleChars);
       
       return str_repeat('*', 4) . $visiblePart;
   }
}