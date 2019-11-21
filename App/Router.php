<?php namespace App;


use \Controllers;

/**
 * Обработчик маршрутов.
 *
 * @package App
 */
class Router
{
    public $controllerName = 'Tasks';
    public $actionName = "index";
    public $viewName = "index";

    public $url;
    public $paths = [];
    public $queries = [];

    private $controller;


    /**
     * Вывод страницы.
     *
     * @throws \Exception
     */
    public function start()
    {
        $this->url = parse_url($_SERVER['REQUEST_URI']);
        $this->paths = explode('/', trim($this->url['path'], '\/'));
        parse_str($this->url['query'], $this->queries);

        $this->checkActions();
        $this->checkAvailable();

        echo $this->controller->{$this->actionName}($this->queries);
    }


    /**
     * Корректировка умолчательных свойств.
     *
     * Проверяет маршрут и, при необходимости, обновляет значения свойств контроллера, метода и вида.
     */
    private function checkActions()
    {
        // Контроллер.
        if (!empty($this->paths[0])) {
            $this->controllerName = $this->dashesToCamelCase($this->paths[0]);
        }

        if (!empty($this->paths[1])) {
            // Метод.
            $this->actionName = $this->dashesToCamelCase($this->paths[1], true);

            // Вид.
            $this->viewName = $this->paths[1];
        }
    }


    /**
     * Проверка наличия файлов контроллера.
     *
     * @throws \Exception
     */
    private function checkAvailable()
    {
        // Наличие файла контроллера.
        $controllerFileName = ROOTPATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Controllers'
            . DIRECTORY_SEPARATOR . $this->controllerName . '.php';
        if (!file_exists($controllerFileName)) {
            throw new \Exception('Контроллер с именем ' . $controllerFileName . ' не найден.');
        }
//        require_once $controllerFileName;

        // Наличие класса.
        if (!class_exists("\\Controllers\\" . $this->controllerName)) {
            throw new \Exception('Класс с именем ' . $this->controllerName . ' не найден.');
        }

        // Наличие метода.
        $controller = '\\Controllers\\' . $this->controllerName;
        $this->controller = new $controller;
        if (!method_exists($this->controller, $this->actionName)) {
            throw new \Exception('Метод с именем ' . $this->actionName . ' не найден.');
        }
    }


    /**
     * Преобразует строку с нижними подчеркиваниями в CamelCase.
     *
     * Например: sign_in_result => SignInResult
     *
     * @param string $string Строка для преобразования.
     * @param bool $isMethod Признак результирующей строки как наименования метода (начинается с маленькой буквы).
     * @return string
     */
    private function dashesToCamelCase($string, $isMethod = false)
    {
        $result = str_replace('_', '', ucwords($string, '_'));

        if ($isMethod) {
            $result = lcfirst($result);
        }

        return $result;
    }
}
