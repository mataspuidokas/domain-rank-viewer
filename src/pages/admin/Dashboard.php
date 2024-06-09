<?php

/**
 * @package DomainRankViewer
 */

 namespace Src\Pages\Admin;

 use Src\Interfaces\RegisterInterface;
 use Src\Includes\IncludeController;
 
 defined('ABSPATH') || exit;
 
 class Dashboard extends IncludeController implements RegisterInterface
 {
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
        require_once $this->pluginPath . 'templates/admin/index.php';
     }
 }
 