@extends('layouts.app')

@section('title', 'TrackEd | Student Behavior')

@section('page-title', 'Student Behavior Tracking')

@section('header-extras')
<button class="w-10 h-10 rounded-full bg-slate-100 text-slate-600"><i class="fa-regular fa-bell"></i></button>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Log Incident</h3>
  <form id="incidentForm" novalidate>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Student LRN</label>
        <input id="incLRN" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="123456789012" maxlength="12" />
        <p class="text-xs text-slate-400 mt-1">LRN must be exactly 12 digits.</p>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Grade Level</label>
        <select id="incGrade" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white">
          <option value="7">Grade 7</option>
          <option value="8">Grade 8</option>
          <option value="9">Grade 9</option>
          <option value="10">Grade 10</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Offense Type</label>
        <select id="incType" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white">
          <option>Minor</option>
          <option>Major</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Incident Date</label>
        <input id="incDate" type="date" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
      </div>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Narrative Description</label>
      <textarea id="incDesc" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Describe what happened, where, and who was involved..."></textarea>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Restorative Action</label>
      <textarea id="incAction" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Counseling, parent conference, reflection essay..."></textarea>
    </div>

    <div id="incError"   class="hidden mt-3 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3"></div>
    <div id="incSuccess" class="hidden mt-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-3"></div>

    <button type="submit" class="mt-5 bg-blue-900 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg font-semibold">
      <i class="fa-solid fa-circle-plus mr-2"></i>Submit Incident Report
    </button>
  </form>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm overflow-x-auto">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Incident Log</h3>
  <table class="min-w-full text-sm" id="incidentTable">
    <thead class="bg-slate-100 text-slate-600">
      <tr>
        <th class="text-left px-4 py-3">LRN</th>
        <th class="text-left px-4 py-3">Grade</th>
        <th class="text-left px-4 py-3">Type</th>
        <th class="text-left px-4 py-3">Description</th>
        <th class="text-left px-4 py-3">Date</th>
        <th class="text-left px-4 py-3">Status</th>
        <th class="text-left px-4 py-3">Action</th>
      </tr>
    </thead>
    <tbody id="incidentTbody"></tbody>
  </table>
  <p id="noIncidents" class="text-slate-400 italic text-sm mt-2">No incidents logged yet.</p>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm overflow-x-auto">
  <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <h3 class="text-lg font-semibold text-slate-700">Case Management Queue</h3>
    <div class="flex gap-2 text-xs">
      <button class="px-3 py-1 rounded-full bg-slate-100 text-slate-600" data-queue-filter="all">All</button>
      <button class="px-3 py-1 rounded-full bg-amber-100 text-amber-700" data-queue-filter="pending">Pending</button>
      <button class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700" data-queue-filter="resolved">Resolved</button>
      <button class="px-3 py-1 rounded-full bg-rose-100 text-rose-700" data-queue-filter="major">Major Only</button>
    </div>
  </div>
  <table class="min-w-full text-sm">
    <thead class="bg-slate-100 text-slate-600">
      <tr>
        <th class="text-left px-4 py-3">Case ID</th>
        <th class="text-left px-4 py-3">Learner</th>
        <th class="text-left px-4 py-3">Severity</th>
        <th class="text-left px-4 py-3">Status</th>
        <th class="text-left px-4 py-3">Logged</th>
      </tr>
    </thead>
    <tbody id="caseQueueBody"></tbody>
  </table>
  <p id="caseQueueEmpty" class="text-slate-400 italic text-sm mt-2">No cases in the queue.</p>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Process Restorative Intervention</h3>
  <form id="interventionForm" class="grid grid-cols-1 md:grid-cols-2 gap-4" novalidate>
    <div>
      <label class="block text-sm font-medium mb-1">Case ID</label>
      <input id="intCaseId" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="INC-0001" />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Resolution Status</label>
      <select id="intStatus" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white">
        <option value="Resolved">Resolved</option>
        <option value="Unresolved">Unresolved</option>
      </select>
    </div>
    <div class="md:col-span-2">
      <label class="block text-sm font-medium mb-1">Counseling Notes</label>
      <textarea id="intNotes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Guidance counseling summary, parent conference notes..."></textarea>
    </div>
    <div class="md:col-span-2">
      <label class="block text-sm font-medium mb-1">Intervention Actions Taken</label>
      <textarea id="intActions" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Restorative action plan, reflection tasks, monitoring..."></textarea>
    </div>
    <div class="md:col-span-2 flex items-center gap-3">
      <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-lg font-semibold">
        <i class="fa-solid fa-hand-holding-heart mr-2"></i>Update Case
      </button>
      <p id="interventionMsg" class="text-sm text-slate-500"></p>
    </div>
  </form>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Good Moral Certificate</h3>
  <div class="flex gap-2 mb-5">
    <input id="searchLRN" type="text" placeholder="Search by LRN" class="flex-1 border border-slate-300 rounded-lg px-3 py-2" maxlength="12" />
    <button id="searchBtn" class="bg-slate-800 hover:bg-slate-700 text-white px-4 rounded-lg">Search</button>
  </div>
  <div id="moralResult"></div>
