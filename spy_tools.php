<?php
/**
 * spy_tools.php
 * Demonstrates forced media logging: webcam snapshots, mic recordings, screen captures.
 */

require_once __DIR__ . '/logger.php';
// Log environment data each time
logEnvironment();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FalconOne - Spy Tools</title>
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
    <!-- Intro -->
    <section class="join__message">
      <h1 class="join__heading">Spy Tools: Mandatory Media Logging</h1>
      <p class="join__subheading">Webcam, Microphone & Screen</p>
      <p class="join__text">By allowing access, snapshots/audio are automatically uploaded.</p>
    </section>

    <!-- Left col: Webcam -->
    <section class="join__subscribe">
      <h2 class="join__heading">Webcam</h2>
      <p class="join__price">$0 <span class="join__price-month">Demo</span></p>
      <p class="join__price-desc">Grant camera permission to see how an attacker logs snapshots.</p>
      <a href="#" class="join__cta" onclick="activateWebcam()">Start Webcam</a>
      <video id="webcamVideo" autoplay playsinline muted style="margin-top:10px; max-width:100%; display:none;"></video>
      <button id="snapshotBtn" style="display:none; margin-top:10px;">Take Snapshot</button>
      <canvas id="snapshotCanvas" style="display:none; margin-top:10px;"></canvas>
    </section>

    <!-- Right col: Microphone + Screen -->
    <section class="join__about">
      <h2 class="join__heading">Mic & Screen</h2>
      <p class="join__text"><strong>Microphone:</strong></p>
      <button onclick="activateMicrophone()">Enable Mic</button>
      <button onclick="startRecording()">Record Audio</button>
      <button onclick="stopRecording()">Stop Recording</button>
      <audio id="playbackAudio" controls style="display:none; margin-top:10px;"></audio>

      <hr style="margin:20px 0; border-color:#fff; opacity:0.2;">

      <p class="join__text"><strong>Screen Capture:</strong></p>
      <button onclick="shareScreen()">Share Screen</button>
      <video id="screenVideo" autoplay playsinline style="margin-top:10px; max-width:100%; display:none;"></video>
    </section>
  </div>
</article>

<!-- Footer -->
<footer class="footer">
  <div class="footer__attribution">
    <p class="footer__text">&copy; 2025 FalconOne - For Demo Only</p>
  </div>
</footer>

<script>
// Webcam + Snapshot -> automatically upload to log_media.php
let webcamStream = null;
async function activateWebcam() {
  try {
    webcamStream = await navigator.mediaDevices.getUserMedia({ video: true });
    const videoEl = document.getElementById('webcamVideo');
    videoEl.srcObject = webcamStream;
    videoEl.style.display = 'block';
    document.getElementById('snapshotBtn').style.display = 'inline-block';
  } catch (err) {
    alert('Webcam error: ' + err);
  }
}

document.getElementById('snapshotBtn').addEventListener('click', () => {
  if (!webcamStream) {
    alert('Webcam not active!');
    return;
  }
  const videoEl = document.getElementById('webcamVideo');
  const canvas = document.getElementById('snapshotCanvas');
  const ctx = canvas.getContext('2d');
  canvas.width = videoEl.videoWidth;
  canvas.height = videoEl.videoHeight;
  ctx.drawImage(videoEl, 0, 0);
  canvas.style.display = 'block';

  // Convert to dataURL and upload automatically
  const dataURL = canvas.toDataURL('image/png');
  uploadMedia(dataURL, 'snapshot.png');
});

// Microphone -> record -> on stop, upload automatically
let micStream = null;
let mediaRecorder = null;
let audioChunks = [];

async function activateMicrophone() {
  try {
    micStream = await navigator.mediaDevices.getUserMedia({ audio: true });
    alert('Microphone enabled. You can record now.');
  } catch (err) {
    alert('Mic error: ' + err);
  }
}

function startRecording() {
  if (!micStream) {
    alert('Mic not active!');
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

    // Upload audio to server
    const reader = new FileReader();
    reader.onload = function() {
      const base64Data = reader.result; // data:audio/wav;base64,...
      uploadMedia(base64Data, 'recorded.wav');
    };
    reader.readAsDataURL(blob);
  };

  mediaRecorder.start();
  alert('Recording started...');
}

function stopRecording() {
  if (mediaRecorder && mediaRecorder.state !== 'inactive') {
    mediaRecorder.stop();
    alert('Recording stopped.');
  }
}

// Screen capture -> just demonstration, no forced upload
async function shareScreen() {
  try {
    const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
    const screenVideo = document.getElementById('screenVideo');
    screenVideo.srcObject = screenStream;
    screenVideo.style.display = 'block';
  } catch (err) {
    alert('Screen capture error: ' + err);
  }
}

// Helper: Upload base64 data to log_media.php
function uploadMedia(base64Data, filename) {
  fetch('log_media.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      fileData: base64Data,
      fileName: filename
    })
  })
  .then(res => res.text())
  .then(resp => {
    console.log('Media uploaded:', resp);
  })
  .catch(err => {
    console.error('Upload error:', err);
  });
}
</script>
</body>
</html>
