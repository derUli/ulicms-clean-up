<?php

use function UliCMS\HTML\icon;

$controller = new CleanUpController();
$tables = $controller->getCleanableTables();
$canCleanLogFolder = $controller->canCleanLogDir();
$canCleanTmpFolder = $controller->canCleanTmpDir();
$crapFilesCount = $controller->getCrapFilesCount();
$thumbsDirSize = $controller->getThumbsDirSize();
$cacheDirSize = $controller->getCacheDirSize();
$cleanablePasswordResetTokens = $controller->getCleanablePasswordResetTokens();
$mysql_optimize_available = in_array("mysql_optimize", getAllModules());
?>
<?php if (Request::getVar("save")) { ?>
    <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php translate("changes_was_saved") ?>
    </div>
<?php } ?>


<div class="row">
    <div class="col-xs-6">
        <a
            href="<?php echo ModuleHelper::buildActionURL("disable_modules"); ?>"
            class="btn btn-default"><?php echo icon("fas fa-list");
?> <?php translate("disable_modules"); ?></a>
    </div>
    <div class="col-xs-6 text-right">
        <a href="<?php echo ModuleHelper::buildActionURL("unused_modules"); ?>"
           class="btn btn-default"><?php echo icon("fas fa-search"); ?> <?php translate("check_for_unused_modules"); ?></a>
    </div>
</div>

<form action="index.php?action=cleanup" method="post" class="voffset3">
    <?php csrf_token_html(); ?>
    <table class="tablesorter">
        <thead>
            <tr>
                <td style="width: 50px;"></td>
                <th><?php translate("object"); ?></th>
                <th><?php translate("size"); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tables as $table) { ?>
                <tr>
                    <td style="text-align: center"><input type="checkbox"
                                                          id="c_<?php Template::escape($table->TABLE_NAME) ?>"
                                                          name="clean_tables[]"
                                                          value="<?php Template::escape($table->TABLE_NAME); ?>"
                                                          <?php if ($table->TABLE_NAME != tbname("history")) echo "checked"; ?>></td>
                    <td><label for="c_<?php Template::escape($table->TABLE_NAME) ?>"><?php Template::escape($table->TABLE_NAME); ?></label></td>
                    <td><?php Template::escape($table->size_in_mb); ?> MB</td>
                </tr>
            <?php } ?>
            <?php if ($canCleanLogFolder) { ?>
                <tr>
                    <td style="text-align: center"><input type="checkbox"
                                                          id="c_log_files" name="log_files" value="1" checked></td>
                    <td><label for="c_log_files">log_files</label></td>
                    <td><?php echo $controller->getLogDirSize(); ?> MB</td>
                </tr>
            <?php } ?>


            <?php if ($canCleanTmpFolder) { ?>
                <tr>
                    <td style="text-align: center"><input type="checkbox"
                                                          id="c_tmp_files" name="tmp_files" value="1" checked></td>
                    <td><label for="c_tmp_files">tmp_files</label></td>
                    <td><?php echo $controller->getTmpDirSize(); ?> MB</td>
                </tr>
            <?php } ?>

            <?php if ($cacheDirSize > 0) { ?>
                <tr>
                    <td style="text-align: center"><input type="checkbox"
                                                          id="c_cache_files" name="cache_files" value="1"></td>
                    <td><label for="c_cache_files">cache</label></td>
                    <td><?php echo $cacheDirSize; ?> MB</td>
                </tr>
            <?php } ?>

            <?php if ($crapFilesCount) { ?>
                <tr>
                    <td style="text-align: center"><input type="checkbox"
                                                          id="c_crap_files" name="crap_files" value="1" checked></td>
                    <td><label for="c_crap_files">crap_files</label></td>
                    <td><?php echo $controller->getCrapFilesCount(); ?> <?php translate("files"); ?></td>
                </tr>
            <?php } ?>
            <?php if ($thumbsDirSize > 0) { ?>
                <tr>
                    <td style="text-align: center"><input type="checkbox"
                                                          id="c_thumbs_dir" name="thumbs_dir" value="1" checked></td>
                    <td><label for="c_thumbs_dir">thumbs_dir</label></td>
                    <td><?php echo $controller->getThumbsDirSize(); ?> MB</td>
                </tr>
            <?php } ?>
            <?php if ($cleanablePasswordResetTokens) { ?>
                <tr>
                    <td style="text-align: center"><input type="checkbox"
                                                          id="c_password_reset_tokens" name="old_password_reset_tokens"
                                                          value="1" checked></td>
                    <td><label for="c_password_reset_tokens">old_password_reset_tokens</label></td>
                    <td><?php echo $cleanablePasswordResetTokens; ?> Tokens</td>
                </tr>
            <?php } ?>
            <?php
            if ($mysql_optimize_available) {
                ?>
                <tr>
                    <td style="text-align: center"><input type="checkbox"
                                                          id="optimize_db" name="optimize_db" value="1" checked></td>
                    <td><label for="optimize_db">optimize_db</label></td>
                    <td></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <p>
        <button name="submit" class="btn btn-primary" type="submit"><?php echo icon("fas fa-broom"); ?> <?php translate("clean"); ?></button>
    </p>
</form>
