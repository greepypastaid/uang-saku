<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('img/UangSakuLogo.png') ?>" type="image/x-icon">
    <title>Uang Saku - Atur Keuangan Dengan Mudah!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Bootstrap JS only for modal/collapse/offcanvas behavior -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    <?= $this->include('layouts/partials/navbar') ?>

    <main class="flex-grow">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('layouts/partials/footer') ?>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
        crossorigin="anonymous"></script>
    <script>
        function showAlert(type, title, text) {
            const icon = type === 'success' ? 'success' : 'error';
            Swal.fire({ icon, title: title || (type === 'success' ? 'Berhasil' : 'Gagal'), text: text || '' });
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>