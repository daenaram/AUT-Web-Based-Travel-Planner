//Firebase used to connect Google log in
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.12.1/firebase-app.js";
import {
    getAuth,
    GoogleAuthProvider,
    OAuthProvider,
    signInWithPopup
} from "https://www.gstatic.com/firebasejs/12.12.1/firebase-auth.js";

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

//To show the message on the screen
function showMessage(message) {
    document.getElementById("loginMessage").textContent = message;
}

//Login for Google
window.loginWithGoogle = function () {
    const provider = new GoogleAuthProvider();

    signInWithPopup(auth, provider)
        .then((result) => {
            showMessage("Google login successful!");
            console.log(result.user);
            window.location.href = "../userDashboard/dashboard.html";
        })
        .catch((error) => {
            console.log(error);

            if (error.code === "Authentication popup closed by user" || error.code === "authentication popup request cancelled") {
                showMessage("Google login was cancelled. Please try again or use email and password.");
            }
            else if (error.code === "Network request failed") {
                showMessage("Google login is currently unavailable. Please try again later or use email and password.");
            }
            else {
                showMessage("Google login failed. Please try again later or use email and password.");
            }
        });
};


//Login for Apple {demo}
window.loginWithApple = function () {
    const confirmLogin = confirm("Continue with Apple login demo version.");

    if (!confirmLogin) {
        showMessage("Apple login was cancelled. Try again with email and password");
        return;
    }
    try {
        showMessage("Apple login successful (demo).");
        window.location.href = "../userDashboard/dashboard.html";
    } catch (error) {
        showMessage("Apple login is currently unavailable. Please try again later or use email and password.");
    }
};


//Login for AUT {demo}
window.loginWithAUT = function () {
    const confirmLogin = confirm("Do you want to continue with AUT login?");

    if (!confirmLogin) {
        showMessage("AUT login was cancelled. Please try again or use email and password.");
        return;
    }

    showMessage("AUT login successful.");
    window.location.href = "../userDashboard/dashboard.html";
};