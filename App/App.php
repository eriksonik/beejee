<?php


class App
{
    public static $router;
    public static $db;
//    public static $kernel;
    public static $session;

    public static function init()
    {
        require_once ROOTPATH . '/vendor/autoload.php';
        static::bootstrap();
    }

    public static function bootstrap()
    {
        static::$router = new \App\Router;
        static::$db = new \App\Db;
        static::$session = new \App\Session;
    }

    /**
     * Редирект.
     *
     * @param string $url Ссылка для редиректа.
     * @param string $flashMessage Сообщение после редиректа.
     * @param string $class Класс для блока bootstrap-сообщения.
     */
    public static function redirect($url, $flashMessage = null, $class = 'alert-info')
    {
        if ($flashMessage) {
            @$_SESSION['flashMessage'] = $flashMessage;
            @$_SESSION['flashMessageClass'] = $class;
        }
        header('Location: ' . $url);
        exit;
    }
}
