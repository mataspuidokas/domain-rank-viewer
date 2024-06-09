<?php

/**
 * Trigger this file on plugin uninstall
 * 
 * @package DomainRankViewer
 */

 use Src\Includes\Services\ConfigService;
 use Src\Includes\Uninstall;

 if(! defined( "WP_UNINSTALL_PLUGIN" )){
    
    exit;
 }
 
 delete_option('domain_rank_viewer_encryption_key');
 delete_option('domain_rank_viewer_api_key');