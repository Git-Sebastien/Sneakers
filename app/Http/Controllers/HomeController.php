<?php 
namespace App\Http\Controllers;


  use App\Models\User;
  use App\Traits\GetClass;
  use App\Traits\SortArray;
  use Core\Controller\BaseController;

  class HomeController extends BaseController{

      use SortArray,GetClass;

      public function index($id)
      {
        return  $this->render('home');
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