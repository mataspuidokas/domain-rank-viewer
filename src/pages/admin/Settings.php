<?php

/**
 * @package DomainRankViewer
 */

namespace Src\Pages\Admin;

use Src\Interfaces\RegisterInterface;
use Src\Includes\IncludeController;

defined('ABSPATH') || exit;

class Settings extends IncludeController implements RegisterInterface
{
    public function register(): void
    {
        add_action('admin_menu', [ $this, 'init' ]);
    }

    public function init(): void
    {
        add_submenu_page(
            'domain_rank_viewer',
            __('Settings', 'domain-rank-viewer'),
            __('Settings', 'domain-rank-viewer'),
            'manage_options', 
            'domain_rank_viewer_settings',
            [$this, 'loadAdminPage'] 
        );
    }

    public function loadAdminPage(): void
    {    
        require_once $this->pluginPath . 'templates/admin/settings.php';
    }
}