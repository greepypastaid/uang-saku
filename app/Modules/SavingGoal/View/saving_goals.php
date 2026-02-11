<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1 flex items-center gap-2"><i data-lucide="piggy-bank" class="w-6 h-6 text-emerald-500"></i> Saving Goals</h1>
            <p class="text-xs text-gray-500 font-medium">Kelola target tabunganmu untuk meraih impian finansial.</p>
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <button type="button" id="btn-auto-allocate" class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-amber-400 to-orange-400 hover:from-amber-500 hover:to-orange-500 text-white font-bold rounded-2xl shadow-lg shadow-amber-200 hover:shadow-xl transition-all text-sm">
                <i data-lucide="zap" class="mr-2 w-4 h-4"></i> Auto-Allocate
            </button>
            <button type="button" id="btn-tambah-goal" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-[#2d5a3f] to-[#3b7a57] hover:from-[#1a3a2a] hover:to-[#2d5a3f] text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:shadow-xl transition-all text-sm">
                <i data-lucide="plus" class="mr-2 w-4 h-4"></i> Tambah Goal
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="target" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full">Active</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Goal Aktif</p>
            <h3 class="text-xl font-extrabold text-gray-900 mt-1" id="active-goals-count"><?= count(array_filter($goals, fn($g) => $g['status'] === 'active')) ?></h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="piggy-bank" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">Total</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Terkumpul</p>
            <h3 class="text-xl font-extrabold text-emerald-600 mt-1">Rp <?= number_format(array_sum(array_column($goals, 'current_amount')), 0, ',', '.') ?></h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="trophy" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-purple-500 bg-purple-50 px-2 py-0.5 rounded-full">Done</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Goal Tercapai</p>
            <h3 class="text-xl font-extrabold text-purple-600 mt-1"><?= count(array_filter($goals, fn($g) => $g['status'] === 'completed')) ?></h3>
        </div>
    </div>

    <!-- Goals Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="goals-container">
        <?php if (empty($goals)): ?>
            <div class="col-span-2 bg-white p-12 rounded-3xl border border-gray-100 shadow-sm text-center">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-gray-50 flex items-center justify-center mb-4"><i data-lucide="target" class="w-10 h-10 text-gray-400"></i></div>
                <h3 class="text-lg font-extrabold text-gray-900 mb-2">Belum Ada Goal</h3>
                <p class="text-sm text-gray-400 mb-6">Mulai buat target tabungan pertamamu!</p>
                <button type="button" onclick="document.getElementById('btn-tambah-goal').click()" class="px-6 py-3 bg-gradient-to-r from-[#2d5a3f] to-[#3b7a57] text-white font-bold rounded-2xl shadow-lg transition-all">
                    <i data-lucide="plus" class="mr-2 w-4 h-4 inline"></i> Buat Goal Pertama
                </button>
            </div>
        <?php else: ?>
            <?php foreach ($goals as $goal): ?>
                <?php
                    $m = $goal['metrics'];
                    $progress = $m['progress_percentage'];
                    $progressColor = $progress >= 80 ? 'emerald' : ($progress >= 50 ? 'blue' : ($progress >= 25 ? 'amber' : 'red'));
                    $isCompleted = $goal['status'] === 'completed';
                    $isCouple = $goal['ownership_type'] === 'couple';
                ?>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all <?= $isCompleted ? 'ring-2 ring-emerald-200' : '' ?>">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-2xl"><?= $goal['icon'] ?? '<i data-lucide="target" class="w-6 h-6 text-gray-600"></i>' ?></div>
                            <div>
                                <h3 class="font-extrabold text-gray-900"><?= esc($goal['name']) ?></h3>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <?php if ($isCouple): ?>
                                        <span class="text-[10px] font-bold text-pink-500 bg-pink-50 px-2 py-0.5 rounded-full inline-flex items-center gap-0.5"><i data-lucide="users" class="w-3 h-3"></i> Couple</span>
                                    <?php endif; ?>
                                    <?php if ($isCompleted): ?>
                                        <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full inline-flex items-center gap-0.5"><i data-lucide="check-circle" class="w-3 h-3"></i> Tercapai</span>
                                    <?php else: ?>
                                        <span class="text-[10px] font-bold text-<?= $progressColor ?>-500 bg-<?= $progressColor ?>-50 px-2 py-0.5 rounded-full">
                                            Prioritas <?= $goal['priority'] ?>/5
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!$isCompleted): ?>
                        <div class="flex gap-1">
                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors btn-edit-goal"
                                data-goal='<?= json_encode($goal) ?>' title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                            <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors btn-delete-goal"
                                data-id="<?= $goal['id'] ?>" title="Hapus">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs font-bold mb-2">
                            <span class="text-gray-500">Rp <?= number_format($goal['current_amount'], 0, ',', '.') ?></span>
                            <span class="text-gray-900">Rp <?= number_format($goal['target_amount'], 0, ',', '.') ?></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-<?= $progressColor ?>-400 to-<?= $progressColor ?>-500 h-3 rounded-full transition-all duration-500" style="width: <?= min(100, $progress) ?>%"></div>
                        </div>
                        <p class="text-right text-xs font-extrabold text-<?= $progressColor ?>-600 mt-1"><?= $progress ?>%</p>
                    </div>

                    <!-- Metrics -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Sisa</p>
                            <p class="text-sm font-extrabold text-gray-900">Rp <?= number_format($m['remaining_amount'], 0, ',', '.') ?></p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Rata-rata/bln</p>
                            <p class="text-sm font-extrabold text-gray-900">Rp <?= number_format($m['avg_monthly_saving'], 0, ',', '.') ?></p>
                        </div>
                        <?php if ($m['estimated_months'] && !$isCompleted): ?>
                        <div class="bg-gray-50 rounded-xl p-3 col-span-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Estimasi Tercapai</p>
                            <p class="text-sm font-extrabold text-gray-900">~<?= $m['estimated_months'] ?> bulan (<?= date('M Y', strtotime($m['estimated_completion_date'])) ?>)</p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($goal['deadline']): ?>
                    <p class="text-[10px] font-bold text-gray-400 mb-3 flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3 h-3"></i> Deadline: <?= date('d M Y', strtotime($goal['deadline'])) ?>
                    </p>
                    <?php endif; ?>

                    <!-- Action Button -->
                    <?php if (!$isCompleted): ?>
                    <button class="w-full py-3 bg-gradient-to-r from-emerald-400 to-emerald-500 hover:from-emerald-500 hover:to-emerald-600 text-white font-bold rounded-xl shadow-sm hover:shadow-md transition-all text-sm btn-contribute" data-id="<?= $goal['id'] ?>" data-name="<?= esc($goal['name']) ?>">
                        <i data-lucide="plus-circle" class="w-4 h-4 inline mr-1"></i> Tambah Tabungan
                    </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Create/Edit Goal -->
