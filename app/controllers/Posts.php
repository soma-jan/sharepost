<?php
class Posts extends Controller
{      
    public function __construct(){
      
       $this->postModel = $this->model('post');
       
    }
    
    
    
    public function index(){

        $posts = $this->postModel->getPost();
      
               $data = [
          'posts' => $posts
          
        ];
  
        $this->view('posts/post',$data);
     
      
    }
      public function add(){

        if($_SERVER['REQUEST_METHOD']=='POST')
        
        { 
            $_POST =filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data = [
              'title' => trim($_POST['title']),
              'body' => trim($_POST['body']),
              'user_id' =>$_SESSION['user_id'],
              'title_err'=>'',
              'body_err'=> ''
            ];
            //validation
            if(empty($data['title']))
              {
                  $data['title_err'] = 'Please enter title';
            }  
            if(empty($data['body']))
            {
                $data['body_err'] = 'Please enter your post';
            }  
            if(empty($data['title_err']) && empty($data['body_err']))
            { 
              if($this->postModel->addPost($data )) 
              {
                flash('post_message','Post Added');
                redirect('posts');
                

              }else
              {
                die('Something went wrong');
              }
            }else{
              $this->view('posts/add', $data); 
            }

           

        }
        else{
           $data = [
          'title' => '',
          'body' =>''
          
        ];
  
        $this->view('posts/add',$data);
      }
      }





        //edit post
        
    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''
        ];

        // Validate data
        if(empty($data['title'])){
          $data['title_err'] = 'Please enter title';
        }
        if(empty($data['body'])){
          $data['body_err'] = 'Please enter body text';
        }

        // Make sure no errors
        if(empty($data['title_err']) && empty($data['body_err'])){
          // Validated
          if($this->postModel->editPost($data)){
            flash('post_message', 'Post Updated');
            redirect('posts');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('posts/edit', $data);
        }

      } else {
        // Get existing post from model
        $post = $this->postModel->getPostById($id);

        // Check for owner
        if($post->user_id != $_SESSION['user_id']){
          redirect('posts');
        }

        $data = [
          'id' => $id,
          'title' => $post->title,
          'body' => $post->body
        ];
  
        $this->view('posts/edit', $data);
      }
    }


    //DELETE post
    public function delete($id)
    {
      //die('dd');

      if($_SERVER['REQUEST_METHOD'] == 'POST')
        { 
         
          // Check for owner
        if($post->user_id != $_SESSION['user_id']){
          redirect('posts');
        }
          if($this->postModel->deletePost($id)){
            flash('post_message', 'Post deleted');
            redirect('posts');
          } else {
            die('Something went wrong');
          }

        }else{
          redirect('posts');
        }

    }

    public function showPost($id)
      {
        $post=  $this->postModel->showPost($id);
        if($post=='')
        {
          redirect('posts');
        }
        $data = [
          'post' =>  $post
          
          
        ];
        $this->view('posts/show',$data);
      }
}