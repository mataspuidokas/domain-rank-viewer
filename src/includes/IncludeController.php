<?php
/**
 * @package DomainRankViewer
 */

namespace Src\Includes;

defined('ABSPATH') || exit;

class IncludeController
{
    public string $pluginPath;
    public string $pluginUrl;
    public string $pluginName;

    public function __construct()
    {
        $this->pluginPath = plugin_dir_path(dirname(__FILE__, 2));
        $this->pluginUrl = plugin_dir_url(dirname(__FILE__, 2));
        $this->pluginName = plugin_basename(dirname(__FILE__, 3) . '/domain-rank-viewer.php');
    }
}