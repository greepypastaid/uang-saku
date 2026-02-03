<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
        background-size: 20px 20px;
    }
    
    .card-register {
        border: none;
        border-radius: 1.5rem;
        transition: transform 0.3s ease;
    }

    .form-control:focus {
        border-color: #FFD600;
        box-shadow: 0 0 0 0.25rem rgba(255, 214, 0, 0.25);
    }

    .btn-auth {
        background-color: #FFD600;
        color: #000000;
        font-weight: 600;
        border: none;
        border-radius: 50px;
        padding: 12px 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(255, 214, 0, 0.3);
    }

    .btn-auth:hover {
        background-color: #ffca00;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(255, 214, 0, 0.4);
    }

    .auth-link {
        color: #000;
        font-weight: 600;
        text-decoration: none;
        position: relative;
    }
    
    .auth-link::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: #FFD600;
        transform-origin: bottom right;
        transition: transform 0.25s ease-out;
    }
    
    .auth-link:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
</style>

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                
                <div class="card card-register shadow-lg p-4 p-md-5 bg-white">
                    <div class="card-body">
                        
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-1">Buat Akun Baru</h2>
                            <p class="text-muted small">Mulai kelola keuanganmu dengan mudah</p>
                        </div>

                        <?php if (session('error') !== null): ?>
                            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i> <?= esc(session('error')) ?>
                            </div>
                        <?php elseif (session('errors') !== null): ?>
                            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 fade show" role="alert">
                                <ul class="mb-0 ps-3">
                                    <?php if (is_array(session('errors'))): ?>
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <li><?= esc(session('errors')) ?></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <form action="<?= url_to('register') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control form-control-lg bg-light border-0" id="floatingEmailInput" name="email" 
                                    inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" 
                                    value="<?= old('email') ?>" required>
                                <label for="floatingEmailInput" class="text-muted"><i class="bi bi-envelope me-2"></i><?= lang('Auth.email') ?></label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-lg bg-light border-0" id="floatingUsernameInput" name="username" 
                                    inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>"
                                    value="<?= old('username') ?>" required>
                                <label for="floatingUsernameInput" class="text-muted"><i class="bi bi-person me-2"></i><?= lang('Auth.username') ?></label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control form-control-lg bg-light border-0" id="floatingPasswordInput" name="password"
                                    inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>"
                                    required>
                                <label for="floatingPasswordInput" class="text-muted"><i class="bi bi-lock me-2"></i><?= lang('Auth.password') ?></label>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control form-control-lg bg-light border-0" id="floatingPasswordConfirmInput"
                                    name="password_confirm" inputmode="text" autocomplete="new-password"
                                    placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                                <label for="floatingPasswordConfirmInput" class="text-muted"><i class="bi bi-check-circle me-2"></i><?= lang('Auth.passwordConfirm') ?></label>
                            </div>

                            <div class="d-grid gap-2 mb-4">
                                <button type="submit" class="btn btn-auth btn-lg">
                                    Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    <?= lang('Auth.haveAccount') ?> 
                                    <a href="<?= url_to('login') ?>" class="auth-link ms-1"><?= lang('Auth.login') ?></a>
                                </p>
                            </div>

                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4 text-muted small">
                    &copy; <?= date('Y') ?> Uang Saku App. All rights reserved.
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>