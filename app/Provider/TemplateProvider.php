<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Tripiko\View\View;

class TemplateProvider implements ProviderInterface
{
    public function register(App $app)
    {
        $app['app.view'] = function($c) {

            return new View($app->getConfig()->views_path);
        }

        $urlHelper->setContainer($app);
        $urlHelper = UrlHelper::register($app['app.view']);
    }

    public function boot(App $app)
    {
    }
}
