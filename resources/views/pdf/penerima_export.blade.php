<!DOCTYPE html>
<html>
<head>
    <title>Data Penerima</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; }
        .info { margin-bottom: 20px; }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h2>Data Penerima</h2>

    <div class="info">
        <strong>Nama:</strong> {{ $penerima['nama_lengkap'] ?? '-' }}<br>
        <strong>Sekolah:</strong> {{ $penerima['asal_sekolah'] ?? '-' }}<br>
        <strong>Kode Unik:</strong> {{ $penerima['kode_unik'] ?? '-' }}
    </div>

    <h3>Barang yang Diterima:</h3>
    <ul>
        <li>Tas</li>
        <li>Sepatu</li>
        <li>Seragam</li>
        <li>Alat Tulis</li> 
    </ul>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>
