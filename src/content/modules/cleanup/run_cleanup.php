<?php
$acl = new ACL ();
if ($acl->hasPermission ( "cleanup" )) {
	$controller = new CleanUpController ();
	$mysql_optimize_available = in_array ( "mysql_optimize", getAllModules () );
	?>
<h1>Clean Up</h1>
<?php
	if (isset ( $_POST ["clean_tables"] ) and is_array ( $_POST ["clean_tables"] )) {
		foreach ( $_POST ["clean_tables"] as $table ) {
			$controller->cleanTable ( $table );
			$tname = Template::getEscape ( $table );
			$crapFiles = $controller->getAllCrapFiles ();
			?>
<p><?php translate("TRUNCATE_TABLE_X" , array("%x" => $tname));?></p>
<?php }}?>
<?php

	if (isset ( $_POST ["log_files"] )) {
		$controller->cleanLogDir ();
		?>

<p><?php translate("TRUNCATE_LOG_FILES");?></p>
<?php }?>
<?php

	if (isset ( $_POST ["tmp_files"] )) {
		$controller->cleanTmpDir ();
		?>

<p><?php translate("TRUNCATE_TMP_FILES");?></p>
<?php }?>

<?php foreach($crapFiles as $file){?>
<p><?php translate("DELETE_FILE_X", array("%x" => Template::getEscape($file)))?>
 <?php if(unlink($file)){?>
 <span style="color: green"><?php translate("x_ok");?></span>
 <?php } else{?>
 <span style="color: red"><?php translate("x_failed");?></span>
 <?php }?>
</p>
<?php }?>

<?php
	if ($mysql_optimize_available and isset ( $_POST ["optimize_db"] )) {
		include_once getModulePath ( "mysql_optimize" ) . "mysql_optimize_lib.php";
		$cfg = new config ();
		db_optimize ( $cfg->db_database );
	}
	?>

<p><?php translate("cleaning_finished");?></p>
<p>
	<a href="<?php echo ModuleHelper::buildAdminURL("cleanup");?>">[<?php translate("cleanup_ok")?>]</a>
		<?php }?>