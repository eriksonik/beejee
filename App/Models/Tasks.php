<?php namespace Models;


use App\Model;

/**
 * Управление задачами в БД.
 *
 * Class Tasks
 * @package Models
 */
class Tasks extends Model
{
    /**
     * Получает задачу по его идентификатору.
     *
     * @param $taskId
     * @return mixed
     */
    public function getTaskById($taskId)
    {
        $stmt = $this->db->prepare('SELECT * FROM `tasks` WHERE `id` = :id');
        $stmt->bindValue(':id', $taskId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }


    /**
     * Получает все задачи.
     *
     * @return mixed
     */
    public function getTasks()
    {
        $stmt = $this->db->prepare('SELECT * FROM `tasks`');
        $stmt->execute();

        return $stmt->fetchAll();
    }


    /**
     * Получает все выполненные задачи.
     *
     * @return mixed
     */
    public function getDoneTasks()
    {
        $stmt = $this->db->prepare('SELECT * FROM `tasks` WHERE `status` = :status');
        $stmt->bindValue(':status', 1, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Создаёт запись о задаче.
     *
     * @param $vars
     * @return mixed
     */
    public function create($vars)
    {
        $stmt = $this->db->prepare("INSERT INTO `tasks` SET 
            `user_name` = :username, `email` = :email, `text` = :text, `status` = :status, `created` = NOW()");
        $stmt->bindValue(':username', $vars['login'], \PDO::PARAM_STR);
        $stmt->bindValue(':email', $vars['email'], \PDO::PARAM_STR);
        $stmt->bindValue(':text', $vars['text'], \PDO::PARAM_STR);
        $stmt->bindValue(':status', $vars['done'], \PDO::PARAM_INT);
        $stmt->execute();

        return $this->db->lastInsertId();
    }


    /**
     * Обновляет запись о задаче.
     *
     * @param $vars
     */
    public function update($vars)
    {
        $task = $this->getTaskById($vars['task_id']);

        $fields = [
            'user_name' => ':username',
            'email' => ':email',
            'text' => ':text',
            'status' => ':status',
        ];
        if ($task['text'] != $vars['text']) {
            $fields['changed'] = 'NOW()';
        }

        $stmt = $this->db->prepare("UPDATE `tasks` SET 
            {$this->prepareSetUpdate($fields)} WHERE `id` = :id");
        $stmt->bindValue(':id', $vars['task_id'], \PDO::PARAM_STR);
        $stmt->bindValue(':username', $vars['login'], \PDO::PARAM_STR);
        $stmt->bindValue(':email', $vars['email'], \PDO::PARAM_STR);
        $stmt->bindValue(':text', $vars['text'], \PDO::PARAM_STR);
        $stmt->bindValue(':status', $vars['done'], \PDO::PARAM_INT);
        $stmt->execute();
    }
}
