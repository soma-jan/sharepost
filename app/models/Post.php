<?php
class Post
{
    public function __construct()
    {
        if(!isLoggedIn()){
            redirect('users/login');
          }
        $this->db = new Database;
    }
    public function getPost()
    {
        $this->db->query('SELECT POST.ID as PostId, POST.title,POST.body AS BODY,POST.CREATED_AT AS created_date ,USER.ID
         as userId,USER.NAME AS USER  FROM POST,USER WHERE POST.USER_ID = USER.ID ORDER BY POST.CREATED_AT DESC ');
        $result = $this->db->resultSet();
        return $result;
    }

    public function addPost($data)
    {
        $this->db->query('INSERT INTO post (USER_ID, TITLE, BODY) VALUES(:user_id, :title, :body)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        if($this->db->execute()){
        
            return true;
        }
        else{
            return false;
        }
    }
        //show_details
        public function showPost($id)
    {
        $this->db->query('select  post.id as post_id,
                                  post.user_id  as user_id,
                                    post.title as title,
                                    post.body as body,
                                    post.CREATED_AT as CREATED_AT,
                                    user.name as name 
                     from           user,post 
                     where          post.user_id =user.ID 
                     AND            post.id  =:id');
       $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result;
    }
//edit
public function editPost($data)
{
    $this->db->query('UPDATE post 
                      SET
                        ID      =   :id,
                        USER_ID =   :user_id,
                        TITLE   =   :title,
                        BODY    =   :body
                        WHERE        USER_ID=   :user_id 
                        AND           ID=:id' );
    $this->db->bind(':id', $data['id']);
    $this->db->bind(':user_id', $data['user_id']);
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':body', $data['body']);
    if($this->db->execute()){
    
        return true;
    }
    else{
        return false;
    }


}
public function deletePost($id)
{
    $this->db->query('delete  FROM post WHERE id = :id');
    $this->db->bind(':id', $id);
    if($this->db->execute()){
    
        return true;
    }
    else{
        return false;
    }
}

public function getPostById($id){

    $this->db->query('SELECT id,user_id,title,body FROM post WHERE id = :id');
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }






}