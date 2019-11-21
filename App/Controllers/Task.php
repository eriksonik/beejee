<?php namespace Controllers;


use App\Controller;

class Task extends Controller
{
    /**
     * @var array Поля формы с начальными значениями.
     */
    private $values = [
        'task_id' => '',
        'login' => '',
        'email' => '',
        'text' => '',
        'done' => 0,
    ];

    /**
     * @var array Ошибки валидации полей.
     */
    private $errors = [
        'login' => false,
        'email' => false,
        'text' => false,
    ];

    /**
     * @var array Сообщения об ошибках валидации.
     */
    private $messages = [];

    /**
     * @var string Режим формы (create, edit).
     */
    private $mode;

    /**
     * @var array Информация для изменения данных задачи.
     */
    private $task;


    /**
     * Форма создания задачи.
     *
     * @return string
     */
    public function create()
    {
        $this->mode = 'create';

        return $this->form();
    }


    /**
     * Форма изменения задачи.
     *
     * @return string
     */
    public function edit()
    {
        $this->mode = 'edit';

        $this->task = (new \Models\Tasks)->getTaskById(
            \App::$router->paths[2]
        );

        return $this->form();
    }


    private function form()
    {
        $this->validate();

        // Если форма отправлена и ошибок нет, то сохраняем в БД.
        if (!empty($_POST['mode']) && !$this->messages) {
            $message = '';
            $tasks = new \Models\Tasks();

            switch ($_POST['mode']) {
                case 'create':
                    $task_id = $tasks->create($this->values);
                    $message = 'Задача #' . $task_id . ' добавлена!';
                    break;
                case 'edit':
                    $tasks->update($this->values);
                    $message = 'Задача #' . $this->values['task_id'] . ' изменена!';
                    break;
            }

            \App::redirect('/tasks', $message);
        }

        $this->twigTpl = 'Task/form.htm';
        $this->twigVars['mode'] = $this->mode;

        $this->twigVars['values'] = $this->values;
        $this->twigVars['errors'] = $this->errors;
        $this->twigVars['messages'] = $this->messages;

        return $this->render();
    }

    private function validate()
    {
        // Начальное состояние полей формы.
        $this->values['task_id'] = $this->task['id'] ?? '';
        $this->values['login'] = $this->task['user_name'] ?? '';
        $this->values['email'] = $this->task['email'] ?? '';
        $this->values['text'] = $this->task['text'] ?? '';
        $this->values['done'] = $this->task['status'] ?? 0;


        // Форма запускается первый раз.
        if (empty($_POST['mode'])) {

            return false;
        }

        $this->values['login'] = $_POST['login'] ?? '';
        $this->values['email'] = $_POST['email'] ?? '';
        $this->values['text'] = strip_tags($_POST['text']) ?? '';
        $this->values['done'] = isset($_POST['done']) ? 1 : 0;


        // Проверка поля "Имя пользователя".
        if (!$this->values['login']) {
            $this->errors['login'] = true;
            $this->messages[] = 'Поле "Имя пользователя" обязательно для заполнения.';
        }

        // Проверка поля "E-mail".
        if (!$this->values['email']) {
            $this->errors['email'] = true;
            $this->messages[] = 'Поле "E-mail" обязательно для заполнения.';
        } else if (!filter_var($this->values['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = true;
            $this->messages[] = 'Поле "E-mail" заполнено некорректно.';
        }

        // Проверка поля "Текст задачи".
        if (!$this->values['text']) {
            $this->errors['text'] = true;
            $this->messages[] = 'Поле "Текст задачи" обязательно для заполнения.';
        }
    }
}
