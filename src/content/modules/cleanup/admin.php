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
					id="c_<?php Template::escape($table)?>" name="clean_tables[]"
					value="<?php Template::escape($table);?>" checked></td>
				<td><?php Template::escape($table->TABLE_NAME);?></td>
				<td><?php Template::escape($table->size_in_mb);?> MB</td>
			</tr>
<?php }?>
<?php if($canCleanLogFolder){?>
<tr>
				<td style="text-align: center"><input type="checkbox"
					id="c_<?php Template::escape($table)?>" name="log_files" value="1"
					checked></td>
				<td>log_files</td>
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
