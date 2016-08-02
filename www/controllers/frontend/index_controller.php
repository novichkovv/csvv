<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 02.08.2016
 * Time: 13:29
 */
class index_controller extends controller
{
    public function index()
    {
        $this->view('index' . DS . 'index');
    }
}