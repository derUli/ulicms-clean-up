<?php

use function UliCMS\HTML\icon;

$acl = new ACL();
$controller = ControllerRegistry::get();
$modules = $controller->getUnusedEmbedModules();
?>
<h1><?php translate("check_for_unused_modules"); ?></h1>
<div class="row">
    <div class="col-xs-12">
        <a href="<?php echo ModuleHelper::buildAdminURL("cleanup"); ?>"
           class="btn btn-default"><?php echo icon("fa fa-arrow-left"); ?> <?php translate("back"); ?></a>
    </div>
</div>
<p><?php translate("unused_modules_help"); ?></p>
<?php
if (count($modules) > 0) {
    ?>
    <ol>
        <?php for ($i = 0; $i < count($modules); $i++) { ?>
            <li><?php Template::escape($modules[$i]); ?> <?php echo getModuleMeta($modules[$i], "version"); ?></li>
        <?php } ?>
    </ol>
    <?php
} else {
    ?>
    <div class="alert alert-danger">
        <?php translate("no_unused_modules_found"); ?>
    </div>
    <?php
}
