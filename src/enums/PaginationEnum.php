<?php
/**
 * @package DomainRankViewer
 */

namespace Src\Enums;

defined('ABSPATH') || exit;

enum PaginationEnum: int
{
    case PER_PAGE = 100;
}