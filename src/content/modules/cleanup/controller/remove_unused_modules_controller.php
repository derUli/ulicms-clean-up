<?php
class RemoveUnusedModulesController extends Controller {
	protected function isUnUsed($module) {
		$pages = ContentFactory::getAll ();
		$retval = true;
		for($i = 0; $i < count ( $pages ); $i ++) {
			if (($pages [$i]->type === "module" and $pages [$i]->module === $module) or $pages [$i]->containsModule ()) {
				$retval = false;
			}
		}
		return $retval;
	}
	public function getUnusedModules() {
		$result = array ();
		$modules = ModuleHelper::getAllEmbedModules ();
		for($i = 0; $i < count ( $modules ); $i ++) {
			if (! $this->isUnUsed ( $modules [$i] )) {
				$result [] = $modules [$i];
			}
		}
		return $result;
	}
}