<?php namespace Controllers;


use App\Controller;

class User extends Controller
{
    public function index ()
    {
        return $this->render();
    }

    public function signIn()
    {
        $this->twigVars['values'] = $this->signInValidate();

        return $this->render();
    }


    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();

        \App::redirect('/');
    }


    private function signInValidate()
    {
        $vars = [
            'login' => $_POST['login'] ?? '',
            'password' => $_POST['password'] ?? '',
            'message' => '',
        ];

        if (!$vars['login'] || !$vars['password']) {
            return $vars;
        }

        $user = (new \Models\User())->checkAuth($vars['login'], $vars['password']);

        if (!$user) {
            $vars['message'] = 'Ошибка авторизации. Неверные данные.';
            return $vars;
        }

        $_SESSION['user'] = $user['password'];

        \App::redirect('/user');
    }
}
