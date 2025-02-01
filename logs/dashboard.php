<?php
/**
 * logs/dashboard.php
 * A responsive dashboard that reads log files, displays them in tables,
 * and shows basic graphs (Chart.js) of log frequency.
 */

// For Chart.js usage:
// <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

// We’ll define a small helper to parse date from each log line.

function parseLogFile($filePath) {
    $lines = [];
    if (file_exists($filePath)) {
        $raw = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($raw as $line) {
            $lines[] = $line;
        }
    }
    return $lines;
}

// Parse date/time from line, expecting format: [YYYY-mm-dd HH:ii:ss]
function extractDate($line) {
    // e.g., "[2025-01-01 12:34:56] ..."
    if (preg_match('/\[(.*?)\]/', $line, $matches)) {
        return $matches[1]; // 2025-01-01 12:34:56
    }
    return null;
}

// Group lines by date (YYYY-mm-dd)
function groupByDate($lines) {
    $counts = [];
    foreach ($lines as $ln) {
        $dt = extractDate($ln);
        if ($dt) {
            // convert to date portion only
            $day = substr($dt, 0, 10); // YYYY-mm-dd
            if (!isset($counts[$day])) {
                $counts[$day] = 0;
            }
            $counts[$day]++;
        }
    }
    return $counts;
}

function listMediaFiles($mediaDir) {
    $files = [];
    if (is_dir($mediaDir)) {
        $scan = scandir($mediaDir);
        foreach ($scan as $f) {
            if ($f === '.' || $f === '..') continue;
            $files[] = $f;
        }
    }
    return $files;
}

// Load each log
$userAgentLines = parseLogFile(__DIR__ . '/user_agents.log');
$envLines       = parseLogFile(__DIR__ . '/environment.log');
$geoLines       = parseLogFile(__DIR__ . '/geolocation.log');
$credLines      = parseLogFile(__DIR__ . '/credentials.log');

// Group by date
$uaGrouped  = groupByDate($userAgentLines);
$envGrouped = groupByDate($envLines);
$geoGrouped = groupByDate($geoLines);
$credGrouped= groupByDate($credLines);

// Media listing
$mediaFiles = listMediaFiles(__DIR__ . '/media');

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FalconOne Logs Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f0f0f0;
    }
    header {
      background: #222;
      color: #fff;
      padding: 1rem;
      text-align: center;
    }
    .container {
      max-width: 1200px;
      margin: 1rem auto;
      padding: 1rem;
      background: #fff;
      border-radius: 4px;
    }
    h1 {
      margin-top: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      font-size: 0.9rem;
      word-break: break-all;
    }
    th {
      background: #eee;
    }
    .charts {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      justify-content: center;
      margin-bottom: 2rem;
    }
    .chart-container {
      width: 320px;
      background: #f9f9f9;
      padding: 1rem;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    @media (max-width: 768px) {
      .charts {
        flex-direction: column;
        align-items: center;
      }
      .chart-container {
        width: 90%;
        margin-bottom: 1rem;
      }
      table {
        font-size: 0.8rem;
      }
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header>
  <h1>FalconOne Logs Dashboard</h1>
</header>
<div class="container">

  <h2>User Agent Logs</h2>
  <div class="charts">
    <div class="chart-container">
      <canvas id="uaChart"></canvas>
    </div>
  </div>
  <table>
    <tr><th>Line</th></tr>
    <?php foreach ($userAgentLines as $uaLine): ?>
      <tr><td><?php echo htmlspecialchars($uaLine); ?></td></tr>
    <?php endforeach; ?>
  </table>

  <h2>Environment Logs</h2>
  <div class="charts">
    <div class="chart-container">
      <canvas id="envChart"></canvas>
    </div>
  </div>
  <table>
    <tr><th>Line</th></tr>
    <?php foreach ($envLines as $line): ?>
      <tr><td><?php echo htmlspecialchars($line); ?></td></tr>
    <?php endforeach; ?>
  </table>

  <h2>Geolocation Logs</h2>
  <div class="charts">
    <div class="chart-container">
      <canvas id="geoChart"></canvas>
    </div>
  </div>
  <table>
    <tr><th>Line</th></tr>
    <?php foreach ($geoLines as $line): ?>
      <tr><td><?php echo htmlspecialchars($line); ?></td></tr>
    <?php endforeach; ?>
  </table>

  <h2>Credentials Logs</h2>
  <div class="charts">
    <div class="chart-container">
      <canvas id="credChart"></canvas>
    </div>
  </div>
  <table>
    <tr><th>Line</th></tr>
    <?php foreach ($credLines as $line): ?>
      <tr><td><?php echo htmlspecialchars($line); ?></td></tr>
    <?php endforeach; ?>
  </table>

  <h2>Media Files</h2>
  <?php if (!empty($mediaFiles)): ?>
    <ul>
      <?php foreach ($mediaFiles as $mf): ?>
        <li>
          <?php echo htmlspecialchars($mf); ?>
          <!-- Optionally link to it: <a href="media/<?php echo rawurlencode($mf); ?>" target="_blank">View</a> -->
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>No media files found.</p>
  <?php endif; ?>

</div>

<script>
// Summaries for each log type
const uaData    = <?php echo json_encode($uaGrouped, JSON_PRETTY_PRINT); ?>;
const envData   = <?php echo json_encode($envGrouped, JSON_PRETTY_PRINT); ?>;
const geoData   = <?php echo json_encode($geoGrouped, JSON_PRETTY_PRINT); ?>;
const credData  = <?php echo json_encode($credGrouped, JSON_PRETTY_PRINT); ?>;

// Convert { '2025-01-01': count, ... } to chart arrays
function prepareChartData(dataObj) {
  const labels = Object.keys(dataObj).sort();
  const values = labels.map(k => dataObj[k]);
  return { labels, values };
}

function makeBarChart(ctxId, chartTitle, dataObj) {
  const ctx = document.getElementById(ctxId).getContext('2d');
  const prep = prepareChartData(dataObj);

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: prep.labels,
      datasets: [{
        label: chartTitle,
        data: prep.values,
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}

makeBarChart('uaChart', 'User Agent Logs', uaData);
makeBarChart('envChart', 'Environment Logs', envData);
makeBarChart('geoChart', 'Geolocation Logs', geoData);
makeBarChart('credChart', 'Credentials Logs', credData);
</script>
</body>
</html>
