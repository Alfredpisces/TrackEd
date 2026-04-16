@extends('layouts.guest')

@section('title', 'TrackEd | Login')

@section('content')
<div class="w-full max-w-md space-y-4">
  <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
    <div class="bg-blue-900 text-white px-8 py-6 text-center">
      <div class="flex items-center justify-center gap-3">
        <i class="fa-solid fa-school text-2xl"></i>
        <h1 class="text-2xl font-bold tracking-wide">TrackEd</h1>
      </div>
      <p class="text-blue-100 text-sm mt-2">Centralized School Information System</p>
    </div>

    <form method="POST" action="/login" class="px-8 py-7 space-y-5">
      @csrf

      @if(session('status'))
      <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-3">
        <i class="fa-solid fa-circle-check mr-1"></i> {{ session('status') }}
      </div>
      @endif

      @if($errors->any())
      <div class="bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3">
        {{ $errors->first() }}
      </div>
      @endif

      <div>
        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="name@school.edu.ph"
          class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700 @error('email') border-rose-400 @enderror" />
      </div>

      <div>
        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
        <input id="password" name="password" type="password" placeholder="••••••••"
          class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
      </div>

      <button type="submit"
        class="w-full rounded-lg bg-blue-900 hover:bg-blue-800 text-white text-center font-semibold py-2.5 transition-colors">
        <i class="fa-solid fa-right-to-bracket mr-2"></i>Login
      </button>
    </form>
  </div>

  <details class="bg-white border border-slate-200 rounded-xl shadow-sm px-5 py-4 text-sm text-slate-700">
    <summary class="cursor-pointer font-semibold text-blue-900 select-none">
      <i class="fa-solid fa-circle-info mr-1"></i> Demo Credentials (click to expand)
    </summary>
    <table class="mt-3 w-full text-xs border-collapse">
      <thead><tr class="bg-slate-50"><th class="text-left px-2 py-1 font-semibold">Role</th><th class="text-left px-2 py-1 font-semibold">Email</th><th class="text-left px-2 py-1 font-semibold">Password</th></tr></thead>
      <tbody>
        <tr class="border-t border-slate-100 cursor-pointer hover:bg-blue-50" onclick="fillDemo('admin@deped.edu.ph','Admin123')"><td class="px-2 py-1.5">Admin</td><td class="px-2 py-1.5">admin@deped.edu.ph</td><td class="px-2 py-1.5">Admin123</td></tr>
        <tr class="border-t border-slate-100 cursor-pointer hover:bg-blue-50" onclick="fillDemo('schoolhead@deped.edu.ph','Head123')"><td class="px-2 py-1.5">School Head</td><td class="px-2 py-1.5">schoolhead@deped.edu.ph</td><td class="px-2 py-1.5">Head123</td></tr>
        <tr class="border-t border-slate-100 cursor-pointer hover:bg-blue-50" onclick="fillDemo('counselor@deped.edu.ph','Counsel123')"><td class="px-2 py-1.5">Counselor</td><td class="px-2 py-1.5">counselor@deped.edu.ph</td><td class="px-2 py-1.5">Counsel123</td></tr>
        <tr class="border-t border-slate-100 cursor-pointer hover:bg-blue-50" onclick="fillDemo('teacher@deped.edu.ph','Teacher123')"><td class="px-2 py-1.5">Teacher</td><td class="px-2 py-1.5">teacher@deped.edu.ph</td><td class="px-2 py-1.5">Teacher123</td></tr>
      </tbody>
    </table>
    <p class="mt-2 text-slate-500 text-xs">Click any row to auto-fill the form.</p>
  </details>
</div>
@endsection

@section('scripts')
<script>
  function fillDemo(email, password) {
    document.getElementById('email').value    = email;
    document.getElementById('password').value = password;
  }
</script>
@endsection
