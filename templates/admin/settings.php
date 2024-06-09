<?php
/**
 * @package DomainRankViewer
 */

defined('ABSPATH') || exit;
?>
<div class="domain-rank-api-wrap">
    <h1><?= __('Settings', 'domain-rank-viewer'); ?></h1>

    <form action="" method="post">
        <div>
            <label for="domain-rank-api-key"><?=  __('Enter Open Page Rank Api Key', 'domain-rank-viewer'); ?></label>
            <input id="domain-rank-api-key" name="domain-rank-api-key" type="text" placeholder="">
        </div>
        <button id="domain-rank-api-submit"><?=  __('Submit', 'domain-rank-viewer'); ?></button>
        <div id="message"></div>
    </form>
</div>