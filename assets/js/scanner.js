const messageBox = document.getElementById("scanMessage");

function setMessage(text, good = false) {
    if (!messageBox) return;
    messageBox.textContent = text;
    messageBox.style.color = good ? "#26734d" : "#a33a3a";
}

function onScanSuccess(decodedText) {
    let parsed;

    try {
        parsed = JSON.parse(decodedText);
    } catch (e) {
        setMessage("Invalid QR code.");
        return;
    }

    if (!parsed.sessionId) {
        setMessage("Session ID missing in QR code.");
        return;
    }

    fetch("../attendance/mark.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            studentId: LOGGED_IN_STUDENT_ID,
            sessionId: parsed.sessionId
        })
    })
    .then(response => response.json())
    .then(data => {
        setMessage(data.message, data.success);

        if (data.success && window.html5QrCodeScanner) {
            window.html5QrCodeScanner.stop().catch(() => {});
        }
    })
    .catch(() => {
        setMessage("Failed to submit attendance.");
    });
}

window.addEventListener("load", () => {
    const readerId = "scanner-reader";

    if (document.getElementById(readerId)) {
        window.html5QrCodeScanner = new Html5Qrcode(readerId);
        window.html5QrCodeScanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            onScanSuccess
        ).catch(() => {
            setMessage("Unable to start camera scanner.");
        });
    }
});