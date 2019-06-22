<?php
$controller = ControllerRegistry::get();
$manager = new ModuleManager();
$allMods = $manager->getAllModules();
if (count($allMods) > 0) {
    ?>
    <h1><?php translate("disable_modules"); ?></h1>
    <div class="row">
        <div class="col-xs-6">
            <a href="<?php echo ModuleHelper::buildAdminURL("cleanup"); ?>"
               class="btn btn-default"><?php translate("back"); ?></a>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <p><?php translate("disable_modules_help"); ?></p>

    <?php echo ModuleHelper::buildMethodCallForm("EnDisModsController", "save"); ?>
    <table class="tablesorter">
        <thead>
            <tr>
                <td><strong><?php translate("enabled"); ?></strong></td>
                <th><?php translate("module"); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allMods as $module) { ?>
                <tr>
                    <td><input type="checkbox"
                               name="<?php Template::escape($module->getName()); ?>"
                               <?php
                               if ($module->isEnabled()) {
                                   echo "checked";
                               }
                               ?> value="1"></td>
                    <td><?php Template::escape($module->getName()); ?> <?php Template::escape($module->getVersion()); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <p>
        <button type="submit" class="btn btn-danger"><?php translate("save_changes") ?></button>
    </p>
    <?php
    echo ModuleHelper::endForm();
}
