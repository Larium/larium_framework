<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Acme\Controller;

use Core\Controller\ApplicationController;
use Larium\Http\Request;
use Larium\Http\Response;

class DefaultController extends ApplicationController
{
    public $message;

    public function index(Request $request)
    {
        return new Response('Hello World from ' . $request->getFullHost());
    }

    public function indexAction(Request $request)
    {
        return new Response('index action');
    }

    public function showAction(Request $request)
    {
        $message = 'Hello world';

        return $this->render('default/show', ['message' => $message]);
    }

    public function loginAction()
    {
    }
}
