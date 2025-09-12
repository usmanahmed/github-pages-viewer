<aside>
    <div id="branding">
        <a href="<?php echo SITE_URL; ?>">Dev Docs</a>
    </div>
    <div id="side-list">
        <?php echo get_nav(scanAllDir(DOCSPATH)); ?>
    </div>
</aside>
<div id="content">
    <?php echo load_content($url); ?>
</div>