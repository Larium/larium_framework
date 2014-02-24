<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\Route\Route;
use Larium\Controller\WebHandler;
use Larium\Http\RedirectResponse;
use Larium\Security\User\InMemoryUserProvider;
use Larium\Security\Storage\SessionStorage;
use Larium\Security\Encoder\BCryptEncoder;
use Larium\Security\Authentication\AuthenticationService;

class SecurityProvider implements ProviderInterface
{
    protected $firewall = array(
        'protected_path' => '^/admin',
        'login_path' => '/admin/login',
        'logout_path' => '/admin/logout',
        'login_check' => '/admin/login_check'
    );

    public function register(App $app)
    {
        $routes = array(
            new Route('/admin/login', array('controller' => 'Default', 'action'=>'loginAction')),
            new Route('/admin/logout', array('controller' => 'Default', 'action'=>'logoutAction')),
            new Route('/admin/login_check', array('controller' => 'Default', 'action'=>'loginCheckAction')),
        );
        $app->getResolver()->getRouter()->addRoutes($routes);
    }

    public function boot(App $app)
    {
        $firewall = $this->firewall;

        $app->getExecutor()->addCommand(WebHandler::ON_REQUEST, function($message) use ($app, $firewall) {

            $provider = new InMemoryUserProvider(array());
            $storage = new SessionStorage('sess_auth', $app['app.session']);
            $encoder = new BCryptEncoder();
            $service = new AuthenticationService($provider, $storage, $encoder);

            $path = $message->getRequest()->getPath();

            if (   $path !== $firewall['login_path']
                && $path !== $firewall['logout_path']
            ) {
                $protected = str_replace('/','\/',$firewall['protected_path']);

                if (preg_match('/'.$protected.'/', $path)
                    && !$service->isAuthenticated()
                ) {
                    $message->setResponse(
                        new RedirectResponse($message->getRequest()->getFullHost() . $firewall['login_path'])
                    );
                }
            }


        });
    }
}
