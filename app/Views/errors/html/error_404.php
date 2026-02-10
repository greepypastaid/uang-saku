<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= lang('Errors.pageNotFound') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FFD600',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans">
    <div class="max-w-md w-full bg-white shadow-lg rounded-2xl p-8 text-center mx-4">
        <h1 class="text-9xl font-bold text-gray-200">404</h1>
        
        <div class="mt-[-2rem] relative z-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Not Found</h2>
            <p class="text-gray-500 mb-6">
                <?php if (ENVIRONMENT !== 'production') : ?>
                    <?= nl2br(esc($message)) ?>
                <?php else : ?>
                    <?= lang('Errors.sorryCannotFind') ?>
                <?php endif; ?>
            </p>
            
            <a href="<?= url_to('/') ?>" class="inline-block bg-primary hover:bg-yellow-500 text-black font-semibold py-3 px-6 rounded-full transition duration-300 shadow-md">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
