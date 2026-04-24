<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'lecturer') {
    header("Location: ../index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">N</div>
            <div>
                <h1>NUST Attendance</h1>
                <p>Lecturer Dashboard</p>
            </div>
        </div>

        <div class="topbar-right">
            <div class="user-chip">
                <span class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                </span>
                <div>
                    <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                    <small>Lecturer</small>
                </div>
            </div>

            <a href="../auth/logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <main class="dashboard-shell">
        <section class="hero-card">
            <div class="hero-text">
                <p class="eyebrow">Session Control</p>
                <h2>Generate a QR code for attendance</h2>
                <p class="hero-copy">
                    Display the QR code to students during class. The QR expires automatically after 5 minutes.
                </p>

                <div class="hero-actions">
                    <button id="generateQrBtn" class="primary-btn">Generate QR</button>
                    <a href="attendance.php" class="secondary-btn">View Attendance Records</a>
                </div>
            </div>

            <div class="hero-status-card">
    <p class="status-label">QR Status</p>
    <div class="status-badge" id="qrStatusBadge">Waiting</div>
    <p class="status-note" id="qrStatusText">Generate a QR code to begin a live attendance session.</p>
</div>
        </section>

        <section class="content-grid">
            <article class="panel-card">
                <div class="panel-header">
                    <div>
                        <p class="panel-kicker">Current QR</p>
                        <h3>Attendance QR Code</h3>
                    </div>
                    <span class="panel-tag">5 min expiry</span>
                </div>

               <div class="qr-box">
    <img id="qrImage" src="" alt="Attendance QR Code" style="display:none;">
    <p id="qrPlaceholder">No active QR session yet.</p>
</div>
            </article>

            <article class="panel-card">
                <div class="panel-header">
                    <div>
                        <p class="panel-kicker">Session Details</p>
                        <h3>Live Session Info</h3>
                    </div>
                </div>

                <ul class="summary-list">
    <li>
        <span>Session ID</span>
        <strong id="sessionIdText">—</strong>
    </li>
    <li>
        <span>Expires In</span>
        <strong id="countdownText" class="warning-text">—</strong>
    </li>
    <li>
        <span>Status</span>
        <strong id="sessionLiveText">No active session</strong>
    </li>
</ul>
            </article>
        </section>
    </main>

    <script>
    let countdownInterval = null;

    function startCountdown(expiresAt) {
        const countdownText = document.getElementById("countdownText");
        const sessionLiveText = document.getElementById("sessionLiveText");
        const qrStatusBadge = document.getElementById("qrStatusBadge");
        const qrStatusText = document.getElementById("qrStatusText");

        if (countdownInterval) {
            clearInterval(countdownInterval);
        }

        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            let remaining = expiresAt - now;

            if (remaining <= 0) {
                clearInterval(countdownInterval);
                countdownText.textContent = "Expired";
                sessionLiveText.textContent = "Session expired";
                qrStatusBadge.textContent = "Expired";
                qrStatusText.textContent = "This QR code is no longer valid. Generate a new one.";
                return;
            }

            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;

            countdownText.textContent =
                String(minutes).padStart(2, "0") + ":" + String(seconds).padStart(2, "0");
            sessionLiveText.textContent = "Live session";
            qrStatusBadge.textContent = "Live";
            qrStatusText.textContent = "Students can scan this QR code while the timer is active.";
        }

        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);
    }

    function generateQrSession() {
        fetch("generate_qr.php?format=json")
            .then(response => response.json())
            .then(data => {
                const qrImage = document.getElementById("qrImage");
                const qrPlaceholder = document.getElementById("qrPlaceholder");
                const sessionIdText = document.getElementById("sessionIdText");

                qrImage.src = data.qrUrl + "&t=" + new Date().getTime();
                qrImage.style.display = "block";
                qrPlaceholder.style.display = "none";

                sessionIdText.textContent = data.sessionId;

                startCountdown(data.expiresAt);
            })
            .catch(() => {
                alert("Failed to generate QR code.");
            });
    }

    document.getElementById("generateQrBtn").addEventListener("click", generateQrSession);
</script>
</body>
</html>