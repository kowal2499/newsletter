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

        $users = $em->getRepository('Newsletter\Models\User')->findAll();
        $this->render('login.html.twig', [
            'users' => $users
        ]);
    }
}
