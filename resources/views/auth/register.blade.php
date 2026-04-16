@extends('layouts.guest')

@section('title', 'TrackEd | Register')

@section('content')
<div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
  <div class="bg-blue-900 text-white px-8 py-6 text-center">
    <div class="flex items-center justify-center gap-3">
      <i class="fa-solid fa-school text-2xl"></i>
      <h1 class="text-2xl font-bold tracking-wide">TrackEd</h1>
    </div>
    <p class="text-blue-100 text-sm mt-2">Create Your Account</p>
  </div>

  <form id="registerForm" class="px-8 py-7 space-y-4" novalidate>
    <div id="errorBanner" class="hidden bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3"></div>
    <div id="successBanner" class="hidden bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-3"></div>

    <div>
      <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Full Name</label>
      <input id="name" type="text" placeholder="Juan Dela Cruz"
        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
    </div>

    <div>
      <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
      <input id="email" type="email" placeholder="name@school.edu.ph"
        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
    </div>

    <div>
      <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
      <input id="password" type="password" placeholder="Min. 8 characters"
        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
    </div>

    <div>
      <label for="confirm" class="block text-sm font-semibold text-slate-700 mb-1">Confirm Password</label>
      <input id="confirm" type="password" placeholder="Repeat password"
        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
    </div>

    <div>
      <label for="role" class="block text-sm font-semibold text-slate-700 mb-1">Role</label>
      <select id="role"
        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-blue-700">
        <option>Admin</option>
        <option>School Head</option>
        <option>Counselor</option>
        <option>Teacher</option>
      </select>
    </div>

    <button type="submit"
      class="w-full rounded-lg bg-blue-900 hover:bg-blue-800 text-white text-center font-semibold py-2.5 transition-colors">
      Create Account
    </button>

    <p class="text-center text-sm text-slate-600">
      Already have an account?
      <a href="{{ route('login') }}" class="text-blue-700 font-semibold hover:underline">Login</a>
    </p>
  </form>
</div>
@endsection

@section('scripts')
<script>
  if (Auth.getUser()) window.location.replace('/dashboard');

  document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const name     = document.getElementById('name').value.trim();
    const email    = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirm  = document.getElementById('confirm').value;
    const role     = document.getElementById('role').value;

    const errorBanner   = document.getElementById('errorBanner');
    const successBanner = document.getElementById('successBanner');
    errorBanner.classList.add('hidden');
    successBanner.classList.add('hidden');

    if (!name || !email || !password) {
      errorBanner.textContent = 'All fields are required.';
      errorBanner.classList.remove('hidden');
      return;
    }
    if (password.length < 8) {
      errorBanner.textContent = 'Password must be at least 8 characters.';
      errorBanner.classList.remove('hidden');
      return;
    }
    if (password !== confirm) {
      errorBanner.textContent = 'Passwords do not match.';
      errorBanner.classList.remove('hidden');
      return;
    }

    const result = Auth.register(name, email, password, role);
    if (!result.ok) {
      errorBanner.textContent = result.msg;
      errorBanner.classList.remove('hidden');
      return;
    }

    successBanner.textContent = 'Account created! Redirecting to login…';
    successBanner.classList.remove('hidden');
    setTimeout(() => window.location.href = '/?registered=1', 1500);
  });
</script>
@endsection
