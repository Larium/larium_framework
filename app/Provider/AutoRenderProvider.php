<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\View\View;
use Larium\Controller\WebHandler;
use Larium\Controller\ActionController;
use Larium\Http\Response;

class AutoRenderProvider implements ProviderInterface
{
    public function register(App $app)
    {
    }

    public function boot(App $app)
    {
        // Auto render action template
        $app->registerCommand(WebHandler::AFTER_COMMAND, function($message) use ($app){
            $command = $message->getCommand();
            if (is_array($command) && $command[0] instanceof ActionController) {
                $view = new View($app->getConfig()->views_path);

                $actionpath = strtolower(str_replace('Controller', '',get_class($command[0])))
                    . '/'
                    . strtolower(str_replace('Action', '', $command[1]));

                $content = $view->render($actionpath);

                $message->setResponse(new Response($content));
            }
        });
    }
}
