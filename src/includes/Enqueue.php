<?php
/**
 * @package DomainRankViewer
 */

namespace Src\Includes;

use Src\Interfaces\RegisterInterface;
use Src\Includes\IncludeController;

defined( 'ABSPATH' ) || exit;

class Enqueue extends IncludeController implements RegisterInterface
{
    public function register(): void
    {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
    }

    public function enqueue()
    {
        wp_enqueue_style( 'required_style',  $this->pluginUrl . '/assets/styles/app.css' );
        wp_enqueue_script('required_script', $this->pluginUrl . 'assets/scripts/submitApiKey.js', ['jquery'], null, true);

        wp_localize_script('required_script', 'ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
}