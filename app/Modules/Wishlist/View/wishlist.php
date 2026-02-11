<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1 flex items-center gap-2"><i data-lucide="shopping-cart" class="w-6 h-6 text-indigo-500"></i> Wishlist & Needs</h1>
            <p class="text-xs text-gray-500 font-medium">Pisahkan keinginan dan kebutuhan. Lihat berapa jam kerjamu untuk membelinya.</p>
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <button type="button" id="btn-work-settings" class="inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl transition-all text-sm">
                <i data-lucide="settings" class="mr-2 w-4 h-4"></i> Jam Kerja
            </button>
            <button type="button" id="btn-tambah-item" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-[#2d5a3f] to-[#3b7a57] hover:from-[#1a3a2a] hover:to-[#2d5a3f] text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:shadow-xl transition-all text-sm">
                <i data-lucide="plus" class="mr-2 w-4 h-4"></i> Tambah Item
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center text-red-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Kebutuhan</p>
            <h3 class="text-xl font-extrabold text-gray-900 mt-1"><?= count($needs) ?></h3>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="heart" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Keinginan</p>
            <h3 class="text-xl font-extrabold text-gray-900 mt-1"><?= count($wants) ?></h3>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Ready to Buy</p>
            <h3 class="text-xl font-extrabold text-emerald-600 mt-1"><?= count(array_filter($items, fn($i) => $i['status'] === 'ready_to_buy')) ?></h3>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="banknote" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Harga</p>
            <h3 class="text-lg font-extrabold text-gray-900 mt-1">Rp <?= number_format(array_sum(array_column(array_filter($items, fn($i) => !in_array($i['status'], ['purchased','cancelled'])), 'price')), 0, ',', '.') ?></h3>
        </div>
    </div>

    <!-- Items List -->
    <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            <button class="tab-btn px-4 py-2 font-bold text-sm rounded-xl transition-all bg-gray-900 text-white" data-tab="all">Semua</button>
            <button class="tab-btn px-4 py-2 font-bold text-sm rounded-xl transition-all bg-gray-100 text-gray-600 hover:bg-gray-200 inline-flex items-center gap-1" data-tab="need"><i data-lucide="alert-circle" class="w-3.5 h-3.5 text-red-500"></i> Kebutuhan</button>
            <button class="tab-btn px-4 py-2 font-bold text-sm rounded-xl transition-all bg-gray-100 text-gray-600 hover:bg-gray-200 inline-flex items-center gap-1" data-tab="want"><i data-lucide="heart" class="w-3.5 h-3.5 text-pink-500"></i> Keinginan</button>
        </div>

        <div class="space-y-3" id="items-list">
            <?php if (empty($items)): ?>
                <div class="text-center py-12">
                    <div class="mb-3"><i data-lucide="shopping-bag" class="w-10 h-10 text-gray-400 mx-auto"></i></div>
                    <p class="text-gray-400 font-bold">Belum ada item. Tambahkan keinginan atau kebutuhanmu!</p>
                </div>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <?php
                        $isNeed = $item['item_type'] === 'need';
                        $isReadyToBuy = $item['status'] === 'ready_to_buy';
                        $isPurchased = $item['status'] === 'purchased';
                        $isCancelled = $item['status'] === 'cancelled';
                        $wc = $item['work_cost'];
                        $urgencyColors = ['urgent' => 'red', 'high' => 'orange', 'medium' => 'amber', 'low' => 'gray'];
                        $uColor = $urgencyColors[$item['urgency_level']] ?? 'gray';
                    ?>
                    <div class="item-card border border-gray-100 rounded-2xl p-5 hover:shadow-md transition-all <?= $isPurchased ? 'opacity-50' : '' ?> <?= $isReadyToBuy ? 'ring-2 ring-emerald-200' : '' ?>"
                         data-type="<?= $item['item_type'] ?>">
                        <div class="flex flex-col md:flex-row justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <?php if ($isNeed): ?><i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i><?php else: ?><i data-lucide="heart" class="w-5 h-5 text-pink-500"></i><?php endif; ?>
                                    <h4 class="font-extrabold text-gray-900 <?= $isPurchased ? 'line-through' : '' ?>"><?= esc($item['name']) ?></h4>
                                    <?php if ($isReadyToBuy): ?>
                                        <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full animate-pulse inline-flex items-center gap-0.5"><i data-lucide="check-circle" class="w-3 h-3"></i> Ready to Buy!</span>
                                    <?php endif; ?>
                                    <?php if ($isPurchased): ?>
                                        <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">Sudah Dibeli</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                    <span class="font-bold text-<?= $uColor ?>-500 bg-<?= $uColor ?>-50 px-2 py-0.5 rounded-full"><?= ucfirst($item['urgency_level']) ?></span>
                                    <?php if ($item['category']): ?>
                                        <span class="font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full"><?= esc($item['category']) ?></span>
                                    <?php endif; ?>
                                    <span class="font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full">Score: <?= $item['priority_score'] ?></span>
                                    <?php if ($item['goal_name']): ?>
                                        <span class="font-bold text-purple-500 bg-purple-50 px-2 py-0.5 rounded-full inline-flex items-center gap-0.5"><i data-lucide="target" class="w-3 h-3"></i> <?= esc($item['goal_name']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-extrabold text-gray-900 text-lg">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                                <?php if ($wc['hours']): ?>
                                    <p class="text-xs font-bold text-amber-600 mt-1 flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i> <?= $wc['hours'] ?> jam kerja (~<?= $wc['days'] ?> hari)
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!$isPurchased && !$isCancelled): ?>
                        <div class="flex justify-end gap-2 mt-3 pt-3 border-t border-gray-50">
                            <?php if ($isReadyToBuy): ?>
                                <button class="px-3 py-1.5 text-xs font-bold text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors btn-purchased" data-id="<?= $item['id'] ?>">
                                    <i data-lucide="shopping-bag" class="w-3 h-3 inline mr-1"></i> Tandai Dibeli
                                </button>
                            <?php endif; ?>
                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors btn-edit-item"
                                data-item='<?= json_encode($item) ?>' title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                            <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors btn-delete-item" data-id="<?= $item['id'] ?>" title="Hapus">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal: Create/Edit Item -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900" id="itemModalLabel">Tambah Item</h1>
                    <p class="text-xs text-gray-400">Keinginan atau kebutuhan baru</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="form_item">
                <input type="hidden" name="id_item" id="id_item" />
                <div class="p-8 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="item_name" required placeholder="misal: iPhone 16 Pro" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="item_price" required placeholder="0" min="1" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tipe</label>
                            <select name="item_type" id="item_type" class="w-full border border-gray-300 rounded-xl px-4 py-2 outline-none transition-all cursor-pointer">
                                <option value="want">💗 Keinginan</option>
                                <option value="need">🔴 Kebutuhan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Urgency</label>
                            <select name="urgency_level" id="item_urgency" class="w-full border border-gray-300 rounded-xl px-4 py-2 outline-none transition-all cursor-pointer">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                        <select name="category" id="item_category" class="w-full border border-gray-300 rounded-xl px-4 py-2 outline-none transition-all cursor-pointer">
                            <option value="">-- Pilih --</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Rumah Tangga">Rumah Tangga</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Hiburan">Hiburan</option>
                            <option value="Transportasi">Transportasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Link ke Saving Goal</label>
                        <select name="goal_id" id="item_goal" class="w-full border border-gray-300 rounded-xl px-4 py-2 outline-none transition-all cursor-pointer">
                            <option value="">-- Tanpa goal --</option>
                            <?php foreach ($goals as $g): ?>
                                <option value="<?= $g['id'] ?>"><?= esc($g['name']) ?> (Rp <?= number_format($g['current_amount'], 0, ',', '.') ?>/<?= number_format($g['target_amount'], 0, ',', '.') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Catatan</label>
                        <textarea name="note" id="item_note" rows="2" placeholder="Opsional" class="w-full border border-gray-300 rounded-xl px-4 py-2 outline-none transition-all"></textarea>
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

<!-- Modal: Work Settings -->
<div class="modal fade" id="workSettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100">
                <h1 class="text-xl font-extrabold text-gray-900 flex items-center gap-2"><i data-lucide="settings" class="w-5 h-5 text-gray-600"></i> Pengaturan Jam Kerja</h1>
                <p class="text-xs text-gray-400">Untuk kalkulasi Work Hours Cost</p>
            </div>
            <form id="form_work_settings">
                <div class="p-8 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Hari Kerja/Bulan</label>
                            <input type="number" name="working_days_per_month" value="<?= $workSettings['working_days_per_month'] ?? 22 ?>" min="1" max="31" class="w-full border border-gray-300 rounded-xl px-4 py-2 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jam Kerja/Hari</label>
                            <input type="number" name="working_hours_per_day" value="<?= $workSettings['working_hours_per_day'] ?? 8 ?>" min="1" max="24" class="w-full border border-gray-300 rounded-xl px-4 py-2 outline-none transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Override Income Bulanan (Rp)</label>
                        <input type="number" name="custom_monthly_income" value="<?= $workSettings['custom_monthly_income'] ?? '' ?>" placeholder="Kosongkan untuk pakai rata-rata income" class="w-full border border-gray-300 rounded-xl px-4 py-2 outline-none transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">Jika kosong, sistem akan menghitung dari rata-rata income 3 bulan terakhir</p>
                    </div>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-full transition-colors" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="px-8 py-2 bg-gray-900 text-white font-bold rounded-full shadow-sm hover:shadow-md transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("wishlist") ?>';

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
        // Tab filtering
        $('.tab-btn').click(function() {
            let tab = $(this).data('tab');
            $('.tab-btn').removeClass('bg-gray-900 text-white').addClass('bg-gray-100 text-gray-600');
            $(this).removeClass('bg-gray-100 text-gray-600').addClass('bg-gray-900 text-white');

            if (tab === 'all') {
                $('.item-card').show();
            } else {
                $('.item-card').hide();
                $(`.item-card[data-type="${tab}"]`).show();
            }
        });

        // Open modals
        $('#btn-tambah-item').click(function() {
            $('#form_item')[0].reset();
            $('#id_item').val('');
            $('#itemModalLabel').text('Tambah Item');
            $('#itemModal').modal('show');
        });

        $('#btn-work-settings').click(function() {
            $('#workSettingsModal').modal('show');
        });

        // Submit item form
        $('#form_item').submit(function(e) {
            e.preventDefault();
            let id = $('#id_item').val();
            let url = id ? `${baseUrl}/update/${id}` : `${baseUrl}/create`;
            $.ajax({
                url: url, type: 'POST', data: $(this).serialize(), dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        $('#itemModal').modal('hide');
                        showAlert('success', 'Berhasil', res.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showAlert('error', 'Gagal', res.message);
                    }
                },
                error: function() { showAlert('error', 'Error', 'Terjadi kesalahan sistem'); }
            });
        });

        // Edit item
        $(document).on('click', '.btn-edit-item', function() {
            let item = $(this).data('item');
            $('#form_item')[0].reset();
            $('#id_item').val(item.id);
            $('#item_name').val(item.name);
            $('#item_price').val(item.price);
            $('#item_type').val(item.item_type);
            $('#item_urgency').val(item.urgency_level);
            $('#item_category').val(item.category || '');
            $('#item_goal').val(item.goal_id || '');
            $('#item_note').val(item.note || '');
            $('#itemModalLabel').text('Edit Item');
            $('#itemModal').modal('show');
        });

        // Delete item
        $(document).on('click', '.btn-delete-item', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Item?', icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#ef4444', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
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

        // Mark purchased
        $(document).on('click', '.btn-purchased', function() {
            let id = $(this).data('id');
            $.ajax({
                url: `${baseUrl}/purchased/${id}`, type: 'POST', dataType: 'json',
                success: function(res) {
                    if (res.status) { showAlert('success', 'Berhasil', res.message); setTimeout(() => location.reload(), 1000); }
                    else { showAlert('error', 'Gagal', res.message); }
                }
            });
        });

        // Save work settings
        $('#form_work_settings').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: `${baseUrl}/work-settings`, type: 'POST', data: $(this).serialize(), dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        $('#workSettingsModal').modal('hide');
                        showAlert('success', 'Berhasil', res.message);
                        setTimeout(() => location.reload(), 1000);
                    } else { showAlert('error', 'Gagal', res.message); }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
