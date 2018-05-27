<?php
namespace Newsletter\Controllers;

use Newsletter\Models\User,
    Newsletter\Core\Tools;


class UserController extends AbstractController
{
    /**
     * Logowanie
     */
    public function login()
    {
        $login_params = $users = [];
        $post = $this->request->getParams();

        // Jeśli jest użytkownik jest już zalogowany to przekieruj do strony głównej
        if ($this->getUser()) {
            Tools::redirect('');
        }

        // Logowanie użytkownika do systemu
        if (!empty($post->get('login'))) {
            $login_params = array_filter($post->get('login'));
        
            if (!empty($login_params['email']) && !empty($login_params['password'])) {
                var_dump($this->o_id);
                $user = $this->em->getRepository(\Newsletter\Models\User::class)->findOneBy([
                    'organization_id' => $this->o_id,//->getOrganizationId(),
                    'email' => $login_params['email'],
                    'password' => md5($login_params['email'] . $login_params['password'] . SALT)
                ]);

                if (!empty($user)) {
                    // zapisz datę udanego logowania
                    $user->setDateLogin(new \DateTime());
                    $this->em->persist($user);
                    $this->em->flush();
                    
                    // zapisać w sesji
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['password'] = $user->getPassword();

                    // przekierować do głównej strony
                    Tools::redirect('');

                    var_dump('Zalogowano');
                } else {
                    var_dump('Zły login lub hasło');
                }
                
            }
        }
        
        $this->render('login.html.twig', [
            'users' => $users,
            'email' => $login_params['email'] ?? '',
            'password' => $login_params['password'] ?? '',
            'url' => $this->request->getUrl()
        ]);
    }

    /**
     * Wylogowanie i zamknięcie sesji
     */
    public function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        Tools::redirect('login');
    }
}
