<?php 

namespace App\Http\Controllers;
use Core\Controller\BaseController;

class HomeController extends BaseController{

    public function index()
    {
      return  $this->render('home');
    }
}