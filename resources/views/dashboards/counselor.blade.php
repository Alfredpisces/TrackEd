@extends('layouts.app')

@section('title', 'TrackEd | Counselor Dashboard')

@section('page-title', 'Counselor Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">Unresolved Incidents</p>
    <p class="text-3xl font-bold text-rose-600 mt-2" id="counselorUnresolved">0</p>
    <p class="text-xs text-slate-400 mt-1">Cases requiring follow-up.</p>
  </article>
  <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">Resolved Cases</p>
    <p class="text-3xl font-bold text-emerald-600 mt-2" id="counselorResolved">0</p>
    <p class="text-xs text-slate-400 mt-1">Closed incidents this cycle.</p>
  </article>
  <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">Good Moral Requests</p>
    <p class="text-3xl font-bold text-blue-900 mt-2" id="counselorRequests">0</p>
    <p class="text-xs text-slate-400 mt-1">Learners evaluated for clearance.</p>
  </article>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Recent Incident Reports</h3>
  <ul id="counselorIncidentFeed" class="space-y-2 text-sm text-slate-600">
    <li class="text-slate-400 italic">No incidents logged yet.</li>
  </ul>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Guidance Actions</h3>
  <div class="flex flex-wrap gap-3">
    <a href="{{ route('student-behavior') }}" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
      <i class="fa-solid fa-user-shield mr-2"></i>Open Student Behavior
    </a>
    <button class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold" onclick="alert('Case conference scheduled.')">
      <i class="fa-solid fa-calendar-check mr-2"></i>Schedule Case Conference
    </button>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const incidents = JSON.parse(localStorage.getItem('tracked_incidents') || '[]');
  const unresolved = incidents.filter(i => !i.resolved).length;
  const resolved = incidents.filter(i => i.resolved).length;

  document.getElementById('counselorUnresolved').textContent = unresolved;
  document.getElementById('counselorResolved').textContent = resolved;
  document.getElementById('counselorRequests').textContent = incidents.length;

  const feed = document.getElementById('counselorIncidentFeed');
  if (incidents.length > 0) {
    feed.innerHTML = '';
    incidents.slice(-5).reverse().forEach(inc => {
      const li = document.createElement('li');
      li.className = 'flex items-start gap-2';
      li.innerHTML = `<span class="mt-0.5 w-2 h-2 rounded-full flex-shrink-0 ${inc.type === 'Major' ? 'bg-rose-500' : 'bg-amber-400'}"></span>
        <span><strong>${inc.lrn}</strong> — ${inc.type} offense &nbsp;<span class="text-slate-400 text-xs">${inc.date || ''}</span></span>`;
      feed.appendChild(li);
    });
  }
</script>
@endsection
