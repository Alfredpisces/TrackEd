@extends('layouts.guest')

@section('title', 'TrackEd | Account Creation')

@section('content')
<div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
  <div class="bg-blue-900 text-white px-8 py-6 text-center">
    <div class="flex items-center justify-center gap-3">
      <i class="fa-solid fa-school text-2xl"></i>
      <h1 class="text-2xl font-bold tracking-wide">TrackEd</h1>
    </div>
    <p class="text-blue-100 text-sm mt-2">Centralized School Information System</p>
  </div>

  <div class="px-8 py-10 text-center space-y-4">
    <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto text-2xl">
      <i class="fa-solid fa-lock"></i>
    </div>
    <h2 class="text-lg font-semibold text-slate-800">Account Creation is Restricted</h2>
    <p class="text-sm text-slate-600">
      New accounts can only be created by a <strong>TrackEd Administrator</strong>.<br>
      Please contact your school admin to have your account set up.
    </p>
    <a href="{{ route('login') }}"
       class="inline-block mt-2 rounded-lg bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 text-sm transition-colors">
      <i class="fa-solid fa-arrow-left mr-2"></i>Back to Login
    </a>
  </div>
</div>
@endsection
