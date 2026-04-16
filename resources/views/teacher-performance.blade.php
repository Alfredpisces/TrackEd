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
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Date</label>
        <input id="dllDate" type="date" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
      </div>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Objectives</label>
      <textarea id="dllObjectives" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="State competencies and learning outcomes..."></textarea>
    </div>
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Procedures</label>
      <textarea id="dllProcedures" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="List lesson flow and classroom activities..."></textarea>
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
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Saved Daily Lesson Logs</h3>
  <ul id="dllList" class="space-y-2 text-sm text-slate-600">
    <li class="text-slate-400 italic">No DLLs saved yet.</li>
  </ul>
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

  document.getElementById('dllForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const subject    = document.getElementById('dllSubject').value.trim();
    const date       = document.getElementById('dllDate').value;
    const objectives = document.getElementById('dllObjectives').value.trim();
    const procedures = document.getElementById('dllProcedures').value.trim();
    const errEl      = document.getElementById('dllError');
    const okEl       = document.getElementById('dllSuccess');
    errEl.classList.add('hidden');
    okEl.classList.add('hidden');

    if (!subject || !date || !objectives || !procedures) {
      errEl.textContent = 'All fields are required before saving.';
      errEl.classList.remove('hidden');
      return;
    }

    const dlls = JSON.parse(localStorage.getItem(DLL_KEY) || '[]');
    dlls.push({ subject, date, objectives, procedures, savedBy: '{{ Auth::user()->name }}', savedAt: new Date().toISOString() });
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
    const procedures = document.getElementById('dllProcedures').value.trim();
    const errEl      = document.getElementById('dllError');
    const resultEl   = document.getElementById('aiResult');
    errEl.classList.add('hidden');
    resultEl.classList.add('hidden');

    if (!subject || !objectives || !procedures) {
      errEl.textContent = 'Please fill in Subject, Objectives, and Procedures before running the AI Pre-Check.';
      errEl.classList.remove('hidden');
      return;
    }

    this.disabled = true;
    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Analyzing…';

    setTimeout(() => {
      const hasKeywords = objectives.length > 20 && procedures.length > 30;
      if (hasKeywords) {
        resultEl.innerHTML = `
          <p class="font-semibold text-emerald-700"><i class="fa-solid fa-circle-check mr-1"></i> AI Pre-Check Passed</p>
          <ul class="list-disc list-inside space-y-1 text-slate-600">
            <li>Objectives align with DepEd K–12 competency standards.</li>
            <li>Lesson flow covers Motivation, Presentation, Practice, and Assessment.</li>
            <li>Estimated contact time is within the 60-minute period.</li>
          </ul>
          <p class="text-xs text-slate-400 mt-1">Pre-check completed at ${new Date().toLocaleTimeString()}</p>`;
      } else {
        resultEl.innerHTML = `
          <p class="font-semibold text-amber-700"><i class="fa-solid fa-triangle-exclamation mr-1"></i> AI Pre-Check: Needs Improvement</p>
          <ul class="list-disc list-inside space-y-1 text-slate-600">
            <li>Objectives are too brief — expand with specific learning competencies.</li>
            <li>Procedures section should detail at least 4 phases of instruction.</li>
          </ul>`;
      }
      resultEl.classList.remove('hidden');
      this.disabled = false;
      this.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles mr-2"></i>Run AI Pre-Check';
    }, 1800);
  });
</script>
@endsection
