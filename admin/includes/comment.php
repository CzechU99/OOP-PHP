<?php 

  class Comment extends Db_object {

    protected static $dbTable = "comments";
    protected static $dbTableFields = array('id', 'photo_id', 'author', 'body');
    public $id;
    public $photo_id;
    public $author;
    public $body;
    
    public function createComment($photo_id, $author, $body){
      if(!empty($photo_id) && !empty($author) && !empty($body)){
        $this->photo_id = $photo_id;
        $this->author = $author;
        $this->body = $body;

        return true;
      }else{
        return false;
      }
    }

    public static function findComments($photo_id){
      global $database;
      $sql = "SELECT * FROM ". self::$dbTable ." WHERE photo_id = '{$database->escape_string($photo_id)}' ORDER BY photo_id ASC";
      return self::find_by_query($sql);
    }

  }

?>