<?php
namespace Newsletter\Controllers;

class UserController extends AbstractController
{
    public function login()
    {
        $this->render('login.twig');
    }
}
