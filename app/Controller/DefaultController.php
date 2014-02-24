<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Larium\Controller\ActionController;

use Larium\Http\Request;
use Larium\Http\Response;

class DefaultController extends ActionController
{
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
        //return new Response('Hello World');
    }

    public function loginAction()
    {
        return new Response('Login form');
    }
}
