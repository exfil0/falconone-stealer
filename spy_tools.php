<?php
/**
 * spy_tools.php
 * 
 * Demonstrates camera, microphone, and screen capture.
 */

require_once __DIR__ . '/logger.php';

// Log environment data each time
logEnvironment();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Spy Tools Demo</title>
  <meta name="description" content="Demonstration of attacker-accessible camera, mic, screen.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Link your styles -->
  <link rel="stylesheet" href="styles/main.css">
  <link rel="stylesheet" href="styles/join.css">
  <link rel="stylesheet" href="styles/footer.css">
  <link rel="stylesheet" href="styles/forms.css">
</head>
<body>

<article class="join">
  <div class="join__container">
    <!-- Headline -->
    <section class="join__message">
      <h1 class="join__heading">Spy Tools Demo</h1>
      <p class="join__subheading">Camera, Microphone, & Screen Capture</p>
      <p class="join__text">See how an attacker might request these permissions.</p>
    </section>

    <!-- Webcam, col 1 -->
    <section class="join__subscribe">
      <h2 class="join__heading">Webcam</h2>
      <p class="join__price">$0 <span class="join__price-month">Demo</span></p>
      <p class="join__price-desc">Grant camera access to see how it works.</p>
      <a href="#" class="join__cta" onclick="activateWebcam()">Start Webcam</a>
      <video id="webcamVideo" autoplay playsinline muted style="display:block; margin-top:10px; max-width:100%;"></video>
      <p>
        <button onclick="captureSnapshot()">Take Snapshot</button>
      </p>
      <canvas id="snapshotCanvas" style="display:none;"></canvas>
    </section>

    <!-- Microphone, col 2 -->
    <section class="join__about">
      <h2 class="join__heading">Microphone & Screen</h2>
      
      <!-- Microphone -->
      <p><strong>Microphone:</strong></p>
      <button onclick="activateMicrophone()">Enable Mic</button>
      <button onclick="startRecording()">Record Audio</button>
      <button onclick="stopRecording()">Stop Recording</button>
      <audio id="playbackAudio" controls style="display:none; margin-top:10px;"></audio>

      <hr style="margin:20px 0; border-color: #fff; opacity:0.2;">

      <!-- Screen -->
      <p><strong>Screen Capture:</strong></p>
      <button onclick="shareScreen()">Share Screen</button>
      <video id="screenVideo" autoplay playsinline style="display:block; margin-top:10px; max-width:100%;"></video>
    </section>
  </div>
</article>

<!-- Footer -->
<footer class="footer">
  <div class="footer__attribution">
    <p class="footer__text">© 2025 Acme Corp. | For Demo Only</p>
  </div>
</footer>

<script>
let webcamStream = null;
async function activateWebcam() {
  try {
    webcamStream = await navigator.mediaDevices.getUserMedia({ video: true });
    document.getElementById('webcamVideo').srcObject = webcamStream;
  } catch (err) {
    alert("Webcam error: " + err);
  }
}

function captureSnapshot() {
  if (!webcamStream) {
    alert("Webcam not active!");
    return;
  }
  const videoEl = document.getElementById('webcamVideo');
  const canvas = document.getElementById('snapshotCanvas');
  const ctx = canvas.getContext('2d');
  canvas.width = videoEl.videoWidth;
  canvas.height = videoEl.videoHeight;
  ctx.drawImage(videoEl, 0, 0);
  canvas.style.display = 'block';
  // Optionally, upload this to log_media.php
}

let micStream = null;
let mediaRecorder = null;
let audioChunks = [];

async function activateMicrophone() {
  try {
    micStream = await navigator.mediaDevices.getUserMedia({ audio: true });
    alert("Microphone enabled. Now you can record audio.");
  } catch (err) {
    alert("Microphone error: " + err);
  }
}

function startRecording() {
  if (!micStream) {
    alert("Mic not active!");
    return;
  }
  mediaRecorder = new MediaRecorder(micStream);
  audioChunks = [];
  mediaRecorder.ondataavailable = e => {
    if (e.data.size > 0) audioChunks.push(e.data);
  };
  mediaRecorder.onstop = () => {
    const blob = new Blob(audioChunks, { type: 'audio/wav' });
    const url = URL.createObjectURL(blob);
    const audioEl = document.getElementById('playbackAudio');
    audioEl.src = url;
    audioEl.style.display = 'block';
    // Optionally, POST the blob to server
  };
  mediaRecorder.start();
  alert("Recording started...");
}

function stopRecording() {
  if (mediaRecorder && mediaRecorder.state !== 'inactive') {
    mediaRecorder.stop();
    alert("Recording stopped.");
  }
}

async function shareScreen() {
  try {
    const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
    document.getElementById('screenVideo').srcObject = screenStream;
  } catch (err) {
    alert("Screen capture error: " + err);
  }
}
</script>
</body>
</html>
