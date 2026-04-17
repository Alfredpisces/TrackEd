@extends('layouts.app')

@section('title', 'TrackEd | School Head Dashboard')
@section('page-title', 'School Head Dashboard')

@section('head-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">DLL Compliance % by Department</h3>
    <p class="text-sm text-slate-500">Weekly submission completion, SY 2026-2027 Q1.</p>
    <canvas id="dllComplianceChart" class="mt-4 h-72"></canvas>
  </section>
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">Behavioral Incidents Distribution</h3>
    <p class="text-sm text-slate-500">Current month guidance office reports.</p>
    <canvas id="behaviorChart" class="mt-4 h-72"></canvas>
  </section>
</div>

<section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-200">
    <h3 class="text-lg font-semibold text-slate-800">Pending DLL Approvals</h3>
    <p class="text-sm text-slate-500">Review and action required from School Head.</p>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="text-left px-6 py-3 font-semibold">Teacher</th>
          <th class="text-left px-6 py-3 font-semibold">Subject / Grade</th>
          <th class="text-left px-6 py-3 font-semibold">Week Covered</th>
          <th class="text-left px-6 py-3 font-semibold">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        <tr>
          <td class="px-6 py-4 font-medium">Ana Mae Gonzales</td>
          <td class="px-6 py-4">Science 9</td>
          <td class="px-6 py-4">Week 4 (June 24-28)</td>
          <td class="px-6 py-4 space-x-2">
            <button class="bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Approve</button>
            <button class="bg-rose-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Return</button>
          </td>
        </tr>
        <tr>
          <td class="px-6 py-4 font-medium">Leo M. Flores</td>
          <td class="px-6 py-4">English 10</td>
          <td class="px-6 py-4">Week 4 (June 24-28)</td>
          <td class="px-6 py-4 space-x-2">
            <button class="bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Approve</button>
            <button class="bg-rose-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">Return</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
    <div>
      <h3 class="text-lg font-semibold text-slate-800">DSS Outstanding Teacher Ranking</h3>
      <p class="text-sm text-slate-500">Composite ranking from DLL, COT, and seminars.</p>
    </div>
    <span class="text-xs font-semibold bg-blue-100 text-blue-800 px-3 py-1 rounded-full">Auto-computed</span>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="text-left px-6 py-3 font-semibold">Teacher</th>
          <th class="text-left px-6 py-3 font-semibold">DLL %</th>
          <th class="text-left px-6 py-3 font-semibold">COT Score</th>
          <th class="text-left px-6 py-3 font-semibold">Seminar Points</th>
          <th class="text-left px-6 py-3 font-semibold">Final DSS</th>
          <th class="text-left px-6 py-3 font-semibold">Rank</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        <tr>
          <td class="px-6 py-4 font-medium">Ana Mae Gonzales</td>
          <td class="px-6 py-4">98%</td>
          <td class="px-6 py-4">6.7 / 7.0</td>
          <td class="px-6 py-4">42</td>
          <td class="px-6 py-4 font-semibold text-blue-900">96.45</td>
          <td class="px-6 py-4"><span class="bg-amber-100 text-amber-700 text-xs px-3 py-1 rounded-full font-semibold">1st</span></td>
        </tr>
        <tr>
          <td class="px-6 py-4 font-medium">Leo M. Flores</td>
          <td class="px-6 py-4">95%</td>
          <td class="px-6 py-4">6.4 / 7.0</td>
          <td class="px-6 py-4">39</td>
          <td class="px-6 py-4 font-semibold text-blue-900">92.86</td>
          <td class="px-6 py-4"><span class="bg-slate-200 text-slate-700 text-xs px-3 py-1 rounded-full font-semibold">2nd</span></td>
        </tr>
        <tr>
          <td class="px-6 py-4 font-medium">Jericho T. Santos</td>
          <td class="px-6 py-4">93%</td>
          <td class="px-6 py-4">6.3 / 7.0</td>
          <td class="px-6 py-4">33</td>
          <td class="px-6 py-4 font-semibold text-blue-900">89.74</td>
          <td class="px-6 py-4"><span class="bg-orange-100 text-orange-700 text-xs px-3 py-1 rounded-full font-semibold">3rd</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
@endsection

@section('scripts')
<script>
  new Chart(document.getElementById('dllComplianceChart'), {
    type: 'bar',
    data: {
      labels: ['Math', 'Science', 'English', 'Filipino', 'AP'],
      datasets: [{
        label: 'DLL Compliance %',
        data: [96, 98, 93, 91, 95],
        backgroundColor: '#1d4ed8',
        borderRadius: 8
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, max: 100 } }
    }
  });

  new Chart(document.getElementById('behaviorChart'), {
    type: 'pie',
    data: {
      labels: ['Minor', 'Major', 'Resolved'],
      datasets: [{
        data: [58, 17, 25],
        backgroundColor: ['#f59e0b', '#ef4444', '#10b981']
      }]
    },
    options: {
      plugins: { legend: { position: 'bottom' } }
    }
  });
</script>
@endsection
