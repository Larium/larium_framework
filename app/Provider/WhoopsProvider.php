<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\Controller\WebHandler;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

class WhoopsProvider implements ProviderInterface
{
    public function register(App $app)
    {
        $run     = new Run;
        $handler = new PrettyPageHandler;
        $run->pushHandler($handler);
        $run->register();
    }

    public function boot(App $app)
    {
    }
}
