<?php
$acl = new ACL();
if ($acl->hasPermission("cleanup")) {
    $controller = ControllerRegistry::get();
    $modules = $controller->getUnusedEmbedModules();
    if (count($modules) > 0) {
        ?>
        <h1><?php translate("check_for_unused_modules");?></h1>
<div class="row">
	<div class="col-xs-6">
		<a href="<?php echo ModuleHelper::buildAdminURL("cleanup");?>"
			class="btn btn-default"><?php translate("back");?></a>
	</div>
	<div class="col-xs-6"></div>
</div>
<p><?php translate("unused_modules_help");?></p>
<ol>
		<?php for($i=0; $i < count($modules); $i++){?>
		<li><?php Template::escape($modules[$i]);?> <?php echo getModuleMeta($modules[$i], "version");?></li>
		<?php }?>
</ol>
<?php
    }
} else {
    noperms();
}