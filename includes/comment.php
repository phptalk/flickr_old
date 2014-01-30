<?php require_once 'database.php'; ?>
<?php
/*
 * Comment Class will make Comment CRUD 
 */
class comment 
{
    public $commentId;
    public $photoId;
    public $author;
    public $comment;
    public $created;
    
    // this method will fetch all comments from DB
    public static function fetchAll(){
        $database = new database();
        $result =$database->query("SELECT * FROM comments");
        $commentSet = $database->fetchArray($result);
        if(isset($commentSet)){
            return $commentSet;
        }else{
            return FALSE;
        }
    }
    
    // this method will fetch user by id 
    public static function fetchById($id){
        $database = new database();
        $result   = $database->query("SELECT * FROM comments WHERE comment_id = $id"); 
        $commentSet  = $database->fetchArray($result);
        if(isset($commentSet)){
            return $commentSet;
        }else{
            return FALSE;
        }
    }
    
    // this method will fetch user by id 
    public static function fetchByPhotoId($id){
        $database = new database();
        $result   = $database->query("SELECT * FROM comments WHERE photo_id = $id"); 
        $commentSet  = $database->fetchArray($result);
        if(isset($commentSet)){
            return $commentSet;
        }else{
            return FALSE;
        }
    }
    
    //create new user
    public function create(){        
        $database = new database();
        $result = $database->query("INSERT INTO comments (photo_id,author,comment,created)
                                    VALUES($this->photoId,
                                           '$this->author',
                                           '$this->comment',
                                           '$this->created')");
        return (($database->affectedRows() !=0) ?  TRUE : FALSE);
    }
    
    // update user method
    public function update($id){
        $database = new database();
        //echo '<pre>';print_r(get_class_methods($database));die;
        $sql = "UPDATE comments SET
                photo_id         = '{$database->filter($this->photoId)}',
                author           = '{$database->filter($this->author)}',
                comment          = '{$database->filter($this->comment)}',
                created          = '{$database->filter($this->created)}'
                WHERE comment_id = {$database->filter($id)}";        
        $result = $database->query($sql);
        return (($database->affectedRows() !=0) ?  TRUE : FALSE);
        
    }
    
    // Delete User 
    public function delete($id){
        $database = new database();
        $sql = "DELETE FROM comments WHERE comment_id = $id";
        $database->query($sql);
        return (($database->affectedRows() !=0) ?  TRUE : FALSE);
    }   
}

?>
