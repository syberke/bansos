<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penerima Bansos</title>
</head>
<body>
    <h1>Tambah Penerima</h1>

    @if ($errors->any())
        <div style="color: red">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penerima.store') }}" method="POST">
        @csrf
        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap"><br>
        <input type="text" name="nama_ayah" placeholder="Nama Ayah"><br>
        <input type="text" name="nama_ibu" placeholder="Nama Ibu"><br>
        <input type="text" name="tempat_lahir" placeholder="Tempat Lahir"><br>
        <input type="date" name="tanggal_lahir"><br>
        <input type="text" name="nama_sekolah" placeholder="Nama Sekolah"><br>
        <select name="tingkat">
            <option value="SD">SD</option>
            <option value="SMP">SMP</option>
        </select><br>
        <input type="text" name="kelas" placeholder="Kelas"><br>
        <textarea name="alamat" placeholder="Alamat"></textarea><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
