<?php
/**
 * @package DomainRankViewer
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="wrap">
    <h1><?= __('Domain Rank Viewer', 'domain-rank-viewer'); ?></h1>

    <?php if (!empty($this->errorMessage)): ?>
    <div class="notice notice-error">
        <p><?= esc_html($this->errorMessage); ?></p>
    </div>
    <?php endif; ?>

    <form method="GET">
        <input type="hidden" name="page" value="domain_rank_viewer">
        <input type="hidden" name="paged" value="1">
        <input type="text" name="s" value="<?= esc_attr($searchQuery); ?>"
            placeholder="<?= esc_attr__('Search domains...', 'domain-rank-viewer'); ?>">
        <input type="submit" value="<?= esc_attr__('Search', 'domain-rank-viewer'); ?>">
    </form>

    <?php if ($pagedDomains) : ?>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?= esc_html__('Domain', 'domain-rank-viewer'); ?></th>
                <th><?= esc_html__('Page Rank', 'domain-rank-viewer'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagedDomains as $key => $domain) : ?>
            <tr>
                <td><?= isset($domain['rootDomain']) ? esc_html($domain['rootDomain']) : __('N/A', 'domain-rank-viewer'); ?>
                </td>
                <td><?= isset($pageRanks[$domain['rootDomain']]) ? esc_html($pageRanks[$domain['rootDomain']]) : __('N/A', 'domain-rank-viewer'); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <?php if(!isset($_GET['s']) || empty($_GET['s'])): ?>
    <div class="tablenav">
        <div class="tablenav-pages">
            <?= $pageLinks; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php else : ?>
    <?= esc_html__('No domains found.', 'domain-rank-viewer'); ?>
    <?php endif; ?>
</div>