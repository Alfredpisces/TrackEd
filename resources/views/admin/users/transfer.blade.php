@extends('layouts.app')

@section('title', 'TrackEd | Transfer User')

@section('page-title', 'Transfer User')

@section('content')
<div class="max-w-xl">
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">

    {{-- User summary --}}
    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-200">
      <div class="w-12 h-12 rounded-full bg-blue-900 text-white grid place-items-center font-semibold">
        {{ $user->initials() }}
      </div>
      <div>
        <p class="font-semibold text-slate-800">{{ $user->name }}</p>
        <p class="text-sm text-slate-500">{{ $user->role }} &mdash; {{ $user->school?->name ?? 'No school assigned' }}</p>
        @if($user->transferred_at)
        <p class="text-xs text-amber-600 mt-0.5">
          <i class="fa-solid fa-right-left mr-1"></i>
          Last transferred {{ $user->transferred_at->format('M d, Y') }}
          from {{ $user->previousSchool?->name ?? 'unknown' }}
        </p>
        @endif
      </div>
    </div>

    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3">
      {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('users.doTransfer', $user) }}" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Transfer to School</label>
        @if($schools->isEmpty())
        <p class="text-sm text-slate-500 italic">No other schools are registered. Add another school first.</p>
        @else
        <select name="school_id"
          class="w-full border border-slate-300 rounded-lg px-3 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-blue-700">
          <option value="">— Select destination school —</option>
          @foreach($schools as $school)
          <option value="{{ $school->id }}">{{ $school->name }}@if($school->division), {{ $school->division }}@endif</option>
          @endforeach
        </select>
        @endif
      </div>

      <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-sm text-amber-800">
        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
        <strong>Before transferring:</strong> ensure the user has settled all property accountability items
        (clearance status must be 100%).
      </div>

      <div class="flex gap-3">
        <button type="submit" {{ $schools->isEmpty() ? 'disabled' : '' }}
          class="bg-amber-500 hover:bg-amber-400 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
          <i class="fa-solid fa-right-left mr-2"></i>Confirm Transfer
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
