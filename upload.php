<?php

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower (pathinfo ($target_file, PATHINFO_EXTENSION));
    
    if (isset ($_POST ["submit"])) {
        $check = getimagesize ($_FILES["fileToUpload"]["tmp_name"])
    }

//incomplete
?>