<?php namespace Controllers;


class Error extends \App\Controller
{
    public function error404()
    {
        return $this->render('Error');
    }
}
