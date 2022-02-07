<?php

namespace alexandermagera\phpmvc\middlewares;

abstract class BaseMiddleware
{
    abstract public function execute();
}