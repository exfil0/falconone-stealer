<?php
/**
 * config.php
 * Shared configuration.
 */

// Directory for logs
define('LOG_DIR', __DIR__ . '/logs');

// Log file paths
define('LOG_FILE_ENV', LOG_DIR . '/environment.log');   // environment
define('LOG_FILE_UA',  LOG_DIR . '/user_agents.log');   // UA logs
define('LOG_FILE_GEO', LOG_DIR . '/geolocation.log');   // location
define('LOG_FILE_CREDS', LOG_DIR . '/credentials.log'); // credentials

// Max log size in bytes before truncating
define('LOG_MAX_SIZE', 3 * 1024 * 1024);

// Directory for saved media
define('MEDIA_DIR', LOG_DIR . '/media');

// Toggle disclaimers, debugging, etc.
define('DEMO_MODE', true);
