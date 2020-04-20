<?php
namespace models;

use core\Model;


/**
 * Responsible for users management.
 */
class Users extends Model
{
    //-----------------------------------------------------------------------
    //        Attributes
    //-----------------------------------------------------------------------
    private $id_user;
    
    
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    /**
     * Creates users manager.
     *
     * @param int $id_user [optional] Id of the current user
     */
    public function __construct($id_user = 0)
    {
        parent::__construct();
        $this->id_user = $id_user;
    }


    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * Checks if a user is logged. If it is not, redirects it to login page.
     */
    public static function verifyLogin()
    {
        if (empty($_SESSION['sn_login'])) {
            header("Location: ".BASE_URL."login");
        }
    }
    
    /**
     * Checks if the user is logged.
     * 
     * @return boolean If the user is logged
     */
    public static function isLogged()
    {
        return !empty($_SESSION['sn_login']);
    }
    
    /**
     * Checks if user credentials are correct.
     * 
     * @param string $email Email of the user
     * @param string $password Password of the user
     * @return string Error message or empty string if login was successful
     */
    public function login($email, $password)
    {
        if (empty($email) || empty($password)) { return "Email and / or password are empty"; }
        
        $response = "";
        
        $sql = $this->db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $sql->execute(array($email, md5($password)));
        
        if ($sql->rowCount() == 0) {
            $response = "Email and / or password incorrect";
        } else {
            $_SESSION['sn_login'] = $sql->fetch()['id'];
            $this->id_user = $sql->fetch()['id'];
        }
        
        return $response;
    }
    
    /**
     * Registers a new user.
     *
     * @param string $name Name of the user
     * @param int $genre Genre of the user
     * @param string $email Email of the user
     * @param string $password Password of the user
     * @return string Error message or empty string if user was successfully registered
     */
    public function register($name, $genre, $email, $password)
    {
        if (empty($email) || empty($password))  {   return "All fields must be filled";   }
        if ($this->existEmail($email))          {   return "User is already registered";  }
        
        $response = "";
        
        $sql = $this->db->prepare("INSERT INTO users (name,genre,email,password) VALUES (?,?,?,?)");
        $sql->execute(array($name, $genre, $email, md5($password)));
        
        if ($sql->rowCount() == 0) {
            $response = "Error registering user";
        } else {
            $_SESSION['sn_login'] = $this->db->lastInsertId();
        }
        
        return $response;
    }
    
    /**
     * Edits a registered user.
     * 
     * @param string $name Name of the user
     * @param string $bio Biography of the user
     * @param int $genre Genre of the user (0: female; 1: male)
     * @param string $passowrd [optional] New password
     * @return boolean If the user was successfully edited
     */
    public function edit($name, $bio, $genre, $password = "")
    {
        if (empty($name)) { return null; }
        
        $response = false;
        
        $data = array();
        $data[] = $name;
        
        $toBeUpdated = array();
        $toBeUpdated[] = "name=?";
        
        // Checks if biography have to be updated
        if (!empty($bio)) {
            $data[] = $bio;
            $toBeUpdated[] = "bio=?";
        }
        
        // Checks if genre have to be updated
        if (!empty($genre) && ($genre == 0 || $genre == 1)) {
            $data[] = $genre;
            $toBeUpdated[] = "genre=?";
        }
        
        if (!empty($password)) {
            $data[] = md5($password);
            $toBeUpdated[] = "password=?";
        }
            
        $sql = $this->db->prepare("UPDATE users SET ".implode(",", $toBeUpdated)." WHERE id = $this->id_user");
        $sql->execute($data);
        
        if ($sql->rowCount() > 0)
            $response = true;
        
        return $response;
    }
    
    /**
     * Returns name of the current user. If the id of a user is passed,
     * returns the name of this user.
     *
     * @param int $id_user [optional] Id of the user
     * @return string Name of the user
     */
    public function getName($id_user = -1)
    {
        if (empty($this->id_user)) { return ""; }
        
        $response = "";
        
        $id_user = $id_user == -1 ? $id_user = $this->id_user : $id_user;
        
        $sql = $this->db->prepare("SELECT name FROM users WHERE id = ?");
        $sql->execute(array($id_user));
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetch()['name'];
        }
        
        return $response;
    }
    
    /**
     * Returns information about current user. If the id of a user is passed,
     * returns information about this user.
     *
     * @param int $id_user [optional] Id of the user
     * @return array Data of current user
     */
    public function getData($id_user = -1)
    {
        if (empty($this->id_user)) { return array(); }
        
        $response = array();
        
        $id_user = $id_user == -1 ? $id_user = $this->id_user : $id_user;
        
        $sql = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $sql->execute(array($id_user));
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetch();
        }
        
        return $response;
    }
    
    /**
     * Checks if a user exists.
     * 
     * @param int $id_user Id of the user
     * @return boolean If the user exists
     */
    private function existUser($id_user)
    {
        if (empty($id_user)) { return false; }
        
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM users WHERE id = ?");
        $sql->execute(array($id_user));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    /**
     * Checks if an email is registered in database.
     * 
     * @param string $email Email to be analyzed
     * @return boolean If email is registered
     */
    private function existEmail($email)
    {
        if (empty($email)) { return false; }
        
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ?");
        $sql->execute(array($email));
        
        return $sql->fetch()['count'] > 0;
    }
}