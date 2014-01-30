<?php 
require_once '../includes/database.php';
require_once '../includes/photo.php';
?>
<?php
if(isset($_POST['upload'])){
    $photo = new photo();
    $photo->filename  = $_FILES['file']['name'];
    $photo->type      = $_FILES['file']['type'];
    $photo->caption   = $_POST['caption'];
    $photo->createdBy = $_POST['created_by'];    
    $photo->create();
    $movePhoto = $photo->attachImage($_FILES['file']['tmp_name'], $photo->filename);    
    if($movePhoto){
        $message = "Photo Uploaded Seccessfully";
    }else{
        $message = "Error Happens While uploaded Image";
    }   
}
?>
<html>
    <head>
        <link rel="stylesheet" href="../public/css/main.css" type="text/css"> 
        <title>Index Upload</title>
    </head>
    <body>
        <div id="header">
            <h1>Admin Site</h1>
        </div>
        <div id="main">
        <table>
            <tr>
                <td>
                    <?php
                    if(isset($message)){
                        echo "<p>$message</p>";
                    }
                    ?>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file"><br><br>
                        <input type="hidden" name="MAX-UPLOAD-FILE" value="2000000">
                        Caption <input type="text" name="caption"><br><br>
                        Created <input type="text" name="created_by"><br><br>
                        <input type="submit" value="upload" name="upload">
                    </form> 
                </td>
            </tr>           
        </table>
             </div>
        <div id="footer">
            <h3>Copyrights eshot 2014</h3>
        </div>
    </body>
</html>