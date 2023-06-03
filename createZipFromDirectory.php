<?php
/**
 * Create a ZIP archive from a directory (and its subdirectories)
 *
 * @param string $sourceDir
 * @param string $outputZipFile
 * @param array $excludeDir
 * @return void
 * @example createZipFromDirectory(__DIR__, __DIR__ . '/sumonst21-temp.zip', array('node_modules', 'vendor')) - exclude the following directories from the ZIP archive
 * @example createZipFromDirectory(__DIR__, __DIR__ . '/sumonst21-temp.zip') - include all the directories in the ZIP archive
 * 
 * @author sumonst21 <sumonst21@gmail.com>
 */
function createZipFromDirectory($sourceDir, $outputZipFile, $excludeDir = array())
{
    // Initialize a new ZIP archive
    $zip = new ZipArchive();

    if ($zip->open($outputZipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        // Create a recursive directory iterator
        $dirIterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        // Iterate over each file and directory in the source directory
        foreach ($dirIterator as $file) {
            // Get the relative path of the file or directory
            $relativePath = substr($file->getPathname(), strlen($sourceDir) + 1);

            if ($file->isFile()) {
                // Add the file to the ZIP archive
                $zip->addFile($file->getPathname(), $relativePath);
            } elseif ($file->isDir()) {
                // Skip if the directory is not allowed to be included
                if (in_array($file->getFilename(), $excludeDir)) {
                    continue;
                }
                // Add an empty directory to the ZIP archive
                $zip->addEmptyDir($relativePath);
            }
        }

        // Close the ZIP archive
        $zip->close();

        echo "ZIP archive created successfully at $outputZipFile";
    } else {
        echo "Failed to create ZIP archive at $outputZipFile";
    }
}

// Example usage
$sourceDir = dirname(__DIR__);
// output file name: directory name + current date time + .zip
$outputZipFile = basename($sourceDir) . '_' . date('Y-m-d_H-i-s') . '.zip';
// exclude the following directories from the ZIP archive
$excludeDir = array('node_modules', 'vendor', 'sumonst21-temp');
createZipFromDirectory($sourceDir, __DIR__ . '/' . $outputZipFile, $excludeDir);
