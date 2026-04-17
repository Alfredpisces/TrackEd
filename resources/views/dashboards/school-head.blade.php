@extends('layouts.app')

@section('title', 'TrackEd | School Head Dashboard')
@section('page-title', 'School Head Dashboard')

@section('head-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')

{{-- ── KPI Summary Cards ── --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">DLL Approvals Pending</p>
    <p class="text-3xl font-bold text-blue-900 mt-2">12</p>
    <p class="text-xs text-slate-400 mt-1">Submissions awaiting your review.</p>
  </article>
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">COT Evaluations</p>
    <p class="text-3xl font-bold text-amber-600 mt-2">8</p>
    <p class="text-xs text-slate-400 mt-1">Ratings encoded for SY 2026-2027.</p>
  </article>
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">DSS Rankings</p>
    <p class="text-3xl font-bold text-emerald-600 mt-2">Top 3</p>
    <p class="text-xs text-slate-400 mt-1">Outstanding teacher shortlist.</p>
  </article>
</div>

{{-- ── Analytics Charts ── --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">DLL Compliance % by Department</h3>
    <p class="text-sm text-slate-500">Weekly submission completion, SY 2026-2027 Q1.</p>
    <canvas id="dllComplianceChart" class="mt-4" height="200"></canvas>
  </section>
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">Behavioral Incidents Distribution</h3>
    <p class="text-sm text-slate-500">Current month guidance office reports.</p>
    <canvas id="behaviorChart" class="mt-4" height="200"></canvas>
  </section>
</div>

{{-- ── Pending DLL Approvals ── --}}
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
    <div>
      <h3 class="text-lg font-semibold text-slate-800">Pending DLL Approvals</h3>
      <p class="text-sm text-slate-500">Review and action required from School Head.</p>
    </div>
    <a href="{{ route('teacher-performance') }}"
       class="text-sm text-blue-900 font-semibold hover:underline">
      Open Full Module →
    </a>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="text-left px-6 py-3 font-semibold">Teacher</th>
          <th class="text-left px-6 py-3 font-semibold">Subject / Grade</th>
          <th class="text-left px-6 py-3 font-semibold">Week Covered</th>
          <th class="text-left px-6 py-3 font-semibold">Submitted</th>
          <th class="text-left px-6 py-3 font-semibold">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        <tr>
          <td class="px-6 py-4 font-medium">Ana Mae Gonzales</td>
          <td class="px-6 py-4">Science 9</td>
          <td class="px-6 py-4">Week 4 (June 24–28)</td>
          <td class="px-6 py-4 text-slate-400">June 23, 2026</td>
          <td class="px-6 py-4 space-x-2">
            <button class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Approve</button>
            <button class="bg-rose-600 hover:bg-rose-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Return</button>
          </td>
        </tr>
        <tr>
          <td class="px-6 py-4 font-medium">Leo M. Flores</td>
          <td class="px-6 py-4">English 10</td>
          <td class="px-6 py-4">Week 4 (June 24–28)</td>
          <td class="px-6 py-4 text-slate-400">June 23, 2026</td>
          <td class="px-6 py-4 space-x-2">
            <button class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Approve</button>
            <button class="bg-rose-600 hover:bg-rose-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Return</button>
          </td>
        </tr>
        <tr>
          <td class="px-6 py-4 font-medium">Jericho T. Santos</td>
          <td class="px-6 py-4">Mathematics 8</td>
          <td class="px-6 py-4">Week 4 (June 24–28)</td>
          <td class="px-6 py-4 text-slate-400">June 24, 2026</td>
          <td class="px-6 py-4 space-x-2">
            <button class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Approve</button>
            <button class="bg-rose-600 hover:bg-rose-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Return</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

{{-- ── DSS Outstanding Teacher Ranking ── --}}
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
    <div>
      <h3 class="text-lg font-semibold text-slate-800">DSS Outstanding Teacher Ranking</h3>
      <p class="text-sm text-slate-500">Composite score from DLL compliance, COT rating, and seminar points.</p>
    </div>
    <span class="text-xs font-semibold bg-blue-100 text-blue-800 px-3 py-1 rounded-full">Auto-computed</span>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="text-left px-6 py-3 font-semibold">Rank</th>
          <th class="text-left px-6 py-3 font-semibold">Teacher</th>
          <th class="text-left px-6 py-3 font-semibold">DLL %</th>
          <th class="text-left px-6 py-3 font-semibold">COT Score</th>
          <th class="text-left px-6 py-3 font-semibold">Seminar Points</th>
          <th class="text-left px-6 py-3 font-semibold">Final DSS Score</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        <tr class="bg-amber-50/50">
          <td class="px-6 py-4">
            <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">🥇 1st</span>
          </td>
          <td class="px-6 py-4 font-semibold">Ana Mae Gonzales</td>
          <td class="px-6 py-4">98%</td>
          <td class="px-6 py-4">6.7 / 7.0</td>
          <td class="px-6 py-4">42</td>
          <td class="px-6 py-4 font-bold text-blue-900">96.45</td>
        </tr>
        <tr>
          <td class="px-6 py-4">
            <span class="bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1 rounded-full">🥈 2nd</span>
          </td>
          <td class="px-6 py-4 font-semibold">Leo M. Flores</td>
          <td class="px-6 py-4">95%</td>
          <td class="px-6 py-4">6.4 / 7.0</td>
          <td class="px-6 py-4">39</td>
          <td class="px-6 py-4 font-bold text-blue-900">92.86</td>
        </tr>
        <tr>
          <td class="px-6 py-4">
            <span class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full">🥉 3rd</span>
          </td>
          <td class="px-6 py-4 font-semibold">Jericho T. Santos</td>
          <td class="px-6 py-4">93%</td>
          <td class="px-6 py-4">6.3 / 7.0</td>
          <td class="px-6 py-4">33</td>
          <td class="px-6 py-4 font-bold text-blue-900">89.74</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

{{-- ── Focus Areas This Week ── --}}
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
  <h3 class="text-lg font-semibold text-slate-800 mb-3">Focus Areas This Week</h3>
  <ul class="list-disc list-inside text-sm text-slate-600 space-y-1">
    <li>Verify DLL submissions for Grade 9 Science and Grade 10 English.</li>
    <li>Finalize COT entries for April observation rounds.</li>
    <li>Run DSS ranking before Friday faculty meeting.</li>
    <li>Review year-end property clearance status with the Custodian.</li>
  </ul>
</section>

@endsection

@section('scripts')
<script>
  new Chart(document.getElementById('dllComplianceChart'), {
    type: 'bar',
    data: {
      labels: ['Math', 'Science', 'English', 'Filipino', 'AP', 'MAPEH'],
      datasets: [{
        label: 'DLL Compliance %',
        data: [94, 98, 93, 91, 95, 88],
        backgroundColor: '#1e3a8a',
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, max: 100 } }
    }
  });

  new Chart(document.getElementById('behaviorChart'), {
    type: 'pie',
    data: {
      labels: ['Minor Offenses', 'Major Offenses', 'Resolved'],
      datasets: [{
        data: [58, 17, 25],
        backgroundColor: ['#f59e0b', '#ef4444', '#10b981']
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'bottom' } }
    }
  });
</script>
@endsection
