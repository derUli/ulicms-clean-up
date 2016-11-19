<?php
define ( "MODULE_ADMIN_HEADLINE", "Clean Up" );
define ( "MODULE_ADMIN_REQUIRED_PERMISSION", "cleanup" );
function cleanup_admin() {
	?>
<form action="index.php?action=cleanup" method="post">
<?php csrf_token_html();?>
	<p>
		<input name="submit" type="submit"
			value="<?php translate("clean");?>">
	</p>
</form>
<?php
}
?>
