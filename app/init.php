<?php

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'dbconstants.php';
require_once '../vendor/autoload.php';



$logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');
$logger->info('app starting');
$app = new App();
?>
