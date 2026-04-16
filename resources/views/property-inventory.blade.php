@extends('layouts.app')

@section('title', 'TrackEd | Property Inventory')

@section('page-title', 'Property Inventory')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm overflow-x-auto">
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-semibold text-slate-700">Assigned Assets (E-PAR)</h3>
    <button id="addAssetBtn" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
      <i class="fa-solid fa-plus mr-1"></i> Add Asset
    </button>
  </div>
  <table class="min-w-full text-sm">
    <thead class="bg-slate-100 text-slate-600">
      <tr>
        <th class="text-left px-4 py-3">Item</th>
        <th class="text-left px-4 py-3">Serial Number</th>
        <th class="text-left px-4 py-3">Condition</th>
        <th class="text-left px-4 py-3">Last Updated</th>
        <th class="text-left px-4 py-3">Action</th>
      </tr>
    </thead>
    <tbody id="assetTbody"></tbody>
  </table>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Year-End Clearance Status</h3>
  <div class="bg-slate-100 rounded-full h-4 overflow-hidden">
    <div class="h-4 bg-amber-500 transition-all duration-500" id="clearanceBar" style="width:0%"></div>
  </div>
  <p class="mt-3 text-sm text-slate-600" id="clearanceText">Calculating…</p>
  <div id="clearanceBanner" class="mt-4 rounded-lg p-3 font-medium text-sm hidden"></div>
</div>
@endsection

