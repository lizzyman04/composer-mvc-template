$(document).ready(function () {
    // Cache selectors for performance
    const $loginForm = $('#loginForm');
    const $registerForm = $('#registerForm');
    const $errorContainer = $('<div class="fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg bg-red-100 text-red-700 hidden"></div>').appendTo('body');
    const $successContainer = $('<div class="fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg bg-green-100 text-green-700 hidden"></div>').appendTo('body');

    // Email validation regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Password strength check (at least 8 chars, 1 letter, 1 number)
    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

    // Function to show notification
    function showNotification($container, message) {
        $container.text(message).removeClass('hidden').fadeIn(300);
        setTimeout(() => $container.fadeOut(300, () => $container.addClass('hidden')), 3000);
    }

    // Login form submission
    $loginForm.on('submit', function (e) {
        e.preventDefault();

        const email = $('input[name="email"]', this).val().trim();
        const password = $('input[name="password"]', this).val();

        // Client-side validation
        if (!email || !password) {
            showNotification($errorContainer, 'Please fill in all fields for login.');
            return;
        }
        if (!emailRegex.test(email)) {
            showNotification($errorContainer, 'Please enter a valid email address.');
            return;
        }

        $.ajax({
            url: '/auth_action',
            method: 'POST',
            data: $(this).serialize() + '&action=login',
            dataType: 'json',
            beforeSend: function () {
                $loginForm.find('button').prop('disabled', true).text('Logging in...');
            },
            success: function (data) {
                if (data.success) {
                    showNotification($successContainer, 'Login successful! Redirecting...');
                    setTimeout(() => window.location.href = data.redirect, 1000);
                } else {
                    showNotification($errorContainer, data.error || 'Login failed.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Login error:', textStatus, errorThrown);
                showNotification($errorContainer, 'An error occurred during login.');
            },
            complete: function () {
                $loginForm.find('button').prop('disabled', false).text('Login');
            }
        });
    });

    // Register form submission
    $registerForm.on('submit', function (e) {
        e.preventDefault();

        const name = $('input[name="name"]', this).val().trim();
        const email = $('input[name="email"]', this).val().trim();
        const password = $('input[name="password"]', this).val();
        const address = $('input[name="address"]', this).val().trim();

        // Client-side validation
        if (!name || !email || !password) {
            showNotification($errorContainer, 'Please fill in all required fields for registration.');
            return;
        }
        if (!emailRegex.test(email)) {
            showNotification($errorContainer, 'Please enter a valid email address.');
            return;
        }
        if (!passwordRegex.test(password)) {
            showNotification($errorContainer, 'Password must be at least 8 characters long with at least one letter and one number.');
            return;
        }

        $.ajax({
            url: '/auth_action',
            method: 'POST',
            data: $(this).serialize() + '&action=register',
            dataType: 'json',
            beforeSend: function () {
                $registerForm.find('button').prop('disabled', true).text('Registering...');
            },
            success: function (data) {
                if (data.success) {
                    showNotification($successContainer, 'Registration successful! Redirecting...');
                    setTimeout(() => window.location.href = data.redirect, 1000);
                } else {
                    showNotification($errorContainer, data.error || 'Registration failed.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Registration error:', textStatus, errorThrown);
                showNotification($errorContainer, 'An error occurred during registration.');
            },
            complete: function () {
                $registerForm.find('button').prop('disabled', false).text('Register');
            }
        });
    });
});