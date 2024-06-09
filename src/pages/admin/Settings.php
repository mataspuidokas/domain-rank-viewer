<?php

/**
 * @package DomainRankViewer
 */

namespace Src\Pages\Admin;

use Src\Interfaces\RegisterInterface;
use Src\Includes\IncludeController;
use Src\Database\Database;
use Src\Helpers\DataHider;
use Src\Includes\Services\ConfigService;

defined('ABSPATH') || exit;

class Settings extends IncludeController implements RegisterInterface
{
    public function __construct(protected ConfigService $configService)
    {
        parent::__construct(); 
    }

    public function register(): void
    {
        add_action('admin_menu', [$this, 'init']);
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
        $encryptionKeyDataField = $this->configService->get('encryption_key_data_field');
        $apiKeyDataField = $this->configService->get('api_key_data_field');

        $encryptedApiKey = get_option($apiKeyDataField);
        $encryptionKey = get_option($encryptionKeyDataField);
        $apiKey = Database::decrypt($encryptedApiKey, $encryptionKey);
        $displayValue = DataHider::hide($apiKey);
         
        require_once $this->pluginPath . 'templates/admin/settings.php';
    }
}