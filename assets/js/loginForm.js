// Firebase used to connect Google login
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import {
    getAuth,
    GoogleAuthProvider,
    signInWithPopup
} from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

const firebaseConfig = {
    apiKey: "AIzaSyDuHGWuk28wzN3BagOE4Et8xOXaedU8x5o",
    authDomain: "campus-trips.firebaseapp.com",
    projectId: "campus-trips",
    storageBucket: "campus-trips.firebasestorage.app",
    messagingSenderId: "684478580677",
    appId: "1:684478580677:web:019fe5dafe14baba066dac",
    measurementId: "G-W998Z5HQKM"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

const dashboardPath = "/AUT-Web-Based-Travel-Planner/Pages/userDashboard/Dashboard.php";
const sessionPath = "/AUT-Web-Based-Travel-Planner/assets/api/auth/firebaseSession.php";

function showMessage(message) {
    const loginMessage = document.getElementById("loginMessage");

    if (loginMessage) {
        loginMessage.textContent = message;
    }
}

function createPhpSession(name, email) {
    fetch(sessionPath, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name: name,
            email: email
        })
    })
        .then(response => response.text())
        .then(data => {
            console.log("PHP session response:", data);

            if (data.trim() === "success") {
                window.location.href = dashboardPath;
            } else {
                showMessage("Session could not be created. Please try again.");
            }
        })
        .catch(error => {
            console.log("Session error:", error);
            showMessage("Login session failed. Please try again.");
        });
}

// Google login
window.loginWithGoogle = function () {
    const provider = new GoogleAuthProvider();

    signInWithPopup(auth, provider)
        .then((result) => {
            const user = result.user;

            showMessage("Google login successful.");

            createPhpSession(user.displayName, user.email);
        })
        .catch((error) => {
            console.log("Google error code:", error.code);
            console.log("Google error message:", error.message);

            if (
                error.code === "auth/popup-closed-by-user" ||
                error.code === "auth/cancelled-popup-request"
            ) {
                showMessage("Google login was cancelled. Please try again or use email and password.");
            } else if (error.code === "auth/network-request-failed") {
                showMessage("Google login is currently unavailable. Please try again later or use email and password.");
            } else {
                showMessage("Google login failed. Please try again later or use email and password.");
            }
        });
};

// Apple login demo
window.loginWithApple = function () {
    const confirmLogin = confirm("Do you want to continue with Apple login demo?");

    if (!confirmLogin) {
        showMessage("Apple login was cancelled. Please try again or use email and password.");
        return;
    }

    showMessage("Apple login successful.");

    createPhpSession("Apple User", "apple_user@icloud.com");
};

// AUT login demo
window.loginWithAUT = function () {
    const confirmLogin = confirm("Do you want to continue with AUT login demo?");

    if (!confirmLogin) {
        showMessage("AUT login was cancelled. Please try again or use email and password.");
        return;
    }

    showMessage("AUT login successful.");

    createPhpSession("AUT Student", "student@aut.ac.nz");
};