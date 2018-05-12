<?php
namespace Newsletter\Controllers;

class IndexController extends AbstractController
{
    public function main()
    {
        $this->render('index.twig');
    }
}
