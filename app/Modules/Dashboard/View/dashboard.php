<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column (2 Parts on Large Screens) -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Top Section: Card & Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Digital Card -->
            <div class="relative overflow-hidden rounded-[2.5rem] bg-[#1e1e1e] p-8 text-white shadow-2xl shadow-gray-200">
                <!-- Decorative Circles -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 left-10 w-32 h-32 bg-primary/20 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex flex-col justify-between h-full min-h-[220px]">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm font-medium mb-1">Total Balance</p>
                            <h2 class="text-3xl font-bold tracking-tight" id="total_saldo">Rp 0</h2>
                        </div>
                        <i data-lucide="wifi" class="text-gray-500 w-8 h-8"></i>
                    </div>

                    <div class="flex justify-between items-end mt-8">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Card Holder</p>
                            <p class="font-bold tracking-wide uppercase">User UangSaku</p>
                        </div>
                        <div class="text-right">
                            <img src="/img/UangSakuLogo.png" alt="Logo" class="w-8 h-8 opacity-80 mb-2 ml-auto grayscale brightness-200">
                            <p class="text-xs text-gray-400">Platinum Card</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col justify-between group hover:border-green-100 transition-all">
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 mb-2">
                        <i data-lucide="arrow-down-left" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase">Income</p>
                        <h3 class="text-lg font-black text-gray-900 mt-1" id="total_pemasukan">Rp 0</h3>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col justify-between group hover:border-red-100 transition-all">
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 mb-2">
                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase">Expense</p>
                        <h3 class="text-lg font-black text-gray-900 mt-1" id="total_pengeluaran">Rp 0</h3>
                    </div>
                </div>

                <div class="col-span-2 bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm flex items-center justify-between group hover:border-yellow-200 transition-all">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase">Budget Status</p>
                        <h3 class="text-lg font-black text-gray-900 mt-1">Safe</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full border-4 border-primary/30 border-t-primary flex items-center justify-center text-xs font-bold">
                        85%
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-900 text-lg">Cashflow Analytics</h3>
                <select class="bg-gray-50 border-0 text-xs font-bold rounded-lg px-3 py-1.5 focus:ring-0 text-gray-500 cursor-pointer">
                    <option>This Year</option>
                    <option>Last Year</option>
                </select>
            </div>
            <div id="cashflowChart" class="w-full h-[300px]"></div>
        </div>

    </div>

    <!-- Right Column: Recent Activity & Quick Action -->
    <div class="space-y-8">
        
        <!-- Quick Actions -->
        <div class="bg-primary/10 p-6 rounded-[2.5rem]">
            <h3 class="font-bold text-gray-900 text-lg mb-4">Quick Actions</h3>
            <div class="grid grid-cols-4 gap-2">
                <a href="<?= base_url('transaction') ?>?action=add" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-gray-900 group-hover:scale-110 transition-transform">
                        <i data-lucide="plus" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-600">Add</span>
                </a>
                <a href="<?= base_url('wallet') ?>" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-gray-900 group-hover:scale-110 transition-transform">
                        <i data-lucide="send" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-600">Transfer</span>
                </a>
                <a href="<?= base_url('budget') ?>" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-gray-900 group-hover:scale-110 transition-transform">
                        <i data-lucide="pie-chart" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-600">Budget</span>
                </a>
                <a href="<?= base_url('hutangpiutang') ?>" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-gray-900 group-hover:scale-110 transition-transform">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-600">Debt</span>
                </a>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm h-full max-h-[500px] overflow-hidden flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-900 text-lg">Recent Transactions</h3>
                <a href="<?= base_url('transaction') ?>" class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            
            <div class="overflow-y-auto pr-2 space-y-4 flex-1 custom-scrollbar" id="recent-transactions-list">
                <!-- Javascript will populate this -->
                <div class="animate-pulse space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-gray-100 rounded w-24 mb-2"></div>
                            <div class="h-2 bg-gray-100 rounded w-16"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full"></div>
                        <div class="flex-1">
                            <div class="h-3 bg-gray-100 rounded w-24 mb-2"></div>
                            <div class="h-2 bg-gray-100 rounded w-16"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formatCurrency = (amount) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        };

        // Fetch Dashboard Data
        fetch('<?= base_url('dashboard/get_data') ?>')
            .then(response => response.json())
            .then(data => {
                // Update Stats
                document.getElementById('total_saldo').innerText = formatCurrency(data.total_saldo);
                document.getElementById('total_pemasukan').innerText = formatCurrency(data.total_pemasukan);
                document.getElementById('total_pengeluaran').innerText = formatCurrency(data.total_pengeluaran);
            })
            .catch(err => console.error('Error:', err));

        // Fetch Recent Transactions
        // Note: Assuming there is an endpoint or we might need to create one. 
        // For now, I'll hit the existing list endpoint with a limit if possible, or mocked for UI demo.
        // Since I don't know if 'transaction/list' supports limits nicely in JSON return without modification, 
        // I will use Javascript to fetch the main list and slice it. 
        // *Optimally, backend should have `latest` endpoint.*
        fetch('<?= base_url('transaction/list') ?>?length=5&start=0')
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById('recent-transactions-list');
                const transactions = data.data || [];
                
                if(transactions.length === 0) {
                    list.innerHTML = '<div class="text-center text-gray-400 text-xs py-10">Belum ada transaksi</div>';
                    return;
                }

                let html = '';
                transactions.forEach(trx => {
                    const isIncome = trx.type === 'income';
                    const icon = isIncome ? 'arrow-down-left' : 'arrow-up-right';
                    const color = isIncome ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600';
                    const amountClass = isIncome ? 'text-green-600' : 'text-gray-900';
                    const prefix = isIncome ? '+' : '-';

                    html += `
                        <div class="flex items-center gap-4 p-2 hover:bg-gray-50 rounded-2xl transition-colors cursor-pointer">
                            <div class="w-12 h-12 rounded-2xl ${color} flex items-center justify-center shrink-0">
                                <i data-lucide="${icon}" class="w-5 h-5"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-900 truncate">${trx.nama_transaksi}</h4>
                                <p class="text-xs text-gray-400 capitalize">${trx.kategori}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black ${amountClass}">${prefix} ${parseFloat(trx.harga).toLocaleString('id-ID')}</p>
                                <p class="text-[10px] text-gray-400">${new Date(trx.tanggal).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'})}</p>
                            </div>
                        </div>
                    `;
                });
                list.innerHTML = html;
                if(typeof lucide !== 'undefined') lucide.createIcons();
            })
            .catch(err => {
                document.getElementById('recent-transactions-list').innerHTML = '<div class="text-center text-red-400 text-xs py-10">Gagal memuat data</div>';
            });

        // Initialize Chart
        var options = {
            series: [{
                name: 'Income',
                data: [44, 55, 57, 56, 61, 58, 63, 66, 75]
            }, {
                name: 'Expense',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: { show: false },
                fontFamily: 'inherit'
            },
            colors: ['#22c55e', '#ef4444'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                    endingShape: 'rounded',
                    borderRadius: 5
                },
            },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: { show: false },
            fill: { opacity: 1 },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val + "k"
                    }
                }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right', 
            }
        };

        var chart = new ApexCharts(document.querySelector("#cashflowChart"), options);
        chart.render();
    });
</script>
<?= $this->endSection() ?>