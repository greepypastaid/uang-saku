<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-gray-50">
    <?= $this->include('layouts/partials/navbar') ?>

    <main class="min-h-screen">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('layouts/partials/footer') ?>
</body>

</html>