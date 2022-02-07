<?php

namespace alexandermagera\phpmvc;

use alexandermagera\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName():string;
}