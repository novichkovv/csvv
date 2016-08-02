<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 31.07.2016
 * Time: 16:07
 */
class page_controller extends controller
{
    public function index()
    {
        $this->render('record', $this->model('data_table')->getById($_GET['id']));
        $this->view('page' . DS . 'index');
    }
}