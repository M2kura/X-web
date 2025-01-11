<?php
function deleteExisting($path) {
    $files = glob($path . 'profile_picture.*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

function uploadPicture($file, $path) {
    deleteExisting($path);
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $targetDir = $path.$fileExtension;
    if (!resizeImage($file, 800))
        return ["success" => false, "message" => "Failed to resize image."];
    if (move_uploaded_file($file["tmp_name"], $targetDir))
        return ["success" => true, "filePath" => substr($targetDir,3)];
    return ["success" => false, "message" => "There's an error with uploading your file."];
}

function resizeImage($file, $targetSize) {
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    list($width, $height) = getimagesize($file["tmp_name"]);

    $minDimension = min($width, $height);
    $srcX = ($width - $minDimension) / 2;
    $srcY = ($height - $minDimension) / 2;

    if ($minDimension <= $targetSize)
        $targetSize = $minDimension;

    $image_p = imagecreatetruecolor($targetSize, $targetSize);

    if ($fileExtension == 'jpeg' || $fileExtension == 'jpg')
        $image = imagecreatefromjpeg($file["tmp_name"]);
    elseif ($fileExtension == 'png')
        $image = imagecreatefrompng($file["tmp_name"]);
    else
        return false;

    imagecopyresampled($image_p, $image, 0, 0, $srcX, $srcY, $targetSize, $targetSize, $minDimension, $minDimension);

    if ($fileExtension == 'jpeg' || $fileExtension == 'jpg')
        imagejpeg($image_p, $file["tmp_name"], 100);
    elseif ($fileExtension == 'png')
        imagepng($image_p, $file["tmp_name"], 9);
    return true;
}

function checkPicture($file) {
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (getimagesize($file["tmp_name"]) === false)
        return ["success" => false, "message" => "File is not an image."];

    if ($file["size"] > 500000)
        return ["success" => false, "message" => "The file cannot be more then 5MB"];

    if ($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg")
        return ["success" => false, "message" => "Allowed formats are: png, jpg"];

    return ["success" => true];
}
