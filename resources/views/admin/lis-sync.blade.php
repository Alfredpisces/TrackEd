@extends('layouts.app')

@section('title', 'TrackEd | LIS Sync')

@section('page-title', 'LIS Sync (Administrator)')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
    <h3 class="text-lg font-semibold text-slate-700 mb-1">Upload LIS Masterlist</h3>
    <p class="text-sm text-slate-500 mb-5">
      Upload the official DepEd LIS CSV file to update the central student masterlist.
      Existing LRNs are updated, new LRNs are inserted, and duplicate rows are skipped.
    </p>

    <form id="lisForm" class="space-y-4" novalidate>
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">LIS CSV File</label>
        <input id="lisFile" type="file" accept=".csv"
          class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white" />
        <p class="text-xs text-slate-400 mt-1">Accepted format: CSV with LRN, Last Name, First Name, Grade, Section.</p>
      </div>

      <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 text-sm text-slate-600">
        <p class="font-semibold text-slate-700 mb-2">File Format Hints</p>
        <ul class="list-disc list-inside space-y-1">
          <li>LRN column must be 12 digits (no spaces).</li>
          <li>Use UTF-8 encoding to avoid corrupted characters.</li>
          <li>Duplicate LRNs in the file are ignored after the first entry.</li>
        </ul>
      </div>

      <div class="flex flex-wrap gap-3">
        <button type="submit"
          class="bg-blue-900 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg font-semibold">
          <i class="fa-solid fa-cloud-arrow-up mr-2"></i>Run LIS Sync
        </button>
        <span id="lisFileName" class="text-sm text-slate-500 self-center"></span>
      </div>

      <div id="lisError" class="hidden bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3"></div>
    </form>
  </div>

  <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm space-y-4">
    <h3 class="text-lg font-semibold text-slate-700">Last Sync Summary</h3>
    <div class="space-y-3 text-sm">
      <div class="flex items-center justify-between">
        <span class="text-slate-500">Last run</span>
        <span id="lisLastRun" class="font-semibold text-slate-700">Not yet synced</span>
      </div>
      <div class="grid grid-cols-3 gap-3">
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 text-center">
          <p class="text-xs text-emerald-700">Inserted</p>
          <p id="lisInserted" class="text-lg font-semibold text-emerald-700">0</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
          <p class="text-xs text-blue-700">Updated</p>
          <p id="lisUpdated" class="text-lg font-semibold text-blue-700">0</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-center">
          <p class="text-xs text-amber-700">Skipped</p>
          <p id="lisSkipped" class="text-lg font-semibold text-amber-700">0</p>
        </div>
      </div>
      <div id="lisMessage" class="hidden text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-lg p-3"></div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const LIS_KEY = 'tracked_lis_sync';
  const lisForm = document.getElementById('lisForm');
  const lisFile = document.getElementById('lisFile');
  const lisFileName = document.getElementById('lisFileName');
  const lisError = document.getElementById('lisError');
  const lisMessage = document.getElementById('lisMessage');

  function renderLisSummary() {
    const last = JSON.parse(localStorage.getItem(LIS_KEY) || 'null');
    document.getElementById('lisLastRun').textContent = last?.ranAt || 'Not yet synced';
    document.getElementById('lisInserted').textContent = last?.inserted ?? 0;
    document.getElementById('lisUpdated').textContent = last?.updated ?? 0;
    document.getElementById('lisSkipped').textContent = last?.skipped ?? 0;
    if (last?.file) {
      lisMessage.textContent = `Last file: ${last.file}. ${last.note}`;
      lisMessage.classList.remove('hidden');
    }
  }
  renderLisSummary();

  lisFile.addEventListener('change', () => {
    lisFileName.textContent = lisFile.files[0]?.name || '';
  });

  lisForm.addEventListener('submit', (e) => {
    e.preventDefault();
    lisError.classList.add('hidden');
    const file = lisFile.files[0];
    if (!file) {
      lisError.textContent = 'Please select a LIS CSV file to upload.';
      lisError.classList.remove('hidden');
      return;
    }

    const fakeSummary = {
      file: file.name,
      ranAt: new Date().toLocaleString('en-PH'),
      inserted: Math.floor(Math.random() * 40) + 10,
      updated: Math.floor(Math.random() * 30) + 5,
      skipped: Math.floor(Math.random() * 8),
      note: 'LRN-based upsert completed successfully.',
    };
    localStorage.setItem(LIS_KEY, JSON.stringify(fakeSummary));
    renderLisSummary();
    lisForm.reset();
    lisFileName.textContent = '';
  });
</script>
@endsection
