<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = window.location.href;

    $(document).ready(function() {
        $('#btn-tambah').click(function() {
            $('#form_transaksi')[0].reset();
            $('#id_transaksi').val('');
            $('#transaksiModal').modal('show');
        });

        $('#form_transaksi').submit(function(e) {
            e.preventDefault();
            submitData();
            $('#transaksiModal').modal('hide');
            showData();
        });

        deleteData();
        editData();
        showData();
    })

    function submitData() {
        let id = $('#id_transaksi').val();
        let tanggal = $('#tanggal').val();
        let nama_transaksi = $('#nama_transaksi').val();
        let harga = $('#harga').val();
        let kategori = $('#kategori').val();

        let form = new FormData();
        form.append('id', id);
        form.append('tanggal', tanggal);
        form.append('nama_transaksi', nama_transaksi);
        form.append('harga', harga);
        form.append('kategori', kategori);

        let url = `${baseUrl}/create`;
        if (id !== '') {
            url = `${baseUrl}/update`;
            form.append("id", id);
        }

        let settings = {
            "url": url,
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        $.ajax(settings).done(function(response) {
            response = JSON.parse(response);
            console.log(response);
            if (response.status) {
                alert(response.message);
            } else {
                alert(response.message);
            }
        });
    }

    function showData() {
        $.ajax({
            url: `${baseUrl}/list`,
            method: "GET",
            dataType: "json",
            success: function(response) {
                let tbody = '';
                response.data.forEach(function(item, index) {
                    tbody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.tanggal}</td>
                        <td class="fw-medium">${item.nama_transaksi}</td>
                        <td class="text-danger fw-bold">Rp ${item.harga}</td>
                        <td><span class="badge bg-info text-dark">${item.kategori}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary btn-edit" data-id="${item.id}">Edit</button>
                            <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${item.id}">Hapus</button>
                        </td>
                    </tr>
                    `;
                });
                $('#tabel-transaksi tbody').html(tbody);
            }
        })
    }

    function deleteData() {
        $(document).on("click", ".btn-delete", function() {
            let id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `${baseUrl}/delete?id=${id}`,
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            showData();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        });
    }

    function editData() {
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data('id');
            // Fetch data transaksi berdasarkan ID dan isi form
            var settings = {
                "url": `${baseUrl}/read?id=${id}`,
                "method": "GET",
                "timeout": 0,
            };

            $.ajax(settings).done(function(response) {
                if (response.status === false) {
                    alert(response.message);
                    return;
                } else {
                    let data = response.data;
                    $('#form_transaksi')[0].reset();
                    $('#id_transaksi').val(data.id);
                    $('#tanggal').val(data.tanggal);
                    $('#nama_transaksi').val(data.nama_transaksi);
                    $('#harga').val(data.harga);
                    $('#kategori').val(data.kategori);
                    $('#transaksiModal').modal('show');
                }
            });
        });
    }
</script>


<?= $this->endSection() ?>