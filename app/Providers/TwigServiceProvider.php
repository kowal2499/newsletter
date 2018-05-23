<?php

namespace Newsletter\Providers;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;

class TwigServiceProvider extends ServiceProvider
{
    private $asssetManifest;

    public function __construct($cfg)
    {
        parent::__construct($cfg);

        // asset manifest
        try {
            if (!isset($this->config['manifest']) || !file_exists($this->config['manifest'])) {
                throw new \Exception('File is not exists.');
            }
            $file = file_get_contents($this->config['manifest']);
            if (!$file) {
                throw new \Exception('File open failed.');
            }
            $manifestContent = json_decode($file, true);
            if (!$manifestContent) {
                throw new \Exception('Error decoding manifest file.');
            }

            if ($manifestContent) {
                $this->asssetManifest = new \Newsletter\Core\FilteredMap($manifestContent);
            }
        } catch (\Exception $e) {
            die('exception!');
        }
    }

    public function provide()
    {
        // Twig provider
        $loader = new Twig_Loader_Filesystem(
            $this->config['dir']
        );
        $twig =  new Twig_Environment($loader, [
            'cache' => $this->config['cache'],
            'auto_reload' => true
        ]);

        // custom functions

        $functionAsset = new Twig_SimpleFunction('getAsset', [$this, 'getAsset']);

        $twig->addFunction($functionAsset);

        return $twig;
    }

    /**
     * Zwraca nazwę zasobu z uwzględnieniem mapy manifestu
     */
    public function getAsset($filename) : string
    {
        if (!$this->asssetManifest) {
            return $this->config['assetsDir'] . $filename;
        } else {
            if ($this->asssetManifest->has($filename)) {
                // zwróć nazwę zasobu z hashem
                return $this->config['assetsDir'] . $this->asssetManifest->getString($filename, false);
            } else {
                // nie ma go w pliku manifestu, więc zwróć po prostu nazwę
                return $this->config['assetsDir'] . $filename;
            }
        }
    }
}
