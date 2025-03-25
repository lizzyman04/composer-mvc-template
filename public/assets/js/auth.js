document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const email = loginForm.querySelector('input[name="email"]').value;
        const password = loginForm.querySelector('input[name="password"]').value;

        if (email === '' || password === '') {
            alert("Please fill in all fields for login.");
            return;
        }

        fetch('/auth_action', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'login',
                email: email,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            alert('Error during login');
        });
    });

    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const name = registerForm.querySelector('input[name="name"]').value;
        const email = registerForm.querySelector('input[name="email"]').value;
        const password = registerForm.querySelector('input[name="password"]').value;

        if (name === '' || email === '' || password === '') {
            alert("Please fill in all fields for registration.");
            return;
        }

        fetch('/auth_action', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'register',
                name: name,
                email: email,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            alert('Error during registration');
        });
    });
});
