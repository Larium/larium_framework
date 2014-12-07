<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core\Provider;

use Larium\View\View;
use Core\App;

class TemplateProvider implements ProviderInterface
{
    public function register(App $app)
    {
        $app['app.view'] = function($c) {

            return new View($c->getConfig()->views_path);
        };
    }

    public function boot(App $app)
    {
    }
}
