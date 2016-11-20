<?php
$acl = new ACL ();
if ($acl->hasPermission ( "cleanup" )) {
	$controller = new CleanUpController ();
	?>
<h1>Clean Up</h1>
<?php
	foreach ( $_POST ["clean_tables"] as $table ) {
		$controller->cleanTable ( $table );
		$tname = Template::getEscape ( $table );
		?>
<p><?php translate("TRUNCATE_TABLE_X" , array("%x" => $tname));?></p>
<?php }?>
<?php if(isset($_POST["log_files"])){?>

<p><?php translate("TRUNCATE_LOG_FILES");?></p>
<?php }?>
<p><?php translate("cleaning_finished");?></p>
<p>
	<a href="<?php echo ModuleHelper::buildAdminURL("cleanup");?>">[<?php translate("cleanup_ok")?>]</a>
		<?php }?>