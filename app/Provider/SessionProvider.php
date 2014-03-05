<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\Controller\WebHandler;
use Larium\Http\Session\Session;
use Larium\Http\Session\Handler\FileSessionHandler;

class SessionProvider implements ProviderInterface
{
    public function register(App $app)
    {
        $handler = new FileSessionHandler();
        $session = new Session($handler);
        $app['app.session'] = $session;
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
