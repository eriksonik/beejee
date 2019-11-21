<?php namespace App;

use App;

class Controller
{
    /**
     * @var \Twig_Environment Объект шаблонизатора Twig.
     */
    protected $twig;

    /**
     * @var array Дополнительные переменные для рендера.
     */
    protected $twigVars = [];

    /**
     * @var string Шаблон для текушего маршрута.
     */
    protected $twigTpl;


    public function __construct()
    {
        // Инициализация шаблонизатора Twig.
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem(ROOTPATH . '/App/Views');
        $this->twig = new \Twig_Environment($loader, [
            'cache' => ROOTPATH . '/cache',
            'auto_reload' => true,
            'debug' => true,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());

        // Указание умолчательного шаблона для текушего маршрута.
        $this->twigTpl = App::$router->controllerName . '/' . App::$router->viewName . '.htm';

        // Если страница генерится через redirect, помещаем сообщение в переменные twig.
        foreach (['flashMessage', 'flashMessageClass'] as $flMsg) {
            if (isset($_SESSION[$flMsg])) {
                $this->twig->addGlobal($flMsg, $_SESSION[$flMsg]);
                unset($_SESSION[$flMsg]);
            }
        }
    }


    /**
     * Рендер страницы.
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(): string
    {
        $session = App::$session;

        $this->twigVars['user'] = $session->user;
        $this->twigVars['isAuth'] = $session->isAuth();
        $this->twigVars['isAdmin'] = $session->isAdmin();

        $template = $this->twig->loadTemplate($this->twigTpl);

        return $template->render($this->twigVars);
    }
}
