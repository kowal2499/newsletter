<?php
namespace Newsletter\Controllers;

class AboutController extends AbstractController
{
    public function main(): string
    {
        return "This is the about page. Access permited for logged users only.";
    }
}
