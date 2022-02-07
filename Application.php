<?php

namespace app\core;

use app\controllers\SiteController;
use app\core\db\Database;
use app\models\User;

class Application
{
    public static Application $app;
    public string $layout='main';
    public static string $ROOT_DIR;
    public string $userClass;
    public Router $router;
    public ?Controller $controller=null;
    public Database $db;
    public Session $session;
    public ?User $user = null;
    public View $view;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->session = new Session();
        $this->router = new Router();
        $this->view = new View();
//        $this->controller = new SiteController();
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function login(User $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        }
        catch (\Exception $e){
            Response::setStatusCode($e->getCode());
            echo $this->view->renderView('error',['exception' => $e]);
        }
    }

    public static function isGuest():bool
    {
        return !self::$app->user;
    }
}