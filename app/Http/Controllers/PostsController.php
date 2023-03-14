<?php 

namespace App\Http\Controllers;

use Core\Controller\BaseController;

class PostsController extends BaseController{

    public function index()
    {
        return $this->render('posts');
    }

}