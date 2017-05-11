<?php
$acl = new ACL ();
if ($acl->hasPermission ( "cleanup" )) {
	$controller = ControllerRegistry::get ();
	$modules = $controller->getUnusedModules ();
	if (count ( $modules ) > 0) {
		?>
<ol>
		<?php foreach($modules as $module){?>
		<li><?php Template::escape($module);?> <?php echo getModuleMeta($module, "version");?></li>
		<?php }?>

</ol>
<?php
	}
} else {
	noperms ();
}