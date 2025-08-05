<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penerima Bansos</title>
</head>
<body>
    <h1>Daftar Penerima Bansos</h1>

    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('penerima.create') }}">+ Tambah Penerima</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Kode Unik</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penerimas as $p)
                <tr>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->kode_unik }}</td>
                    <td>{{ $p->status ? '✅' : '❌' }}</td>
                    <td>
                        <a href="{{ route('penerima.edit', $p->id) }}">Edit</a> |
                        <a href="{{ route('penerima.barcode', $p->id) }}">Download Barcode</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
