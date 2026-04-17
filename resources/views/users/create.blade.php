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
        <input name="email" type="email" value="{{ old('email') }}" placeholder="name@deped.edu.ph"
          class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-700" />
        <p class="text-xs text-slate-400 mt-1">Use the official DepEd email for authentication and PBAC access.</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Employee ID</label>
        <input name="employee_id" type="text" value="{{ old('employee_id') }}" placeholder="e.g. DEP-2026-00192"
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

      <div class="border-t border-slate-200 pt-4">
        <label class="block text-sm font-medium text-slate-700 mb-2">PBAC Permissions Checklist</label>
        <p class="text-xs text-slate-400 mb-3">Select the functional rights granted to this account.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-slate-700">
          @foreach([
            'Can Submit DLL',
            'Can Approve DLL',
            'Can Encode COT Scores',
            'Can Upload Seminar Certificates',
            'Can Log Incidents',
            'Can Resolve Cases',
            'Can Manage Inventory',
            'Can Generate Clearances',
          ] as $permission)
          <label class="flex items-center gap-2">
            <input type="checkbox" name="permissions[]" value="{{ $permission }}"
              class="rounded border-slate-300 text-blue-800 permission-toggle">
            <span>{{ $permission }}</span>
          </label>
          @endforeach
        </div>
      </div>

      <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 text-sm">
        <p class="font-semibold text-slate-700 mb-2">Selected PBAC Rights</p>
        <ul id="permissionSummary" class="list-disc list-inside text-slate-600 space-y-1">
          <li class="text-slate-400 italic">No permissions selected yet.</li>
        </ul>
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

@section('scripts')
<script>
  const toggles = document.querySelectorAll('.permission-toggle');
  const summary = document.getElementById('permissionSummary');

  function renderSummary() {
    const selected = Array.from(toggles).filter(t => t.checked).map(t => t.value);
    if (!selected.length) {
      summary.innerHTML = '<li class="text-slate-400 italic">No permissions selected yet.</li>';
      return;
    }
    summary.innerHTML = selected.map(p => `<li>${p}</li>`).join('');
  }

  toggles.forEach(t => t.addEventListener('change', renderSummary));
  renderSummary();
</script>
@endsection
