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
  @php($role = Auth::user()->role)
  <div class="min-h-screen flex">

    <aside class="w-64 bg-blue-900 text-blue-100 p-5 hidden md:flex flex-col">
      <div class="flex items-center gap-2 mb-8">
        <i class="fa-solid fa-school text-xl"></i>
        <h1 class="text-xl font-bold">TrackEd</h1>
      </div>
      <nav class="space-y-2 flex-1">
        <a href="{{ route(Auth::user()->dashboardRouteName()) }}"
           class="block px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.*') ? 'bg-blue-800 text-white font-medium' : 'hover:bg-blue-800' }}">
          <i class="fa-solid fa-chart-line mr-2"></i>Dashboard
        </a>
        @if(in_array($role, ['Teacher', 'School Head']))
        <a href="{{ route('teacher-performance') }}"
           class="block px-3 py-2 rounded-lg {{ request()->routeIs('teacher-performance') ? 'bg-blue-800 text-white font-medium' : 'hover:bg-blue-800' }}">
          <i class="fa-solid fa-chalkboard-user mr-2"></i>Teacher Performance
        </a>
        @endif
        @if($role === 'Counselor')
        <a href="{{ route('student-behavior') }}"
           class="block px-3 py-2 rounded-lg {{ request()->routeIs('student-behavior') ? 'bg-blue-800 text-white font-medium' : 'hover:bg-blue-800' }}">
          <i class="fa-solid fa-user-shield mr-2"></i>Student Behavior
        </a>
        @endif
        @if(in_array($role, ['Admin', 'Teacher']))
        <a href="{{ route('property-inventory') }}"
           class="block px-3 py-2 rounded-lg {{ request()->routeIs('property-inventory') ? 'bg-blue-800 text-white font-medium' : 'hover:bg-blue-800' }}">
          <i class="fa-solid fa-box-archive mr-2"></i>Property Inventory
        </a>
        @endif
        @if(Auth::user()->role === 'Admin')
        <a href="{{ route('users.index') }}"
           class="block px-3 py-2 rounded-lg {{ request()->routeIs('users.*') && !request()->routeIs('users.lis-sync') ? 'bg-blue-800 text-white font-medium' : 'hover:bg-blue-800' }}">
          <i class="fa-solid fa-users-gear mr-2"></i>Manage Personnel
        </a>
        <a href="{{ route('users.lis-sync') }}"
           class="block px-3 py-2 rounded-lg {{ request()->routeIs('users.lis-sync') ? 'bg-blue-800 text-white font-medium' : 'hover:bg-blue-800' }}">
          <i class="fa-solid fa-cloud-arrow-up mr-2"></i>LIS Sync
        </a>
        @endif
        <a href="#" class="block px-3 py-2 rounded-lg hover:bg-blue-800">
          <i class="fa-solid fa-gear mr-2"></i>Settings
        </a>
      </nav>
      <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-800 text-blue-200 w-full text-left text-sm">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
      </form>
    </aside>

    <main class="flex-1">
      <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
        <h2 class="text-xl font-bold text-blue-900">@yield('page-title')</h2>
        <div class="flex items-center gap-4">
          @yield('header-extras')
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-full bg-blue-900 text-white grid place-items-center font-semibold text-sm">
              {{ Auth::user()->initials() }}
            </div>
            <div>
              <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
              <p class="text-xs text-slate-500">{{ Auth::user()->role }}</p>
            </div>
          </div>
        </div>
      </header>

      <section class="p-6 space-y-6">
        @yield('content')
      </section>
    </main>

  </div>

  @yield('modal')
  @yield('scripts')
</body>
</html>
