@extends('layouts.app')

@section('title', 'TrackEd | Property Inventory')

@section('page-title', 'Property Inventory')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
    <h3 class="text-lg font-semibold text-slate-700 mb-1">Assign Hardware Asset (E-PAR)</h3>
    <p class="text-sm text-slate-500 mb-4">
      Link assets to a teacher profile and generate an electronic property acknowledgment receipt.
    </p>
    <form id="assignForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Asset ID</label>
        <input id="assignItem" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Laptop / Smart TV" />
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Serial Number</label>
        <input id="assignSerial" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="SN-2026-00192" />
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Teacher ID</label>
        <input id="assignTeacher" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="TCH-1001" />
      </div>
      <div class="md:col-span-3 flex items-center gap-3">
        <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg font-semibold">
          <i class="fa-solid fa-file-signature mr-2"></i>Generate E-PAR
        </button>
        <p id="assignMsg" class="text-sm text-slate-500"></p>
      </div>
    </form>
  </div>
  <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
    <h3 class="text-lg font-semibold text-slate-700 mb-4">E-PAR Preview</h3>
    <div id="epPreview" class="text-sm text-slate-600 space-y-2">
      <p class="text-slate-400 italic">No E-PAR generated yet.</p>
    </div>
  </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm overflow-x-auto">
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-semibold text-slate-700">Assigned Assets (E-PAR)</h3>
    <button id="addAssetBtn" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
      <i class="fa-solid fa-plus mr-1"></i> Quick Add Asset
    </button>
  </div>
  <table class="min-w-full text-sm">
    <thead class="bg-slate-100 text-slate-600">
      <tr>
        <th class="text-left px-4 py-3">Item</th>
        <th class="text-left px-4 py-3">Serial Number</th>
        <th class="text-left px-4 py-3">Assigned To</th>
        <th class="text-left px-4 py-3">Acknowledgment</th>
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

