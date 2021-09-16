<?php 
ini_set('include_path', '.:../php:..'); 
require_once 'business/Config.inc.php';
include('../' . Config::getCommercialPrefix() . '/index.html'); 
?>