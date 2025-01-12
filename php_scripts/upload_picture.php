<?php
/**
 * Delete all the files with the name profile_picture in the
 * given directory
 *
 * @param $path Folder to look for the files in
 */
function deleteExisting($path) {
    $files = glob($path . 'profile_picture.*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

/**
 * Uploades file into given directory
 *
 * @param $file File to be uploaded
 * @param string $path The path of desired directory for a file to be placed in
 * @return array Returns success code and a message
 */
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

/**
 * Compresess and resizes the image according to
 * target size
 *
 * @param $file File to be resized
 * @param int $targetSize Desired amount on pixels for height and width
 * @return bool Returns true if resizing was successfull
 */
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

/**
 * Validates the size and extension of the file
 *
 * @param $file File to be checked
 * @return array Returns success code and a message
 */
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
