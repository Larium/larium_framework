<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

return array(
    'home' => array(
        'pattern' => '/',
        'route' => array('controller' => 'Acme\Controller\Default', 'action' => 'indexAction'),
        'method' => 'GET'
    ),
    'page' => array(
        'pattern' => '/:slug',
        'route' => array('controller' => 'Acme\Controller\Default', 'action' => 'indexAction'),
        'method' => 'GET'
    ),
    'page_show' => array(
        'pattern' => '/hello/world',
        'route' => array('controller' => 'Acme\Controller\Default', 'action' => 'showAction')
    )
);
