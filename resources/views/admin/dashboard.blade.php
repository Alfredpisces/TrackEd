@extends('layouts.app')

@section('title', 'TrackEd | Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

{{-- ── KPI Summary Cards ── --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">Personnel Records</p>
    <p class="text-3xl font-bold text-blue-900 mt-2">128</p>
    <p class="text-xs text-slate-400 mt-1">Active staff profiles under supervision.</p>
  </article>
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">LIS Sync Queue</p>
    <p class="text-3xl font-bold text-amber-600 mt-2">4</p>
    <p class="text-xs text-slate-400 mt-1">Pending updates awaiting validation.</p>
  </article>
  <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-sm text-slate-500">Inventory Oversight</p>
    <p class="text-3xl font-bold text-emerald-600 mt-2">96%</p>
    <p class="text-xs text-slate-400 mt-1">Assets cleared for year-end audit.</p>
  </article>
</div>

{{-- ── PBAC User Management + LIS Upload (side by side) ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  <section class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <div>
        <h3 class="text-lg font-semibold text-slate-800">PBAC User Management Configuration</h3>
        <p class="text-sm text-slate-500">Assign module-level permissions for multi-designated personnel.</p>
      </div>
      <a href="{{ route('users.create') }}"
         class="bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-4 py-2 rounded-lg">
        Add Personnel
      </a>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="text-left px-6 py-3 font-semibold">Personnel</th>
            <th class="text-left px-6 py-3 font-semibold">Designation</th>
            <th class="text-left px-6 py-3 font-semibold">Granted Permissions</th>
            <th class="text-left px-6 py-3 font-semibold">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr>
            <td class="px-6 py-4 font-medium">Juan Dela Cruz</td>
            <td class="px-6 py-4">Teacher III / Property Custodian</td>
            <td class="px-6 py-4">Submit DLL, Manage Inventory</td>
            <td class="px-6 py-4">
              <a href="{{ route('users.index') }}" class="text-blue-900 font-semibold hover:underline text-sm">Edit Permissions</a>
            </td>
          </tr>
          <tr>
            <td class="px-6 py-4 font-medium">Ma. Elena Reyes</td>
            <td class="px-6 py-4">Guidance Designate</td>
            <td class="px-6 py-4">Process Discipline, Generate Good Moral</td>
            <td class="px-6 py-4">
              <a href="{{ route('users.index') }}" class="text-blue-900 font-semibold hover:underline text-sm">Edit Permissions</a>
            </td>
          </tr>
          <tr>
            <td class="px-6 py-4 font-medium">Ramon Villanueva</td>
            <td class="px-6 py-4">School Head</td>
            <td class="px-6 py-4">Grade Teachers, Approve DLL, Audit Clearance</td>
            <td class="px-6 py-4">
              <a href="{{ route('users.index') }}" class="text-blue-900 font-semibold hover:underline text-sm">Edit Permissions</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="px-6 py-3 border-t border-slate-100">
      <a href="{{ route('users.index') }}" class="text-sm text-blue-800 font-semibold hover:underline">View All Personnel →</a>
    </div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">LIS CSV Upload</h3>
    <p class="text-sm text-slate-500 mt-1">Import official Learner Information System records.</p>
    <a href="{{ route('users.lis-sync') }}"
       class="block mt-5 border-2 border-dashed border-blue-300 rounded-2xl bg-blue-50/60 p-8 text-center hover:bg-blue-50 transition">
      <i class="fa-solid fa-file-arrow-up text-3xl text-blue-900"></i>
      <p class="mt-3 font-semibold text-slate-700">Drag and drop LIS CSV file</p>
      <p class="text-xs text-slate-500 mt-1">Accepted format: .csv &nbsp;|&nbsp; Max file size: 10 MB</p>
      <span class="mt-4 inline-block bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">Browse File</span>
    </a>
    <p class="mt-4 text-xs text-slate-400">Last upload: April 12, 2026 — Grade 7 to Grade 10 learners</p>
  </section>

</div>

{{-- ── Asset Master Ledger ── --}}
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
    <div>
      <h3 class="text-lg font-semibold text-slate-800">Asset Master Ledger</h3>
      <p class="text-sm text-slate-500">Government property monitored for E-PAR accountability.</p>
    </div>
    <a href="{{ route('property-inventory') }}"
       class="bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold px-4 py-2 rounded-lg">
      View Full Inventory
    </a>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="text-left px-6 py-3 font-semibold">Asset Type</th>
          <th class="text-left px-6 py-3 font-semibold">Asset Tag / Serial No.</th>
          <th class="text-left px-6 py-3 font-semibold">Condition</th>
          <th class="text-left px-6 py-3 font-semibold">Assigned To</th>
          <th class="text-left px-6 py-3 font-semibold">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        <tr>
          <td class="px-6 py-4 font-medium">Lenovo ThinkPad Laptop</td>
          <td class="px-6 py-4">DEPED-LPT-2026-014 / PF39A2Q1</td>
          <td class="px-6 py-4">
            <span class="bg-emerald-100 text-emerald-700 text-xs font-semibold px-2 py-1 rounded-full">Working</span>
          </td>
          <td class="px-6 py-4 text-slate-400 italic">Unassigned</td>
          <td class="px-6 py-4">
            <button class="bg-blue-900 hover:bg-blue-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
              Assign (E-PAR)
            </button>
          </td>
        </tr>
        <tr>
          <td class="px-6 py-4 font-medium">Smart TV 55"</td>
          <td class="px-6 py-4">DEPED-TV-2025-006 / SN-55A9K22</td>
          <td class="px-6 py-4">
            <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2 py-1 rounded-full">For Repair</span>
          </td>
          <td class="px-6 py-4">Gr. 9 – Mahogany</td>
          <td class="px-6 py-4">
            <button class="bg-blue-900 hover:bg-blue-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
              Assign (E-PAR)
            </button>
          </td>
        </tr>
        <tr>
          <td class="px-6 py-4 font-medium">LCD Projector</td>
          <td class="px-6 py-4">DEPED-PRJ-2024-002 / EP-X4500</td>
          <td class="px-6 py-4">
            <span class="bg-emerald-100 text-emerald-700 text-xs font-semibold px-2 py-1 rounded-full">Working</span>
          </td>
          <td class="px-6 py-4">Juan Dela Cruz</td>
          <td class="px-6 py-4">
            <button class="bg-slate-200 text-slate-500 px-3 py-1.5 rounded-lg text-xs font-semibold cursor-not-allowed">
              Assigned
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

{{-- ── PBAC Role Access Snapshot (for Admin reference) ── --}}
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
  <h3 class="text-lg font-semibold text-slate-800 mb-1">PBAC Permission Reference</h3>
  <p class="text-sm text-slate-500 mb-4">Default permission bundles by common designation in this school.</p>
  @php($roles = ['Admin', 'School Head', 'Counselor', 'Teacher'])
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm text-slate-600">
    @foreach($roles as $r)
      <div class="border border-slate-100 rounded-xl p-4 bg-slate-50">
        <p class="font-semibold text-slate-700 mb-2">{{ $r }}</p>
        <ul class="list-disc list-inside space-y-1">
          @foreach(\App\Models\User::permissionsForRole($r) as $perm)
            <li>{{ $perm }}</li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
</section>

@endsection
