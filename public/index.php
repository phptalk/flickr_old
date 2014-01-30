<?php
require_once '../includes/photo.php';
//$photos = photo::fetchAll();
$perPage = 3;
if(!isset($_GET['page'])){
    $pageId = $_GET['page'] =  1;
}

$offset = ($_GET['page']  - 1) * $perPage;
$photos = photo::fetchBySql("SELECT * FROM photos
                             LIMIT $perPage offset $offset");
$totalPages = photo::fetchBySql("SELECT COUNT(*) FROM photos");
$imageNum   = array_shift(array_shift($totalPages));
$totalPages = $imageNum / $perPage;
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
                        foreach ($photos as $photo){
                            echo "<div style='float:left; margin:30px;text-align:center'>";
                            echo "<a href='photo.php?photo_id={$photo['photo_id']}'><img src='../upload/{$photo['filename']}' width='300' height='250'></a><br>";
                            echo "<span style='color:blue;font-size:20px;margin:10px'>{$photo['caption']}</span>";
                            echo "</div>";
                        }
                    ?>
                    <div style="clear:both"></div>
                   <?php 
                   
                    for($page=1;$page<=$totalPages;$page++){
                    echo "<a href='index.php?page=$page'>{$page} </a>";
                    }?>
                </td>
            </tr>           
        </table>
             </div>
        <div id="footer">
            <h3>Copyrights eshot 2014</h3>
        </div>
    </body>
</html>