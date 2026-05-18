<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IT-Ops Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">IT-Ops Center</a>
            <div class="d-flex">
                <span class="text-white">ยินดีต้อนรับ, Admin</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
    <a href="{{ route('maintenances.index') }}" class="list-group-item list-group-item-action {{ request()->is('maintenances*') ? 'active' : '' }}">
        📊 Dashboard
    </a>
    @if(auth()->user() && auth()->user()->role == 'admin')
    <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action {{ request()->is('users*') ? 'active' : '' }}">
        👥 จัดการพนักงาน
    </a>
    
    <a href="{{ route('assets.index') }}" class="list-group-item list-group-item-action {{ request()->is('assets*') ? 'active' : '' }}">
        💻 จัดการอุปกรณ์
    </a>
    @endif
</div>
            </div>
            <div class="col-md-9">
                @yield('content') </div>
        </div>
    </div>
</body>
</html>