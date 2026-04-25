<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">N</div>
            <div>
                <h1>NUST Attendance</h1>
                <p>Scan Attendance QR</p>
            </div>
        </div>

        <div class="topbar-right">
            <div class="user-chip">
                <span class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                </span>
                <div>
                    <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                    <small>Student</small>
                </div>
            </div>

            <a href="../auth/logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <main class="dashboard-shell">
        <section class="panel-card">
            <div class="panel-header">
                <div>
                    <p class="panel-kicker">Live Scanner</p>
                    <h3>Scan the lecturer's QR code</h3>
                </div>
                <a href="dashboard.php" class="link-btn">Back to dashboard</a>
            </div>

            <div id="scanner-reader" class="scanner-box"></div>
            <div id="scanMessage" style="margin-top:16px; font-weight:600;"></div>
        </section>
    </main>

    <script>
        const LOGGED_IN_STUDENT_ID = <?php echo (int)$_SESSION['user_id']; ?>;
    </script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="../assets/js/scanner.js"></script>
</body>
</html>
