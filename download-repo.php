<?php
// download zip file from url & extract it to a folder
$url = 'https://github.com/stripe/stripe-php/archive/refs/tags/v13.13.0.zip';
$zipFile = 'stripe-php.zip';
$zipResource = fopen($zipFile, "w");

function get_zip_file($url, $zipResource)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FILE, $zipResource);
    $page = curl_exec($ch);
    if (!$page) {
        echo "Error :- " . curl_error($ch);
    }
    curl_close($ch);
}
get_zip_file($url, $zipResource);

$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo 'Zip File Extracted';
} else {
    echo 'Failed To Extract Zip File';
}

echo "<br>";

// delete the zip file
if (!unlink($zipFile)) {
    echo "Error: Unable to delete file";
}

echo "<br>";

echo "Stripe PHP SDK Downloaded Successfully";

// Path: download-repo.php
