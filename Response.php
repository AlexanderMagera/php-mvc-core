<?php

namespace alexandermagera\phpmvc;

class Response
{
    public static function setStatusCode(int $code){
        http_response_code($code);
    }

    public static function redirect(string $url)
    {
        header('Location: '.$url);
    }
}