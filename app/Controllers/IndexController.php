<?php
namespace Newsletter\Controllers;

class IndexController extends AbstractController
{
    public function main()
    {
        $values = [
            'today' => date('Y-m-d')
        ];
        $this->render('index.html.twig', $values);
    }
}
