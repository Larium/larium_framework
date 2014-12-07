<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core\Provider;

use Larium\View\View;
use Larium\Controller\WebHandler;
use Larium\Controller\ActionController;
use Larium\Http\Response;
use Core\App;

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
                $view = isset($app['app.view']) ? $app['app.view'] : new View($app->getConfig()->views_path);

                $actionpath = strtolower(str_replace(array('\\','Controller'), array(DIRECTORY_SEPARATOR,null),get_class($command[0])))
                    . '/'
                    . strtolower(str_replace('Action', '', $command[1]));

                $content = $view->render($actionpath, get_object_vars($command[0]));

                $message->setResponse(new Response($content));
            }
        });
    }
}
