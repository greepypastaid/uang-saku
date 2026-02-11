<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column (2 Parts on Large Screens) -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Top Section: Card & Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Green Gradient Card -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1a3a2a] to-[#2d5a3f] p-7 text-white shadow-xl">
                <!-- Decorative Elements -->
                <div class="absolute -top-8 -right-8 w-36 h-36 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute bottom-8 left-6 w-28 h-28 bg-emerald-400/15 rounded-full blur-xl"></div>
                <div class="absolute top-4 right-6">
                    <svg class="w-10 h-10 text-emerald-500/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zM17.9 17.39A9.822 9.822 0 0014 16.6V15c0-1.1-.9-2-2-2H8v-2c0-.55.45-1 1-1h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41C18.93 5.77 20 8.65 20 12c0 2.08-.64 4.02-2.1 5.39z"/></svg>
                </div>

                <div class="relative z-10 flex flex-col justify-between h-full min-h-[200px]">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                                <img src="/img/UangSakuLogo.png" alt="Logo" class="w-5 h-5 brightness-200">
                            </div>
                            <span class="text-emerald-300/70 text-xs font-semibold tracking-wider uppercase">Uang Saku</span>
                        </div>
                        <p class="text-emerald-200/60 text-xs font-medium mt-4 mb-1">Total Balance</p>
                        <h2 class="text-3xl font-extrabold tracking-tight" id="total_saldo">Rp 0</h2>
                    </div>

                    <div class="flex justify-between items-end mt-6">
                        <div>
                            <p class="text-[10px] text-emerald-200/50 mb-0.5 uppercase tracking-wider">Card Holder</p>
                            <p class="font-bold text-sm tracking-wide">User UangSaku</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-emerald-200/50 mb-0.5 uppercase tracking-wider">Status</p>
                            <p class="text-xs font-bold text-emerald-400">● Active</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Income Card -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group cursor-pointer">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                            <i data-lucide="trending-up" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">↑ Income</span>
                    </div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Income</p>
                    <h3 class="text-xl font-extrabold text-gray-900 mt-1" id="total_pemasukan">Rp 0</h3>
                </div>

                <!-- Expense Card -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group cursor-pointer">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                            <i data-lucide="trending-down" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">↓ Expense</span>
                    </div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Expense</p>
                    <h3 class="text-xl font-extrabold text-gray-900 mt-1" id="total_pengeluaran">Rp 0</h3>
                </div>

                <!-- Quick Action Buttons Row -->
                <div class="col-span-2 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="grid grid-cols-4 gap-2">
                        <a href="<?= base_url('transaction') ?>?action=add" class="flex flex-col items-center gap-1.5 group">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-100 group-hover:scale-110 transition-all">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                            </div>
                            <span class="text-[10px] font-bold text-gray-500 group-hover:text-gray-900 transition-colors">Add</span>
                        </a>
                        <a href="<?= base_url('wallet') ?>" class="flex flex-col items-center gap-1.5 group">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-100 group-hover:scale-110 transition-all">
                                <i data-lucide="send" class="w-5 h-5"></i>
                            </div>
                            <span class="text-[10px] font-bold text-gray-500 group-hover:text-gray-900 transition-colors">Transfer</span>
                        </a>
                        <a href="<?= base_url('budget') ?>" class="flex flex-col items-center gap-1.5 group">
                            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 group-hover:bg-amber-100 group-hover:scale-110 transition-all">
                                <i data-lucide="pie-chart" class="w-5 h-5"></i>
                            </div>
                            <span class="text-[10px] font-bold text-gray-500 group-hover:text-gray-900 transition-colors">Budget</span>
                        </a>
                        <a href="<?= base_url('hutangpiutang') ?>" class="flex flex-col items-center gap-1.5 group">
                            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 group-hover:bg-purple-100 group-hover:scale-110 transition-all">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <span class="text-[10px] font-bold text-gray-500 group-hover:text-gray-900 transition-colors">Debt</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cashflow Chart Section -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Cashflow</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Perbandingan income & expense bulanan</p>
                </div>
                <select id="cashflowPeriod" class="bg-[#f0f5f0] border-0 text-xs font-bold rounded-xl px-4 py-2 focus:ring-0 text-gray-600 cursor-pointer">
                    <option>This Year</option>
                    <option>Last Year</option>
                </select>
            </div>
            <!-- Cashflow Legend -->
            <div class="flex items-center gap-6 mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#2d5a3f]"></div>
                    <span class="text-xs text-gray-500 font-semibold">Income</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#a8d5ba]"></div>
                    <span class="text-xs text-gray-500 font-semibold">Expense</span>
                </div>
            </div>
            <div id="cashflowChart" class="w-full h-[300px]"></div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Recent Transactions</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Transaksi terbaru dari semua wallet</p>
                </div>
                <a href="<?= base_url('transaction') ?>" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-4 py-2 rounded-xl hover:bg-emerald-100 transition-all flex items-center gap-1">
                    Lihat Semua <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
            
            <!-- Table Header -->
            <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 bg-[#f0f5f0] rounded-xl text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">
                <div class="col-span-4">Transaction Name</div>
                <div class="col-span-3">Date & Time</div>
                <div class="col-span-2 text-right">Amount</div>
                <div class="col-span-3 text-center">Status</div>
            </div>

            <div class="space-y-2" id="recent-transactions-list">
                <!-- Loading skeleton -->
                <div class="animate-pulse space-y-3">
                    <div class="flex items-center gap-4 p-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-gray-100 rounded w-32 mb-2"></div>
                            <div class="h-2 bg-gray-100 rounded w-20"></div>
                        </div>
                        <div class="h-3 bg-gray-100 rounded w-20"></div>
                    </div>
                    <div class="flex items-center gap-4 p-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-gray-100 rounded w-28 mb-2"></div>
                            <div class="h-2 bg-gray-100 rounded w-16"></div>
                        </div>
                        <div class="h-3 bg-gray-100 rounded w-24"></div>
                    </div>
                    <div class="flex items-center gap-4 p-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-gray-100 rounded w-24 mb-2"></div>
                            <div class="h-2 bg-gray-100 rounded w-14"></div>
                        </div>
                        <div class="h-3 bg-gray-100 rounded w-20"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Statistic & Activity -->
    <div class="space-y-6">
        
        <!-- Statistic Donut Chart -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-extrabold text-gray-900 text-lg">Statistic</h3>
                <select class="bg-[#f0f5f0] border-0 text-[10px] font-bold rounded-lg px-3 py-1.5 focus:ring-0 text-gray-500 cursor-pointer">
                    <option>This Month</option>
                    <option>Last Month</option>
                </select>
            </div>
            
            <!-- Income vs Expense Mini Labels -->
            <div class="flex items-center justify-center gap-6 mb-3">
                <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#2d5a3f]"></div>
                    <span class="text-[10px] text-gray-500 font-semibold">Income</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                    <span class="text-[10px] text-gray-500 font-semibold">Expense</span>
                </div>
            </div>

            <div id="donutChart" class="w-full"></div>

            <!-- Category Breakdown -->
            <div class="space-y-3 mt-4" id="category-breakdown">
                <div class="animate-pulse space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-5 bg-gray-100 rounded"></div>
                            <div class="h-3 bg-gray-100 rounded w-20"></div>
                        </div>
                        <div class="h-3 bg-gray-100 rounded w-16"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-5 bg-gray-100 rounded"></div>
                            <div class="h-3 bg-gray-100 rounded w-24"></div>
                        </div>
                        <div class="h-3 bg-gray-100 rounded w-14"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm max-h-[420px] overflow-hidden flex flex-col">
            <div class="flex justify-between items-center mb-5">
                <h3 class="font-extrabold text-gray-900 text-lg">Recent Activity</h3>
                <button class="w-8 h-8 flex items-center justify-center rounded-xl bg-[#f0f5f0] text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                    <i data-lucide="more-vertical" class="w-4 h-4"></i>
                </button>
            </div>
            
            <div class="overflow-y-auto flex-1 space-y-1 pr-1 custom-scrollbar" id="recent-activity-list">
                <!-- Javascript will populate this -->
                <div class="animate-pulse space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-gray-100 rounded w-28 mb-2"></div>
                            <div class="h-2 bg-gray-100 rounded w-16"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-gray-100 rounded w-24 mb-2"></div>
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Custom Scrollbar Style -->
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 100px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formatCurrency = (amount) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        };

        let dashboardData = {};

        // Fetch Dashboard Data
        fetch('<?= base_url('dashboard/get_data') ?>')
            .then(response => response.json())
            .then(data => {
                dashboardData = data;
                document.getElementById('total_saldo').innerText = formatCurrency(data.total_saldo);
                document.getElementById('total_pemasukan').innerText = formatCurrency(data.total_pemasukan);
                document.getElementById('total_pengeluaran').innerText = formatCurrency(data.total_pengeluaran);

                // Render Donut Chart with real data
                renderDonutChart(data.total_pemasukan, data.total_pengeluaran);
            })
            .catch(err => console.error('Error:', err));

        // Donut Chart
        function renderDonutChart(income, expense) {
            const total = parseFloat(income || 0) + parseFloat(expense || 0);
            const incomeVal = parseFloat(income || 0);
            const expenseVal = parseFloat(expense || 0);

            var donutOptions = {
                series: [incomeVal, expenseVal],
                chart: { type: 'donut', height: 240, fontFamily: 'Inter, sans-serif' },
                labels: ['Income', 'Expense'],
                colors: ['#2d5a3f', '#ef4444'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                name: { show: true, fontSize: '12px', fontWeight: 700, color: '#6b7280' },
                                value: { show: true, fontSize: '18px', fontWeight: 800, color: '#111827',
                                    formatter: val => 'Rp ' + parseFloat(val).toLocaleString('id-ID')
                                },
                                total: {
                                    show: true, label: 'Total Expense',
                                    fontSize: '10px', fontWeight: 600, color: '#9ca3af',
                                    formatter: w => 'Rp ' + parseFloat(expenseVal).toLocaleString('id-ID')
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                legend: { show: false },
                stroke: { width: 3, colors: ['#fff'] },
                tooltip: {
                    y: { formatter: val => 'Rp ' + parseFloat(val).toLocaleString('id-ID') }
                }
            };
            var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
            donutChart.render();
        }

        // Fetch Recent Transactions
        fetch('<?= base_url('transaction/list') ?>?length=5&start=0')
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById('recent-transactions-list');
                const activityList = document.getElementById('recent-activity-list');
                const transactions = data.data || [];
                
                if(transactions.length === 0) {
                    list.innerHTML = '<div class="text-center text-gray-400 text-xs py-10">Belum ada transaksi</div>';
                    activityList.innerHTML = '<div class="text-center text-gray-400 text-xs py-10">Belum ada aktivitas</div>';
                    document.getElementById('category-breakdown').innerHTML = '<div class="text-center text-gray-400 text-xs py-4">Belum ada data</div>';
                    return;
                }

                // Transaction list with table-like layout
                let html = '';
                transactions.forEach(trx => {
                    const isIncome = trx.type === 'income';
                    const icon = isIncome ? 'arrow-down-left' : 'arrow-up-right';
                    const iconBg = isIncome ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500';
                    const amountClass = isIncome ? 'text-emerald-600' : 'text-gray-900';
                    const prefix = isIncome ? '+' : '-';
                    const statusBadge = `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold ${isIncome ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'}">${isIncome ? 'Completed' : 'Completed'}</span>`;
                    const dateStr = new Date(trx.tanggal).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});

                    html += `
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-center p-3 hover:bg-[#f0f5f0] rounded-xl transition-colors cursor-pointer border-b border-gray-50 last:border-0">
                            <div class="col-span-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl ${iconBg} flex items-center justify-center shrink-0">
                                    <i data-lucide="${icon}" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-gray-900 truncate">${trx.nama_transaksi}</h4>
                                    <p class="text-[10px] text-gray-400 capitalize">${trx.kategori}</p>
                                </div>
                            </div>
                            <div class="col-span-3 hidden md:block">
                                <span class="text-xs text-gray-500 font-medium">${dateStr}</span>
                            </div>
                            <div class="col-span-2 text-right hidden md:block">
                                <p class="text-sm font-extrabold ${amountClass}">${prefix} Rp ${parseFloat(trx.harga).toLocaleString('id-ID')}</p>
                            </div>
                            <div class="col-span-3 text-center hidden md:block">
                                ${statusBadge}
                            </div>
                            <!-- Mobile layout amount -->
                            <div class="md:hidden flex justify-between items-center">
                                <span class="text-[10px] text-gray-400">${dateStr}</span>
                                <p class="text-sm font-extrabold ${amountClass}">${prefix} Rp ${parseFloat(trx.harga).toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                    `;
                });
                list.innerHTML = html;

                // Recent Activity
                let actHtml = '';
                transactions.slice(0, 5).forEach((trx, idx) => {
                    const isIncome = trx.type === 'income';
                    const avatarColors = ['bg-emerald-100 text-emerald-600', 'bg-blue-100 text-blue-600', 'bg-amber-100 text-amber-600', 'bg-purple-100 text-purple-600', 'bg-red-100 text-red-600'];
                    const color = avatarColors[idx % avatarColors.length];
                    const initials = trx.nama_transaksi.substring(0, 2).toUpperCase();
                    const timeStr = new Date(trx.tanggal).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
                    const action = isIncome ? 'received income' : 'made a payment';

                    actHtml += `
                        <div class="flex items-start gap-3 p-2.5 hover:bg-[#f0f5f0] rounded-xl transition-colors">
                            <div class="w-9 h-9 rounded-full ${color} flex items-center justify-center text-xs font-bold shrink-0">${initials}</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-900"><span class="font-bold">${trx.nama_transaksi}</span> ${action}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">${timeStr}</p>
                            </div>
                        </div>
                    `;
                });
                activityList.innerHTML = actHtml;

                // Category Breakdown
                const cats = {};
                let totalExpense = 0;
                transactions.forEach(trx => {
                    if (trx.type === 'expense') {
                        cats[trx.kategori] = (cats[trx.kategori] || 0) + parseFloat(trx.harga);
                        totalExpense += parseFloat(trx.harga);
                    }
                });

                const catColors = ['#2d5a3f', '#3b7a57', '#5a9e7a', '#7cb89b', '#a8d5ba'];
                let catHtml = '';
                let colorIdx = 0;
                Object.keys(cats).sort((a,b) => cats[b] - cats[a]).forEach(cat => {
                    const pct = totalExpense > 0 ? Math.round(cats[cat] / totalExpense * 100) : 0;
                    const c = catColors[colorIdx % catColors.length];
                    catHtml += `
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-[10px] font-extrabold text-white px-2 py-0.5 rounded-md" style="background: ${c}">${pct}%</span>
                                <span class="text-xs font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">${cat}</span>
                            </div>
                            <span class="text-xs font-bold text-gray-900">Rp ${cats[cat].toLocaleString('id-ID')}</span>
                        </div>
                    `;
                    colorIdx++;
                });
                if (catHtml) {
                    document.getElementById('category-breakdown').innerHTML = catHtml;
                } else {
                    document.getElementById('category-breakdown').innerHTML = '<div class="text-center text-gray-400 text-xs py-4">Belum ada pengeluaran</div>';
                }

                if(typeof lucide !== 'undefined') lucide.createIcons();
            })
            .catch(err => {
                document.getElementById('recent-transactions-list').innerHTML = '<div class="text-center text-red-400 text-xs py-10">Gagal memuat data</div>';
            });

        // Cashflow Bar Chart
        var options = {
            series: [{
                name: 'Income',
                data: [44, 55, 57, 56, 61, 58, 63, 66, 75, 70, 68, 72]
            }, {
                name: 'Expense',
                data: [35, 42, 48, 45, 40, 52, 44, 50, 46, 43, 38, 55]
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            colors: ['#2d5a3f', '#a8d5ba'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    borderRadius: 6,
                    borderRadiusApplication: 'end'
                },
            },
            dataLabels: { enabled: false },
            stroke: { show: false },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 600 } }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9ca3af', fontSize: '11px', fontWeight: 600 },
                    formatter: val => val >= 1000 ? (val / 1000).toFixed(0) + 'K' : val
                }
            },
            fill: { opacity: 1 },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toLocaleString('id-ID')
                    }
                },
                theme: 'dark'
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 4,
                xaxis: { lines: { show: false } }
            },
            legend: { show: false }
        };

        var chart = new ApexCharts(document.querySelector("#cashflowChart"), options);
        chart.render();
    });
</script>
<?= $this->endSection() ?>