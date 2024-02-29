<?php 

  class Db_object {

    public $uploadDirectory = 'images';
    public $tmpPath;
    public $customErrors = array();
    public $uploadErrorsArray = array(
      UPLOAD_ERR_OK => "There is no error",
      UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive",
      UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive",
      UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
      UPLOAD_ERR_NO_FILE => "No file was uploaded",
      UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
      UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
      UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload",
    );

    public static function find_all(){
      return static::find_by_query("SELECT * FROM ". static::$dbTable ."");
    }

    public static function find_by_id($id){
      $result_array = static::find_by_query("SELECT * FROM ". static::$dbTable ." WHERE id = $id LIMIT 1");
      
      if(!empty($result_array)){
        $item = array_shift($result_array);
        return $item;
      }else{
        return false;
      }
    }

    public static function find_by_query($sql){
      global $database;
      $result_set = $database->query($sql);
      $object_array = array();
      while($row = mysqli_fetch_array($result_set)){
        $object_array[] = static::instantation($row);
      }
      return $object_array;
    }

    public static function instantation($the_record){
      $callingClass = get_called_class();
      $object = new $callingClass;

      foreach($the_record as $attribiute => $value){
        if($object->has_the_attribiute($attribiute)){
          $object->$attribiute = $value;
        }
      }

      return $object;
    }

    private function has_the_attribiute($attribiute){
      $object_properties = get_object_vars($this);
      return array_key_exists($attribiute, $object_properties);
    }

    public function save(){
      return isset($this->id) ? $this->update() : $this->create();
    }

    protected function properties(){
      $properties = array();
      foreach(static::$dbTableFields as $dbField){
        if(property_exists($this, $dbField)){
          $properties[$dbField] = $this->$dbField;
        }
      }
      return $properties;
    }

    protected function cleanProperties(){
      global $database;

      $cleanProperties = array();

      foreach($this->properties() as $key => $value){
        $cleanProperties[$key] = $database->escape_string($value);
      }

      return $cleanProperties;
    }

    public function create(){
      global $database;

      $properties = $this->cleanProperties();

      $sql = "INSERT INTO ". static::$dbTable ." (". implode(",", array_keys($properties)) .") VALUES ('". implode("','", array_values($properties)) ."')";

      if($database->query($sql)){
        $this->id = $database->the_insert_id();
        return true;
      }else{
        return false;
      }
    }

    public function update(){
      global $database;

      $properties = $this->cleanProperties();
      $propertiesPairs = array();
      foreach($properties as $key => $value){
        $propertiesPairs[] = "{$key}='{$value}'"; 
      }

      $sql = "UPDATE ". static::$dbTable ." SET ". implode(",", $propertiesPairs) ." WHERE id='{$this->id}'";
      $database->query($sql);

      return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete(){
      global $database;

      $sql = "DELETE FROM ". static::$dbTable ." WHERE id = '{$this->id}' LIMIT 1";
      $database->query($sql);

      return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public static function countALL(){
      global $database;
      $sql = "SELECT count(*) FROM " . static::$dbTable . "";
      $result_set = $database->query($sql);
      $row = mysqli_fetch_array($result_set);

      return array_shift($row);
    }

  }

?>