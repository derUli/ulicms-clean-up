<?php
include_once getModulePath ( "cleanup" ) . "controller/cleanup_controller.php";
global $actions;
$actions ["cleanup"] = getModulePath ( "cleanup" ) . "run_cleanup.php";
