<?php require_once 'database.php'; ?>
<?php
/*
 * User Class will make User CRUD 
 */
class photo 
{
    public $photoId;
    public $filename;
    public $type;
    public $caption;
    public $createdBy;
    public $path = '../upload/';


    // this method will fetch all photos from DB
    public static function fetchAll(){
        $database = new database();
        $result =$database->query("SELECT * FROM photos");
        $photoSet = $database->fetchArray($result);
        if(isset($photoSet)){
            return $photoSet;
        }else{
            return FALSE;
        }
    }
    
    // this method will fetch user by id 
    public static function fetchById($id){
        $database = new database();
        $result   = $database->query("SELECT * FROM photos WHERE photo_id = $id"); 
        $userSet  = $database->fetchArray($result);
        if(isset($userSet)){
            return $userSet;
        }else{
            return FALSE;
        }
    }
    
    public static function fetchBySql($sql){
        $database = new database();
        $result   = $database->query($sql); 
        $userSet  = $database->fetchArray($result);
        if(isset($userSet)){
            return $userSet;
        }else{
            return FALSE;
        }
    }
    
    
    //create new user
    public function create(){
        $database = new database();
        $result = $database->query("INSERT INTO photos (filename,type,caption,created_by)
                                    VALUES('$this->filename',
                                           '$this->type',
                                           '$this->caption',
                                           '$this->createdBy')
                                  ");
        return (($database->affectedRows() !=0) ?  TRUE : FALSE);
    }
    
    // update user method
    public function update($id){
        $database = new database();
        //echo '<pre>';print_r(get_class_methods($database));die;
        $sql = "UPDATE photos SET
                filename      = '{$database->filter($this->filename)}',
                type          = '{$database->filter($this->type)}',
                caption       = '{$database->filter($this->caption)}',
                created_by    = '{$database->filter($this->createdBy)}'
                WHERE photo_id = {$database->filter($id)}";        
        $result = $database->query($sql);
        return (($database->affectedRows() !=0) ?  TRUE : FALSE);
        
    }
    
    // Delete User 
    public function delete($id){
        $database = new database();
        $sql = "DELETE FROM photos WHERE photo_id = $id";
        $database->query($sql);
        return (($database->affectedRows() !=0) ?  TRUE : FALSE);
    }
    public function attachImage($tmp,$file){
        $move = move_uploaded_file($tmp, $this->path.$file);
        if($move){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}


?>
