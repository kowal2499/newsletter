<?php
namespace Newsletter\Controllers;

class ErrorController extends AbstractController
{
    public function notFound(): string
    {
        $properties = ['errorMessage' => 'Page not found!'];
        // return $this->render('error.twig', $properties);
        return $properties['errorMessage'];
    }
}
