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
    $currentPath = request()->path();
    $prototypeProfile = ['name' => 'Dr. Maria Santos', 'role' => 'School Head', 'initials' => 'MS'];
    $profileName = optional(Auth::user())->name ?? $prototypeProfile['name'];
    $profileRole = optional(Auth::user())->role ?? $prototypeProfile['role'];
    $profileInitials = optional(Auth::user())->initials() ?? $prototypeProfile['initials'];
    $sidebarLinks = [
      ['label' => 'Dashboard', 'icon' => 'fa-chart-line', 'href' => '/head', 'match' => ['admin', 'head', 'counselor', 'teacher']],
      ['label' => 'User Management', 'icon' => 'fa-users-gear', 'href' => '/admin', 'match' => ['admin']],
      ['label' => 'Performance', 'icon' => 'fa-chalkboard-user', 'href' => '/head', 'match' => ['head']],
      ['label' => 'Discipline', 'icon' => 'fa-user-shield', 'href' => '/counselor', 'match' => ['counselor']],
      ['label' => 'Inventory', 'icon' => 'fa-box-archive', 'href' => '/teacher', 'match' => ['teacher']],
    ];
  @endphp

  <div class="min-h-screen flex">
    <aside class="w-72 bg-blue-900 text-blue-100 p-6 hidden lg:flex flex-col shadow-2xl">
      <div class="flex items-center gap-3 mb-8">
        <div class="w-11 h-11 rounded-xl bg-blue-700 grid place-items-center">
          <i class="fa-solid fa-school text-white text-lg"></i>
        </div>
        <div>
          <h1 class="text-xl font-bold tracking-wide">TrackEd</h1>
          <p class="text-xs text-blue-200">DepEd Information System</p>
        </div>
      </div>

      <nav class="space-y-2 flex-1">
        @foreach($sidebarLinks as $link)
          @php($active = in_array($currentPath, $link['match']))
          <a href="{{ $link['href'] }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $active ? 'bg-blue-800 text-white font-semibold shadow-lg shadow-blue-950/50' : 'hover:bg-blue-800/70 text-blue-100' }}">
            <i class="fa-solid {{ $link['icon'] }} w-4 text-center"></i>
            <span>{{ $link['label'] }}</span>
          </a>
        @endforeach
      </nav>

      <div class="mt-6 rounded-xl bg-blue-800/70 p-4 text-xs text-blue-100">
        <p class="font-semibold">SY 2026-2027</p>
        <p class="mt-1 text-blue-200">Centralized monitoring for DLL, discipline, and inventory accountability.</p>
      </div>
    </aside>

    <main class="flex-1 min-w-0">
      <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-blue-900 text-white grid place-items-center">
            <i class="fa-solid fa-school"></i>
          </div>
          <div>
            <p class="text-sm text-slate-500">TrackEd · Department of Education</p>
            <h2 class="text-xl font-bold text-blue-900">@yield('page-title', 'Dashboard')</h2>
          </div>
        </div>
        <div class="flex items-center gap-4">
          <button type="button" class="relative w-10 h-10 rounded-full border border-slate-200 bg-white hover:bg-slate-50">
            <i class="fa-regular fa-bell text-slate-600"></i>
            <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] rounded-full px-1.5">3</span>
          </button>
          <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2">
            <div class="w-10 h-10 rounded-full bg-blue-900 text-white grid place-items-center font-semibold text-sm">{{ $profileInitials }}</div>
            <div>
              <p class="text-sm font-semibold leading-tight">{{ $profileName }}</p>
              <p class="text-xs text-slate-500">{{ $profileRole }}</p>
            </div>
          </div>
        </div>
      </header>

      <section class="p-4 sm:p-6 space-y-6">
        @yield('content')
      </section>
    </main>
  </div>

  @yield('scripts')
</body>
</html>
