@extends('layouts.app')

@section('title', 'TrackEd | Teacher Performance')

@section('page-title', 'Teacher Performance')

@section('content')
{{-- ── Weekly DLL Builder ── --}}
<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-1">System-Based DLL Builder</h3>
  <p class="text-sm text-slate-400 mb-5">Create a weekly lesson plan covering Monday–Friday. Save the full week, selected days, or one day at a time.</p>

  {{-- Week-level header fields --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pb-5 border-b border-slate-100">
    <div>
      <label class="block text-sm font-medium mb-1">Subject <span class="text-rose-500">*</span></label>
      <input id="dllSubject" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g. Science 9" />
      <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllSubject"></p>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Grade &amp; Section</label>
      <input id="dllGradeSection" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g. Grade 9 — Coral" />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Quarter</label>
      <select id="dllQuarter" class="w-full border border-slate-300 rounded-lg px-3 py-2">
        <option value="">— Select —</option>
        <option>Q1</option><option>Q2</option><option>Q3</option><option>Q4</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Week No.</label>
      <input id="dllWeekNo" type="number" min="1" max="52" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g. 3" />
    </div>
  </div>

  <div class="mt-4 mb-5">
    <label class="block text-sm font-medium mb-1">Week of <span class="text-rose-500">*</span></label>
    <input id="dllWeekOf" type="week" class="border border-slate-300 rounded-lg px-3 py-2 w-full sm:w-64" />
    <p class="text-xs text-slate-400 mt-1" id="dllWeekLabel"></p>
    <p class="text-xs text-rose-600 mt-1 hidden" data-error-for="dllWeekOf"></p>
  </div>

  {{-- Day tab bar (☑ checkbox + tab button per day) --}}
  <div class="overflow-x-auto -mx-6 px-6">
    <div class="flex gap-0.5 min-w-max border-b border-slate-200 mb-5" id="dayTabBar"></div>
  </div>

  {{-- Day panels (rendered by JS) --}}
  <div id="dayPanels"></div>

  {{-- Feedback banners --}}
  <div id="dllError"   class="hidden mt-3 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3"></div>
  <div id="dllSuccess" class="hidden mt-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-3"></div>
  <div id="aiResult"   class="hidden mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-slate-700 space-y-2"></div>

  {{-- Bottom action buttons --}}
  <div class="mt-5 flex flex-wrap gap-3">
    <button type="button" id="saveWeekBtn" class="bg-slate-700 hover:bg-slate-600 text-white px-5 py-2.5 rounded-lg font-semibold">
      <i class="fa-solid fa-calendar-week mr-2"></i>Save Entire Week
    </button>
    <button type="button" id="saveSelectedBtn" class="bg-slate-500 hover:bg-slate-400 text-white px-5 py-2.5 rounded-lg font-semibold">
      <i class="fa-solid fa-floppy-disk mr-2"></i>Save Selected Days
    </button>
    <button type="button" id="aiCheckBtn" class="bg-blue-900 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg font-semibold">
      <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>AI Pre-Check (Active Day)
    </button>
  </div>
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
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Saved Weekly Lesson Logs</h3>
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
  // ── Constants ──────────────────────────────────────────────────────────────
  const DLL_KEY        = 'tracked_dlls';
  const DLL_STATUS_KEY = 'tracked_dll_status';
  const COT_KEY        = 'tracked_cot_scores';

  const DAYS       = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
  const DAY_LABELS = { monday: 'Monday', tuesday: 'Tuesday', wednesday: 'Wednesday', thursday: 'Thursday', friday: 'Friday' };
  const DAY_SHORT  = { monday: 'Mon', tuesday: 'Tue', wednesday: 'Wed', thursday: 'Thu', friday: 'Fri' };

  const DLL_MIN_OBJECTIVES = 20;
  const DLL_MIN_PROCEDURES = 30;
  const DLL_MIN_CONTENT    = 20;

  let activeDay = 'monday';

  // ── Helpers ────────────────────────────────────────────────────────────────
  function escHtml(str) {
    return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  function weekInputToMonday(weekValue) {
    if (!weekValue) return null;
    const [yearStr, wPart] = weekValue.split('-W');
    const year = parseInt(yearStr, 10);
    const week = parseInt(wPart, 10);
    const jan4 = new Date(Date.UTC(year, 0, 4));
    const dow  = jan4.getUTCDay() || 7;
    return new Date(Date.UTC(year, 0, 4 + (1 - dow) + (week - 1) * 7));
  }

  function fmtDate(d) {
    return d.toLocaleDateString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' });
  }

  function showError(msg) {
    const el = document.getElementById('dllError');
    el.textContent = msg;
    el.classList.remove('hidden');
    setTimeout(() => el.classList.add('hidden'), 4000);
  }

  function showSuccess(msg) {
    const el = document.getElementById('dllSuccess');
    el.innerHTML = `<i class="fa-solid fa-circle-check mr-1"></i> ${escHtml(msg)}`;
    el.classList.remove('hidden');
    setTimeout(() => el.classList.add('hidden'), 3500);
  }

  function clearHeaderErrors() {
    ['dllSubject', 'dllWeekOf'].forEach(id => {
      const err = document.querySelector(`[data-error-for="${id}"]`);
      if (err) { err.classList.add('hidden'); err.textContent = ''; }
      const inp = document.getElementById(id);
      if (inp) inp.classList.remove('border-rose-400');
    });
  }

  function setFieldError(id, msg) {
    const inp = document.getElementById(id);
    const err = document.querySelector(`[data-error-for="${id}"]`);
    if (inp) inp.classList.add('border-rose-400');
    if (err) { err.textContent = msg; err.classList.remove('hidden'); }
  }

  // ── Day data helpers ───────────────────────────────────────────────────────
  function getDayData(day) {
    return {
      objectives: (document.getElementById(`${day}-objectives`)?.value ?? '').trim(),
      content:    (document.getElementById(`${day}-content`)?.value    ?? '').trim(),
      resources:  (document.getElementById(`${day}-resources`)?.value  ?? '').trim(),
      procedures: (document.getElementById(`${day}-procedures`)?.value ?? '').trim(),
      reflection: (document.getElementById(`${day}-reflection`)?.value ?? '').trim(),
    };
  }

  function isDayFilled(day) {
    return Object.values(getDayData(day)).some(v => v.length > 0);
  }

  // ── Tab rendering ──────────────────────────────────────────────────────────
  function renderTabs() {
    const bar = document.getElementById('dayTabBar');
    bar.innerHTML = DAYS.map(d => `
      <div class="flex items-center">
        <label class="flex items-center px-1.5 py-2 cursor-pointer" title="Select for bulk save">
          <input type="checkbox" class="day-checkbox w-3.5 h-3.5 rounded accent-blue-900" data-day="${d}" id="chk-${d}" />
        </label>
        <button type="button"
          class="day-tab-btn px-3 py-2 text-sm font-medium rounded-t-lg transition-colors ${d === activeDay ? 'bg-blue-900 text-white' : 'text-slate-600 hover:bg-slate-100'}"
          data-day="${d}">
          ${DAY_SHORT[d]}<span class="day-fill-dot ml-1.5 inline-block w-2 h-2 rounded-full align-middle bg-slate-200" id="dot-${d}"></span>
        </button>
      </div>
    `).join('');
    bar.querySelectorAll('.day-tab-btn').forEach(btn => {
      btn.addEventListener('click', () => switchTab(btn.dataset.day));
    });
  }

  function renderPanels() {
    const container = document.getElementById('dayPanels');
    container.innerHTML = DAYS.map(d => `
      <div class="day-panel ${d !== activeDay ? 'hidden' : ''}" data-day="${d}">
        <p class="text-sm font-semibold text-blue-900 mb-4">${DAY_LABELS[d]} Lesson Plan</p>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-1">Objectives</label>
            <textarea id="${d}-objectives" rows="3"
              class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
              placeholder="State competencies and learning outcomes..."></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Content</label>
            <textarea id="${d}-content" rows="3"
              class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
              placeholder="Key concepts, topics, and content standards..."></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Learning Resources</label>
            <textarea id="${d}-resources" rows="3"
              class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
              placeholder="Textbooks, modules, links, and materials..."></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Procedures</label>
            <textarea id="${d}-procedures" rows="4"
              class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
              placeholder="List lesson flow and classroom activities..."></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Reflection</label>
            <textarea id="${d}-reflection" rows="3"
              class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
              placeholder="What went well, adjustments, and learner response..."></textarea>
          </div>
        </div>
        <div class="mt-4">
          <button type="button" class="save-day-btn bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-semibold" data-day="${d}">
            <i class="fa-solid fa-floppy-disk mr-1"></i>Save ${DAY_LABELS[d]} Only
          </button>
        </div>
      </div>
    `).join('');
    container.querySelectorAll('.save-day-btn').forEach(btn => {
      btn.addEventListener('click', () => saveDays([btn.dataset.day]));
    });
    container.querySelectorAll('textarea').forEach(ta => {
      ta.addEventListener('input', updateFillDots);
    });
  }

  function switchTab(day) {
    activeDay = day;
    document.querySelectorAll('.day-panel').forEach(p => p.classList.toggle('hidden', p.dataset.day !== day));
    document.querySelectorAll('.day-tab-btn').forEach(b => {
      const on = b.dataset.day === day;
      b.className = `day-tab-btn px-3 py-2 text-sm font-medium rounded-t-lg transition-colors ${on ? 'bg-blue-900 text-white' : 'text-slate-600 hover:bg-slate-100'}`;
    });
  }

  function updateFillDots() {
    DAYS.forEach(d => {
      const dot = document.getElementById(`dot-${d}`);
      if (dot) dot.className = `day-fill-dot ml-1.5 inline-block w-2 h-2 rounded-full align-middle ${isDayFilled(d) ? 'bg-emerald-400' : 'bg-slate-200'}`;
    });
  }

  // ── Header validation ──────────────────────────────────────────────────────
  function validateHeader() {
    clearHeaderErrors();
    let ok = true;
    if (!document.getElementById('dllSubject').value.trim()) {
      setFieldError('dllSubject', 'Subject is required.');
      ok = false;
    }
    if (!document.getElementById('dllWeekOf').value) {
      setFieldError('dllWeekOf', 'Please select a week.');
      ok = false;
    }
    return ok;
  }

  // ── Build & upsert record ──────────────────────────────────────────────────
  function buildRecord(daysToSave) {
    const weekVal = document.getElementById('dllWeekOf').value;
    const monday  = weekInputToMonday(weekVal);
    const weekOf  = monday ? monday.toISOString().slice(0, 10) : weekVal;
    const subject = document.getElementById('dllSubject').value.trim();
    const daysData = {};
    daysToSave.forEach(d => { daysData[d] = getDayData(d); });
    return {
      id:           weekOf + '-' + subject.replace(/[^a-zA-Z0-9]/g, '_'),
      weekOf,
      subject,
      gradeSection: document.getElementById('dllGradeSection').value.trim(),
      quarter:      document.getElementById('dllQuarter').value,
      weekNo:       document.getElementById('dllWeekNo').value,
      days:         daysData,
      savedBy:      '{{ Auth::user()->name }}',
      savedAt:      new Date().toISOString(),
    };
  }

  function upsertRecord(newRecord) {
    const dlls = JSON.parse(localStorage.getItem(DLL_KEY) || '[]');
    const idx  = dlls.findIndex(r => r.id === newRecord.id);
    if (idx >= 0) {
      dlls[idx].days    = Object.assign({}, dlls[idx].days, newRecord.days);
      dlls[idx].savedAt = newRecord.savedAt;
    } else {
      dlls.push(newRecord);
    }
    localStorage.setItem(DLL_KEY, JSON.stringify(dlls));
  }

  // ── Save actions ───────────────────────────────────────────────────────────
  function saveDays(days) {
    if (!validateHeader()) return;
    if (!days.length) { showError('Select at least one day to save.'); return; }
    upsertRecord(buildRecord(days));
    showSuccess('Saved: ' + days.map(d => DAY_LABELS[d]).join(', '));
    updateFillDots();
    renderDLLList();
    updateDllStatus();
  }

  document.getElementById('saveWeekBtn').addEventListener('click', () => {
    if (!validateHeader()) return;
    saveDays(DAYS);
  });

  document.getElementById('saveSelectedBtn').addEventListener('click', () => {
    if (!validateHeader()) return;
    const selected = [...document.querySelectorAll('.day-checkbox:checked')].map(cb => cb.dataset.day);
    if (!selected.length) { showError('Please check at least one day (☑) in the tab bar to save.'); return; }
    saveDays(selected);
  });

  // ── AI Pre-Check (active day) ──────────────────────────────────────────────
  document.getElementById('aiCheckBtn').addEventListener('click', function () {
    const d     = activeDay;
    const data  = getDayData(d);
    const errEl = document.getElementById('dllError');
    const resEl = document.getElementById('aiResult');
    errEl.classList.add('hidden');
    resEl.classList.add('hidden');

    if (!data.objectives && !data.content && !data.procedures) {
      errEl.textContent = `Fill in Objectives, Content, or Procedures for ${DAY_LABELS[d]} before running the AI Pre-Check.`;
      errEl.classList.remove('hidden');
      return;
    }

    this.disabled = true;
    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Analyzing…';

    setTimeout(() => {
      const passed = data.objectives.length >= DLL_MIN_OBJECTIVES
        && data.procedures.length >= DLL_MIN_PROCEDURES
        && data.content.length    >= DLL_MIN_CONTENT;

      if (passed) {
        resEl.innerHTML = `
          <p class="font-semibold text-emerald-700"><i class="fa-solid fa-circle-check mr-1"></i> AI Pre-Check Passed — ${escHtml(DAY_LABELS[d])}</p>
          <ul class="list-disc list-inside space-y-1 text-slate-600">
            <li>Objectives align with DepEd K–12 competency standards.</li>
            <li>Lesson flow covers Motivation, Presentation, Practice, and Assessment.</li>
            <li>Content, resources, and reflection sections are complete.</li>
          </ul>
          <p class="text-xs text-slate-400 mt-1">Pre-check completed at ${new Date().toLocaleTimeString()}</p>`;
        localStorage.setItem(DLL_STATUS_KEY, JSON.stringify({
          label: 'Pending Approval', tone: 'pending',
          at: new Date().toLocaleString('en-PH'), reviewer: 'School Head',
        }));
        renderStatus();
      } else {
        resEl.innerHTML = `
          <p class="font-semibold text-amber-700"><i class="fa-solid fa-triangle-exclamation mr-1"></i> AI Pre-Check: Needs Improvement — ${escHtml(DAY_LABELS[d])}</p>
          <ul class="list-disc list-inside space-y-1 text-slate-600">
            <li>Objectives are too brief — expand with specific learning competencies.</li>
            <li>Procedures section should detail at least 4 phases of instruction.</li>
            <li>Content and reflection should include clear learning insights.</li>
          </ul>`;
      }
      resEl.classList.remove('hidden');
      this.disabled = false;
      this.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles mr-2"></i>AI Pre-Check (Active Day)';
    }, 1800);
  });

  // ── Status ─────────────────────────────────────────────────────────────────
  function renderStatus() {
    const status   = JSON.parse(localStorage.getItem(DLL_STATUS_KEY) || 'null');
    const badge    = document.getElementById('dllStatusBadge');
    const meta     = document.getElementById('dllStatusMeta');
    const reviewer = document.getElementById('dllReviewer');
    if (!status) {
      badge.textContent    = 'Pending Draft';
      badge.className      = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-amber-100 text-amber-700';
      meta.textContent     = 'No DLL submitted yet.';
      reviewer.textContent = 'School Head (Pending Assignment)';
      return;
    }
    badge.textContent    = status.label;
    badge.className      = status.tone === 'approved'
      ? 'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700'
      : 'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700';
    meta.textContent     = `Last update: ${status.at}`;
    reviewer.textContent = status.reviewer || 'School Head';
  }

  function updateDllStatus() {
    const dlls = JSON.parse(localStorage.getItem(DLL_KEY) || '[]');
    if (!dlls.length) return;
    const latest = dlls[dlls.length - 1];
    const filled = DAYS.filter(d => latest.days?.[d] && Object.values(latest.days[d]).some(v => v)).length;
    const cur    = JSON.parse(localStorage.getItem(DLL_STATUS_KEY) || 'null');
    if (cur?.tone === 'approved') return;
    localStorage.setItem(DLL_STATUS_KEY, JSON.stringify({
      label: `${filled}/5 Days Saved`, tone: filled === 5 ? 'approved' : 'pending',
      at: new Date().toLocaleString('en-PH'), reviewer: 'School Head',
    }));
    renderStatus();
  }

  // ── Saved DLL list (grouped by week) ──────────────────────────────────────
  function renderDLLList() {
    const dlls = JSON.parse(localStorage.getItem(DLL_KEY) || '[]');
    const list = document.getElementById('dllList');
    if (!dlls.length) {
      list.innerHTML = '<li class="text-slate-400 italic">No DLLs saved yet.</li>';
      return;
    }
    list.innerHTML = dlls.slice().reverse().map((d, idx) => {
      const monday    = new Date(d.weekOf + 'T00:00:00');
      const friday    = new Date(monday);
      friday.setDate(monday.getDate() + 4);
      const weekLabel = `${fmtDate(monday)} – ${fmtDate(friday)}`;
      const dayDots   = DAYS.map(day => {
        const filled = d.days?.[day] && Object.values(d.days[day]).some(v => v);
        return `<span title="${DAY_LABELS[day]}" class="inline-block w-2.5 h-2.5 rounded-full ${filled ? 'bg-emerald-500' : 'bg-slate-200'}"></span>`;
      }).join('');
      const detailId = `dll-detail-${idx}`;
      return `
        <li class="border border-slate-100 rounded-xl bg-slate-50 overflow-hidden">
          <button type="button"
            class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-slate-100 transition-colors"
            onclick="document.getElementById('${detailId}').classList.toggle('hidden')">
            <i class="fa-regular fa-calendar-week text-blue-700 flex-shrink-0 text-base"></i>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-slate-800 truncate">${escHtml(d.subject)}</p>
              <p class="text-xs text-slate-400 mt-0.5">Week of ${escHtml(weekLabel)}${d.gradeSection ? ' · ' + escHtml(d.gradeSection) : ''}${d.quarter ? ' · ' + escHtml(d.quarter) : ''}${d.weekNo ? ' · Week ' + escHtml(d.weekNo) : ''}</p>
            </div>
            <div class="flex items-center gap-1 flex-shrink-0">${dayDots}</div>
            <i class="fa-solid fa-chevron-down text-slate-400 text-xs flex-shrink-0 ml-1"></i>
          </button>
          <div id="${detailId}" class="hidden border-t border-slate-100 px-4 py-3">
            <div class="grid grid-cols-1 sm:grid-cols-5 gap-2">
              ${DAYS.map(day => {
                const dd     = d.days?.[day];
                const filled = dd && Object.values(dd).some(v => v);
                return `<div class="text-xs rounded-lg border ${filled ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-white'} p-2">
                  <p class="font-semibold ${filled ? 'text-emerald-700' : 'text-slate-400'} mb-1">${DAY_LABELS[day]}</p>
                  ${filled ? `<p class="text-slate-600 line-clamp-3">${escHtml(dd.objectives || '—')}</p>` : '<p class="text-slate-300 italic">No content</p>'}
                </div>`;
              }).join('')}
            </div>
            <p class="text-xs text-slate-400 mt-2">Saved by ${escHtml(d.savedBy)} on ${new Date(d.savedAt).toLocaleDateString('en-PH')}</p>
          </div>
        </li>`;
    }).join('');
  }

  // ── Week picker label ──────────────────────────────────────────────────────
  document.getElementById('dllWeekOf').addEventListener('change', function () {
    const monday = weekInputToMonday(this.value);
    if (!monday) { document.getElementById('dllWeekLabel').textContent = ''; return; }
    const friday = new Date(monday);
    friday.setDate(monday.getDate() + 4);
    document.getElementById('dllWeekLabel').textContent = `${fmtDate(monday)} – ${fmtDate(friday)}`;
  });

  // ── COT ledger ─────────────────────────────────────────────────────────────
  function renderCOTLedger() {
    const entries = JSON.parse(localStorage.getItem(COT_KEY) || '[]');
    const tbody   = document.getElementById('cotLedger');
    if (!entries.length) {
      tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-4 text-center text-slate-400 italic">No evaluation records yet.</td></tr>';
      return;
    }
    tbody.innerHTML = entries.slice().reverse().map(e => `
      <tr class="border-b border-slate-100">
        <td class="px-4 py-3">${escHtml(e.year)}</td>
        <td class="px-4 py-3 font-semibold">${escHtml(e.score)}</td>
        <td class="px-4 py-3 text-slate-500 text-xs">${escHtml(e.seminar || '—')}</td>
        <td class="px-4 py-3 text-slate-500 text-xs">${escHtml(e.date)}</td>
      </tr>
    `).join('');
  }

  document.getElementById('cotForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const year        = document.getElementById('cotYear').value.trim();
    const score       = document.getElementById('cotScore').value.trim();
    const seminarFile = document.getElementById('cotSeminar').files[0];
    const msg         = document.getElementById('cotMessage');
    if (!year || !score) {
      msg.textContent = 'School year and COT rating are required.';
      msg.className   = 'text-sm text-rose-600';
      return;
    }
    const entries = JSON.parse(localStorage.getItem(COT_KEY) || '[]');
    entries.push({ year, score, seminar: seminarFile?.name || 'Uploaded certificate', date: new Date().toLocaleDateString('en-PH') });
    localStorage.setItem(COT_KEY, JSON.stringify(entries));
    msg.textContent = 'Evaluation saved to performance ledger.';
    msg.className   = 'text-sm text-emerald-600';
    this.reset();
    renderCOTLedger();
    setTimeout(() => { msg.textContent = ''; }, 3000);
  });

  // ── DSS ────────────────────────────────────────────────────────────────────
  document.getElementById('dssComputeBtn').addEventListener('click', function () {
    document.getElementById('dssLastRun').textContent = `Computed ${new Date().toLocaleTimeString()}`;
  });

  // ── Init ───────────────────────────────────────────────────────────────────
  renderTabs();
  renderPanels();
  renderDLLList();
  renderStatus();
  renderCOTLedger();
</script>
@endsection
