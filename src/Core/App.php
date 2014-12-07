<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core;

use Larium\Http\RequestInterface;
use Larium\Controller\WebHandler;
use Larium\Executor\Executor;
use Larium\Controller\CommandResolver;
use Larium\Route\Router;
use Larium\Http\Response;
use Pimple;

class App extends Pimple
{
    protected $env;

    protected $handler;

    protected $executor;

    protected $resolver;

    protected $config;

    protected $providers = array();

    protected $values = array();

    public function __construct($env = 'dev')
    {
        $this->env = $env;
    }

    /**
     * Handles given request and returns the response as string.
     *
     * @param RequestInterface $request
     * @access public
     * @return string
     */
    public function handle(RequestInterface $request)
    {

        $this->config = new Config(array(
            'web_path' => __DIR__ . '/../../web',
            'views_path' =>  __DIR__ . '/../../views',
            'config_path' => __DIR__ . '/../../config',
            'log_path' => __DIR__ . '/../../var/logs',
            'cache_path' => __DIR__ . '/../../var/cache'
        ));

        //config default routing
        $this->config_routing();

        $this->execute_bootstrap();

        $this->handler = $this->getHandler() ?: new WebHandler($this->getExecutor());

        return $this->handler->handle($request, $this->getResolver())->send();
    }

    /**
     * Execute bootstrap commands.
     *
     * @access private
     * @return void
     */
    private function execute_bootstrap()
    {
        $bootstrap = new Bootstrap();

        $bootstrap->boot($this);

        foreach($this->providers as $provider) {
            $provider->boot($this);
        }
    }

    private function config_routing()
    {
        if (null === $this->resolver) {

            if (file_exists($this->config->config_path . '/routing.php')) {
                $router = Router::loadFromArray($this->config->config_path . '/routing.php');
            } elseif (file_exists($this->config->config_path . '/routing.yml')) {
                $router = Router::loadFromYaml($this->config->config_path . '/routing.yml');
            } else {
                $router = new Router();
            }

            $this->resolver = new CommandResolver($router);
        }
    }

    public function addProvider(Provider\ProviderInterface $provider)
    {
        $name = strtolower(get_class($provider));
        $this->providers[$name] = $provider;

        $provider->register($this);
    }

    public function registerCommand($state, $callable)
    {
        if (is_callable($callable)) {
            $this->getExecutor()->addCommand($state, $callable);
        }
    }

    // Setters Getters for instances

    /**
     * Gets executor.
     *
     * @access public
     * @return mixed
     */
    public function getExecutor()
    {
        if (null === $this->executor) {
            $this->executor = new Executor();
        }

        return $this->executor;
    }

    /**
     * Sets executor.
     *
     * @param mixed $executor the value to set.
     * @access public
     * @return void
     */
    public function setExecutor($executor)
    {
        $this->executor = $executor;
    }

    /**
     * Gets handler.
     *
     * @access public
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Sets handler.
     *
     * @param mixed $handler the value to set.
     * @access public
     * @return void
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }

    /**
     * Gets resolver.
     *
     * @access public
     * @return mixed
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * Sets resolver.
     *
     * @param mixed $resolver the value to set.
     * @access public
     * @return void
     */
    public function setResolver($resolver)
    {
        $this->resolver = $resolver;
    }

    public function getEnv()
    {
        return $this->env;
    }

    /**
     * Gets config.
     *
     * @access public
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function get($name)
    {
        return $this->offsetGet($name);
    }
}
