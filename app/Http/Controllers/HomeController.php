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
        $post->setAuthor('Plus Mark ni Peter mais Jean');
        $post->update($post);
        $post->save();
        // $user = new User();
        // $user->find($id);
        // $user->setEmail('new mail');
        // $user->update($user);

        return $this->render('home');
      }

      public function create()
      {
        return $this->render('home');
      }

      public function show($mail)
      {
        $user = new User();

        return $this->render('show');

      }
  }