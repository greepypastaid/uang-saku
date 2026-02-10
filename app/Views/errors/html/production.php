<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <title><?= lang('Errors.whoops') ?></title>
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
        <div class="mb-6 text-red-500">
            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= lang('Errors.whoops') ?></h1>
        
        <p class="text-gray-500 mb-6"><?= lang('Errors.weHitASnag') ?></p>
        
        <a href="<?= url_to('/') ?>" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-full transition duration-300">
            Coba Lagi
        </a>
    </div>
</body>
</html>
