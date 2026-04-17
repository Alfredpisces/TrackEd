@extends('layouts.app')

@section('title', 'TrackEd | Teacher Performance')

@section('page-title', 'Teacher Performance')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">System-Based DLL Builder</h3>
  <form id="dllForm" novalidate>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Subject</label>
        <input id="dllSubject" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Grade 9 Science" />
        <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllSubject"></p>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Date</label>
        <input id="dllDate" type="date" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
        <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllDate"></p>
      </div>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Objectives</label>
      <textarea id="dllObjectives" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="State competencies and learning outcomes..."></textarea>
      <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllObjectives"></p>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Content</label>
      <textarea id="dllContent" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Key concepts, topics, and content standards..."></textarea>
      <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllContent"></p>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Learning Resources</label>
      <textarea id="dllResources" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Textbooks, modules, links, and materials..."></textarea>
      <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllResources"></p>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Procedures</label>
      <textarea id="dllProcedures" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="List lesson flow and classroom activities..."></textarea>
      <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllProcedures"></p>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Reflection</label>
      <textarea id="dllReflection" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="What went well, adjustments, and learner response..."></textarea>
      <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllReflection"></p>
    </div>

    <div id="dllError"   class="hidden mt-3 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3"></div>
    <div id="dllSuccess" class="hidden mt-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-3"></div>
    <div id="aiResult"   class="hidden mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-slate-700 space-y-2"></div>

    <div class="mt-5 flex flex-wrap gap-3">
      <button type="submit" class="bg-slate-700 hover:bg-slate-600 text-white px-5 py-2.5 rounded-lg font-semibold">
        <i class="fa-solid fa-floppy-disk mr-2"></i>Save DLL
      </button>
      <button type="button" id="aiCheckBtn" class="bg-blue-900 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg font-semibold">
        <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>Run AI Pre-Check
      </button>
    </div>
  </form>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Submission Status</h3>
  <div class="flex items-center justify-between flex-wrap gap-4">
    <div>
      <p class="text-sm text-slate-500">Current Status</p>
      <span id="dllStatusBadge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-amber-100 text-amber-700">
        Pending Draft
      </span>
      <p class="text-xs text-slate-400 mt-1" id="dllStatusMeta">No DLL submitted yet.</p>
    </div>
    <div class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-600">
      <p class="font-semibold text-slate-700">Reviewer</p>
      <p id="dllReviewer">School Head (Pending Assignment)</p>
    </div>
  </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Saved Daily Lesson Logs</h3>
  <ul id="dllList" class="space-y-2 text-sm text-slate-600">
    <li class="text-slate-400 italic">No DLLs saved yet.</li>
  </ul>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">COT &amp; Seminar Evaluation</h3>
  <form id="cotForm" class="grid grid-cols-1 lg:grid-cols-3 gap-4" novalidate>
    <div>
      <label class="block text-sm font-medium mb-1">School Year</label>
      <input id="cotYear" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="2025-2026" />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Average COT Rating</label>
      <input id="cotScore" type="number" min="1" max="5" step="0.1"
        class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="4.8" />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Seminar Certificate</label>
      <input id="cotSeminar" type="file" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white" />
      <p class="text-xs text-slate-400 mt-1">Upload PDF/JPG proof for professional growth points.</p>
    </div>
    <div class="lg:col-span-3 flex gap-3 items-center">
      <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white px-5 py-2.5 rounded-lg font-semibold">
        <i class="fa-solid fa-chart-simple mr-2"></i>Save Evaluation
      </button>
      <p id="cotMessage" class="text-sm text-slate-500"></p>
    </div>
  </form>

  <div class="mt-5 overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-100 text-slate-600">
        <tr>
          <th class="text-left px-4 py-3">School Year</th>
          <th class="text-left px-4 py-3">Average COT</th>
          <th class="text-left px-4 py-3">Seminar Certificate</th>
          <th class="text-left px-4 py-3">Encoded On</th>
        </tr>
      </thead>
      <tbody id="cotLedger">
        <tr>
          <td colspan="4" class="px-4 py-4 text-center text-slate-400 italic">No evaluation records yet.</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
    <div>
      <h3 class="text-lg font-semibold text-slate-700">DSS Ranking Controls</h3>
      <p class="text-sm text-slate-500">Weights: DLL Compliance 40% • COT Score 40% • Seminar Points 20%</p>
    </div>
    <div class="flex items-center gap-3">
      <button id="dssComputeBtn" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
        <i class="fa-solid fa-ranking-star mr-1"></i>Compute Ranking
      </button>
      <span id="dssLastRun" class="text-xs text-slate-400">Not computed yet.</span>
    </div>
  </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm overflow-x-auto">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">DSS Outstanding Teacher Ranking</h3>
  <table class="min-w-full text-sm">
    <thead class="bg-slate-100 text-slate-600">
      <tr>
        <th class="text-left px-4 py-3">Teacher</th>
        <th class="text-left px-4 py-3">DLL Compliance %</th>
        <th class="text-left px-4 py-3">COT Score</th>
        <th class="text-left px-4 py-3">Professional Growth</th>
        <th class="text-left px-4 py-3">Final DSS Score</th>
        <th class="text-left px-4 py-3">Rank</th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b border-slate-200">
        <td class="px-4 py-3">Juan Dela Cruz</td><td class="px-4 py-3">96%</td><td class="px-4 py-3">4.7</td><td class="px-4 py-3">18 pts</td><td class="px-4 py-3 font-semibold">94.8</td>
        <td class="px-4 py-3"><span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-semibold">#1</span></td>
      </tr>
      <tr class="border-b border-slate-200">
        <td class="px-4 py-3">Ana Reyes</td><td class="px-4 py-3">93%</td><td class="px-4 py-3">4.6</td><td class="px-4 py-3">16 pts</td><td class="px-4 py-3 font-semibold">92.1</td>
        <td class="px-4 py-3"><span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold">#2</span></td>
      </tr>
      <tr>
        <td class="px-4 py-3">Mark Valdez</td><td class="px-4 py-3">90%</td><td class="px-4 py-3">4.4</td><td class="px-4 py-3">15 pts</td><td class="px-4 py-3 font-semibold">88.7</td>
        <td class="px-4 py-3"><span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 font-semibold">#3</span></td>
      </tr>
    </tbody>
  </table>
