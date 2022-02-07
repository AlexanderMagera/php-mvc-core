<?php

namespace alexandermagera\phpmvc;

class Request
{
    public static function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        return ($position === false) ? $path : substr($path, 0, $position);
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isGet(){
        return self::method()==='GET';
    }

    public static function isPost(){
        return self::method()==='POST';
    }

    public static function getBody(){
        $body=[];
        if (self::isGet()){
            foreach ($_GET as $key=>$value){
                $body[$key]=filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if (self::isPost()){
            foreach ($_POST as $key=>$value){
                $body[$key]=filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}