@extends('layouts.app')

@section('title', 'TrackEd | Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <section class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <div>
        <h3 class="text-lg font-semibold text-slate-800">PBAC User Management Configuration</h3>
        <p class="text-sm text-slate-500">Assign module-level permissions for multi-designated personnel.</p>
      </div>
      <button class="bg-blue-900 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-800">Add Personnel</button>
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
            <td class="px-6 py-4"><button class="text-blue-900 font-semibold hover:underline">Edit Permissions</button></td>
          </tr>
          <tr>
            <td class="px-6 py-4 font-medium">Ma. Elena Reyes</td>
            <td class="px-6 py-4">Guidance Designate</td>
            <td class="px-6 py-4">Process Discipline, Generate Good Moral</td>
            <td class="px-6 py-4"><button class="text-blue-900 font-semibold hover:underline">Edit Permissions</button></td>
          </tr>
          <tr>
            <td class="px-6 py-4 font-medium">Ramon Villanueva</td>
            <td class="px-6 py-4">School Head</td>
            <td class="px-6 py-4">Grade Teachers, Approve DLL, Audit Clearance</td>
            <td class="px-6 py-4"><button class="text-blue-900 font-semibold hover:underline">Edit Permissions</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">LIS CSV Upload</h3>
    <p class="text-sm text-slate-500 mt-1">Import official Learner Information System records.</p>
    <div class="mt-5 border-2 border-dashed border-blue-300 rounded-2xl bg-blue-50/60 p-8 text-center">
      <i class="fa-solid fa-file-arrow-up text-3xl text-blue-900"></i>
      <p class="mt-3 font-semibold text-slate-700">Drag and drop LIS CSV file</p>
      <p class="text-xs text-slate-500 mt-1">Accepted format: .csv | Max file size: 10MB</p>
      <button class="mt-4 bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800">Browse File</button>
    </div>
    <div class="mt-4 text-xs text-slate-500">Last upload: April 12, 2026 - Grade 7 to Grade 10 learners</div>
  </section>
</div>

<section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
    <div>
      <h3 class="text-lg font-semibold text-slate-800">Asset Master Ledger</h3>
      <p class="text-sm text-slate-500">Government property monitored for E-PAR accountability.</p>
    </div>
    <button class="bg-emerald-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-500">Add Asset</button>
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
          <td class="px-6 py-4"><span class="bg-emerald-100 text-emerald-700 text-xs font-semibold px-2 py-1 rounded-full">Working</span></td>
          <td class="px-6 py-4">Unassigned</td>
          <td class="px-6 py-4"><button class="bg-blue-900 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-800">Assign (E-PAR)</button></td>
        </tr>
        <tr>
          <td class="px-6 py-4 font-medium">Smart TV 55"</td>
          <td class="px-6 py-4">DEPED-TV-2025-006 / SN-55A9K22</td>
          <td class="px-6 py-4"><span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2 py-1 rounded-full">For Repair</span></td>
          <td class="px-6 py-4">Gr. 9 - Mahogany</td>
          <td class="px-6 py-4"><button class="bg-blue-900 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-800">Assign (E-PAR)</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
@endsection
