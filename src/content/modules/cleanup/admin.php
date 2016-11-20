<?php
define ( "MODULE_ADMIN_HEADLINE", "Clean Up" );
define ( "MODULE_ADMIN_REQUIRED_PERMISSION", "cleanup" );
function cleanup_admin() {
	$controller = new CleanUpController ();
	$tables = $controller->getCleanableTables ();
	$canCleanLogFolder = $controller->canCleanLogDir ();
	?>
<form action="index.php?action=cleanup" method="post">
<?php csrf_token_html();?>
<table class="tablesorter">
		<thead>
			<tr>
				<td style="width: 50px;"></td>
				<th><?php translate("object");?></th>
				<th><?php translate("size");?></th>
			</tr>
		</thead>
		<tbody>
<?php foreach($tables as $table){?>
<tr>
				<td style="text-align: center"><input type="checkbox"
					id="c_<?php Template::escape($table->TABLE_NAME)?>"
					name="clean_tables[]"
					value="<?php Template::escape($table->TABLE_NAME);?>" checked></td>
				<td><label for="c_<?php Template::escape($table->TABLE_NAME)?>"><?php Template::escape($table->TABLE_NAME);?></label></td>
				<td><?php Template::escape($table->size_in_mb);?> MB</td>
			</tr>
<?php }?>
<?php if($canCleanLogFolder){?>
<tr>
				<td style="text-align: center"><input type="checkbox"
					id="c_log_files" name="log_files" value="1" checked></td>
				<td><label for="c_log_files">log_files</label></td>
				<td><?php echo $controller->getLogDirSize();?> MB</td>
			</tr>
<?php }?>
</tbody>
	</table>
	<p>
		<input name="submit" type="submit" value="<?php translate("clean");?>">
	</p>
</form>
<?php
}
?>
