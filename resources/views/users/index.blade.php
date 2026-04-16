@extends('layouts.app')

@section('title', 'TrackEd | Manage Users')

@section('page-title', 'Manage Users')

@section('header-extras')
<a href="{{ route('users.create') }}"
   class="flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
  <i class="fa-solid fa-user-plus"></i> New Account
</a>
@endsection

@section('content')
@if(session('success'))
<div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-3">
  <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-slate-100 text-slate-600">
      <tr>
        <th class="text-left px-4 py-3">Name</th>
        <th class="text-left px-4 py-3">Email</th>
        <th class="text-left px-4 py-3">Role</th>
        <th class="text-left px-4 py-3">School</th>
        <th class="text-left px-4 py-3">Last Transfer</th>
        <th class="text-left px-4 py-3">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $u)
      @php
        $roleBadge = match($u->role) {
          'Admin'       => 'bg-rose-100 text-rose-700',
          'School Head' => 'bg-purple-100 text-purple-700',
          'Counselor'   => 'bg-blue-100 text-blue-700',
          default       => 'bg-slate-100 text-slate-600',
        };
      @endphp
      <tr class="border-b border-slate-100 hover:bg-slate-50">
        <td class="px-4 py-3 font-medium">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-blue-900 text-white grid place-items-center text-xs font-semibold">
              {{ $u->initials() }}
            </div>
            {{ $u->name }}
            @if($u->id === Auth::id())
            <span class="text-xs text-slate-400">(you)</span>
            @endif
          </div>
        </td>
        <td class="px-4 py-3 text-slate-600">{{ $u->email }}</td>
        <td class="px-4 py-3">
          <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $roleBadge }}">{{ $u->role }}</span>
        </td>
        <td class="px-4 py-3 text-slate-600">{{ $u->school?->name ?? '—' }}</td>
        <td class="px-4 py-3 text-slate-500 text-xs">
          @if($u->transferred_at)
            {{ $u->transferred_at->format('M d, Y') }}<br>
            <span class="text-slate-400">from {{ $u->previousSchool?->name ?? 'unknown' }}</span>
          @else
            —
          @endif
        </td>
        <td class="px-4 py-3">
          @if($u->id !== Auth::id())
          <a href="{{ route('users.transfer', $u) }}"
             class="text-xs bg-amber-500 hover:bg-amber-400 text-white px-3 py-1.5 rounded-lg font-medium">
            <i class="fa-solid fa-right-left mr-1"></i>Transfer
          </a>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="px-4 py-6 text-center text-slate-400 italic">No users found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
