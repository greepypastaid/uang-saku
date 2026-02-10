<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden transform transition-all duration-300 hover:scale-[1.01]">
    <div class="p-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Buat Akun Baru</h2>
            <p class="text-gray-500 text-sm">Mulai kelola keuanganmu dengan mudah</p>
        </div>

        <?php if (session('error') !== null): ?>
            <div class="bg-red-50 border border-red-100 text-red-600 rounded-lg p-4 mb-6 flex items-start text-sm" role="alert">
                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?= session('error') ?></span>
            </div>
        <?php elseif (session('errors') !== null): ?>
            <div class="bg-red-50 border border-red-100 text-red-600 rounded-lg p-4 mb-6 text-sm" role="alert">
                <ul class="list-disc list-inside space-y-1">
                    <?php if (is_array(session('errors'))): ?>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    <?php else: ?>
                        <li><?= session('errors') ?></li>
                    <?php endif ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="<?= url_to('register') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>

            <!-- Email -->
            <div class="relative">
                <input type="email" class="peer w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                    id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                <label for="floatingEmailInput" class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-primary peer-focus:bg-white peer-focus:px-1 pointer-events-none">
                    <?= lang('Auth.email') ?>
                </label>
            </div>

            <!-- Username -->
            <div class="relative">
                <input type="text" class="peer w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                    id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                <label for="floatingUsernameInput" class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-primary peer-focus:bg-white peer-focus:px-1 pointer-events-none">
                    <?= lang('Auth.username') ?>
                </label>
            </div>

            <!-- Password -->
            <div class="relative">
                <input type="password" class="peer w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                    id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
                <label for="floatingPasswordInput" class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-primary peer-focus:bg-white peer-focus:px-1 pointer-events-none">
                    <?= lang('Auth.password') ?>
                </label>
            </div>

            <!-- Password Confirm -->
            <div class="relative">
                <input type="password" class="peer w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                    id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                <label for="floatingPasswordConfirmInput" class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-primary peer-focus:bg-white peer-focus:px-1 pointer-events-none">
                    <?= lang('Auth.passwordConfirm') ?>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-black font-bold py-3 px-4 rounded-full shadow-lg shadow-yellow-400/30 transform transition-all duration-200 hover:-translate-y-0.5 hover:shadow-yellow-400/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <?= lang('Auth.register') ?>
            </button>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-gray-500 text-sm">
                    <?= lang('Auth.haveAccount') ?> 
                    <a href="<?= url_to('login') ?>" class="text-black font-semibold hover:text-primary hover:underline ml-1 transition duration-150 ease-in-out">
                        <?= lang('Auth.login') ?>
                    </a>
                </p>
            </div>

        </form>
    </div>
</div>

<div class="text-center mt-8 text-gray-400 text-xs">
    &copy; <?= date('Y') ?> Uang Saku App. All rights reserved.
</div>

<?= $this->endSection() ?>
