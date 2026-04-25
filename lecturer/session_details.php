<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'lecturer') {
    header("Location: ../index.html");
    exit;
}

$lecturerId = $_SESSION['user_id'];
$sessionId = $_GET['session_id'] ?? '';

if (empty($sessionId)) {
    die("Session ID is required.");
}

// First confirm that this session belongs to the logged-in lecturer
$sessionSql = "
    SELECT session_id, created_at, expires_at
    FROM sessions
    WHERE session_id = ? AND lecturer_id = ?
    LIMIT 1
";
$sessionStmt = $conn->prepare($sessionSql);
$sessionStmt->bind_param("si", $sessionId, $lecturerId);
$sessionStmt->execute();
$sessionResult = $sessionStmt->get_result();

if ($sessionResult->num_rows !== 1) {
    die("Session not found or access denied.");
}

$session = $sessionResult->fetch_assoc();

// Fetch all students who attended this session
$studentsSql = "
    SELECT 
        u.first_name,
        u.last_name,
        u.number,
        u.gender,
        a.scanned_at
    FROM attendance a
    INNER JOIN users u ON a.student_id = u.id
    WHERE a.session_id = ?
    ORDER BY a.scanned_at DESC
";
$studentsStmt = $conn->prepare($studentsSql);
$studentsStmt->bind_param("s", $sessionId);
$studentsStmt->execute();
$studentsResult = $studentsStmt->get_result();

$totalStudents = $studentsResult->num_rows;
$isLive = time() <= (int)$session['expires_at'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Details</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">N</div>
            <div>
                <h1>NUST Attendance</h1>
                <p>Session Attendance Details</p>
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
                <p class="eyebrow">Session Overview</p>
                <h2>Attendance for <?php echo htmlspecialchars($session['session_id']); ?></h2>
                <p class="hero-copy">
                    This page shows all students who successfully scanned the QR code for this session.
                </p>

                <div class="hero-actions">
                    <a href="attendance.php" class="secondary-btn">Back to Sessions</a>
                    <a href="dashboard.php" class="primary-btn">Back to Dashboard</a>
                </div>
            </div>

            <div class="hero-status-card">
                <p class="status-label">Session Summary</p>
                <div class="status-badge"><?php echo $totalStudents; ?> Students</div>
                <p class="status-note">
                    Status:
                    <?php echo $isLive ? "Live session" : "Expired session"; ?>
                </p>
            </div>
        </section>

        <section class="content-grid">
            <article class="panel-card">
                <div class="panel-header">
                    <div>
                        <p class="panel-kicker">Session Info</p>
                        <h3>Details</h3>
                    </div>
                </div>

                <ul class="summary-list">
                    <li>
                        <span>Session ID</span>
                        <strong><?php echo htmlspecialchars($session['session_id']); ?></strong>
                    </li>
                    <li>
                        <span>Date Created</span>
                        <strong><?php echo htmlspecialchars($session['created_at']); ?></strong>
                    </li>
                    <li>
                        <span>Expires At</span>
                        <strong><?php echo date("Y-m-d H:i:s", (int)$session['expires_at']); ?></strong>
                    </li>
                    <li>
                        <span>Status</span>
                        <strong class="<?php echo $isLive ? '' : 'warning-text'; ?>">
                            <?php echo $isLive ? "Live" : "Expired"; ?>
                        </strong>
                    </li>
                </ul>
            </article>

            <article class="panel-card">
                <div class="panel-header">
                    <div>
                        <p class="panel-kicker">Attendance Count</p>
                        <h3>Students Present</h3>
                    </div>
                </div>

                <div style="font-size: 42px; font-weight: 700; color: var(--navy);">
                    <?php echo $totalStudents; ?>
                </div>
                <p style="margin-top: 8px; color: var(--muted);">
                    Total students who scanned this session.
                </p>
            </article>
        </section>

        <section class="panel-card">
            <div class="panel-header">
                <div>
                    <p class="panel-kicker">Students</p>
                    <h3>Attended Students</h3>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Student Number</th>
                            <th>Gender</th>
                            <th>Scanned At</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($studentsResult->num_rows > 0): ?>
                            <?php while ($student = $studentsResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['number']); ?></td>
                                    <td><?php echo htmlspecialchars($student['gender']); ?></td>
                                    <td><?php echo date("Y-m-d H:i:s", (int)$student['scanned_at']); ?></td>
                                    <td><span class="table-badge present">Present</span></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No students have attended this session yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>