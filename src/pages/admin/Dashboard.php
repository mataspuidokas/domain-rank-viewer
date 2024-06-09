<?php
/**
 * @package DomainRankViewer
 */

 namespace Src\Pages\Admin;

 use Src\Interfaces\RegisterInterface;
 use Src\Includes\IncludeController;
 use Src\Enums\PaginationEnum;
 use Src\Database\Database;
 use Src\Includes\Services\ConfigService;
 use Exception;
 
 defined('ABSPATH') || exit;
 
 class Dashboard extends IncludeController implements RegisterInterface
 {
     private $errorMessage = '';
 
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
         add_menu_page(
             __('Domain Rank Viewer', 'domain-rank-viewer'),
             __('Domain Rank Viewer', 'domain-rank-viewer'),
             'manage_options',
             'domain_rank_viewer',
             [$this, 'loadAdminPage'],
             'dashicons-editor-ol',
             100
         );
     }
 
     public function loadAdminPage(): void
     {
         $searchQuery = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
         $currentPage = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
 
         $domains = $this->loadDomainData();
         $filteredDomains = $this->filterDomains($domains, $searchQuery);
         $pagedDomains = $this->paginateDomains($filteredDomains, $currentPage);
 
         list($pageRanks, $error, $errorMessage) = $this->fetchPageRanks(array_column($pagedDomains, 'rootDomain'));
         if ($error) {
             $this->errorMessage = $errorMessage;
         }
 
         $this->displayPageContent($pagedDomains, $pageRanks, $currentPage, $searchQuery, $domains);
     }
 
     private function loadDomainData(): array
     {
         $jsonData = file_get_contents($this->pluginPath . 'assets/data/top-sites.json');
         if ($jsonData === false) {
             return [];
         }
 
         $domains = json_decode($jsonData, true);
         if (json_last_error() !== JSON_ERROR_NONE) {
             return [];
         }
 
         return $domains;
     }
 
     private function filterDomains(array $domains, string $searchQuery): array
     {
         if ($searchQuery) {
             return array_filter($domains, function ($domain) use ($searchQuery) {
                 return stripos($domain['rootDomain'], $searchQuery) !== false;
             });
         }
 
         return $domains;
     }
 
     private function paginateDomains(array $domains, int $currentPage, int $itemsPerPage = PaginationEnum::PER_PAGE->value): array
     {
         $offset = ($currentPage - 1) * $itemsPerPage;
         return array_slice($domains, $offset, $itemsPerPage);
     }
 
     private function fetchPageRanks(array $domains): array
     {
         try {
             $encryptionKeyDataField = $this->configService->get('encryption_key_data_field');
             $apiKeyDataField = $this->configService->get('api_key_data_field');
 
             $encryptedApiKey = get_option($apiKeyDataField);
             $encryptionKey = get_option($encryptionKeyDataField);
             $apiKey = Database::decrypt($encryptedApiKey, $encryptionKey);
 
             $url = $this->configService->get('api_url');
             $query = http_build_query(['domains' => $domains]);
             $fullUrl = $url . '?' . $query;
 
             $response = wp_remote_get($fullUrl, [
                 'headers' => [
                     'API-OPR' => "$apiKey",
                 ],
             ]);
 
             if (is_wp_error($response)) {
                 throw new Exception(__('Network error: Unable to fetch data.', 'domain-rank-viewer'));
             }
 
             $body = wp_remote_retrieve_body($response);
 
             if (empty($body)) {
                 throw new Exception(__('Error: Empty response from the API.', 'domain-rank-viewer'));
             }
 
             $output = json_decode($body, true);
             if (json_last_error() !== JSON_ERROR_NONE) {
                 throw new Exception(__('Error: Invalid JSON response from the API.', 'domain-rank-viewer'));
             }
 
             if (isset($output['status']) && !$output['status'] && isset($output['error'])) {
                 throw new Exception('API error: ' . $output['error']);
             }
 
             $pageRanks = [];
             if (!empty($output['response'] && is_array($output['response']))) {
                 foreach ($output['response'] as $entry) {
                     if (!empty($entry['domain']) && isset($entry['rank'])) {
                         $pageRanks[$entry['domain']] = $entry['rank'];
                     }
                 }
             }
 
             return [$pageRanks, false, ''];
         } catch (Exception $e) {
             return [[], true, $e->getMessage()];
         }
     }
 
     private function displayPageContent(array $pagedDomains, array $pageRanks, int $currentPage, string $searchQuery, array $domains): void
     {
         $itemsPerPage = PaginationEnum::PER_PAGE->value;
         $totalPages = ceil(count($domains) / $itemsPerPage);
         $pageLinks = '';
 
         if ($totalPages > 1) {
             $pageLinks = paginate_links([
                 'base' => add_query_arg(['paged' => '%#%', 's' => $searchQuery, 'page' => 'domain_rank_viewer']),
                 'format' => '',
                 'prev_text' => __('&laquo; Previous', 'domain-rank-viewer'),
                 'next_text' => __('Next &raquo;', 'domain-rank-viewer'),
                 'total' => $totalPages,
                 'current' => $currentPage,
             ]);
         }
 
         $templatePath = $this->pluginPath . 'templates/admin/index.php';
         if (file_exists($templatePath)) {
             include $templatePath;
         } else {
             echo esc_html__('Template file not found.', 'domain-rank-viewer');
         }
     }
 }
 