@extends('layouts.app')

@section('title', 'TrackEd | Teacher Dashboard')

@section('page-title', 'Teacher Dashboard')

@section('content')
<<<<<<< HEAD
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">DLL Status</p>
            <p class="text-3xl font-bold text-blue-900 mt-2" id="teacherDllStatus">Pending Draft</p>
            <p class="text-xs text-slate-400 mt-1" id="teacherDllMeta">No DLL submitted yet.</p>
        </article>
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Saved DLLs</p>
            <p class="text-3xl font-bold text-emerald-600 mt-2" id="teacherDllCount">0</p>
            <p class="text-xs text-slate-400 mt-1">Drafts in your local log.</p>
        </article>
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Assigned Assets</p>
            <p class="text-3xl font-bold text-amber-600 mt-2" id="teacherAssetCount">0</p>
            <p class="text-xs text-slate-400 mt-1" id="teacherAssetMeta">Inventory updates pending.</p>
        </article>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-700 mb-3">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('teacher-performance') }}"
                class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                <i class="fa-solid fa-file-lines mr-2"></i>Open DLL Builder
            </a>
            <a href="{{ route('property-inventory') }}"
                class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                <i class="fa-solid fa-box-archive mr-2"></i>Update Assets
            </a>
        </div>
=======

{{-- ── KPI Summary Cards ── --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">DLL Status</p>
    <p class="text-3xl font-bold text-blue-900 mt-2" id="teacherDllStatus">Pending Draft</p>
    <p class="text-xs text-slate-400 mt-1" id="teacherDllMeta">No DLL submitted yet.</p>
  </article>
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">Saved DLLs</p>
    <p class="text-3xl font-bold text-emerald-600 mt-2" id="teacherDllCount">0</p>
    <p class="text-xs text-slate-400 mt-1">Drafts in your local log.</p>
  </article>
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">Assigned Assets</p>
    <p class="text-3xl font-bold text-amber-600 mt-2" id="teacherAssetCount">0</p>
    <p class="text-xs text-slate-400 mt-1" id="teacherAssetMeta">Inventory updates pending.</p>
  </article>
</div>

{{-- ── System-Based DLL Builder ── --}}
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
  <div class="flex items-center justify-between mb-2">
    <h3 class="text-lg font-semibold text-slate-800">System-Based DLL Builder</h3>
    <a href="{{ route('teacher-performance') }}"
       class="text-sm text-blue-900 font-semibold hover:underline">Open Full DLL Module →</a>
  </div>
  <p class="text-sm text-slate-500 mb-5">Prepare a Daily Lesson Log for School Head review. Run the AI Pre-Check before submission.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-slate-700">Subject</label>
      <select class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
        <option>Science 9</option>
        <option>English 10</option>
        <option>Mathematics 8</option>
        <option>Filipino 7</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700">Date Covered</label>
      <input type="date" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" value="2026-06-24" />
    </div>
  </div>

  <div class="mt-4">
    <label class="block text-sm font-medium text-slate-700">Objectives</label>
    <textarea rows="3" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none">At the end of the lesson, learners should explain the law of conservation of mass through guided experimentation.</textarea>
  </div>
  <div class="mt-4">
    <label class="block text-sm font-medium text-slate-700">Procedures / Learning Activities</label>
    <textarea rows="4" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none">1. Review previous topic on chemical reactions. 2. Group activity using vinegar and baking soda setup. 3. Process observations and connect to MELC competency. 4. Reflection and assessment.</textarea>
  </div>

  <div class="mt-5 flex flex-wrap gap-3">
    <button onclick="alert('AI Pre-Check: ✅ Passed — Objectives and Procedures have sufficient detail. You may now submit.')"
            class="bg-blue-900 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold">
      <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>Run AI Pre-Check
    </button>
    <button class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-sm font-semibold">
      <i class="fa-regular fa-floppy-disk mr-2"></i>Save Draft
    </button>
  </div>
</section>

{{-- ── Student Incident Report + E-PAR Accountability ── --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800 mb-1">Student Incident Report Form</h3>
    <p class="text-sm text-slate-500 mb-5">Log behavioral incidents for guidance office review.</p>
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-slate-700">Learner Reference Number (LRN)</label>
        <input type="text" value="112233445566"
               class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none"
               placeholder="12-digit LRN (auto-fills name)" />
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700">Offense Category</label>
        <select class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
          <option>— Select offense —</option>
          <optgroup label="Minor Offenses">
            <option>Tardiness</option>
            <option>Improper Uniform</option>
            <option>Class Disruption</option>
          </optgroup>
          <optgroup label="Major Offenses">
            <option>Bullying</option>
            <option>Cheating / Academic Dishonesty</option>
            <option>Vandalism</option>
            <option>Substance Abuse</option>
          </optgroup>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700">Incident Narrative</label>
        <textarea rows="4" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none"
                  placeholder="Describe the incident in detail...">Learner repeatedly teased a classmate during group activity, resulting in emotional distress. Incident was witnessed by the section adviser and documented for guidance intervention.</textarea>
      </div>
      <button class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
        <i class="fa-solid fa-paper-plane mr-2"></i>Submit Incident Report
      </button>
>>>>>>> b05e733d2fe31fda4fd84e4465f3dd929ca07fcf
    </div>

<<<<<<< HEAD
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-700 mb-3">Next Steps</h3>
        <ul class="list-disc list-inside text-sm text-slate-600 space-y-1">
            <li>Submit DLL for approval before Friday.</li>
            <li>Upload seminar certificates to update professional growth points.</li>
            <li>Review asset acknowledgment status for assigned equipment.</li>
        </ul>
    </div>
@endsection

@section('scripts')
    <script>
        const dllStatus = JSON.parse(localStorage.getItem('tracked_dll_status') || 'null');
        const dlls = JSON.parse(localStorage.getItem('tracked_dlls') || '[]');
        const assets = JSON.parse(localStorage.getItem('tracked_assets') || '[]');

        document.getElementById('teacherDllCount').textContent = dlls.length;
        if (dllStatus) {
            document.getElementById('teacherDllStatus').textContent = dllStatus.label;
            document.getElementById('teacherDllMeta').textContent = `Last update: ${dllStatus.at}`;
        }

        const blockedAssets = assets.filter(a => ['Damaged', 'Lost'].includes(a.condition) && a.resolution !==
            'Paid/Replaced'
        );
        document.getElementById('teacherAssetCount').textContent = assets.length;
        document.getElementById('teacherAssetMeta').textContent =
            blockedAssets.length ? `${blockedAssets.length} asset(s) need resolution.` : 'All assets cleared.';
    </script>
=======
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <div>
        <h3 class="text-lg font-semibold text-slate-800">My Accountability (E-PAR)</h3>
        <p class="text-sm text-slate-500">Equipment assigned to you requiring acknowledgment.</p>
      </div>
      <a href="{{ route('property-inventory') }}"
         class="text-sm text-blue-900 font-semibold hover:underline">View All →</a>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm" id="eParTable">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="text-left px-6 py-3 font-semibold">Asset</th>
            <th class="text-left px-6 py-3 font-semibold">Serial No.</th>
            <th class="text-left px-6 py-3 font-semibold">Date Assigned</th>
            <th class="text-left px-6 py-3 font-semibold">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100" id="eParBody">
          {{-- Seeded mock row --}}
          <tr>
            <td class="px-6 py-4 font-medium">Lenovo ThinkPad Laptop</td>
            <td class="px-6 py-4">PF39A2Q1</td>
            <td class="px-6 py-4 text-slate-400">June 03, 2026</td>
            <td class="px-6 py-4">
              <button class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg"
                      onclick="alert('E-PAR acknowledged. Thank you for confirming receipt of Lenovo ThinkPad Laptop.')">
                Acknowledge
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

</div>

{{-- ── Quick Actions / Next Steps ── --}}
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
  <h3 class="text-lg font-semibold text-slate-800 mb-3">Next Steps This Week</h3>
  <ul class="list-disc list-inside text-sm text-slate-600 space-y-1">
    <li>Submit DLL for School Head approval before Friday.</li>
    <li>Upload seminar certificates to update professional growth points.</li>
    <li>Review asset acknowledgment status for all assigned equipment.</li>
    <li>Report any student behavioral incidents to the guidance office.</li>
  </ul>
</section>

@endsection

@section('scripts')
<script>
  const dllStatus = JSON.parse(localStorage.getItem('tracked_dll_status') || 'null');
  const dlls      = JSON.parse(localStorage.getItem('tracked_dlls')       || '[]');
  const assets    = JSON.parse(localStorage.getItem('tracked_assets')     || '[]');

  document.getElementById('teacherDllCount').textContent = dlls.length;
  if (dllStatus) {
    document.getElementById('teacherDllStatus').textContent = dllStatus.label;
    document.getElementById('teacherDllMeta').textContent   = `Last update: ${dllStatus.at}`;
  }

  const blockedAssets = assets.filter(a =>
    ['Damaged', 'Lost'].includes(a.condition) && a.resolution !== 'Paid/Replaced'
  );
  document.getElementById('teacherAssetCount').textContent = assets.length || 1; // show at least the mock row
  document.getElementById('teacherAssetMeta').textContent  =
    blockedAssets.length ? `${blockedAssets.length} asset(s) need resolution.` : 'All assets cleared.';
</script>
>>>>>>> b05e733d2fe31fda4fd84e4465f3dd929ca07fcf
@endsection
