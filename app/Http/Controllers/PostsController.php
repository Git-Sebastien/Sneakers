<?php 

namespace App\Http\Controllers;

use App\Facades\Query;
use Core\Controller\BaseController;

class PostsController extends BaseController{

    public function index($id,$is,$email)
    {  
        $user = Query::table('users')
        ->select('id')
        ->get();
        return $this->render('posts',compact('user'));
    }
}