<?php
include_once getModulePath ( "cleanup", true ) . "controller/cleanup_controller.php";
global $actions;
$actions ["cleanup"] = getModulePath ( "cleanup", true ) . "run_cleanup.php";
