<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\View\Helper;

class UrlHelper extends Helper
{
    protected $container;

    public function _init_url()
    {
        $url = function($name, array $params = array()) {

            return $this->container->getResolver()->getRouter()->createUrl($name, $params);
        };

        $this->getView()->assign('url', $url);
    }

    public function setContainer(App $app)
    {
        $this->container = $app;
    }
}
