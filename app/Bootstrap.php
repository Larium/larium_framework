<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

class Bootstrap
{
    public function boot($app)
    {
        // Register your providers here

        // Session should be registered on top, if want access to it in other
        // providers.
        $app->addProvider(new SessionProvider());

        //Error handler
        $app->addProvider(new WhoopsProvider());

        //Auto render action
        $app->addProvider(new AutoRenderProvider());

        // Security
        $app->addProvider(new SecurityProvider());
    }
}
