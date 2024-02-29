<?php 

  class User extends Db_object {

    protected static $dbTable = "users";
    protected static $dbTableFields = array('username', 'password', 'first_name', 'last_name', 'user_image');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    
    public $imagePlaceholder = "http://placehold.it/400x400&text=image";

    public function setFile($file){
      if(empty($file) || !$file || !is_array($file)){
        $this->customErrors[] = "There was no file uploaded here";
        return false;
      }elseif($file['error'] != 0){
        $this->customErrors[] = $this->uploadErrorsArray[$file['error']];
        return false;
      }else{
        $this->user_image = basename($file['name']);
        $this->tmpPath = $file['tmp_name'];
      }
      
    }

    public function saveUserImage(){

      if(!empty($this->customErrors)){
        return false;
      }

      if(empty($this->user_image) || empty($this->tmpPath)){
        $this->customErrors[] = "The file was not available";
        return false;
      }

      $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->uploadDirectory . DS . $this->user_image;

      if(file_exists($targetPath)){
        $this->customErrors[] = "The file alreadu exists";
        return false;
      }

      if(move_uploaded_file($this->tmpPath, $targetPath)){
        unset($this->tmpPath);
        return true;
      }else{
        $this->customErrors[] = "The file directory does not have permission";
        return false;
      }

      $this->create();
      
    }

    public function imagePathPlaceholder(){
      return empty($this->user_image) ? $this->imagePlaceholder : $this->uploadDirectory . DS . $this->user_image;
    }

    public static function verify_user($username, $password){
      global $database;

      $username = $database->escape_string($username);
      $password = $database->escape_string($password);

      $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

      $result_array = self::find_by_query($sql);
      
      if(!empty($result_array)){
        $item = array_shift($result_array);
        return $item;
      }else{
        return false;
      }

    }

    public function ajax_save_user_image($user_image, $user_id){

      global $database;

      $user_image = $database->escape_string($user_image);
      $user_id = $database->escape_string($user_id);

      $this->user_image = $user_image;
      $this->id = $user_id;

      $sql = "UPDATE " . self::$dbTable . " SET user_image = '{$this->user_image}' WHERE id = '{$this->id}'";
      $update_image = $database->query($sql);

      echo $this->imagePathPlaceholder();

    }

  }

?>