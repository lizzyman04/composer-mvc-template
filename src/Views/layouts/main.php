<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A lightweight yet powerful MVC template for PHP projects using Composer.">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Composer MVC Template'; ?></title>

    <!-- Tailwind CSS Play CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <?= $content ?>
</body>

</html>