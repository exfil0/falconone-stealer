<?php
/**
 * log_media.php
 * Receives JSON with fileData (base64) + fileName, saves to logs/media.
 * Logs environment.
 */

require_once __DIR__ . '/logger.php';

// Log environment each time
logEnvironment();

// Expecting JSON in the form { "fileData": "data:...", "fileName": "..." }
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (!empty($data['fileData']) && !empty($data['fileName'])) {
    $fileData = $data['fileData'];
    $fileName = basename($data['fileName']);

    // Check if base64 is present
    // Format: data:<mime>;base64,<encodedString>
    $parts = explode(',', $fileData);
    if (count($parts) === 2) {
        $mimePart = $parts[0];
        $base64Part = $parts[1];

        $decoded = base64_decode($base64Part);
        if ($decoded !== false) {
            $targetPath = MEDIA_DIR . '/' . $fileName;
            file_put_contents($targetPath, $decoded);
            echo "Uploaded to $targetPath";
            exit;
        }
    }
}

echo "Invalid upload data.";
