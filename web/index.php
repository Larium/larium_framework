<?php

//$start = microtime(true);
//$memory = memory_get_usage(true);
require_once __DIR__ . '/../vendor/autoload.php';

use Larium\Http\Request;

$app = new App('dev');

echo $app->handle(Request::createFromServer());


//$end = microtime(true);
//$em = memory_get_usage(true);
//echo number_format(($end - $start) * 1000, 0) . " ms<br />";
//echo number_format( ($em - $memory) / (1024), 0, ",", "." ) . " kb";
