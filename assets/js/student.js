
// assets/student.js - client-side scanner script
// Expects `window.STUDENT_ID` to be set by the server page (scan.php)

const html5QrCode = new Html5Qrcode("reader");

function onScanSuccess(decodedText) {
    let data;
    try {
        data = JSON.parse(decodedText);
    } catch (e) {
        console.error('Invalid QR payload:', e, decodedText);
        alert('Scanned QR is invalid.');
        return;
    }

    const studentId = (typeof window.STUDENT_ID !== 'undefined') ? window.STUDENT_ID : null;
    if (!studentId) {
        console.error('STUDENT_ID not provided on page.');
        alert('Student not authenticated. Please log in.');
        return;
    }

    fetch("../attendance/mark.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            studentId: studentId,
            sessionId: data.sessionId
        })
    })
    .then(res => res.text())
    .then(msg => alert(msg))
    .catch(err => {
        console.error('Fetch error:', err);
        alert('An error occurred while marking attendance.');
    });
}

html5QrCode.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 250 },
    onScanSuccess
);