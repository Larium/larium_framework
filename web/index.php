<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Larium\Http\Request;
use Core\App;

$app = new App('dev');

echo $app->handle(Request::createFromServer());
