<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Aplikasi')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }
        .sidebar {
            width: 220px;
            background-color: #1e293b;
            color: #fff;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }
        .content {
            margin-left: 240px; /* Sesuaikan dgn sidebar */
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="{{ url('/') }}">Dashboard</a>
        <a href="{{ url('/qr-codes') }}">QR Codes</a>
        <a href="{{ url('/settings') }}">Pengaturan</a>
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>
