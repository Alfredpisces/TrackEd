@extends('layouts.app')

@section('title', 'TrackEd | Teacher Dashboard')

@section('page-title', 'Teacher Dashboard')

@section('content')
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
    <a href="{{ route('teacher-performance') }}" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
      <i class="fa-solid fa-file-lines mr-2"></i>Open DLL Builder
    </a>
    <a href="{{ route('property-inventory') }}" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
      <i class="fa-solid fa-box-archive mr-2"></i>Update Assets
    </a>
  </div>
</div>

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

  const blockedAssets = assets.filter(a =>
    ['Damaged', 'Lost'].includes(a.condition) && a.resolution !== 'Paid/Replaced'
  );
  document.getElementById('teacherAssetCount').textContent = assets.length;
  document.getElementById('teacherAssetMeta').textContent =
    blockedAssets.length ? `${blockedAssets.length} asset(s) need resolution.` : 'All assets cleared.';
</script>
@endsection
