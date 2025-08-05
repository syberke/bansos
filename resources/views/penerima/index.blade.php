@extends('layouts.app')

@section('title', 'Daftar Penerima Bansos')

@section('content')
    <h1>Daftar Penerima Bansos</h1>

    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif
    <a href="{{ route('penerima.exportAllBarcode') }}" style="margin-top: 10px; display: inline-block;">⬇️ Export Semua QR (ZIP)</a>

    <a href="{{ route('penerima.create') }}">+ Tambah Penerima</a>

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px; background: white;">
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Kode Unik</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penerimas as $p)
                <tr>
                    <td>{{ $p['nama_lengkap'] }}</td>
<td>{{ $p['kode_unik'] }}</td>
<td>{{ $p['status'] ? '✅' : '❌' }}</td>
                    <td>
                         |
                        <a href="{{ route('penerima.barcode', $p['id']) }}">Export Barcode</a>



                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada data penerima.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
