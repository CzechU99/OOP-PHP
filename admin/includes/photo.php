<?php 

  class Photo extends Db_object{

    protected static $dbTable = "photos";
    protected static $dbTableFields = array('id', 'title', 'caption', 'description', 'filename', 'alternate_text', 'type', 'size');
    public $id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;

    public function setFile($file){
      if(empty($file) || !$file || !is_array($file)){
        $this->customErrors[] = "There was no file uploaded here";
        return false;
      }elseif($file['error'] != 0){
        $this->customErrors[] = $this->uploadErrorsArray[$file['error']];
        return false;
      }else{
        $this->filename = basename($file['name']);
        $this->tmpPath = $file['tmp_name'];
        $this->size = $file['size'];
        $this->type = $file['type'];
      }
      
    }

    public function picturePath(){
      return $this->uploadDirectory . DS . $this->filename;
    }

    public function save(){

      if($this->id){
        $this->update();
      }else{
        if(!empty($this->customErrors)){
          return false;
        }

        if(empty($this->filename) || empty($this->tmpPath)){
          $this->customErrors[] = "The file was not available";
          return false;
        }

        $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->picturePath();

        if(file_exists($targetPath)){
          $this->customErrors[] = "The file alreadu exists";
          return false;
        }

        if(move_uploaded_file($this->tmpPath, $targetPath)){
          if($this->create()){
            unset($this->tmpPath);
            return true;
          }
        }else{
          $this->customErrors[] = "The file directory does not have permission";
          return false;
        }

        $this->create();
      }

    }

    public function delete_photo(){
      
      if($this->delete()){

        $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->picturePath();
        return unlink($targetPath) ? true : false;

      }else{
        return false;
      }

    }

  }

?>