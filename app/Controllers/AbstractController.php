<?php
namespace Newsletter\Controllers;

// use Bookstore\Core\Config;
// use Bookstore\Core\Db;
use Newsletter\Core\Request;
use Monolog\Logger;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Monolog\Handler\StreamHandler;

abstract class AbstractController
{
    protected $request;
    protected $db;
    protected $config;
    protected $view;
    protected $log;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
        // $this->db = Db::getInstance();
        // $this->config = Config::getInstance();
        $loader = new Twig_Loader_Filesystem(
            __DIR__ . '/../../views'
        );

        $this->view = new Twig_Environment($loader);
        $this->log = new Logger('newsletter');
        // $logFile = $this->config->get('log');
        // $this->log->pushHandler(
            // new StreamHandler($logFile, Logger::DEBUG)
        // );
    }
}
