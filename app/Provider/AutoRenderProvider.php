<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Tripiko\View\View;
use Tripiko\Controller\WebHandler;
use Tripiko\Controller\ActionController;
use Tripiko\Http\Response;

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
                $view = $app['app.view'] ?: new View($app->getConfig()->views_path);

                $actionpath = strtolower(str_replace(array('\\','Controller'), array('/',''),get_class($command[0])))
                    . '/'
                    . strtolower(str_replace('Action', '', $command[1]));

                $content = $view->render($actionpath);

                $message->setResponse(new Response($content));
            }
        });
    }
}
