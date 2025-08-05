@extends('layouts.app')

@section('title', 'Edit Penerima Bansos')

@section('content')
    <h1>Edit Penerima</h1>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penerima.update', $penerima->id) }}" method="POST" style="background: white; padding: 20px; border-radius: 8px;">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Lengkap</label><br>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $penerima->nama_lengkap) }}" required>
        </div>
        <div>
            <label>Nama Ayah</label><br>
            <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $penerima->nama_ayah) }}">
        </div>
        <div>
            <label>Nama Ibu</label><br>
            <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $penerima->nama_ibu) }}">
        </div>
        <div>
            <label>Tempat Lahir</label><br>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $penerima->tempat_lahir) }}">
        </div>
        <div>
            <label>Tanggal Lahir</label><br>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penerima->tanggal_lahir) }}">
        </div>
        <div>
            <label>Nama Sekolah</label><br>
            <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $penerima->nama_sekolah) }}">
        </div>
        <div>
            <label>Tingkat Sekolah</label><br>
            <select name="tingkat">
                <option value="SD" @selected(old('tingkat', $penerima->tingkat) === 'SD')>SD</option>
                <option value="SMP" @selected(old('tingkat', $penerima->tingkat) === 'SMP')>SMP</option>
            </select>
        </div>
        <div>
            <label>Kelas</label><br>
            <input type="text" name="kelas" value="{{ old('kelas', $penerima->kelas) }}">
        </div>
        <div>
            <label>Alamat</label><br>
            <textarea name="alamat">{{ old('alamat', $penerima->alamat) }}</textarea>
        </div>
        <div>
            <label>Status</label><br>
            <select name="status">
                <option value="1" @selected(old('status', $penerima->status) == true)>Aktif</option>
                <option value="0" @selected(old('status', $penerima->status) == false)>Nonaktif</option>
            </select>
        </div>
        <br>
        <button type="submit">Update</button>
    </form>
@endsection
