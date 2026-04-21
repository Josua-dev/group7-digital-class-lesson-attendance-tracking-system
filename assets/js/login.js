function showMessage(message, isError = true) {
    const box = document.getElementById("messageBox");
    if (!box) return;

    box.textContent = message;
    box.classList.remove("hidden");
    box.classList.toggle("error", isError);
    box.classList.toggle("success", !isError);
}

function login() {
    const number = document.getElementById("number").value.trim();
    const password = document.getElementById("password").value.trim();

    if (!number || !password) {
        showMessage("Please enter your number and password.");
        return;
    }

    fetch("auth/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ number, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.role === "lecturer") {
                window.location.href = "lecturer/dashboard.php";
            } else if (data.role === "student") {
                window.location.href = "student/dashboard.php";
            } else {
                showMessage("Unknown user role.");
            }
        } else {
            showMessage(data.message || "Login failed.");
        }
    })
    .catch(() => {
        showMessage("Something went wrong. Please try again.");
    });
}