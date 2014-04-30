<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\Controller\WebHandler;
use Larium\Http\Session\Session;
use Larium\Http\Session\Handler\FileSessionHandler;

class SessionProvider implements ProviderInterface
{
    public function register(App $app)
    {

        $app['app.session'] = function($c) {

            $handler = new FileSessionHandler();

            return new Session($handler);
        }
    }

    public function boot(App $app)
    {
        // Start session when we receive the request.
        $app->registerCommand(WebHandler::ON_REQUEST, function($message) use ($app) {
            $message->getRequest()->setSession($app['app.session']);
            $app['app.session']->start();
        });
    }
}
