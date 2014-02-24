<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

require_once 'larium_activerecord/autoload.php';
require_once 'larium_controller/autoload.php';
require_once 'larium_form/autoload.php';
require_once 'larium_http/autoload.php';
require_once 'larium_routing/autoload.php';
require_once 'larium_template/autoload.php';
require_once 'larium_validation/autoload.php';
require_once 'larium_security/autoload.php';
require_once 'vendor/autoload.php';

/*
$whoops = new SplClassLoader('Whoops', __DIR__ . '/vendor/whoops/src');
$whoops->register();

 */
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

$run     = new Run;
$handler = new PrettyPageHandler;
$run->pushHandler($handler);
$run->register();
