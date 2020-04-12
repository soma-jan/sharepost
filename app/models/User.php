<?php
class User
{
    public function __construct()
    {
        $this->db = new Database;
    }


    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM USER WHERE EMAIL = :email');
        $this->db->bind(':email', $email);
        $this->db->single();
        if($this->db->rowCount() > 0)
        {
            return true;
        }else{
            return false;
        }
    }

    public function registerUser($data)
    {
        $this->db->query('INSERT INTO user (name, email, password) VALUES(:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        if($this->db->execute()){
        
            return true;
        }
        else{
            return false;
        }
    }
    public function login($email,$password)
    {
        $this->db->query('SELECT id as user_id,name,password FROM USER WHERE EMAIL = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

       
      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)){
        return $row;
      } else {
        return false;
      }
    

    }
    
}




?>