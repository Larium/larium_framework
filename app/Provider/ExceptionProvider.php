<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\Http\Response;
use Larium\Controller\WebHandler;

class ExceptionProvider implements ProviderInterface
{
    public function register(App $app)
    {
    }

    public function boot(App $App)
    {
        $app->registerCommand(WebHandler::ON_EXCEPTION, function($message){
            $response = new Response($message->getException()->getMessage());
            $message->setResponse($response);
        });
    }
}
