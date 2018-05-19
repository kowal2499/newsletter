<?php
namespace Newsletter\Controllers;

// use Bookstore\Core\Config;
// use Bookstore\Core\Db;
use Newsletter\Core\Request;
use Monolog\Logger;

use Newsletter\Providers\TwigServiceProvider;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Monolog\Handler\StreamHandler;

abstract class AbstractController
{
    protected $request;
    protected $db;
    protected $user_id;
    protected $config;
    protected $view;
    protected $entityManager;
    protected $log;
    
    public function __construct(Request $request)
    {
        $this->request = $request;

        // process config
        $this->config = include(__DIR__ . '/../../config/config.php');

        // process defines
        foreach ($this->config['defines'] as $item => $value) {
            define($item, $value);
        }

        $twig = new TwigServiceProvider($this->config);
        $this->view = $twig->provide();

        // Doctrine provider
        $config = Setup::createAnnotationMetadataConfiguration([], true);
        $this->entityManager = EntityManager::create($this->config['database'], $config);

        // Logger provider
        $this->log = new Logger('newsletter');
        // $logFile = $this->config->get('log');
        // $this->log->pushHandler(
            // new StreamHandler($logFile, Logger::DEBUG)
        // );
    }

    /**
     * Uruchomienie widoku
     */
    protected function render(string $tempate, array $params = [])
    {
        $content =  $this->view->loadTemplate($tempate)->render($params);
        echo $content;
    }

    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Ustawia id użytkownika
     * @param int
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

        
    
}
