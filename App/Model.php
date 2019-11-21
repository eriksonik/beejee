<?php namespace App;


class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = \App::$db->get();
    }

    protected function prepareSetUpdate(array $fields)
    {
        $conditions = [];
        foreach ($fields as $key => $field) {
            $conditions[] = "`$key` = $field";
        }

        return implode(', ', $conditions);
    }
}
