<?php
namespace Newsletter\Core;

class Request
{
    const GET = 'GET';
    const POST = 'POST';

    private $domain;
    private $path;
    private $method;

    private $params;
    private $cookies;

    public function __construct()
    {
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->path = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->params = new FilteredMap(
            array_merge(
                array_filter($_POST), 
                array_filter($_GET)
            )
        );
        $this->session = new FilteredMap($_SESSION);
        $this->cookies = new FilteredMap($_COOKIE);
    }

    public function getUrl(): string
    {
        $domain = !empty($this->getDomain()) ? ('http://' . $this->getDomain()) : '';
        if (!empty($domain)) {
            return $domain . $this->path;
        } else {
            return '';
        }
    }

    public function getDomain(): string
    {
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    }
    
    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
        
    public function isPost(): bool
    {
        return $this->method === self::POST;
    }
    
    public function isGet(): bool
    {
        return $this->method === self::GET;
    }

    public function getParams(): FilteredMap
    {
        return $this->params;
    }
    public function getCookies(): FilteredMap
    {
        return $this->cookies;
    }
    public function getSession(): FilteredMap
    {
        return $this->session;
    }
}
