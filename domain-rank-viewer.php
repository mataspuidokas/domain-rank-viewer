<?php
/**
 * @package DomainRankViewer
 */
/*
 Plugin Name: Domain Rank Viewer
 Plugin URI: https://github.com/mataspuidokas/domain-rank-viewer
 Description: A plugin to display a list of domains and their PageRank in the WP Admin panel.
 Version: 0.0.1
 Author: Matas Puidokas
 Author URI: https://www.mataspuidokas.com/
 Lincense: MIT
 Text Domain: Domain rank Viewer
 */ 

use Src\Includes\Activate;
use Src\Includes\Deactivate;

defined('ABSPATH') || exit;

 if(file_exists(dirname(__FILE__) . '/vendor/autoload.php')){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
 }

function activateDomainRankViewer()
{
   Activate::activate();
}
register_activation_hook(__FILE__, 'activateDomainRankViewer');

function deactivateDomainRankViewer()
{
   Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivateDomainRankViewer');

if(class_exists( 'Src\\Init')){
   Src\Init::registerServices();
}