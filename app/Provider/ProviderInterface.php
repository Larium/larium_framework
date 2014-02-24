<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

interface ProviderInterface
{
    public function register(App $app);

    public function boot(App $app);
}
