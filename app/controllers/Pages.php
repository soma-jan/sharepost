<?php
  class Pages extends Controller {
    public function __construct(){
         //echo 'constructo';
        
    
    }

    public function index(){
    
      $data = [
        'title' => 'Welcome',
        'description' =>'Simple networking site'
      ];

      $this->view('/Pages/index',$data);
    }

    public function about(){
      $data = [
        'title' => 'ABOUT US',
        'description' =>'App to share post with your friends'
           ];

      $this->view('/Pages/about',$data);
    }
  }