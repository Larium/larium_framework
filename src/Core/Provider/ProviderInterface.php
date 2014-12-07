<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core\Provider;

use Core\App;

interface ProviderInterface
{
    public function register(App $app);

    public function boot(App $app);
}