<div class="modal fade" id="goalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900" id="goalModalLabel">Tambah Saving Goal</h1>
                    <p class="text-xs text-gray-400">Buat target tabungan baru</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="form_goal">
                <div class="p-8 space-y-4">
                    <input type="hidden" name="id_goal" id="id_goal" />
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Goal <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="goal_name" required placeholder="misal: Liburan Bali 🏖️" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Target Amount (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="target_amount" id="goal_target" required placeholder="0" min="1" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Prioritas</label>
                            <select name="priority" id="goal_priority" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all cursor-pointer">
                                <option value="1">1 - Rendah</option>
                                <option value="2">2</option>
                                <option value="3" selected>3 - Sedang</option>
                                <option value="4">4</option>
                                <option value="5">5 - Tinggi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Deadline</label>
                            <input type="date" name="deadline" id="goal_deadline" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Icon</label>
                        <input type="text" name="icon" id="goal_icon" value="" maxlength="20" placeholder="target, gift, etc" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tipe Kepemilikan</label>
                        <select name="ownership_type" id="goal_ownership" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all cursor-pointer">
                            <option value="individual">👤 Individual</option>
                            <option value="couple">👫 Couple (Bersama)</option>
                        </select>
                    </div>
                    <div id="partner-field" class="hidden">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Partner ID</label>
                        <input type="number" name="partner_id" id="goal_partner" placeholder="ID pasangan" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">Masukkan user ID pasangan kamu</p>
                    </div>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-full transition-colors" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="px-8 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-bold rounded-full shadow-sm hover:shadow-md transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Contribute -->
<div class="modal fade" id="contributeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100">
                <h1 class="text-xl font-extrabold text-gray-900 flex items-center gap-2"><i data-lucide="wallet" class="w-5 h-5 text-emerald-500"></i> Tambah Tabungan</h1>
                <p class="text-xs text-gray-400" id="contribute-goal-name">-</p>
            </div>
            <form id="form_contribute">
                <input type="hidden" name="contribute_goal_id" id="contribute_goal_id" />
                <div class="p-8 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nominal (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="amount" id="contribute_amount" required placeholder="0" min="1" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Dari Wallet</label>
                        <select name="wallet_id" id="contribute_wallet" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all cursor-pointer">
                            <option value="">-- Tanpa wallet --</option>
                            <?php foreach ($wallets as $w): ?>
                                <option value="<?= $w['id'] ?>"><?= esc($w['nama']) ?> (Rp <?= number_format($w['saldo'], 0, ',', '.') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Catatan</label>
                        <input type="text" name="note" id="contribute_note" placeholder="Opsional" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                    </div>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-full transition-colors" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="px-8 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-bold rounded-full shadow-sm hover:shadow-md transition-all">Setor</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("saving-goals") ?>';

    // CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr) {
            var csrfName = '<?= csrf_token() ?>';
            var csrfHash = '<?= csrf_hash() ?>';
            if (this.type === 'POST' && this.data) {
                this.data += '&' + csrfName + '=' + csrfHash;
            } else if (this.type === 'POST') {
                this.data = csrfName + '=' + csrfHash;
            }
        }
    });

    $(document).ready(function() {
        // Toggle partner field
        $('#goal_ownership').change(function() {
            $('#partner-field').toggleClass('hidden', $(this).val() !== 'couple');
        });

        // Open create modal
        $('#btn-tambah-goal').click(function() {
            $('#form_goal')[0].reset();
            $('#id_goal').val('');
            $('#goal_icon').val('');
            $('#goal_priority').val('3');
            $('#partner-field').addClass('hidden');
            $('#goalModalLabel').text('Tambah Saving Goal');
            $('#goalModal').modal('show');
        });

        // Submit goal form
        $('#form_goal').submit(function(e) {
            e.preventDefault();
            let id = $('#id_goal').val();
            let url = id ? `${baseUrl}/update/${id}` : `${baseUrl}/create`;
            $.ajax({
                url: url, type: 'POST', data: $(this).serialize(), dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        $('#goalModal').modal('hide');
                        showAlert('success', 'Berhasil', res.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showAlert('error', 'Gagal', res.message);
                    }
                },
                error: function() { showAlert('error', 'Error', 'Terjadi kesalahan sistem'); }
            });
        });

        // Edit goal
        $(document).on('click', '.btn-edit-goal', function() {
            let goal = $(this).data('goal');
            $('#form_goal')[0].reset();
            $('#id_goal').val(goal.id);
            $('#goal_name').val(goal.name);
            $('#goal_target').val(goal.target_amount);
            $('#goal_priority').val(goal.priority);
            $('#goal_deadline').val(goal.deadline || '');
            $('#goal_icon').val(goal.icon || '');
            $('#goal_ownership').val(goal.ownership_type);
            $('#goal_partner').val(goal.partner_id || '');
            $('#partner-field').toggleClass('hidden', goal.ownership_type !== 'couple');
            $('#goalModalLabel').text('Edit Goal');
            $('#goalModal').modal('show');
        });

        // Delete goal
        $(document).on('click', '.btn-delete-goal', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Goal?', text: 'Goal dan semua kontribusi akan dihapus!', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseUrl}/delete/${id}`, type: 'POST', dataType: 'json',
                        success: function(res) {
                            if (res.status) { showAlert('success', 'Berhasil', res.message); setTimeout(() => location.reload(), 1000); }
                            else { showAlert('error', 'Gagal', res.message); }
                        }
                    });
                }
            });
        });

        // Open contribute modal
        $(document).on('click', '.btn-contribute', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#form_contribute')[0].reset();
            $('#contribute_goal_id').val(id);
            $('#contribute-goal-name').text('Untuk: ' + name);
            $('#contributeModal').modal('show');
        });

        // Submit contribution
        $('#form_contribute').submit(function(e) {
            e.preventDefault();
            let goalId = $('#contribute_goal_id').val();
            $.ajax({
                url: `${baseUrl}/contribute/${goalId}`, type: 'POST', data: $(this).serialize(), dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        $('#contributeModal').modal('hide');
                        showAlert('success', 'Berhasil', res.message);
                        setTimeout(() => location.reload(), 1200);
                    } else {
                        showAlert('error', 'Gagal', res.message);
                    }
                },
                error: function() { showAlert('error', 'Error', 'Terjadi kesalahan sistem'); }
            });
        });

        // Auto-allocate
        $('#btn-auto-allocate').click(function() {
            Swal.fire({
                title: 'Auto-Allocate?',
                text: 'Sisa budget bulan ini akan didistribusikan ke goal aktif berdasarkan prioritas.',
                icon: 'question', showCancelButton: true, confirmButtonText: 'Ya, Jalankan!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseUrl}/auto-allocate`, type: 'POST', dataType: 'json',
                        success: function(res) {
                            showAlert(res.status ? 'success' : 'info', res.status ? 'Berhasil' : 'Info', res.message);
                            if (res.status && res.data.allocated > 0) setTimeout(() => location.reload(), 1500);
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