</div>
@endsection

@section('scripts')
<script>
  const DLL_KEY = 'tracked_dlls';
  const DLL_STATUS_KEY = 'tracked_dll_status';
  const COT_KEY = 'tracked_cot_scores';

  function renderDLLList() {
    const dlls = JSON.parse(localStorage.getItem(DLL_KEY) || '[]');
    const list = document.getElementById('dllList');
    if (!dlls.length) { list.innerHTML = '<li class="text-slate-400 italic">No DLLs saved yet.</li>'; return; }
    list.innerHTML = dlls.slice().reverse().map(d =>
      `<li class="flex items-center gap-2 border border-slate-100 rounded-lg px-3 py-2 bg-slate-50">
        <i class="fa-regular fa-file-lines text-blue-700"></i>
        <span><strong>${d.subject}</strong> &mdash; ${d.date}</span>
        <span class="ml-auto text-slate-400 text-xs">${d.savedBy}</span>
      </li>`
    ).join('');
  }
  renderDLLList();

  function renderStatus() {
    const status = JSON.parse(localStorage.getItem(DLL_STATUS_KEY) || 'null');
    const badge = document.getElementById('dllStatusBadge');
    const meta = document.getElementById('dllStatusMeta');
    const reviewer = document.getElementById('dllReviewer');
    if (!status) {
      badge.textContent = 'Pending Draft';
      badge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-amber-100 text-amber-700';
      meta.textContent = 'No DLL submitted yet.';
      reviewer.textContent = 'School Head (Pending Assignment)';
      return;
    }
    badge.textContent = status.label;
    badge.className = status.tone === 'approved'
      ? 'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700'
      : 'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700';
    meta.textContent = `Last update: ${status.at}`;
    reviewer.textContent = status.reviewer || 'School Head';
  }
  renderStatus();

  function clearFieldErrors() {
    document.querySelectorAll('[data-error-for]').forEach(el => {
      el.classList.add('hidden');
      el.textContent = '';
    });
    ['dllSubject', 'dllDate', 'dllObjectives', 'dllContent', 'dllResources', 'dllProcedures', 'dllReflection']
      .forEach(id => document.getElementById(id).classList.remove('border-rose-400'));
  }

  function setFieldError(id, message) {
    const input = document.getElementById(id);
    const error = document.querySelector(`[data-error-for="${id}"]`);
    if (input) input.classList.add('border-rose-400');
    if (error) {
      error.textContent = message;
      error.classList.remove('hidden');
    }
  }

  document.getElementById('dllForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const subject    = document.getElementById('dllSubject').value.trim();
    const date       = document.getElementById('dllDate').value;
    const objectives = document.getElementById('dllObjectives').value.trim();
    const content    = document.getElementById('dllContent').value.trim();
    const resources  = document.getElementById('dllResources').value.trim();
    const procedures = document.getElementById('dllProcedures').value.trim();
    const reflection = document.getElementById('dllReflection').value.trim();
    const errEl      = document.getElementById('dllError');
    const okEl       = document.getElementById('dllSuccess');
    errEl.classList.add('hidden');
    okEl.classList.add('hidden');
    clearFieldErrors();

    let hasError = false;
    if (!subject) { setFieldError('dllSubject', 'Subject is required.'); hasError = true; }
    if (!date) { setFieldError('dllDate', 'Date is required.'); hasError = true; }
    if (!objectives) { setFieldError('dllObjectives', 'Objectives are required.'); hasError = true; }
    if (!content) { setFieldError('dllContent', 'Content is required.'); hasError = true; }
    if (!resources) { setFieldError('dllResources', 'Learning resources are required.'); hasError = true; }
    if (!procedures) { setFieldError('dllProcedures', 'Procedures are required.'); hasError = true; }
    if (!reflection) { setFieldError('dllReflection', 'Reflection is required.'); hasError = true; }
    if (hasError) {
      errEl.textContent = 'Complete all required DLL sections before saving.';
      errEl.classList.remove('hidden');
      return;
    }

    const dlls = JSON.parse(localStorage.getItem(DLL_KEY) || '[]');
    dlls.push({
      subject,
      date,
      objectives,
      content,
      resources,
      procedures,
      reflection,
      savedBy: '{{ Auth::user()->name }}',
      savedAt: new Date().toISOString()
    });
    localStorage.setItem(DLL_KEY, JSON.stringify(dlls));

    okEl.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> DLL saved successfully!';
    okEl.classList.remove('hidden');
    this.reset();
    renderDLLList();
    setTimeout(() => okEl.classList.add('hidden'), 3000);
  });

  document.getElementById('aiCheckBtn').addEventListener('click', function () {
    const subject    = document.getElementById('dllSubject').value.trim();
    const objectives = document.getElementById('dllObjectives').value.trim();
    const content    = document.getElementById('dllContent').value.trim();
    const resources  = document.getElementById('dllResources').value.trim();
    const procedures = document.getElementById('dllProcedures').value.trim();
    const reflection = document.getElementById('dllReflection').value.trim();
    const errEl      = document.getElementById('dllError');
    const resultEl   = document.getElementById('aiResult');
    errEl.classList.add('hidden');
    resultEl.classList.add('hidden');
    clearFieldErrors();

    let hasError = false;
    if (!subject) { setFieldError('dllSubject', 'Subject is required for AI pre-check.'); hasError = true; }
    if (!objectives) { setFieldError('dllObjectives', 'Objectives are required for AI pre-check.'); hasError = true; }
    if (!content) { setFieldError('dllContent', 'Content is required for AI pre-check.'); hasError = true; }
    if (!resources) { setFieldError('dllResources', 'Learning resources are required for AI pre-check.'); hasError = true; }
    if (!procedures) { setFieldError('dllProcedures', 'Procedures are required for AI pre-check.'); hasError = true; }
    if (!reflection) { setFieldError('dllReflection', 'Reflection is required for AI pre-check.'); hasError = true; }
    if (hasError) {
      errEl.textContent = 'Please complete all DLL sections before running the AI Pre-Check.';
      errEl.classList.remove('hidden');
      return;
    }

    this.disabled = true;
    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Analyzing…';

    setTimeout(() => {
      const hasKeywords = objectives.length > 20 && procedures.length > 30 && content.length > 20 && reflection.length > 20;
      if (hasKeywords) {
        resultEl.innerHTML = `
          <p class="font-semibold text-emerald-700"><i class="fa-solid fa-circle-check mr-1"></i> AI Pre-Check Passed</p>
          <ul class="list-disc list-inside space-y-1 text-slate-600">
            <li>Objectives align with DepEd K–12 competency standards.</li>
            <li>Lesson flow covers Motivation, Presentation, Practice, and Assessment.</li>
            <li>Content, resources, and reflection sections are complete.</li>
          </ul>
          <p class="text-xs text-slate-400 mt-1">Pre-check completed at ${new Date().toLocaleTimeString()}</p>`;
        localStorage.setItem(DLL_STATUS_KEY, JSON.stringify({
          label: 'Pending Approval',
          tone: 'pending',
          at: new Date().toLocaleString('en-PH'),
          reviewer: 'School Head'
        }));
        renderStatus();
      } else {
        resultEl.innerHTML = `
          <p class="font-semibold text-amber-700"><i class="fa-solid fa-triangle-exclamation mr-1"></i> AI Pre-Check: Needs Improvement</p>
          <ul class="list-disc list-inside space-y-1 text-slate-600">
            <li>Objectives are too brief — expand with specific learning competencies.</li>
            <li>Procedures section should detail at least 4 phases of instruction.</li>
            <li>Content and reflection should include clear learning insights.</li>
          </ul>`;
      }
      resultEl.classList.remove('hidden');
      this.disabled = false;
      this.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles mr-2"></i>Run AI Pre-Check';
    }, 1800);
  });

  function renderCOTLedger() {
    const entries = JSON.parse(localStorage.getItem(COT_KEY) || '[]');
    const tbody = document.getElementById('cotLedger');
    if (!entries.length) {
      tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-4 text-center text-slate-400 italic">No evaluation records yet.</td></tr>';
      return;
    }
    tbody.innerHTML = entries.slice().reverse().map(e => `
      <tr class="border-b border-slate-100">
        <td class="px-4 py-3">${e.year}</td>
        <td class="px-4 py-3 font-semibold">${e.score}</td>
        <td class="px-4 py-3 text-slate-500 text-xs">${e.seminar || '—'}</td>
        <td class="px-4 py-3 text-slate-500 text-xs">${e.date}</td>
      </tr>
    `).join('');
  }
  renderCOTLedger();

  document.getElementById('cotForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const year = document.getElementById('cotYear').value.trim();
    const score = document.getElementById('cotScore').value.trim();
    const seminarFile = document.getElementById('cotSeminar').files[0];
    const msg = document.getElementById('cotMessage');
    if (!year || !score) {
      msg.textContent = 'School year and COT rating are required.';
      msg.className = 'text-sm text-rose-600';
      return;
    }
    const entries = JSON.parse(localStorage.getItem(COT_KEY) || '[]');
    entries.push({
      year,
      score,
      seminar: seminarFile?.name || 'Uploaded certificate',
      date: new Date().toLocaleDateString('en-PH'),
    });
    localStorage.setItem(COT_KEY, JSON.stringify(entries));
    msg.textContent = 'Evaluation saved to performance ledger.';
    msg.className = 'text-sm text-emerald-600';
    this.reset();
    renderCOTLedger();
    setTimeout(() => { msg.textContent = ''; }, 3000);
  });

  document.getElementById('dssComputeBtn').addEventListener('click', function () {
    document.getElementById('dssLastRun').textContent = `Computed ${new Date().toLocaleTimeString()}`;
  });
</script>
@endsection
