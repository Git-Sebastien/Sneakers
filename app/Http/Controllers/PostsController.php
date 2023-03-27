<?php 

namespace App\Http\Controllers;

use App\Facades\Query;
use Core\Controller\BaseController;

class PostsController extends BaseController{

    public function index($email,$id)
    {  
        // dd($id,$email);
        return $this->render('posts');
    }
}