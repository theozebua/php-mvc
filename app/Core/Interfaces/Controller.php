<?php

namespace App\Core\Interfaces;

interface Controller
{
    /**
     * This is a function to create a index method that
     * every controller class must implements. This is also
     * the default method of each controller.
     */
    public function index();
}
