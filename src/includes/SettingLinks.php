<?php
/**
 * @package DomainRankViewer
 */

namespace Src\Includes;

use Src\Includes\SettingLinks;
use Src\Interfaces\RegisterInterface;
use Src\Includes\IncludeController;

defined('ABSPATH') || exit;

class SettingLinks extends IncludeController implements RegisterInterface
{
    public function register(): void
    {
        add_filter("plugin_action_links_" . $this->pluginName, 
            [
                $this,
                'settingsLink'
            ]
        ); 
    }

    public function settingsLink(array $links): array
    {
        $settingsLink = '<a href="admin.php?page=domain_rank_viewer_settings">' . __('Settings', 'domain-rank-viewer') . '</a>';
        array_push($links, $settingsLink);
        
        return $links;
    }
}