<?php
namespace Newsletter\Controllers;

class ErrorController extends AbstractController
{
    public function notFound()
    {
        $this->render('404.twig');
    }
}
