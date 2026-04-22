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
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">N</div>
            <div>
                <h1>NUST Attendance</h1>
                <p>Student Dashboard</p>
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
        <section class="hero-card">
            <div class="hero-text">
                <p class="eyebrow">Quick Action</p>
                <h2>Scan your class QR code</h2>
                <p class="hero-copy">
                    Use the scanner to mark your attendance for the current lesson.
                </p>

                <div class="hero-actions">
    <a href="scan.php" class="primary-btn">Open Scanner</a>
    <a href="history.php" class="secondary-btn">View History</a>
</div>
            </div>

            <div class="hero-status-card">
                <p class="status-label">Today’s Status</p>
                <div class="status-badge">Ready to Scan</div>
                <p class="status-note">Scan once per active session.</p>
            </div>
        </section>

        <section class="content-grid">
            <article class="panel-card">
                <div class="panel-header">
                    <div>
                        <p class="panel-kicker">Scanner</p>
                        <h3>Attendance Scanner</h3>
                    </div>
                    <span class="panel-tag">Active</span>
                </div>

                <div class="scanner-box">
                    QR Scanner available on the next page
                </div>

                <div style="margin-top:16px;">
                    <a href="scan.php" class="primary-btn">Start Scanning</a>
                </div>
            </article>

            <article class="panel-card">
                <div class="panel-header">
                    <div>
                        <p class="panel-kicker">Summary</p>
                        <h3>Attendance Overview</h3>
                    </div>
                </div>

                <ul class="summary-list">
    <li>
        <span>Status</span>
        <strong>Active Account</strong>
    </li>
    <li>
        <span>Role</span>
        <strong>Student</strong>
    </li>
    <li>
        <span>History</span>
        <strong><a href="history.php" class="link-btn">View attendance records</a></strong>
    </li>
</ul>
            </article>
        </section>
    </main>
</body>
</html>
