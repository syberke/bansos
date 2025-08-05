<!DOCTYPE html>
<html>
<head>
    <title>Edit Penerima Bansos</title>
</head>
<body>
    <h1>Edit Penerima</h1>

    @if ($errors->any())
        <div style="color: red">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penerima.update', $penerima->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="nama_lengkap" value="{{ $penerima->nama_lengkap }}"><br>
        <input type="text" name="nama_ayah" value="{{ $penerima->nama_ayah }}"><br>
        <input type="text" name="nama_ibu" value="{{ $penerima->nama_ibu }}"><br>
        <input type="text" name="tempat_lahir" value="{{ $penerima->tempat_lahir }}"><br>
        <input type="date" name="tanggal_lahir" value="{{ $penerima->tanggal_lahir }}"><br>
        <input type="text" name="nama_sekolah" value="{{ $penerima->nama_sekolah }}"><br>
        <select name="tingkat">
            <option value="SD" @selected($penerima->tingkat === 'SD')>SD</option>
            <option value="SMP" @selected($penerima->tingkat === 'SMP')>SMP</option>
        </select><br>
        <input type="text" name="kelas" value="{{ $penerima->kelas }}"><br>
        <textarea name="alamat">{{ $penerima->alamat }}</textarea><br>
        <select name="status">
            <option value="1" @selected($penerima->status==true)>Aktif</option>
            <option value="0" @selected($penerima->status==false)>Nonaktif</option>
        </select><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
