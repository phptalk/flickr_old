<?php
require_once LIB_PATH.DS.'database.php';

class User{
    
    public $photo_id;
    public $filename;
    public $type;
    public $size;
    public $caption;
    
    public $upload_dir = "../public/images";
    public $errors     = array();
    private $tmp_path;

    public static function find_all(){        
        $result_set = self::find_by_sql("SELECT * FROM photographs");
        return $result_set;
    }
    
    public static function find_by_id($id=0){
        global $database;        
        $result_set = self::find_by_sql("SELECT * FROM photographs WHERE photo_id = {$id} LIMIT 1");                
        $found = array_shift($result_set);        
        return self::instantiate($found);
    }
    
    public static function find_by_sql($sql=""){
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
        
    }
    
    public function full_name(){
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name." ".$this->last_name;
        }else{
            return "";
        }
    }
    
    private static function instantiate($record){
          $object = new self;
        
//        $object->user_id    = $record['user_id'];
//        $object->username   = $record['username'];
//        $object->first_name = $record['first_name'];
//        $object->last_name  = $record['last_name'];       
//        
        
        /* but what if we have many columns in our code 
         * More dynamic short form approach 
         */
        foreach ($record as $attribute=> $value){
            $object->$attribute = $value;
        }
        
        return $object;
    }
    
    public static function authenticate($username = "", $password =""){
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);
        $sql  = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}'";
        $sql .= " AND password = '{$password}'";
        $sql .= " LIMIT 1";        
        $result_array = self::find_by_sql($sql);        
        return !empty($result_array) ? array_shift($result_array) : FALSE;        
    }
    
    public function attach_file($file){
        // assign variables
        if(!$file || empty($file)){
            $this->errors = "There is no file to upload";
            return FALSE;
        }  else {        
            $this->filename = $file['filename'];
            $this->size = $file['size'];
            $this->type = $file['type'];
            $this->tmp_path = $file['tmp_name'];
            return TRUE;
        }
    }


    public function save(){
        if(!empty($this->errors)){ return false;}
        $upload_dir = SITE_ROOT.DS.'public'.DS.'images'.DS.$this->filename; 
        if(move_uploaded_file($this->tmp_path, $upload_dir)){
            // create new record in DB
            $this->create();
            unset($this->tmp_path);
            return TRUE;
        }else{
            $this->errors = "You cant move file $this->filename";
            return FALSE;
        }
    // 1. move images to my folders 
        
        // 2. save record in DB
        
    }

         public function create(){
        global $database;
        $sql = "INSERT INTO photographs (";
        $sql.= "filename, type, size, caption";
        $sql.= ") values ('";
        $sql.= $database->escape_value($this->filename)."', '";
        $sql.= $database->escape_value($this->type)."', '";
        $sql.= $database->escape_value($this->size)."', '";
        $sql.= $database->escape_value($this->caption)."')";
        if($database->query($sql)){
            $this->photo_id = $database->insert_id();
            return TRUE;
       }  else {
            return FALSE;
        }
        
    }
    
    public function update(){
        global $database;
        $sql = "UPDATE photographs SET ";
        $sql.= "filename= '".$database->escape_value($this->filename)."', ";
        $sql.= "type = '".$database->escape_value($this->type)."', ";
        $sql.= "size= '".$database->escape_value($this->size)."', ";
        $sql.= "caption= '".$database->escape_value($this->caption)."' ";
        $sql.= "WHERE photo_id = ".$database->escape_value($this->photo_id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? TRUE : FALSE;        
    }
    
    public function delete(){
        // 1. delete the record from DB
        global $database;
        $sql = "DELETE FROM photographs ";
        $sql.= "WHERE photo_id = ".$database->escape_value($this->photo_id);
        $sql.= " LIMIT 1";
        $database->query($sql);
        // 2. delete the file 
        $target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();        
	unlink($target_path);
        return ($database->affected_rows() == 1) ? TRUE : FALSE;
    }
}
?>