<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\Controller\WebHandler;
use Larium\Http\Session\Session;
use Larium\Http\Session\Handler\FileSessionHandler;

class SessionProvider implements ProviderInterface
{
    public function register(App $app)
    {
    }

    public function boot(App $app)
    {
        $app->registerCommand(WebHandler::ON_REQUEST, function($message) use ($app) {
            $handler = new FileSessionHandler();
            $session = new Session($handler);
            $message->getRequest()->setSession($session);
            $session->start();
            $app['app.session'] = $session;
        });
    }
}
