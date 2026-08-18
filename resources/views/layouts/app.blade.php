<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TLU Club System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --sidebar: #073664; --sidebar-hover: #105797; --primary: #1769e0; }
        body { background: #f4f7fb; color: #24354b; font-size: .94rem; }
        .sidebar { background: linear-gradient(180deg, #073664, #052a50); min-height: 100vh; width: 245px; position: fixed; inset: 0 auto 0 0; color: #fff; z-index: 10; }
        .brand { border-bottom: 1px solid rgba(255,255,255,.16); padding: 1.15rem 1.25rem; font-weight: 700; line-height: 1.3; }
        .brand small { display: block; opacity: .7; font-size: .7rem; font-weight: 500; letter-spacing: .04em; }
        .nav-link { color: rgba(255,255,255,.83); border-radius: .45rem; margin: .15rem .7rem; padding: .62rem .75rem; }
        .nav-link:hover, .nav-link.active { color: #fff; background: var(--sidebar-hover); }
        .nav-link i { width: 1.35rem; margin-right: .35rem; }
        .main { margin-left: 245px; min-height: 100vh; }
        .topbar { height: 68px; background: #fff; border-bottom: 1px solid #e6ebf2; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; }
        .page { padding: 1.8rem 2rem; }
        .page-title { font-size: 1.35rem; font-weight: 700; margin: 0; color: #123b69; }
        .page-subtitle { color: #738196; font-size: .86rem; }
        .card { border: 0; border-radius: .8rem; box-shadow: 0 2px 12px rgba(28, 57, 91, .08); }
        .stat-card { overflow: hidden; border-left: 4px solid var(--primary); }
        .stat-value { color: #123b69; font-size: 1.55rem; font-weight: 700; }
        .table > :not(caption) > * > * { padding: .78rem .75rem; vertical-align: middle; }
        .table thead th { background: #f0f5fb; color: #35506e; white-space: nowrap; font-size: .8rem; }
        .badge { font-weight: 600; }
        .form-label { font-weight: 600; color: #344b66; }
        .required::after { content: ' *'; color: #dc3545; }
        .empty-state { color: #8492a6; padding: 2.5rem !important; }
        @media (max-width: 992px) { .sidebar { width: 70px; } .brand span, .sidebar .nav-link span { display: none; } .brand { padding: 1.2rem .9rem; } .sidebar .nav-link { text-align: center; margin: .15rem .35rem; } .sidebar .nav-link i { margin: 0; font-size: 1.15rem; } .main { margin-left: 70px; } .topbar, .page { padding-left: 1rem; padding-right: 1rem; } }
    </style>
</head>
@php($routeName = request()->route()?->getName() ?? '')
<body>
    <aside class="sidebar">
        <div class="brand"><i class="bi bi-mortarboard-fill me-1"></i><span>ĐẠI HỌC THỦY LỢI</span><small>CLUB SYSTEM</small></div>
        <nav class="pt-3">
            <a class="nav-link {{ $routeName === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2"></i><span>Dashboard</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'clubs.') ? 'active' : '' }}" href="{{ route('clubs.index') }}"><i class="bi bi-people"></i><span>Câu lạc bộ</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'club_roles.') ? 'active' : '' }}" href="{{ route('club_roles.index') }}"><i class="bi bi-person-badge"></i><span>Chức vụ CLB</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'club_members.') ? 'active' : '' }}" href="{{ route('club_members.index') }}"><i class="bi bi-person-lines-fill"></i><span>Thành viên</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'event-categories.') ? 'active' : '' }}" href="{{ route('event-categories.index') }}"><i class="bi bi-tags"></i><span>Loại sự kiện</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'events.') ? 'active' : '' }}" href="{{ route('events.index') }}"><i class="bi bi-calendar-event"></i><span>Sự kiện</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'event-approvals.') ? 'active' : '' }}" href="{{ route('event-approvals.index') }}"><i class="bi bi-check2-square"></i><span>Duyệt sự kiện</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'registrations.') ? 'active' : '' }}" href="{{ route('registrations.index') }}"><i class="bi bi-clipboard-check"></i><span>Đăng ký</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'checkins.') ? 'active' : '' }}" href="{{ route('checkins.index') }}"><i class="bi bi-box-arrow-in-right"></i><span>Check-in</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'activity-point-rules.') || str_starts_with($routeName, 'student-points.') ? 'active' : '' }}" href="{{ route('student-points.index') }}"><i class="bi bi-award"></i><span>Điểm hoạt động</span></a>
            <a class="nav-link {{ str_starts_with($routeName, 'certificates.') ? 'active' : '' }}" href="{{ route('certificates.index') }}"><i class="bi bi-patch-check"></i><span>Chứng nhận</span></a>
        </nav>
    </aside>
    <div class="main">
        <header class="topbar"><strong>Hệ thống quản lý CLB, sự kiện và điểm hoạt động</strong><div class="text-secondary"><i class="bi bi-person-circle me-1"></i>Chế độ demo cán bộ</div></header>
        <main class="page">
            @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
            @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
