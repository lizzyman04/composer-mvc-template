<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <script src="<?= BASE_URL ?>assets/js/auth.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/auth.css">
</head>

<body css="auth">
    <div class="auth-container">
        <h1>Authentication</h1>

        <div id="login-form" class="auth-form">
            <h2>Login</h2>
            <form id="loginForm">
                <input type="text" name="email" placeholder="Email or Phone" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit" name="action" value="login">Login</button>
            </form>
        </div>

        <div id="register-form" class="auth-form">
            <h2>Register</h2>
            <form id="registerForm">
                <input type="text" name="name" placeholder="Name" required><br>
                <input type="text" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="text" name="address" placeholder="Address (optional)"><br>
                <button type="submit" name="action" value="register">Register</button>
            </form>
        </div>
    </div>

</body>
</html>