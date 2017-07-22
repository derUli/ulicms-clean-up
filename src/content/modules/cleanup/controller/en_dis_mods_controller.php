<?php

class EnDisModsController extends Controller
{

    public function save()
    {
        $manager = new ModuleManager();
        $allMods = $manager->getAllModules();
        foreach ($allMods as $module) {
            if (Request::getVar($module->getName())) {
                $module->enable();
            } else {
                $module->disable();
            }
        }
        Request::redirect(ModuleHelper::buildAdminURL("cleanup", "save=1"));
    }
}