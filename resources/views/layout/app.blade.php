<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f5f7fb;
    font-size: 15px;
}

/* ================= SIDEBAR ================= */
.sidebar {
    height: 100vh;
     width: 190px;
    position: fixed;
    left: 0;
    top: 0;
    background: #1e293b;
    color: #fff;
    transition: 0.3s;
    z-index: 999;
}

.sidebar.hide {
    width: 70px;
}

.sidebar.show {
    left: 0;
}

/* Header */
.sidebar-header {
    height: 50px;
    background: linear-gradient(45deg, #0f172a, #1e3a8a);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* Links */
.sidebar a {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #cbd5e1;
    padding: 10px 15px;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #334155;
    color: #fff;
}

.sidebar a.active {
    background: #334155;
    color: #fff !important;
    border-left: 3px solid #3b82f6;
}

.sidebar.hide a span {
    display: none;
}

/* ================= TOPBAR ================= */
.topbar {
    margin-left: 190px;
    height: 50px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 15px;
    border-bottom: 1px solid #ddd;
    transition: 0.3s;
}

.topbar.full {
    margin-left: 70px;
}

/* ================= CONTENT ================= */
.content {
    margin-left: 190px;
    padding: 15px;
    transition: 0.3s;
}

.content.full {
    margin-left: 70px;
}

/* ================= CARDS ================= */
.card-custom {
    border-radius: 12px;
    padding: 15px;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.card-custom:hover {
    transform: translateY(-3px);
}

.card-title {
    font-size: 13px;
    color: #555;
}

.card-value {
    font-size: 22px;
    font-weight: bold;
}

/* ================= GRID ================= */
.five-cols {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 15px;
    width: 100%;
}

/* Tablet */
@media (max-width: 992px) {
    .five-cols {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Mobile */
@media (max-width: 768px) {
    .sidebar {
        left: -190px;
    }

    .topbar,
    .content {
        margin-left: 0;
    }

    .five-cols {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Small Mobile */
@media (max-width: 576px) {
    .five-cols {
        grid-template-columns: 1fr;
    }
}

/* ================= TABLE ================= */
.table-container {
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
    overflow-x: auto;
}

/* ================= TOGGLE ================= */
.toggle-btn {
    font-size: 20px;
    cursor: pointer;
}

/* ================= OVERLAY ================= */
#overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 998;
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    
    <div class="sidebar-header">
        @if (Auth::user()->role== "admin")
        Admin
        @elseif (Auth::user()->role== "headmaster")
        H.Master
        @elseif (Auth::user()->role== "teacher")

        Teacher
        @else
        Supervisor
        @endif
    </div>

    @php
    $current = Route::currentRouteName();
@endphp

@if(Auth::user()->role=="admin")
<a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
</a>

<a href="{{ route('district.index') }}" class="{{ request()->routeIs('district.*') ? 'active' : '' }}">
    <i class="bi bi-geo-alt-fill"></i> <span>Districts</span>
</a>

<a href="{{ route('school.index') }}" class="{{ request()->routeIs('school.*') ? 'active' : '' }}">
    <i class="bi bi-building"></i> <span>Schools</span>
</a>

<a href="{{ route('system-user.index') }}" class="{{ request()->routeIs('system-user.*') ? 'active' : '' }}">
    <i class="bi bi-person-gear"></i> <span>Manage Users</span>
</a>

{{-- <a href="{{ route('schoold') }}" class="{{ request()->routeIs('schoold') ? 'active' : '' }}">
    <i class="bi bi-diagram-3-fill"></i> <span>Workbooks</span>
</a> --}}

<a href="{{ route('vwork') }}" class="">
    <i class="bi bi-file-earmark-bar-graph"></i> <span>View works</span>
</a>
<div class="nav-item dropdown">
    <a href="#" 
       class="nav-link dropdown-toggle {{ request()->routeIs('adminsupervisors.reports') || request()->routeIs('adminsil') ? 'active' : '' }}" 
       id="reportsDropdown" 
       role="button" 
       data-bs-toggle="dropdown" 
       aria-expanded="false">
        <i class="bi bi-file-earmark-bar-graph"></i> <span>Reports</span>
    </a>
    
    <ul class="dropdown-menu" aria-labelledby="reportsDropdown" style="background: black">
        <li>
            <a href="{{ route('adminsupervisors.reports') }}" class="dropdown-item {{ request()->routeIs('adminsupervisors.reports') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow me-2"></i> School Performance
            </a>
        </li>

        
        
        <li>
            <a href="{{ route('adminsil') }}" class="dropdown-item {{ request()->routeIs('adminsil') ? 'active' : '' }}">
                <i class="bi bi-book me-2"></i> Syllabus
            </a>
        </li>
        <li>
            <a href="{{ route('performance') }}" class="dropdown-item {{ request()->routeIs('adminsupervisors.reports') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow me-2"></i> Teacher Performance
            </a>
        </li>
    </ul>
</div>


<a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
    <i class="bi bi-person-circle"></i> <span>Profile</span>
</a>
@elseif(Auth::user()->role =="supervisor")
<a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
</a>
<a href="{{ route('orders.index') }}"
   class="{{ request()->is('orders.index') ? 'active' : '' }}">

    <i class="bi bi-clipboard-check"></i>

    View Orders

    {{-- <span class="badge bg-danger">
        {{ $totalOrders ?? 0 }}
    </span> --}}

</a>
<a href="{{ route('showtl') }}" class="{{ request()->routeIs('showtl') ? 'active' : '' }}">
    <i class="bi bi-person-gear"></i> <span>View Teachers</span>
</a>
<a href="{{ route('adminsil') }}" class="{{ request()->routeIs('showtl') ? 'active' : '' }}">
    <i class="bi bi-person-gear"></i> <span>View report</span>
</a>

<a href="{{ route('supervisor.student.performance.report') }}" class="">
    <i class="bi bi-file-earmark-bar-graph"></i> <span>Send Report</span>
</a>
@elseif(Auth::user()->role =="headmaster")

<a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i>
    <span>Dashboard</span>
</a>

<a href="{{ route('system-user.index') }}"
   class="{{ request()->routeIs('system-user.*') ? 'active' : '' }}">
    <i class="bi bi-person-lines-fill"></i>
    <span>View Teachers</span>
</a>
<a href="{{ route('school-class.index') }}"
   class="{{ request()->routeIs('school-class.*') ? 'active' : '' }}">
    <i class="bi bi-door-open-fill"></i>
    <span>Class Rooms</span>
</a>
<a href="{{ route('student.index') }}"
   class="{{ request()->routeIs('student.index') ? 'active' : '' }}">
    <i class="bi bi-people"></i>
    <span>Student info</span>
</a>

<a href="{{ route('subject.index') }}"
   class="{{ request()->routeIs('subject.*') ? 'active' : '' }}">
    <i class="bi bi-book-fill"></i>
    <span>Subjects</span>
</a>

<a href="{{ route('showtl') }}"
   class="{{ request()->routeIs('showtl') ? 'active' : '' }}">
    <i class="bi bi-journal-text"></i>
    <span>View Lesson Plans</span>
</a>


@elseif(Auth::user()->role =="teacher")

<a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i>
    <span>Dashboard</span>
</a>

<a href="{{ route('subject.index') }}"
   class="{{ request()->routeIs('subject.*') ? 'active' : '' }}">
    <i class="bi bi-book-half"></i>
    <span>Subjects</span>
</a>

<a href="{{ route('lesson-plan.index') }}"
   class="{{ request()->routeIs('lesson-plan.*') ? 'active' : '' }}">
    <i class="bi bi-journal-check"></i>
    <span>Lesson Plan</span>
</a>

<a href="{{ route('assessment.index') }}"
   class="{{ request()->routeIs('assessment.*') ? 'active' : '' }}">
    <i class="bi bi-journal-check"></i>
    <span>Assessment Book</span>
</a>
<a href="{{ route('scheme.index') }}"
   class="{{ request()->routeIs('assessment.*') ? 'active' : '' }}">
    <i class="bi bi-journal-check"></i>
    <span>Schemes of work</span>
</a>

<a href="{{ route('daily-record.index') }}"
   class="{{ request()->routeIs('daily-record.*') ? 'active' : '' }}">
    <i class="bi bi-clipboard-data-fill"></i>
    <span>Daily Record</span>
</a>

@endif

<a href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>




</div>

<!-- Navbar -->
<div class="topbar d-flex justify-content-between align-items-center px-3" id="topbar">
    
    <div class="d-flex align-items-center gap-2">
        <span class="toggle-btn" onclick="toggleSidebar()">☰</span>
        <h6 class="mb-0">Dashboard</h6>
    </div>

    
</div>

<!-- Content -->
@yield("content")
<script>
function toggleSidebar() {
    let sidebar = document.getElementById("sidebar");
    let content = document.getElementById("content");
    let topbar = document.getElementById("topbar");
    let overlay = document.getElementById("overlay");

    if (window.innerWidth < 768) {
        sidebar.classList.toggle("show");

        if (sidebar.classList.contains("show")) {
            overlay.style.display = "block";
        } else {
            overlay.style.display = "none";
        }

    } else {
        sidebar.classList.toggle("hide");
        content.classList.toggle("full");
        topbar.classList.toggle("full");
    }
}

/* Close sidebar when clicking overlay */
document.getElementById("overlay").addEventListener("click", function () {
    document.getElementById("sidebar").classList.remove("show");
    this.style.display = "none";
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>