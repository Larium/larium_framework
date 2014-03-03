<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

return array(
    'homepage' => array(
        'pattern' => '/:slug',
        'route' => array('controller' => 'Default', 'action' => 'indexAction'),
        'method' => 'GET'
    ),
    'page_show' => array(
        'pattern' => '/hello/world',
        'route' => array('controller' => 'Default', 'action' => 'showAction')
    )
);
