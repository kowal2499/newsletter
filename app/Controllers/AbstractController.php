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

        // process definitions
        foreach ($this->config['defines'] as $item => $value) {
            define($item, $value);
        }

        $twig = new TwigServiceProvider($this->config['twig']);
        $this->view = $twig->provide();

        // Doctrine provider
        $config = Setup::createAnnotationMetadataConfiguration([], true);
        $this->em = EntityManager::create($this->config['database'], $config);

        // Logger provider
        $this->log = new Logger('newsletter');
        
        // organizacja
        $this->o_id = null;
        $this->o = $this->setOrganization();

        // ustawienie użytkownika na podstawie sesji
        $this->u = $this->setUser();
    }

    /**
     * Uruchomienie widoku
     */
    protected function render(string $tempate, array $params = [])
    {
        $extra = [
            'userName' => $this->u ? $this->u->getName() : null
        ];
        $content =  $this->view->loadTemplate($tempate)->render(
            array_merge($params, $extra)
        );
        echo $content;
    }

    protected function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Ustawienie organizacji
     */
    private function setOrganization()
    {
        $o = $this->em->getRepository(\Newsletter\Models\Organization::class)->findOneBy(['url' => $this->request->getDomain()]);
        if ($o) {
            $this->o_id = $o->getOrganizationId();
            return $o;
        }
        return null;
    }

    /**
     * Ustawienie aktywnego użytkownika na podstawie sesji
     */
    private function setUser()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $password = $_SESSION['password'] ?? null;
        if ($userId && $password) {
            // mamy jakieś dane w sesji, sprawdzamy czy są to właściwe dane logowania
            $user = $this->em->getRepository(\Newsletter\Models\User::class)->findOneBy([
                'user_id' => $userId,
                'organization_id' => $this->o->getOrganizationId(),
                'password' => $password
            ]);

            if (!empty($user)) {
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function getUser()
    {
        return $this->u;
    }
}
