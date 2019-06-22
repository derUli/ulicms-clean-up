<?php

class RemoveUnusedModulesController extends Controller {

    public function getUnusedEmbedModules() {
        $unusedModules = array();
        $pages = ContentFactory::getAll();
        $embedModules = ModuleHelper::getAllEmbedModules();
        foreach ($embedModules as $module) {
            $unused = true;
            foreach ($pages as $page) {
                if ($page->containsModule($module)) {
                    $unused = false;
                }
            }
            if ($unused) {
                $unusedModules [] = $module;
            }
        }
        return $unusedModules;
    }

}