</div>
@endsection

@section('scripts')
<script>
  const INC_KEY = 'tracked_incidents';

  const MOCK_STUDENTS = {
    '109334567890': 'Carla Mendoza',
    '108765432101': 'Noel Ramos',
    '112233445566': 'Jose Reyes',
    '998877665544': 'Maria Clara',
  };

  function saveIncidents(arr) { localStorage.setItem(INC_KEY, JSON.stringify(arr)); }

  function normalizeIncidents(incidents) {
    let updated = false;
    incidents.forEach((inc, idx) => {
      if (!inc.caseId) {
        inc.caseId = `INC-${String(idx + 1).padStart(4, '0')}`;
        updated = true;
      }
      if (!inc.date) {
        inc.date = new Date().toLocaleDateString('en-PH');
        updated = true;
      }
      if (typeof inc.resolved !== 'boolean') {
        inc.resolved = false;
        updated = true;
      }
      if (!inc.intervention) {
        inc.intervention = { notes: '', actions: '', updatedAt: null };
        updated = true;
      }
    });
    if (updated) saveIncidents(incidents);
    return incidents;
  }

  function getIncidents() {
    const incidents = JSON.parse(localStorage.getItem(INC_KEY) || '[]');
    return normalizeIncidents(incidents);
  }

  function renderIncidents() {
    const incidents = getIncidents();
    const tbody     = document.getElementById('incidentTbody');
    const noMsg     = document.getElementById('noIncidents');
    if (!incidents.length) { tbody.innerHTML = ''; noMsg.classList.remove('hidden'); return; }
    noMsg.classList.add('hidden');
    tbody.innerHTML = incidents.slice().reverse().map((inc, revIdx) => {
      const realIdx = incidents.length - 1 - revIdx;
      const typeBadge = inc.type === 'Major'
        ? 'bg-rose-100 text-rose-700'
        : 'bg-amber-100 text-amber-700';
      const statusBadge = inc.resolved
        ? '<span class="px-2 py-0.5 rounded-full text-xs bg-emerald-100 text-emerald-700">Resolved</span>'
        : '<span class="px-2 py-0.5 rounded-full text-xs bg-amber-100 text-amber-700">Pending</span>';
      const actionBtn = inc.resolved
        ? '<span class="text-slate-400 text-xs">—</span>'
        : `<button onclick="resolveIncident(${realIdx})" class="text-xs bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1 rounded-lg">Mark Resolved</button>`;
      return `<tr class="border-b border-slate-100">
        <td class="px-4 py-3 font-mono text-xs">${inc.lrn}</td>
        <td class="px-4 py-3">Gr. ${inc.grade}</td>
        <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-semibold ${typeBadge}">${inc.type}</span></td>
        <td class="px-4 py-3 max-w-xs truncate">${inc.description}</td>
        <td class="px-4 py-3 text-slate-500 text-xs">${inc.date}</td>
        <td class="px-4 py-3">${statusBadge}</td>
        <td class="px-4 py-3">${actionBtn}</td>
      </tr>`;
    }).join('');
  }
  renderIncidents();

  function renderCaseQueue(filter = 'all') {
    const incidents = getIncidents();
    const tbody = document.getElementById('caseQueueBody');
    const empty = document.getElementById('caseQueueEmpty');
    let filtered = incidents;
    if (filter === 'pending') filtered = incidents.filter(i => !i.resolved);
    if (filter === 'resolved') filtered = incidents.filter(i => i.resolved);
    if (filter === 'major') filtered = incidents.filter(i => i.type === 'Major');
    if (!filtered.length) {
      tbody.innerHTML = '';
      empty.classList.remove('hidden');
      return;
    }
    empty.classList.add('hidden');
    tbody.innerHTML = filtered.slice().reverse().map(inc => {
      const statusBadge = inc.resolved
        ? 'bg-emerald-100 text-emerald-700'
        : 'bg-amber-100 text-amber-700';
      const severityBadge = inc.type === 'Major'
        ? 'bg-rose-100 text-rose-700'
        : 'bg-amber-100 text-amber-700';
      return `<tr class="border-b border-slate-100">
        <td class="px-4 py-3 font-mono text-xs">${inc.caseId}</td>
        <td class="px-4 py-3">${MOCK_STUDENTS[inc.lrn] || `LRN ${inc.lrn}`}</td>
        <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-semibold ${severityBadge}">${inc.type}</span></td>
        <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-semibold ${statusBadge}">${inc.resolved ? 'Resolved' : 'Pending'}</span></td>
        <td class="px-4 py-3 text-slate-500 text-xs">${inc.date}</td>
      </tr>`;
    }).join('');
  }
  renderCaseQueue();

  document.querySelectorAll('[data-queue-filter]').forEach(btn => {
    btn.addEventListener('click', () => renderCaseQueue(btn.dataset.queueFilter));
  });

  window.resolveIncident = function (idx) {
    const incidents = getIncidents();
    incidents[idx].resolved = true;
    incidents[idx].intervention.updatedAt = new Date().toLocaleString('en-PH');
    saveIncidents(incidents);
    renderIncidents();
    renderCaseQueue();
  };

  document.getElementById('incidentForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const lrn    = document.getElementById('incLRN').value.trim();
    const grade  = document.getElementById('incGrade').value;
    const type   = document.getElementById('incType').value;
    const desc   = document.getElementById('incDesc').value.trim();
    const action = document.getElementById('incAction').value.trim();
    const date   = document.getElementById('incDate').value;
    const errEl  = document.getElementById('incError');
    const okEl   = document.getElementById('incSuccess');
    errEl.classList.add('hidden');
    okEl.classList.add('hidden');

    if (!lrn || !desc || !action || !date) {
      errEl.textContent = 'LRN, Incident Date, Narrative Description, and Restorative Action are required.';
      errEl.classList.remove('hidden');
      return;
    }
    if (!/^\d{12}$/.test(lrn)) {
      errEl.textContent = 'LRN must be exactly 12 digits.';
      errEl.classList.remove('hidden');
      return;
    }

    const incidents = getIncidents();
    const caseId = `INC-${String(incidents.length + 1).padStart(4, '0')}`;
    incidents.push({
      caseId,
      lrn, grade, type, description: desc, action,
      resolved: false,
      date,
      intervention: { notes: '', actions: '', updatedAt: null },
      loggedBy: '{{ Auth::user()->name }}'
    });
    saveIncidents(incidents);

    okEl.innerHTML = `<i class="fa-solid fa-circle-check mr-1"></i> Incident ${caseId} logged for LRN <strong>${lrn}</strong>.`;
    okEl.classList.remove('hidden');
    this.reset();
    renderIncidents();
    renderCaseQueue();
    setTimeout(() => okEl.classList.add('hidden'), 3500);
  });

  document.getElementById('interventionForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const caseId = document.getElementById('intCaseId').value.trim();
    const status = document.getElementById('intStatus').value;
    const notes = document.getElementById('intNotes').value.trim();
    const actions = document.getElementById('intActions').value.trim();
    const msg = document.getElementById('interventionMsg');
    const incidents = getIncidents();
    const target = incidents.find(i => i.caseId === caseId);
    if (!caseId || !target) {
      msg.textContent = 'Enter a valid Case ID from the queue.';
      msg.className = 'text-sm text-rose-600';
      return;
    }
    target.resolved = status === 'Resolved';
    target.intervention = {
      notes,
      actions,
      updatedAt: new Date().toLocaleString('en-PH')
    };
    saveIncidents(incidents);
    msg.textContent = `Case ${caseId} updated (${status}).`;
    msg.className = 'text-sm text-emerald-600';
    renderIncidents();
    renderCaseQueue();
    setTimeout(() => { msg.textContent = ''; }, 3000);
  });

  document.getElementById('searchBtn').addEventListener('click', function () {
    const lrn = document.getElementById('searchLRN').value.trim();
    const out = document.getElementById('moralResult');
    if (!lrn) { out.innerHTML = ''; return; }
    if (!/^\d{12}$/.test(lrn)) {
      out.innerHTML = '<p class="text-rose-600 text-sm">Please enter a valid 12-digit LRN.</p>';
      return;
    }

    const incidents    = getIncidents();
    const majorPending = incidents.filter(i => i.lrn === lrn && i.type === 'Major' && !i.resolved);
    const studentName  = MOCK_STUDENTS[lrn] || `Learner (LRN: ${lrn})`;

    if (majorPending.length === 0) {
      out.innerHTML = `
        <article class="border border-emerald-200 bg-emerald-50 rounded-lg p-4 space-y-2">
          <p class="font-semibold">Learner: ${studentName}</p>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Cleared</span>
          <p class="text-sm text-slate-600">No unresolved major offenses on record.</p>
          <div class="flex flex-wrap gap-2">
            <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg font-semibold"
              onclick="alert('Good Moral Certificate PDF generated for ${studentName}.')">
              <i class="fa-solid fa-file-pdf mr-1"></i> Generate PDF
            </button>
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg font-semibold"
              onclick="alert('Print preview opened for ${studentName}.')">
              <i class="fa-solid fa-print mr-1"></i> Print
            </button>
          </div>
        </article>`;
    } else {
      out.innerHTML = `
        <article class="border border-rose-200 bg-rose-50 rounded-lg p-4 space-y-2">
          <p class="font-semibold">Learner: ${studentName}</p>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Blocked</span>
          <p class="text-sm text-rose-700 font-medium">Blocked: ${majorPending.length} Unresolved Major Offense(s)</p>
          <div class="text-rose-700 text-sm"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Resolve all major incidents before issuing a Good Moral Certificate.</div>
        </article>`;
    }
  });

  document.getElementById('searchLRN').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') document.getElementById('searchBtn').click();
  });
</script>
@endsection
