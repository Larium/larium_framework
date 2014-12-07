<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core;

class Bootstrap
{
    public function boot($app)
    {
        // Register your providers here

        // Session should be registered on top, if want access to it in other
        // providers.
        $app->addProvider(new Provider\SessionProvider());

        $app->addProvider(new Provider\AppProvider());

        //Error handler
        $app->addProvider(new Provider\WhoopsProvider());

        //Auto render action
        $app->addProvider(new Provider\AutoRenderProvider());

        // Security
        $app->addProvider(new Provider\SecurityProvider());

        $app->addProvider(new Provider\TemplateProvider());
    }
}
