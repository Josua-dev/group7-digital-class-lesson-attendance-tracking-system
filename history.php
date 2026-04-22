<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../index.html");
    exit;
}

$studentId = $_SESSION['user_id'];

$sql = "
    SELECT 
        a.session_id,
        a.scanned_at,
        s.created_at,
        s.expires_at
    FROM attendance a
    INNER JOIN sessions s ON a.session_id = s.session_id
    WHERE a.student_id = ?
    ORDER BY a.scanned_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();

$totalAttended = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance History</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">N</div>
            <div>
                <h1>NUST Attendance</h1>
                <p>Student Attendance History</p>
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
                <p class="eyebrow">History</p>
                <h2>Your attendance records</h2>
                <p class="hero-copy">
                    Review all sessions you have successfully scanned and recorded.
                </p>

                <div class="hero-actions">
                    <a href="dashboard.php" class="secondary-btn">Back to Dashboard</a>
                    <a href="scan.php" class="primary-btn">Scan New QR</a>
                </div>
            </div>

            <div class="hero-status-card">
                <p class="status-label">Summary</p>
                <div class="status-badge"><?php echo $totalAttended; ?> Recorded</div>
                <p class="status-note">These are all attendance entries linked to your account.</p>
            </div>
        </section>

        <section class="panel-card">
            <div class="panel-header">
                <div>
                    <p class="panel-kicker">Attendance Log</p>
                    <h3>My Attendance History</h3>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Session ID</th>
                            <th>Session Created</th>
                            <th>Scanned At</th>
                            <th>Session Expiry</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php mysqli_data_seek($result, 0); ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['session_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    <td><?php echo date("Y-m-d H:i:s", (int)$row['scanned_at']); ?></td>
                                    <td><?php echo date("Y-m-d H:i:s", (int)$row['expires_at']); ?></td>
                                    <td>
                                        <span class="table-badge present">Present</span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No attendance records found yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
