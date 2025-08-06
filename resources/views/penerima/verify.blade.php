@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Verifikasi Kode Unik</h3>

    @if (session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('verifikasi.kode') }}">
        @csrf
        <div>
            <label for="kode_unik">Masukkan Kode Unik:</label><br>
            <input type="text" name="kode_unik" id="kode_unik" value="{{ old('kode_unik') }}" required>
        </div>
        <br>
        <button type="submit">Verifikasi</button>
    </form>
</div>
@endsection
