<?php
$acl = new ACL();
if ($acl->hasPermission("cleanup")) {
    $controller = new CleanUpController();
    $mysql_optimize_available = in_array("mysql_optimize", getAllModules());
    ?>
<h1><?php translate("clean");?></h1>
<?php
    if (isset($_POST["clean_tables"]) and is_array($_POST["clean_tables"])) {
        foreach ($_POST["clean_tables"] as $table) {
            $controller->cleanTable($table);
            $tname = Template::getEscape($table);
            $crapFiles = $controller->getAllCrapFiles();
            ?>
<p><?php translate("TRUNCATE_TABLE_X" , array("%x" => $tname));?></p>
<?php fcflush();?>
<?php }}?>
<?php
    if (isset($_POST["log_files"])) {
        $controller->cleanLogDir();
        ?>

<p><?php translate("TRUNCATE_LOG_FILES");?></p>
<?php fcflush();?>
<?php }?>
<?php
    if (isset($_POST["tmp_files"])) {
        $controller->cleanTmpDir();
        ?>

<p><?php translate("TRUNCATE_TMP_FILES");?></p>
<?php fcflush();?>
<?php }?>
<?php
    if (isset($_POST["cache_files"])) {
        $controller->cleanCacheDir();
        ?>

<p><?php translate("CLEAR_CACHE");?></p>
<?php fcflush();?>
<?php }?>

<?php
    if (isset($_POST["thumbs_dir"])) {
        $controller->cleanThumbsDir();
        ?>

<p><?php translate("TRUNCATE_THUMBNAIL_FILES");?></p>
<?php fcflush();?>
<?php }?>
<?php if(isset($_POST["old_password_reset_tokens"])){?>
<?php $controller->cleanOldPasswordResetToken();?>
<p><?php translate("delete_old_password_reset_tokens")?></p>
<?php }?>
<?php foreach($crapFiles as $file){?>
<p><?php translate("DELETE_FILE_X", array("%x" => Template::getEscape($file)))?>
 <?php if(unlink($file)){?>
 <span style="color: green"><?php translate("x_ok");?></span>
 <?php } else{?>
 <span style="color: red"><?php translate("x_failed");?></span>
 <?php }?>
</p>
<?php fcflush();?>
<?php }?>

<?php fcflush();?>
<?php
    if ($mysql_optimize_available and isset($_POST["optimize_db"])) {
        include_once getModulePath("mysql_optimize", true) . "mysql_optimize_lib.php";
        $cfg = new config();
        db_optimize($cfg->db_database);
    }
    ?>

<?php fcflush();?>
<p><?php translate("cleaning_finished");?></p>
<p>
	<a href="<?php echo ModuleHelper::buildAdminURL("cleanup");?>">[<?php translate("cleanup_ok")?>]</a>
		<?php }?>