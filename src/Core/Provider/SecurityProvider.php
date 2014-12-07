<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core\Provider;

use Larium\Route\Route;
use Larium\Controller\WebHandler;
use Larium\Http\RedirectResponse;
use Larium\Security\User\InMemoryUserProvider;
use Larium\Security\Storage\SessionStorage;
use Larium\Security\Encoder\BCryptEncoder;
use Larium\Security\Encoder\PlainTextEncoder;
use Larium\Security\Authentication\AuthenticationService;
use Larium\Security\User\UserNotFoundException;
use Core\App;

class SecurityProvider implements ProviderInterface
{
    protected $firewall = array(
        'protected_path' => '^/admin',
        'login_path' => '/admin/login',
        'logout_path' => '/admin/logout',
        'login_check' => '/admin/login_check'
    );

    protected $options;

    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    private function resolve_options($app)
    {
        $default = array(
            'provider' => array(
                '\Larium\Security\User\InMemoryUserProvider',
                array(
                    array(
                        array(
                            'username'=>'andreas',
                            'password'=>'root',
                            'roles' => array(
                                'ROLE_ADMIN'
                            )
                        )
                    )
                )
            ),
            'storage' => array(
                '\Larium\Security\Storage\SessionStorage',
                array(
                    'sess_auth',
                    $app['app.session']
                )
            ),
            'encoder' => array(
                '\Larium\Security\Encoder\PlainTextEncoder',
                array()
            ),
            'token_key' => 'sess_auth',
            'login_redirect' => '/',
            'firewall'  => array(
                'protected_path' => '^/admin',
                'login_path' => '/admin/login',
                'logout_path' => '/admin/logout',
                'login_check' => '/admin/login_check'
            )
        );

        $this->options = array_merge($default, $this->options);
        $this->firewall = $this->options['firewall'];
    }

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
        $this->resolve_options($app);

        $firewall = $this->firewall;

        $app->getExecutor()->addCommand(WebHandler::ON_REQUEST, function($message) use ($app, $firewall) {

            $provider = $this->create_instance_from_class($this->options['provider']);

            $storage = $this->create_instance_from_class($this->options['storage']);

            $encoder = $this->create_instance_from_class($this->options['encoder']);

            $service = new AuthenticationService($provider, $storage, $encoder);

            $path = $message->getRequest()->getPath();

            if (   $path !== $firewall['login_path']
                && $path !== $firewall['logout_path']
                && $path !== $firewall['login_check']
            ) {
                $protected = str_replace('/','\/',$firewall['protected_path']);

                if (preg_match('/'.$protected.'/', $path)
                    && !$service->isAuthenticated()
                ) {

                    $message->setResponse(
                        new RedirectResponse($message->getRequest()->getFullHost() . $firewall['login_path'])
                    );
                }
            } elseif ($path == $firewall['login_check']) {
                $post = $message->getRequest()->getPost();
                $username = $post['username'];
                $password = $post['password'];

                try {
                    $auth = $service->authenticate($username, $password);
                } catch (UserNotFoundException $e) {
                    $auth = false;
                }

                if ($auth) {
                    $message->setResponse(
                        new RedirectResponse($message->getRequest()->getFullHost() . $this->options['login_redirect'])
                    );
                } else {
                    $message->setResponse(
                        new RedirectResponse($message->getRequest()->getFullHost() . $firewall['login_path'])
                    );
                }
            } elseif ($path == $firewall['logout_path']) {

                $service->getAuthenticateStorage()->erase($this->options['token_key']);
                $message->setResponse(
                    new RedirectResponse($message->getRequest()->getFullHost() . $firewall['login_path'])
                );
            }


        });
    }

    private function create_instance_from_class(array $options)
    {
        list($class, $params) = $options;

        $ref = new \ReflectionClass($class);

        return $ref->newInstanceArgs($params);
    }
}
