<?php
session_start();
include("../config/db.php");
include("../libs/phpqrcode/qrlib.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "lecturer") {
    exit("Unauthorized");
}

$lecturerId = $_SESSION["user_id"];
$sessionId = uniqid("SES-");
$expiresAt = time() + 300; // 5 minutes

$stmt = $conn->prepare("INSERT INTO sessions (session_id, lecturer_id, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $sessionId, $lecturerId, $expiresAt);
$stmt->execute();

if (isset($_GET["format"]) && $_GET["format"] === "json") {
    header("Content-Type: application/json");
    echo json_encode([
        "sessionId" => $sessionId,
        "expiresAt" => $expiresAt,
        "qrUrl" => "generate_qr.php?session=" . urlencode($sessionId)
    ]);
    exit;
}

if (isset($_GET["session"])) {
    $existingSessionId = $_GET["session"];

    $stmt = $conn->prepare("SELECT session_id, expires_at FROM sessions WHERE session_id = ? AND lecturer_id = ? LIMIT 1");
    $stmt->bind_param("si", $existingSessionId, $lecturerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        $qrData = json_encode([
            "sessionId" => $row["session_id"],
            "expiresAt" => (int)$row["expires_at"]
        ]);

        header("Content-Type: image/png");
        QRcode::png($qrData, false, QR_ECLEVEL_L, 8);
        exit;
    }

    exit("Invalid session");
}

$qrData = json_encode([
    "sessionId" => $sessionId,
    "expiresAt" => $expiresAt
]);

header("Content-Type: image/png");
QRcode::png($qrData, false, QR_ECLEVEL_L, 8);
?>