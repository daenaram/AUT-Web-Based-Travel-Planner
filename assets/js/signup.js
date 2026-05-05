// Close modal function
function closeModal() {
    document.getElementById('error-modal').style.display = 'none';
    window.history.replaceState({}, document.title, window.location.pathname);
}

// Close modal when clicking outside the modal box
document.getElementById('error-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// Error messages configuration
const errorMessages = {
    'password_mismatch': { title: 'Password Mismatch', message: 'The passwords you entered do not match. Please try again.' },
    'email_taken': { title: 'Email Already Registered', message: 'This email is already associated with an account. Please use a different email or log in instead.' },
    'username_taken': { title: 'Username Already Taken', message: 'This username is already in use. Please choose a different one.' },
    'password_too_short': { title: 'Password Too Short', message: 'Your password must be at least 8 characters long.' },
    'all_fields_required': { title: 'Missing Fields', message: 'Please fill in all required fields before submitting.' },
    'server_error': { title: 'Server Error', message: 'Something went wrong on our end. Please try again later.' }
};

// Display error message
function displayError(errorType) {
    const errorInfo = errorMessages[errorType];
    if (errorInfo) {
        document.getElementById('error-modal').style.display = 'flex';
        document.querySelector('.modal-box h3').textContent = errorInfo.title;
        document.querySelector('.modal-box p').textContent = errorInfo.message;
    }
}

// Check for error in URL and display
const error = new URLSearchParams(window.location.search).get('error');
if (error) displayError(error);