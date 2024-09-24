<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Transaksi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Input Transaksi</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/transaction" method="POST">
            @csrf
            <div class="form-group">
                <label for="kode_customer">Kode Customer</label>
                <select class="form-control" name="kode_customer" required>
                    <option value="">Pilih Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->kode_customer }}">{{ $customer->nama_customer }}</option>
                    @endforeach
                </select>
            </div>

            <h3>Detail Transaksi</h3>
            <div id="details">
                <div class="form-row">
                    <div class="col">
                        <input type="date" name="details[0][tgl_transaksi]" class="form-control" required>
                    </div>
                    <div class="col">
                        <select name="details[0][nama_barang]" class="form-control" onchange="updateKodeBarang(this, 0)" required>
                            <option value="">Pilih Nama Barang</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->nama_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="details[0][kode_barang]" class="kode_barang" value="">
                    </div>
                    <div class="col">
                        <input type="number" name="details[0][qty]" class="form-control" required min="1" onchange="calculateSubtotal(0)">
                    </div>
                    <div class="col">
                        <input type="number" name="details[0][harga]" class="form-control" readonly>
                    </div>
                    <div class="col">
                        <input type="number" name="details[0][subtotal]" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="addRow()">Tambah Detail</button>

            <h3 class="mt-4">Total Pembayaran</h3>
            <div class="form-group">
                <label for="total">Total</label>
                <input type="number" id="total" name="total" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" name="keterangan" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan Transaksi</button>
        </form>
    </div>

    <script>
        function updateKodeBarang(selectElement, index) {
            const nama_barang = selectElement.value;
            const items = @json($items); // Using Laravel to pass items data to JS
            const selectedItem = items.find(item => item.nama_barang === nama_barang);
            if (selectedItem) {
                document.querySelector(`input[name="details[${index}][harga]"]`).value = selectedItem.harga;
                document.querySelector(`input[name="details[${index}][kode_barang]"]`).value = selectedItem.kode_barang; // Set kode_barang
                calculateSubtotal(index);
            } else {
                document.querySelector(`input[name="details[${index}][harga]"]`).value = '';
                document.querySelector(`input[name="details[${index}][kode_barang]"]`).value = ''; // Reset kode_barang
            }
        }

        function calculateSubtotal(index) {
            const qty = parseFloat(document.querySelector(`input[name="details[${index}][qty]"]`).value) || 0;
            const harga = parseFloat(document.querySelector(`input[name="details[${index}][harga]"]`).value) || 0;
            const subtotal = qty * harga;
            document.querySelector(`input[name="details[${index}][subtotal]"]`).value = subtotal.toFixed(2);
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            const rows = document.querySelectorAll('#details .form-row');
            rows.forEach(row => {
                const subtotal = parseFloat(row.querySelector('input[name*="[subtotal]"]').value) || 0;
                total += subtotal;
            });
            document.getElementById('total').value = total.toFixed(2);
        }

        function addRow() {
            const index = document.querySelectorAll('#details .form-row').length;
            const newRow = `
                <div class="form-row">
                    <div class="col">
                        <input type="date" name="details[${index}][tgl_transaksi]" class="form-control" required>
                    </div>
                    <div class="col">
                        <select name="details[${index}][nama_barang]" class="form-control" onchange="updateKodeBarang(this, ${index})" required>
                            <option value="">Pilih Nama Barang</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->nama_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="details[${index}][kode_barang]" class="kode_barang" value="">
                    </div>
                    <div class="col">
                        <input type="number" name="details[${index}][qty]" class="form-control" required min="1" onchange="calculateSubtotal(${index})">
                    </div>
                    <div class="col">
                        <input type="number" name="details[${index}][harga]" class="form-control" readonly>
                    </div>
                    <div class="col">
                        <input type="number" name="details[${index}][subtotal]" class="form-control" readonly>
                    </div>
                </div>
            `;
            document.getElementById('details').insertAdjacentHTML('beforeend', newRow);
        }
    </script>
</body>
</html>
