# FalconOne - Comprehensive Phishing & Tracking Demo

**Disclaimer**
This repository is a **proof-of-concept** for **authorized security research** and **educational demonstrations**.
Do **not** use without **explicit permission** in real environments.

---

## Overview

FalconOne showcases how attackers might combine:
1. **Phishing** (fake login via `landing.php` → `credentials_grabber.php`)
2. **Geolocation** (HTML5 location request)
3. **User-Agent & Environment Logging** (`logger.php` → text files in `logs/`)
4. **Media Capture** (via `spy_tools.php` for webcam/mic/screen capture)

**File Structure**:
```
falconone/
├── config.php
├── logger.php
├── landing.php
├── location_forwarder.php
├── credentials_grabber.php
├── spy_tools.php
├── log_media.php      (optional)
├── logs/
│   ├── user_agents.log
│   ├── environment.log
│   ├── geolocation.log
│   └── credentials.log
└── styles/
    ├── main.css
    ├── join.css
    ├── footer.css
    └── forms.css
```

---

## Installation

1. Clone or download this repository.
2. Host on a server with **PHP 7+** (or 8+).
3. Ensure `logs/` is writable (e.g. `chmod 777 logs`).
4. Browse to `landing.php`:
   - Enter credentials → stored in `credentials.log`.
   - Grant geolocation → lat/long in `geolocation.log`.
5. Check `logs/` folder for captured data.

## Usage

- **`landing.php`**: Simulates a branded login & location request.
- **`location_forwarder.php`**: Validates lat/lon, logs them, redirects (e.g. to Google).
- **`credentials_grabber.php`**: Saves credentials into `credentials.log`.
- **`spy_tools.php`**: Demonstrates camera, mic, or screen share requests.
- **`log_media.php`** (optional): Uploads snapshots/audio to your server if needed.

## Customization

- **Branding**: Swap logos, color scheme, domain, etc. to mimic a real site.
- **Multi-Step Flow**: Add 2FA screens or other steps for more realism.
- **Database**: For large logs, store them in a SQL DB instead of text files.
- **Email/SMS Lures**: Typically, attackers email or text a link to `landing.php` disguised as official notice.

**Use Responsibly!**

---

## Bonus: Render the README on a Canvas

Below is an **HTML** snippet showing how you could render this README text onto an `<canvas>` element in the browser. Save it as something like `readmeCanvas.html`, open it, and you’ll see the text drawn onto the canvas:

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FalconOne README in a Canvas</title>
  <style>
    body {
      margin: 0;
      background: #f5f5f5;
      font-family: Arial, sans-serif;
    }
    .canvas-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    canvas {
      background: #fff;
      border: 1px solid #ccc;
    }
    .note {
      margin-top: 20px;
      color: #333;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="canvas-container">
    <canvas id="readmeCanvas" width="900" height="1600"></canvas>
    <p class="note">
      Scroll if text overflows. This is a simple demo for rendering text on a canvas.
    </p>
  </div>

  <script>
    const readmeLines = [
      "# FalconOne - Comprehensive Phishing & Tracking Demo",
      "",
      "Disclaimer:",
      "This repository is a proof-of-concept for authorized security research",
      "and educational demonstrations. Do not use without explicit permission.",
      "",
      "## Overview",
      "FalconOne showcases how attackers might combine:",
      "1. Phishing (landing.php -> credentials_grabber.php)",
      "2. Geolocation (HTML5 location request)",
      "3. Logging (logger.php -> text files in logs/)",
      "4. Media Capture (spy_tools.php for webcam/mic/screen)",
      "",
      "File Structure:",
      "falconone/",
      "├── config.php",
      "├── logger.php",
      "├── landing.php",
      "├── location_forwarder.php",
      "├── credentials_grabber.php",
      "├── spy_tools.php",
      "├── log_media.php (optional)",
      "├── logs/",
      "│   ├── user_agents.log",
      "│   ├── environment.log",
      "│   ├── geolocation.log",
      "│   └── credentials.log",
      "└── styles/",
      "    ├── main.css",
      "    ├── join.css",
      "    ├── footer.css",
      "    └── forms.css",
      "",
      "## Installation",
      "1. Clone or download.",
      "2. Use PHP 7+ or 8+.",
      "3. chmod 777 logs.",
      "4. Open landing.php -> credentials.log, geolocation.log for data.",
      "",
      "## Usage",
      "- landing.php: login & location request",
      "- location_forwarder.php: logs lat/lon, redirects",
      "- credentials_grabber.php: logs credentials",
      "- spy_tools.php: camera, mic, screen capture",
      "- log_media.php: optional file uploads",
      "",
      "## Customization",
      "- Branding: logos, colors, domain",
      "- Multi-Step Flow: 2FA, etc.",
      "- Database: store logs in SQL",
      "- Email/SMS Lures: link to landing.php disguised as official notice",
      "",
      "Use Responsibly!"
    ];

    const canvas = document.getElementById("readmeCanvas");
    const ctx = canvas.getContext("2d");

    ctx.fillStyle = "#000";
    ctx.font = "16px Arial";
    const lineHeight = 22;
    let x = 20;
    let y = 40;

    readmeLines.forEach(line => {
      ctx.fillText(line, x, y);
      y += lineHeight;
    });
  </script>
</body>
</html>
```

**End of README**
