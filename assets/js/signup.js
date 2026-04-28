function closeModal() {
    document.getElementById('error-modal').style.display = 'none';
    window.history.replaceState({}, document.title, window.location.pathname);
}

const params = new URLSearchParams(window.location.search);
const error = params.get('error');

if (error === 'email_taken') {
    document.getElementById('error-modal').style.display = 'flex';
} else if (error === 'username_taken') {
    document.getElementById('error-modal').style.display = 'flex';
    document.querySelector('.modal-box h3').textContent = 'Username Already Taken';
    document.querySelector('.modal-box p').textContent = 'This username is already in use. Please choose a different one.';
} else if (error === 'password_too_short') {
    document.getElementById('error-modal').style.display = 'flex';
    document.querySelector('.modal-box h3').textContent = 'Password Too Short';
    document.querySelector('.modal-box p').textContent = 'Your password must be at least 8 characters long.';
} else if (error === 'all_fields_required') {
    document.getElementById('error-modal').style.display = 'flex';
    document.querySelector('.modal-box h3').textContent = 'Missing Fields';
    document.querySelector('.modal-box p').textContent = 'Please fill in all required fields before submitting.';
} else if (error === 'server_error') {
    document.getElementById('error-modal').style.display = 'flex';
    document.querySelector('.modal-box h3').textContent = 'Server Error';
    document.querySelector('.modal-box p').textContent = 'Something went wrong on our end. Please try again later.';
}