<?php
require_once('../../includes/intialize.php');
?>
<?php
$message = "";
if(isset($_POST['submit'])){        
    $photo = new Photograph();
    $photo->caption = $_POST['caption'];    
    $photo->attach_file($_FILES['file_upload']);    
    if($photo->save()){
        //success
        $message = "Photograph upload successfully";
    }else{
        // faliure
        $message = join("<br/>", $photo->errors);
    }
}
?>
<?php include_layout_template('admin_header.php'); ?>
<h2>Photo Upload</h2>
<?php
if($message){
    echo $message;
}
?>
<form action="photo_upload.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
    <p><input type="file" name="file_upload"></p>
    <p>Caption: <input type="text" name="caption" value="" /></p>
    <input type="submit" name="submit" value="upload" />
</form>
</div>

<?php include_layout_template('admin_footer.php'); ?>       