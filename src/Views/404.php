<?php
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/404.css">
</head>

<body css="not-found">
    <div class="container">
        <h1>404</h1>
        <p>Oops! The page you are looking for does not exist.</p>
        <a href="/">Go Back Home</a>
    </div>
</body>

</html>