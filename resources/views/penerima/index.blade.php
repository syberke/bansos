@extends('layouts.app')

@section('title', 'Daftar Penerima Bansos')

@section('content')
    <h1>Daftar Penerima Bansos</h1>

    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('penerima.exportAllBarcode') }}" style="margin-top: 10px; display: inline-block;">⬇️ Export Semua QR (ZIP)</a>


    {{-- Jika form create masih dari DB lokal, tampilkan ini. Kalau tidak, bisa disembunyikan --}}
    {{-- <a href="{{ route('penerima.create') }}">+ Tambah Penerima</a> --}}

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px; background: white;">
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Tempat lahir</th>
                <th>Nama Sekolah</th>
                <th>Tingkat</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th>Kode Unik</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penerimas as $p)
                <tr>
                    <td>{{ $p['nama_lengkap'] ?? '-' }}</td>
                    <td>{{ $p['tempat_lahir'] ?? '-' }}</td>
                    <td>{{ $p['nama_sekolah'] ?? '-' }}</td>
                    <td>{{ $p['tingkat'] ?? '-' }}</td>
                    <td>{{ $p['kelas'] ?? '-' }}</td>
                    <td>{{ $p['alamat'] ?? '-' }}</td>
                    <td>{{ $p['kode_unik'] ?? '-' }}</td>
                    <td>
                        @if (isset($p['status']) && ($p['status'] == 1 || $p['status'] == '1' || $p['status'] === true))
                            ✅
                        @else
                            ❌
                        @endif
                    </td>
                    <td>
                        {{-- Edit akan error jika tidak ada route dan ID dari DB --}}
                        {{-- <a href="{{ route('penerima.edit', $p['id']) }}">Edit</a> | --}}

                        @if (isset($p['kode_unik']))
                            <a href="{{ route('penerima.export', ['kode' => $p['kode_unik']]) }}">Download Barcode</a>

                        @else
                            -
                        @endif
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
