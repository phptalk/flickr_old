<?php
require_once '../includes/photo.php';
require_once '../includes/comment.php';

if(isset($_GET['photo_id'])){
    $photo    = photo::fetchById($_GET['photo_id']);   
}
if(isset($_POST['submit'])){    
    $comment = new comment();
    $comment->created = date('Y-m-d');
    $comment->photoId = $_GET['photo_id'];
    $comment->author  = $_POST['author'];
    $comment->comment = $_POST['comment'];
    $comment->create();
}
$comments = comment::fetchByPhotoId($_GET['photo_id']);
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
                  echo "<img src='../upload/{$photo[0]['filename']}'><br>"; 
                  echo "<h2 align='center'>{$photo[0]['caption']}</h2>";
                  echo "<p><a href=index.php>Go Back</a></p>";
                  if(isset($comments) && !empty($comments)){
                      foreach ($comments as $comment){
                          $output = "<p>{$comment['created']}  {$comment['author']} </p>";
                          $output .= "<p>{$comment['comment']}</p>";                          
                          echo $output;
                          echo "<hr>";
                      }
                  }
                  
                  ?>
                   <form method="post">
                        Name: <input type="text" name="author"><br><br>
                        Body: <textarea name="comment"></textarea><br><br>
                        <input type="submit" name="submit" value="POST">
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