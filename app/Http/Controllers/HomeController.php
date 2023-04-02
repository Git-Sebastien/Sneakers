<?php 
namespace App\Http\Controllers;

use App\Models\Post;


  use App\Models\User;
  use App\Traits\GetClass;
  use App\Traits\SortArray;
  use Core\Controller\BaseController;

  class HomeController extends BaseController{

      use SortArray,GetClass;

      public function index($id)
      {
        $post = new Post();
        $post->find($id);
        $post->delete($id);
        return $this->render('home');
      }

      public function create()
      {

        return $this->render('home');
      }

      public function show($mail)
      {

        return $this->render('show');
      }
  }