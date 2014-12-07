<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core\Controller;

use Larium\Controller\ActionController;
use Larium\Http\Response;

abstract class ApplicationController extends ActionController
{
    /**
     * Shortcut getter for App container.
     *
     * @param string $name
     * @access public
     * @return mixed
     */
    public function get($name)
    {
        return $this->getContainer()->get($name);
    }

    public function render($template, array $params = array())
    {
        $content = $this->get('app.view')->render($template, $params);

        return new Response($content);
    }
}
