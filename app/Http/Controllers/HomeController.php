<?php 
namespace App\Http\Controllers;

use Core\Model\Model;

  use App\Models\User;
  use App\Facades\Query;
  use App\Traits\SortArray;
  use Core\Controller\BaseController;

  class HomeController extends BaseController{

      use SortArray;

      public function index($id)
      {
        $user = new User();
        $user->find(1);
        $password =  $user->setPassword("Ca marche");
        $password =  $user->setEmail("Ca a l'air bon cette fois");
        $user->save();
        


        // dd($user->save(),$user);
        return  $this->render('home',compact('user'));
      }
  }