<?php
include_once('Models/Model.php');
class Controller{


    private $model;

    public function __construct(){
        $this->model = new Model();
    }

    public function register(){
        $error = $this->model->create_user();
        include 'Views/view.php';
    }
}