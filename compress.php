<?php
function resizeAndCompressImage($source, $destination, $newWidth, $quality) {
    list($width, $height, $type) = getimagesize($source);
    $aspectRatio = $height / $width;
    $newHeight = $newWidth * $aspectRatio;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($source);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }

    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $destination, $quality);
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $destination);
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $destination);
            break;
    }

    imagedestroy($image);
    imagedestroy($newImage);

    return true;
}

$inputDir = './img/clothes/uncompressed'; 
$outputDir = './img/clothes/compressed';
$newWidth = 400; 
$quality = 80; 

if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
}

$files = scandir($inputDir);

$fileIndex = 1;

foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        $inputFilePath = $inputDir . '/' . $file;
        //$outputFilePath = $outputDir . '/' . $file;
        $outputFilePath = $outputDir . '/' . $fileIndex . '.jpg'; 

        if (resizeAndCompressImage($inputFilePath, $outputFilePath, $newWidth, $quality)) {
            echo "Processed file $inputFilePath => $outputFilePath\n";
        } else {
            echo "Failed to process file $inputFilePath\n";
        }
    }
}
?>