<?php

namespace Newsletter\Providers;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;

class TwigServiceProvider extends ServiceProvider
{
    public function provide()
    {
        // Twig provider
        $loader = new Twig_Loader_Filesystem(
            $this->config['twig']['dir']
        );
        $twig =  new Twig_Environment($loader, [
            'cache' => $this->config['twig']['cache'],
            'auto_reload' => true
        ]);

        $functionAsset = new Twig_SimpleFunction('asset', function ($fileName) {
            return '/public/' . $fileName;
        });

        $twig->addFunction($functionAsset);

        return $twig;
    }
}