{{-- Add / Edit Asset Modal --}}
@section('modal')
<div id="modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 space-y-4">
    <h4 class="text-lg font-semibold text-slate-800" id="modalTitle">Add Asset</h4>
    <div>
      <label class="block text-sm font-medium mb-1">Item Name</label>
      <input id="mItem" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g. Lenovo Laptop" />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Serial Number</label>
      <input id="mSerial" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g. LNV-2025-00192" />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Condition</label>
      <select id="mCondition" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white">
        <option value="Functional">Functional</option>
        <option value="For Repair">For Repair</option>
        <option value="Damaged">Damaged</option>
        <option value="Condemned">Condemned</option>
      </select>
    </div>
    <div id="modalError" class="hidden bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-3"></div>
    <div class="flex gap-3 justify-end">
      <button onclick="closeModal()" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm">Cancel</button>
      <button id="modalSaveBtn" onclick="saveAsset()" class="px-4 py-2 rounded-lg bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold">Save</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const user = Auth.require();
  if (!user) throw new Error('unauthenticated');
  document.getElementById('userName').textContent     = user.name;
  document.getElementById('userInitials').textContent = user.initials;

  const ASSET_KEY = 'tracked_assets';
  const DEFAULT_ASSETS = [
    { item: 'Lenovo Laptop', serial: 'LNV-2025-00192', condition: 'Functional', updated: 'Apr 1, 2026' },
    { item: 'Smart TV 55"',  serial: 'STV-2023-00811', condition: 'Damaged',    updated: 'Mar 15, 2026' },
  ];

  function getAssets() {
    const raw = localStorage.getItem(ASSET_KEY);
    return raw ? JSON.parse(raw) : DEFAULT_ASSETS;
  }
  function saveAssets(arr) { localStorage.setItem(ASSET_KEY, JSON.stringify(arr)); }

  const CONDITION_BADGE = {
    'Functional': 'bg-emerald-100 text-emerald-700',
    'For Repair':  'bg-amber-100 text-amber-700',
    'Damaged':     'bg-rose-100 text-rose-700',
    'Condemned':   'bg-slate-200 text-slate-600',
  };

  function renderAssets() {
    const assets = getAssets();
    const tbody  = document.getElementById('assetTbody');
    tbody.innerHTML = assets.map((a, i) => {
      const badge = CONDITION_BADGE[a.condition] || 'bg-slate-100 text-slate-600';
      return `<tr class="border-b border-slate-200">
        <td class="px-4 py-3">${a.item}</td>
        <td class="px-4 py-3 font-mono text-xs">${a.serial}</td>
        <td class="px-4 py-3"><span class="px-2.5 py-1 rounded-full text-xs font-semibold ${badge}">${a.condition}</span></td>
        <td class="px-4 py-3 text-slate-500 text-xs">${a.updated}</td>
        <td class="px-4 py-3">
          <button onclick="openEdit(${i})" class="bg-blue-900 hover:bg-blue-800 text-white px-3 py-1.5 rounded-lg text-xs">Update Condition</button>
        </td>
      </tr>`;
    }).join('');
    renderClearance(assets);
  }

  function renderClearance(assets) {
    const total   = assets.length;
    const cleared = assets.filter(a => a.condition === 'Functional').length;
    const pct     = total === 0 ? 100 : Math.round((cleared / total) * 100);
    const damaged = assets.filter(a => a.condition !== 'Functional').length;

    document.getElementById('clearanceBar').style.width = pct + '%';
    document.getElementById('clearanceBar').className =
      'h-4 transition-all duration-500 ' + (pct === 100 ? 'bg-emerald-500' : pct >= 70 ? 'bg-amber-500' : 'bg-rose-500');
    document.getElementById('clearanceText').textContent =
      `${pct}% complete — ${damaged} asset(s) pending repair/settlement.`;

    const banner = document.getElementById('clearanceBanner');
    banner.classList.remove('hidden');
    if (damaged === 0) {
      banner.className = 'mt-4 rounded-lg p-3 font-medium text-sm border border-emerald-200 bg-emerald-50 text-emerald-800';
      banner.innerHTML = '<i class="fa-solid fa-circle-check mr-2"></i>Clearance Status: All assets accounted for. Cleared!';
    } else {
      banner.className = 'mt-4 rounded-lg p-3 font-medium text-sm border border-amber-200 bg-amber-50 text-amber-800';
      banner.innerHTML = `<i class="fa-solid fa-triangle-exclamation mr-2"></i>Clearance Status: Blocked until ${damaged} unresolved property accountability item(s) are settled.`;
    }
  }

  let editIdx = null;

  window.openEdit = function (idx) {
    editIdx = idx;
    const a = getAssets()[idx];
    document.getElementById('modalTitle').textContent = 'Update Asset Condition';
    document.getElementById('mItem').value            = a.item;
    document.getElementById('mItem').disabled         = true;
    document.getElementById('mSerial').value          = a.serial;
    document.getElementById('mSerial').disabled       = true;
    document.getElementById('mCondition').value       = a.condition;
    document.getElementById('modalError').classList.add('hidden');
    document.getElementById('modal').classList.remove('hidden');
  };

  document.getElementById('addAssetBtn').addEventListener('click', function () {
    editIdx = null;
    document.getElementById('modalTitle').textContent = 'Add Asset';
    document.getElementById('mItem').value            = '';
    document.getElementById('mItem').disabled         = false;
    document.getElementById('mSerial').value          = '';
    document.getElementById('mSerial').disabled       = false;
    document.getElementById('mCondition').value       = 'Functional';
    document.getElementById('modalError').classList.add('hidden');
    document.getElementById('modal').classList.remove('hidden');
  });

  window.closeModal = function () {
    document.getElementById('modal').classList.add('hidden');
  };

  window.saveAsset = function () {
    const item      = document.getElementById('mItem').value.trim();
    const serial    = document.getElementById('mSerial').value.trim();
    const condition = document.getElementById('mCondition').value;
    const errEl     = document.getElementById('modalError');
    errEl.classList.add('hidden');

    if (!item || !serial) {
      errEl.textContent = 'Item name and serial number are required.';
      errEl.classList.remove('hidden');
      return;
    }

    const assets = getAssets();
    const today  = new Date().toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });

    if (editIdx !== null) {
      assets[editIdx].condition = condition;
      assets[editIdx].updated   = today;
    } else {
      assets.push({ item, serial, condition, updated: today });
    }
    saveAssets(assets);
    closeModal();
    renderAssets();
  };

  document.getElementById('modal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
  });

  renderAssets();
</script>
@endsection
