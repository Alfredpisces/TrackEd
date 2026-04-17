@extends('layouts.app')

@section('title', 'TrackEd | School Head Dashboard')

@section('page-title', 'School Head Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">DLL Approvals</p>
    <p class="text-3xl font-bold text-blue-900 mt-2">12</p>
    <p class="text-xs text-slate-400 mt-1">Submissions awaiting review.</p>
  </article>
  <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">COT Evaluations</p>
    <p class="text-3xl font-bold text-amber-600 mt-2">8</p>
    <p class="text-xs text-slate-400 mt-1">Ratings encoded for SY 2025-2026.</p>
  </article>
  <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">DSS Rankings</p>
    <p class="text-3xl font-bold text-emerald-600 mt-2">Top 3</p>
    <p class="text-xs text-slate-400 mt-1">Outstanding teacher shortlist.</p>
  </article>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-3">Performance Review Center</h3>
  <p class="text-sm text-slate-600 mb-4">
    Monitor DLL compliance, COT ratings, and professional growth documentation. Use the Teacher Performance module to
    approve or return submissions.
  </p>
  <a href="{{ route('teacher-performance') }}" class="inline-flex items-center bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
    <i class="fa-solid fa-chalkboard-user mr-2"></i>Open Teacher Performance
  </a>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-3">Focus Areas This Week</h3>
  <ul class="list-disc list-inside text-sm text-slate-600 space-y-1">
    <li>Verify DLL submissions for Grade 9 Science and Grade 10 English.</li>
    <li>Finalize COT entries for April observation rounds.</li>
    <li>Run DSS ranking before Friday faculty meeting.</li>
  </ul>
</div>
@endsection
