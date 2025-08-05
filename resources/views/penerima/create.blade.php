@extends('layouts.app')

@section('title', 'Tambah Penerima Bansos')

@section('content')
    <h1>Tambah Penerima</h1>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penerima.store') }}" method="POST" style="background: white; padding: 20px; border-radius: 8px;">
        @csrf
        <div style="margin-bottom: 10px;">
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <input type="text" name="nama_ayah" placeholder="Nama Ayah" value="{{ old('nama_ayah') }}" style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <input type="text" name="nama_ibu" placeholder="Nama Ibu" value="{{ old('nama_ibu') }}" style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}" style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <input type="text" name="nama_sekolah" placeholder="Nama Sekolah" value="{{ old('nama_sekolah') }}" style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <select name="tingkat" style="width: 100%; padding: 8px;">
                <option value="SD" @selected(old('tingkat') == 'SD')>SD</option>
                <option value="SMP" @selected(old('tingkat') == 'SMP')>SMP</option>
            </select>
        </div>
        <div style="margin-bottom: 10px;">
            <input type="text" name="kelas" placeholder="Kelas" value="{{ old('kelas') }}" style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <textarea name="alamat" placeholder="Alamat" style="width: 100%; padding: 8px;">{{ old('alamat') }}</textarea>
        </div>
        <div style="margin-bottom: 20px;">
            <select name="status" style="width: 100%; padding: 8px;">
                <option value="1" @selected(old('status') == '1')>Aktif</option>
                <option value="0" @selected(old('status') == '0')>Nonaktif</option>
            </select>
        </div>
        <button type="submit" style="padding: 10px 20px;">Simpan</button>
    </form>
@endsection
