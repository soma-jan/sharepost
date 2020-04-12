<?php
class Users extends Controller
{
    public function __construct()
    {
            $this->userModel = $this->model('User');
    }



    public function Register()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        
        { 
            $_POST =filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' =>trim($_POST['email']),
                'password' =>trim($_POST['password']),
                'confirm_password' =>trim($_POST['confirm_password']),
                'name_err' =>'',
                'email_err' =>'',
                'password_err' =>'',
                'confirm_password_err' =>'',
                   ];


               //CHECK FOR EMPTY FIELD//
               if(empty($data['name']))
               {
                   $data['name_err'] = 'Please enter name';
               } 
               if(empty($data['email']))
               {
                   $data['email_err'] = 'Please enter email';
               } else
               {
                   if($this->userModel->findUserByEmail($data['email'])==true)
                   {
                   $data['email_err'] = 'Email is already registered';

                   }

               }   
               if(empty($data['password']))
               {
                   $data['password_err'] = 'Please enter password';
               }elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be atleast 6 characters';
               }   
               if(empty($data['confirm_password']))
               {
                   $data['confirm_password'] = 'Please enter confirm password';
               }else{
                   if(($data['confirm_password']) != ($data['password'])) {

                $data['confirm_password_err'] = 'Passwords do not match';
                }}
                if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
                {
                    //hash password
                    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                    if($this->userModel->registerUser($data))
                    {
                        flash('register_success','You have registered and can log in');
                       redirect('users/login');
                       //header('location :' . URLROOT .'/users/login');
                    }else{
                        die('something went wrong');
                    }

                   }else{                 
                $this->view('/users/register',$data);
                }

        }else {
            $data = [
                'name' => '',
                'email' =>'',
                'password' =>'',
                'confirm_password' =>'',
                'name_err' =>'',
                'email_err' =>'',
                'password_err' =>'',
                'confirm_password_err' =>'',
                   ];

            $this->view('/users/register', $data) ;      
        }
    }


    public function login()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        
        { 
            $_POST =filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data = [
                'email' =>trim($_POST['email']),
                'password' =>trim($_POST['password']),
                'email_err' =>'',
                'password_err' =>''               
                   ];

                   if(empty($data['email']))
                   {
                       $data['email_err'] = 'Please enter email';
                   }    
                   if(empty($data['password']))
                   {
                       $data['password_err'] = 'Please enter password';
                   }elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be atleast 6 characters';
                   }  
                      //check for corret email
                      if($this->userModel->findUserByEmail($data['email'])==true)
                      {
                            //user found
   
                      }else{
                          $data['email_err'] = 'Email is not valid';
                          $this->view('/users/login',$data);
                         
                      }
                      //-----------------------------------------------------------------------------------

                      if(empty($data['email_err']) && empty($data['password_err'])){
                        // Validated
                        // Check and set logged in user
                        $loggedInUser = $this->userModel->login($data['email'], $data['password']);
              
                        if($loggedInUser){
                          // Create Session
                          $this->createUserSession($loggedInUser);
                        } else {
                          $data['password_err'] = 'Password incorrect';
              
                          $this->view('users/login', $data);
                        }
                      } else {
                        // Load view with errors
                        $this->view('users/login', $data);
                      }
              
              
                    } else {
                      // Init data
                      $data =[    
                        'email' => '',
                        'password' => '',
                        'email_err' => '',
                        'password_err' => '',        
                      ];
              
                      // Load view
                      $this->view('users/login', $data);
                    }
                  }
              
                  public function createUserSession($user){
                    $_SESSION['user_id'] = $user->user_id;
                    $_SESSION['user_email'] = $user->email;
                    $_SESSION['user_name'] = $user->name;
                    redirect('posts');
                  }
              
                  public function logout(){
                    unset($_SESSION['user_id']);
                    unset($_SESSION['user_email']);
                    unset($_SESSION['user_name']);
                    session_destroy();
                    redirect('users/login');
                  }
                }