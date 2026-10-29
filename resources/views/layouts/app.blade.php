<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DEL-LEATS')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="site-header">
        <h1>DEL-LEATS</h1>
        <nav class="main-nav">
            <a href="{{ route('equipments.index') }}" class="{{ request()->routeIs('equipments.index', 'equipments.show') ? 'active' : '' }}">Katalog Aset</a>
            <a href="{{ route('equipments.create') }}" class="{{ request()->routeIs('equipments.create') ? 'active' : '' }}">Tambah Aset</a>
            <a href="{{ route('loans.index') }}" class="{{ request()->routeIs('loans.index') ? 'active' : '' }}">Riwayat Peminjaman</a>
        </nav>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} DEL Lab Equipment &amp; Asset Tracking System</p>
    </footer>
</body>
</html>