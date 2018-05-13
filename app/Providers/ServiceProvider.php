<?php

namespace Newsletter\Providers;

abstract class ServiceProvider
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
    public function provide()
    {
    }
}
