<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->renderSection('title') ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            important: true,
            theme: {
                extend: {
                    colors: {
                        primary: '#FFD600',
                        'primary-hover': '#FFC000',
                    }
                }
            }
        }
    </script>
    <?= $this->renderSection('pageStyles') ?>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans antialiased text-gray-900">

    <main role="main" class="w-full max-w-md px-4">
        <?= $this->renderSection('main') ?>
    </main>

    <?= $this->renderSection('pageScripts') ?>
</body>
</html>
