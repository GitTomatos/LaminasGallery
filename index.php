<?php

ini_set('display_errors', '1');
ini_set('post_max_size', '5M');
ini_set('upload_max_filesize', '5M');
error_reporting(E_ALL);


//$target_dir = "uploads/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$uploadOk = 1;
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
//    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//    if($check !== false) {
//        echo "File is an image - " . $check["mime"] . ".";
//        $uploadOk = 1;
//    } else {
//        echo "File is not an image.";
//        $uploadOk = 0;
//    }
//}
echo "<pre>";
var_dump($_FILES);
echo "</pre>";

//if ($_FILES["fileToUpload"]["size"] > 5) {
//    echo "Sorry, your file is too large.";
//    $uploadOk = 0;
//}
?>

<!DOCTYPE html>
<html>
<body>

<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
<!--    <input type="hidden" name="MAX_FILE_SIZE" value="50" />-->
    <input type="file" name="fileToUpload" id="fileToUpload" >
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>