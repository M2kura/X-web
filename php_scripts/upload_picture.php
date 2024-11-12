<?php

function uploadPicture($file, $path) {
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $targetDir = $path . "." . $fileExtension;

    if (move_uploaded_file($file["tmp_name"], $targetDir)) {
        chmod($targetDir, 0777);
        return ["success" => true, "filePath" => $targetDir];
    } else {
        return ["success" => false, "message" => "There's an error with uploading your file."];
    }
}

function checkPicture($file) {
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (getimagesize($file["tmp_name"]) === false) {
        return ["success" => false, "message" => "File is not an image."];
    }

    if ($file["size"] > 500000) {
        return ["success" => false, "message" => "The file cannot be more then 5MB"];
    }

    if ($fileExtension != "jpg" && $fileExtension != "png") {
        return ["success" => false, "message" => "Allowed formats are: png, jpg"];
    } 
    
    return ["success" => true];
}