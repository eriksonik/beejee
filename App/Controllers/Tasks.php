<?php namespace Controllers;


use App\Controller;

class Tasks extends Controller
{
    public function index()
    {
        $this->twigVars['tasks'] = (new \Models\Tasks())->getTasks();

        return $this->render();
    }
}
