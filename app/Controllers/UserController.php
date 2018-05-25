<?php
namespace Newsletter\Controllers;

use Newsletter\Models\User;

class UserController extends AbstractController
{
    public function login()
    {
        

        $em = $this->entityManager;
        // add new
        /*
        $user = new User();
        $user->setName('Roman Kowalski');
        $em->persist($user);
        $em->flush();
        */
        // edit
        /*
        $user = $em->getRepository('Newsletter\Models\User')->find(3);
        $user->setName('Lena Kowalska');
        $em->persist($user);
        $em->flush();
        */
        $login_params = [];

        $post = $this->request->getParams();
        if (!empty($post)) {
            $login_params = array_filter($post->get('login'));
        }
        
        if (!empty($login_params['email']) && !empty($login_params['password'])) {
            // $users = $em->getRepository('Newsletter\Models\User')->findAll();
            $users = $em->getRepository('Newsletter\Models\User')->findBy(['name' => $login_params['email']]);
            var_dump($users);
        }
        
        $this->render('login.html.twig', [
            'users' => $users,
            'email' => $login_params['email'] ?? '',
            'password' => $login_params['password'] ?? '',
            'url' => $this->request->getUrl()
        ]);
    } 
}
