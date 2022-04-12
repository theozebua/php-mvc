<?php

namespace App\Controllers;

use App\Core\Interfaces\Controller;
use App\Models\UserModel;

class DefaultController implements Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new UserModel;
    }

    public function index()
    {
        $title = 'Default Page';
        return view('welcome', compact(var_name: 'title'));
    }
}
