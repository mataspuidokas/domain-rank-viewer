<?php
/**
 * @package DomainRankViewer
 */

 namespace Src\Includes;
 
 use Src\Interfaces\RegisterInterface;
 use Src\Database\Database;
 use Src\Helpers\DataHider;
 use Src\Includes\Services\ConfigService;
 
 defined('ABSPATH') || exit;
 
 class AjaxHandler implements RegisterInterface
 {
    public function __construct(protected ConfigService $configService)
    {
    }

    public function register(): void
    {
        add_action('wp_ajax_process_api_key', [$this, 'processApiKey']);
        add_action('wp_ajax_nopriv_process_api_key', [$this, 'processApiKey']);
    }

    public function processApiKey(): void
    {
        if (!isset($_POST['api_key']) || empty($_POST['api_key'])) {
            wp_send_json_error(['message' => __('API key is missing.', 'domain-rank-viewer')]);
        }

        $encryptionKeyDataField = $this->configService->get('encryption_key_data_field');
        $apiKeyDataField = $this->configService->get('api_key_data_field');

        $apiKey = sanitize_text_field($_POST['api_key']);
        $encryptionKey = get_option($encryptionKeyDataField);
        $encryptedApiKey = Database::encrypt($apiKey, $encryptionKey);
        $displayValue = DataHider::hide($apiKey);
        if (!$encryptedApiKey) {
            wp_send_json_error(['message' => __('Failed to encrypt API key.', 'domain-rank-viewer')]);
        }

        $result = update_option($apiKeyDataField, $encryptedApiKey);
        if ($result) {
            wp_send_json_success([
                'message' => __('API key saved successfully.', 'domain-rank-viewer'),
                'api_key' => $displayValue
            ]);
        } else {
            wp_send_json_error([
                'message' => __('Failed to save API key.', 'domain-rank-viewer')
            ]);
        }
    }
 }