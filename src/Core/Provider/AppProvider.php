<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core\Provider;

use Larium\Controller\WebHandler;
use Larium\Controller\ContainerAwareInterface;
use Core\App;

class AppProvider implements ProviderInterface
{
    public function register(App $app)
    {

    }

    public function boot(App $app)
    {
        $app->registerCommand(WebHandler::BEFORE_COMMAND, function($message) use ($app) {
            $command = $message->getCommand();
            if (is_array($command)) {
                list($command, $action) = $command;
            }
            if ($command instanceof ContainerAwareInterface) {
                $command->setContainer($app);
            }
        });
    }
}
