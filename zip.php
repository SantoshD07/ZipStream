<?php
$dir = $_SERVER['REQUEST_URI'];
$dir = str_replace('/zip', '', $dir);
$zip_file = basename($dir) . '.zip';

$zip = new ZipArchive();
$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $file_path = $file->getRealPath();
        $relative_path = substr($file_path, strlen($dir) + 1);
        $zip->addFile($file_path, $relative_path);
    }
}

$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zip_file . '"');
header('Content-Length: ' . filesize($zip_file));

readfile($zip_file);
unlink($zip_file);
exit;