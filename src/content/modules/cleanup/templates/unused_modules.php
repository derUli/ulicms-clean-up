<?php
$acl = new ACL ();
if ($acl->hasPermission ( "cleanup" )) {
	$controller = ControllerRegistry::get ();
	$modules = $controller->getUnusedEmbedModules ();
	if (count ( $modules ) > 0) {
		?>
<ol>
		<?php for($i=0; $i < count($modules); $i++){?>
		<li><?php Template::escape($modules[$i]);?> <?php echo getModuleMeta($modules[$i], "version");?></li>
		<?php }?>
</ol>
<?php
	}
} else {
	noperms ();
}