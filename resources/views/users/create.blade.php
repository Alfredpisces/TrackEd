@extends('layouts.app')

@section('title', 'TrackEd | Create Account')

@section('page-title', 'Create Account')

@section('content')
<div class="max-w-xl">
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-700 mb-5">New User Account</h3>

    @if($errors->any())
    <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3">
      <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
        <input name="name" type="text" value="{{ old('name') }}" placeholder="Juan Dela Cruz"
          class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
        <input name="email" type="email" value="{{ old('email') }}" placeholder="name@school.edu.ph"
          class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
        <input name="password" type="password" placeholder="Min. 8 chars, mixed case + number"
          class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
        <select name="role"
          class="w-full border border-slate-300 rounded-lg px-3 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-blue-700">
          @foreach(['Admin', 'School Head', 'Counselor', 'Teacher'] as $role)
          <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>{{ $role }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Assign to School</label>
        <select name="school_id"
          class="w-full border border-slate-300 rounded-lg px-3 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-blue-700">
          <option value="">— None —</option>
          @foreach($schools as $school)
          <option value="{{ $school->id }}" {{ (string)old('school_id') === (string)$school->id ? 'selected' : '' }}>
            {{ $school->name }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="submit"
          class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors">
          <i class="fa-solid fa-user-plus mr-2"></i>Create Account
        </button>
        <a href="{{ route('users.index') }}"
          class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
