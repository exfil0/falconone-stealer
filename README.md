# FalconOne: Mandatory Media Logging + Responsive Dashboard

## Description
FalconOne is a **proof-of-concept** phishing and tracking toolkit designed for **authorized security research** and **educational demonstrations**. It showcases how attackers might:

- Deploy a **phishing** landing page to steal credentials
- Capture **HTML5 Geolocation** data
- Log **user environment** and **user-agent** details
- Force **media logging** (webcam snapshots, microphone recordings) with automatic uploads
- Display **responsive** graphs and tables of captured data via a web-based dashboard

> **Disclaimer:** This project is strictly for **legitimate security research** and **learning purposes**. Do **not** use without explicit permission.

---

## How to Use

1. **Set Up**
   - Place the code in a PHP-capable server (PHP 7+).
   - Ensure the `logs/` folder and `logs/media/` subfolder are writable, e.g.:
     ```bash
     chmod 777 logs
     chmod 777 logs/media
     ```

2. **Phishing Flow**
   - Open `landing.php` in your browser:
     - Enter credentials → stored in `logs/credentials.log`.
     - Grant location → lat/long stored in `logs/geolocation.log`.
   - The environment & user-agent details are logged respectively to `logs/environment.log` and `logs/user_agents.log`.

3. **Spy Tools**
   - Visit `spy_tools.php` to see forced camera and microphone permission requests.
   - Snapped images and recorded audio automatically upload to `logs/media/` via `log_media.php`.

4. **Dashboard**
   - Navigate to `logs/dashboard.php` to:
     - View log files in separate tables
     - Display date-based bar charts for each log category using Chart.js
     - Check or download any media files saved in `logs/media/`
   - This dashboard is **responsive**, so it adapts to mobile screens.

---

## Directory Structure

```
falconone/
├── config.php                # Config constants (paths, log files)
├── logger.php                # Logging helpers (logEnvironment, logUserAgent, etc.)
├── landing.php               # Main phishing page (geolocation + login)
├── location_forwarder.php    # Validates geolocation & logs
├── credentials_grabber.php   # Logs credentials
├── spy_tools.php             # Webcam/Mic/Screen capture + forced media logging
├── log_media.php             # Receives base64 media, saves to logs/media
├── logs/
│   ├── user_agents.log
│   ├── environment.log
│   ├── geolocation.log
│   ├── credentials.log
│   ├── media/                # Folder for uploaded media
│   └── dashboard.php         # Responsive logs dashboard
└── styles/
    ├── main.css
    ├── join.css
    ├── footer.css
    └── forms.css
```

---

## Installation

1. **Clone or Download** this repository.
2. **Deploy** on a server with PHP 7+ or 8+.
3. Make `logs/` and `logs/media/` writable.
4. **Access**:
   - `landing.php` for the main phishing flow.
   - `spy_tools.php` for forced media logging.
   - `logs/dashboard.php` for a summary UI of your logs & media.

---

## License
This project is released under the [MIT License](https://opensource.org/licenses/MIT). You are free to use, modify, and distribute it for **lawful** and **ethical** purposes under the license terms.

---

## Important Notice
- This code is provided **as is**, without warranty of any kind.
- Use it **responsibly** and **only** under authorized engagements.
- The authors bear **no responsibility** for any misuse or damage.

