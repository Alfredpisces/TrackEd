<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'TrackEd')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  @yield('head-scripts')
</head>
<body class="bg-slate-100 text-slate-800">
  @php
    $role = optional(Auth::user())->role ?? '';
    $prototypeProfile = ['name' => 'Dr. Maria Santos', 'role' => 'School Head', 'initials' => 'MS'];
    $profileName     = optional(Auth::user())->name     ?? $prototypeProfile['name'];
    $profileRole     = optional(Auth::user())->role     ?? $prototypeProfile['role'];
    $profileInitials = method_exists(optional(Auth::user()), 'initials') ? (Auth::user() ? Auth::user()->initials() : $prototypeProfile['initials']) : $prototypeProfile['initials'];
  @endphp

  <div class="min-h-screen flex">

    {{-- ── Left Sidebar ── --}}
    <aside class="w-72 bg-blue-900 text-blue-100 p-6 hidden lg:flex flex-col shadow-2xl">
      <div class="flex items-center gap-3 mb-8">
        <div class="w-11 h-11 rounded-xl bg-blue-700 grid place-items-center">
          <i class="fa-solid fa-school text-white text-lg"></i>
        </div>
        <div>
          <h1 class="text-xl font-bold tracking-wide">TrackEd</h1>
          <p class="text-xs text-blue-300">DepEd Information System</p>
        </div>
      </div>

      <nav class="space-y-1 flex-1">
        {{-- Dashboard (all roles) --}}
        <a href="{{ Auth::check() ? route(Auth::user()->dashboardRouteName()) : '/head' }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                  {{ request()->routeIs('dashboard.*') ? 'bg-blue-800 text-white font-semibold shadow-lg shadow-blue-950/40' : 'hover:bg-blue-800/60 text-blue-100' }}">
          <i class="fa-solid fa-chart-line w-4 text-center"></i>
          <span>Dashboard</span>
        </a>

        {{-- Teacher Performance (Teacher / School Head) --}}
        @if(in_array($role, ['Teacher', 'School Head']))
        <a href="{{ route('teacher-performance') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                  {{ request()->routeIs('teacher-performance') ? 'bg-blue-800 text-white font-semibold shadow-lg shadow-blue-950/40' : 'hover:bg-blue-800/60 text-blue-100' }}">
          <i class="fa-solid fa-chalkboard-user w-4 text-center"></i>
          <span>Teacher Performance</span>
        </a>
        @endif

        {{-- Student Behavior (Counselor) --}}
        @if($role === 'Counselor')
        <a href="{{ route('student-behavior') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                  {{ request()->routeIs('student-behavior') ? 'bg-blue-800 text-white font-semibold shadow-lg shadow-blue-950/40' : 'hover:bg-blue-800/60 text-blue-100' }}">
          <i class="fa-solid fa-user-shield w-4 text-center"></i>
          <span>Student Behavior</span>
        </a>
        @endif

        {{-- Property Inventory (Admin / Teacher) --}}
        @if(in_array($role, ['Admin', 'Teacher']))
        <a href="{{ route('property-inventory') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                  {{ request()->routeIs('property-inventory') ? 'bg-blue-800 text-white font-semibold shadow-lg shadow-blue-950/40' : 'hover:bg-blue-800/60 text-blue-100' }}">
          <i class="fa-solid fa-box-archive w-4 text-center"></i>
          <span>Property Inventory</span>
        </a>
        @endif

        {{-- Manage Personnel (Admin) --}}
        @if($role === 'Admin')
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                  {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.transfer') ? 'bg-blue-800 text-white font-semibold shadow-lg shadow-blue-950/40' : 'hover:bg-blue-800/60 text-blue-100' }}">
          <i class="fa-solid fa-users-gear w-4 text-center"></i>
          <span>Manage Personnel</span>
        </a>
        <a href="{{ route('users.lis-sync') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                  {{ request()->routeIs('users.lis-sync') ? 'bg-blue-800 text-white font-semibold shadow-lg shadow-blue-950/40' : 'hover:bg-blue-800/60 text-blue-100' }}">
          <i class="fa-solid fa-cloud-arrow-up w-4 text-center"></i>
          <span>LIS Sync</span>
        </a>
        @endif
      </nav>

      <div class="mt-4 rounded-xl bg-blue-800/60 p-4 text-xs text-blue-100">
        <p class="font-semibold">SY 2026-2027</p>
        <p class="mt-1 text-blue-300">Centralized monitoring for DLL, discipline, and inventory accountability.</p>
      </div>

      @if(Auth::check())
      <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit"
                class="flex items-center gap-2 w-full px-4 py-2.5 rounded-xl text-sm text-blue-200 hover:bg-blue-800/60 transition">
          <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
          <span>Logout</span>
        </button>
      </form>
      @endif
    </aside>

    {{-- ── Main Content ── --}}
    <main class="flex-1 min-w-0">
      <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-4 flex items-center justify-between shadow-sm">
        <div>
          <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">TrackEd · Department of Education</p>
          <h2 class="text-xl font-bold text-blue-900">@yield('page-title', 'Dashboard')</h2>
        </div>
        <div class="flex items-center gap-3">
          @yield('header-extras')
          <button type="button"
                  class="relative w-10 h-10 rounded-full border border-slate-200 bg-white hover:bg-slate-50 grid place-items-center">
            <i class="fa-regular fa-bell text-slate-500"></i>
            <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] rounded-full px-1.5">3</span>
          </button>
          <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2">
            <div class="w-9 h-9 rounded-full bg-blue-900 text-white grid place-items-center font-semibold text-sm">{{ $profileInitials }}</div>
            <div class="hidden sm:block">
              <p class="text-sm font-semibold leading-tight">{{ $profileName }}</p>
              <p class="text-xs text-slate-500">{{ $profileRole }}</p>
            </div>
          </div>
          {{-- Logout button visible on mobile (sidebar is hidden on small screens) --}}
          @if(Auth::check())
          <form action="{{ route('logout') }}" method="POST" class="lg:hidden">
            @csrf
            <button type="submit"
                    class="w-10 h-10 rounded-full border border-slate-200 bg-white hover:bg-rose-50 hover:border-rose-300 grid place-items-center transition"
                    title="Logout">
              <i class="fa-solid fa-right-from-bracket text-slate-500 hover:text-rose-500"></i>
            </button>
          </form>
          @endif
        </div>
      </header>

      <section class="p-4 sm:p-6 space-y-6">
        @yield('content')
      </section>
    </main>

  </div>

  @yield('modal')
  @yield('scripts')
</body>
</html>