<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
  <h3 class="text-lg font-semibold text-slate-700 mb-4">Asset Condition History</h3>
  <ul id="assetHistory" class="space-y-2 text-sm text-slate-600">
    <li class="text-slate-400 italic">No history logged yet.</li>
  </ul>
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
        <option value="Lost">Lost</option>
        <option value="Condemned">Condemned</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Resolution Status</label>
      <select id="mResolution" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white">
        <option value="Unresolved">Unresolved</option>
        <option value="Paid/Replaced">Paid/Replaced</option>
      </select>
      <p class="text-xs text-slate-400 mt-1">Required for Lost/Damaged assets.</p>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Remarks</label>
      <textarea id="mRemarks" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Damage details, incident notes..."></textarea>
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
  const ASSET_KEY = 'tracked_assets';
  const EPAR_KEY = 'tracked_epar_last';
  const EPAR_SEQ_KEY = 'tracked_epar_seq';
  const DEFAULT_ASSETS = [
    {
      item: 'Lenovo Laptop',
      serial: 'LNV-2025-00192',
      assignedTo: 'TCH-1001',
      ackStatus: 'Acknowledged',
      condition: 'Functional',
      resolution: 'Unresolved',
      remarks: '',
      updated: 'Apr 1, 2026',
      history: [{ date: 'Apr 1, 2026', condition: 'Functional', remarks: 'Issued for SY 2025-2026', resolution: 'Unresolved' }]
    },
    {
      item: 'Smart TV 55"',
      serial: 'STV-2023-00811',
      assignedTo: 'TCH-1007',
      ackStatus: 'Pending Acknowledgment',
      condition: 'Damaged',
      resolution: 'Unresolved',
      remarks: 'Cracked screen reported.',
      updated: 'Mar 15, 2026',
      history: [{ date: 'Mar 15, 2026', condition: 'Damaged', remarks: 'Reported cracked screen', resolution: 'Unresolved' }]
    },
  ];

  function getAssets() {
    const raw = localStorage.getItem(ASSET_KEY);
    const assets = raw ? JSON.parse(raw) : DEFAULT_ASSETS;
    return assets.map(a => ({
      assignedTo: '',
      ackStatus: 'Pending Acknowledgment',
      resolution: 'Unresolved',
      remarks: '',
      history: [],
      ...a
    }));
  }
  function saveAssets(arr) { localStorage.setItem(ASSET_KEY, JSON.stringify(arr)); }

  const CONDITION_BADGE = {
    'Functional': 'bg-emerald-100 text-emerald-700',
    'For Repair':  'bg-amber-100 text-amber-700',
    'Damaged':     'bg-rose-100 text-rose-700',
    'Lost':        'bg-rose-100 text-rose-700',
    'Condemned':   'bg-slate-200 text-slate-600',
  };
  const ACK_BADGE = {
    'Pending Acknowledgment': 'bg-amber-100 text-amber-700',
    'Acknowledged': 'bg-emerald-100 text-emerald-700',
  };

  function renderAssets() {
    const assets = getAssets();
    const tbody  = document.getElementById('assetTbody');
    tbody.innerHTML = assets.map((a, i) => {
      const badge = CONDITION_BADGE[a.condition] || 'bg-slate-100 text-slate-600';
      const ackBadge = ACK_BADGE[a.ackStatus] || 'bg-slate-100 text-slate-600';
      return `<tr class="border-b border-slate-200">
        <td class="px-4 py-3">${a.item}</td>
        <td class="px-4 py-3 font-mono text-xs">${a.serial}</td>
        <td class="px-4 py-3">${a.assignedTo || '—'}</td>
        <td class="px-4 py-3"><span class="px-2.5 py-1 rounded-full text-xs font-semibold ${ackBadge}">${a.ackStatus || 'Pending'}</span></td>
        <td class="px-4 py-3"><span class="px-2.5 py-1 rounded-full text-xs font-semibold ${badge}">${a.condition}</span></td>
        <td class="px-4 py-3 text-slate-500 text-xs">${a.updated}</td>
        <td class="px-4 py-3">
          <button onclick="openEdit(${i})" class="bg-blue-900 hover:bg-blue-800 text-white px-3 py-1.5 rounded-lg text-xs">Update Condition</button>
        </td>
      </tr>`;
    }).join('');
    renderClearance(assets);
    renderHistory(assets);
  }

  function renderClearance(assets) {
    const total   = assets.length;
    const cleared = assets.filter(a =>
      a.condition === 'Functional' ||
      (['Damaged', 'Lost'].includes(a.condition) && a.resolution === 'Paid/Replaced')
    ).length;
    const pct     = total === 0 ? 100 : Math.round((cleared / total) * 100);
    const blockedItems = assets.filter(a =>
      ['Damaged', 'Lost'].includes(a.condition) && a.resolution !== 'Paid/Replaced'
    );

    document.getElementById('clearanceBar').style.width = pct + '%';
    document.getElementById('clearanceBar').className =
      'h-4 transition-all duration-500 ' + (pct === 100 ? 'bg-emerald-500' : pct >= 70 ? 'bg-amber-500' : 'bg-rose-500');
    document.getElementById('clearanceText').textContent =
      `${pct}% complete — ${blockedItems.length} asset(s) blocked (Lost/Damaged unresolved).`;

    const banner = document.getElementById('clearanceBanner');
    banner.classList.remove('hidden');
    if (blockedItems.length === 0) {
      banner.className = 'mt-4 rounded-lg p-3 font-medium text-sm border border-emerald-200 bg-emerald-50 text-emerald-800';
      banner.innerHTML = '<i class="fa-solid fa-circle-check mr-2"></i>Clearance Status: All assets accounted for. Cleared!';
    } else {
      banner.className = 'mt-4 rounded-lg p-3 font-medium text-sm border border-amber-200 bg-amber-50 text-amber-800';
      banner.innerHTML = `
        <div class="space-y-2">
          <div><i class="fa-solid fa-triangle-exclamation mr-2"></i>Clearance Status: Blocked until ${blockedItems.length} unresolved item(s) are settled.</div>
          <ul class="list-disc list-inside text-xs">
            ${blockedItems.map(a => `<li>${a.item} (${a.serial}) — ${a.condition} / ${a.resolution}</li>`).join('')}
          </ul>
          <p class="text-xs">Required action: mark as Paid/Replaced or update condition to Functional.</p>
        </div>`;
    }
  }

  function renderHistory(assets) {
    const historyEl = document.getElementById('assetHistory');
    const entries = assets.flatMap(a => (a.history || []).map(h => ({ ...h, item: a.item, serial: a.serial })));
    if (!entries.length) {
      historyEl.innerHTML = '<li class="text-slate-400 italic">No history logged yet.</li>';
      return;
    }
    historyEl.innerHTML = entries.slice().reverse().slice(0, 8).map(h => `
      <li class="border border-slate-100 rounded-lg px-3 py-2 bg-slate-50">
        <div class="flex flex-wrap items-center gap-2">
          <span class="text-xs text-slate-400">${h.date}</span>
          <span class="text-xs font-semibold text-slate-700">${h.item}</span>
          <span class="text-xs text-slate-500">${h.serial}</span>
        </div>
        <div class="text-xs text-slate-600 mt-1">
          Condition: ${h.condition} • Resolution: ${h.resolution || 'Unresolved'} • ${h.remarks || 'No remarks'}
        </div>
      </li>
    `).join('');
  }

  function renderEparPreview() {
    const last = JSON.parse(localStorage.getItem(EPAR_KEY) || 'null');
    const preview = document.getElementById('epPreview');
    if (!last) {
      preview.innerHTML = '<p class="text-slate-400 italic">No E-PAR generated yet.</p>';
      return;
    }
    preview.innerHTML = `
      <div class="border border-slate-200 rounded-lg p-4 bg-slate-50 space-y-1">
        <p class="text-xs text-slate-500">E-PAR #${last.ref}</p>
        <p class="font-semibold text-slate-800">${last.item}</p>
        <p class="text-xs text-slate-500">Serial: ${last.serial}</p>
        <p class="text-xs text-slate-500">Assigned to: ${last.teacher}</p>
        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
          Pending Acknowledgment
        </span>
      </div>
      <p class="text-xs text-slate-400">Generated on ${last.date}</p>
    `;
  }
  renderEparPreview();

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
    document.getElementById('mResolution').value      = a.resolution || 'Unresolved';
    document.getElementById('mRemarks').value         = a.remarks || '';
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
    document.getElementById('mResolution').value      = 'Unresolved';
    document.getElementById('mRemarks').value         = '';
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
    const resolution = document.getElementById('mResolution').value;
    const remarks   = document.getElementById('mRemarks').value.trim();
    const errEl     = document.getElementById('modalError');
    errEl.classList.add('hidden');

    if (!item || !serial) {
      errEl.textContent = 'Item name and serial number are required.';
      errEl.classList.remove('hidden');
      return;
    }

    const assets = getAssets();
    const today  = new Date().toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
    const historyEntry = { date: today, condition, remarks, resolution };

    if (editIdx !== null) {
      assets[editIdx].condition = condition;
      assets[editIdx].resolution = resolution;
      assets[editIdx].remarks = remarks;
      assets[editIdx].updated   = today;
      assets[editIdx].history = (assets[editIdx].history || []).concat(historyEntry);
    } else {
      assets.push({
        item,
        serial,
        assignedTo: '',
        ackStatus: 'Pending Acknowledgment',
        condition,
        resolution,
        remarks,
        updated: today,
        history: [historyEntry]
      });
    }
    saveAssets(assets);
    closeModal();
    renderAssets();
  };

  document.getElementById('modal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
  });

  document.getElementById('assignForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const item = document.getElementById('assignItem').value.trim();
    const serial = document.getElementById('assignSerial').value.trim();
    const teacher = document.getElementById('assignTeacher').value.trim();
    const msg = document.getElementById('assignMsg');
    if (!item || !serial || !teacher) {
      msg.textContent = 'Asset ID, Serial Number, and Teacher ID are required.';
      msg.className = 'text-sm text-rose-600';
      return;
    }
    const assets = getAssets();
    const today = new Date().toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
    assets.push({
      item,
      serial,
      assignedTo: teacher,
      ackStatus: 'Pending Acknowledgment',
      condition: 'Functional',
      resolution: 'Unresolved',
      remarks: '',
      updated: today,
      history: [{ date: today, condition: 'Functional', remarks: 'Assigned via E-PAR', resolution: 'Unresolved' }]
    });
    saveAssets(assets);
    const lastSeq = parseInt(localStorage.getItem(EPAR_SEQ_KEY) || '1000', 10);
    const ref = lastSeq + 1;
    localStorage.setItem(EPAR_SEQ_KEY, ref.toString());
    localStorage.setItem(EPAR_KEY, JSON.stringify({
      ref,
      item,
      serial,
      teacher,
      date: new Date().toLocaleString('en-PH')
    }));
    renderEparPreview();
    renderAssets();
    msg.textContent = `E-PAR #${ref} generated and sent for acknowledgment.`;
    msg.className = 'text-sm text-emerald-600';
    this.reset();
    setTimeout(() => { msg.textContent = ''; }, 3000);
  });

  renderAssets();
</script>
@endsection
