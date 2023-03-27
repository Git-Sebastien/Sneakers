<?php 

namespace App\Http\Controllers;

use Core\Controller\BaseController;

class ErrorController extends BaseController{

    public function index()
    {
        return $this->render('error');
    }

}