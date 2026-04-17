@extends('layouts.app')

@section('title', 'TrackEd | Counselor Dashboard')
@section('page-title', 'Guidance Counselor Dashboard')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
      <h3 class="text-lg font-semibold text-slate-800">Pending Disciplinary Cases</h3>
      <p class="text-sm text-slate-500">Cases requiring restorative intervention records.</p>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="text-left px-6 py-3 font-semibold">LRN</th>
            <th class="text-left px-6 py-3 font-semibold">Learner</th>
            <th class="text-left px-6 py-3 font-semibold">Offense</th>
            <th class="text-left px-6 py-3 font-semibold">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr>
            <td class="px-6 py-4 font-medium">112233445566</td>
            <td class="px-6 py-4">Mark Angelo Pineda</td>
            <td class="px-6 py-4">Bullying (Major)</td>
            <td class="px-6 py-4"><span class="bg-rose-100 text-rose-700 text-xs px-2 py-1 rounded-full font-semibold">For Case Conference</span></td>
          </tr>
          <tr>
            <td class="px-6 py-4 font-medium">119988776655</td>
            <td class="px-6 py-4">Jenica Mae Torres</td>
            <td class="px-6 py-4">Class Disruption (Minor)</td>
            <td class="px-6 py-4"><span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded-full font-semibold">Needs Parent Call</span></td>
          </tr>
          <tr>
            <td class="px-6 py-4 font-medium">109944887722</td>
            <td class="px-6 py-4">Ralph Christian Ramos</td>
            <td class="px-6 py-4">Cheating (Major)</td>
            <td class="px-6 py-4"><span class="bg-rose-100 text-rose-700 text-xs px-2 py-1 rounded-full font-semibold">Restorative Session Pending</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">Good Moral Certificate Generator</h3>
    <p class="text-sm text-slate-500">Validate learner standing before PDF generation.</p>

    <label class="mt-5 block text-sm font-medium text-slate-700">Search Learner by LRN</label>
    <div class="mt-2 flex gap-2">
      <input type="text" value="112233445566" class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300" />
      <button class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800">Search</button>
    </div>

    <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
      <p class="text-sm font-semibold text-emerald-700">Cleared: Generate PDF</p>
      <p class="text-xs text-emerald-700/80 mt-1">Learner: Andrea Marie Velasco (LRN: 100200300400) has no unresolved major offense.</p>
      <button class="mt-3 bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-500">Generate Good Moral PDF</button>
    </div>

    <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 p-4">
      <p class="text-sm font-semibold text-rose-700">Blocked: Unresolved Major Offense</p>
      <p class="text-xs text-rose-700/80 mt-1">Learner: Mark Angelo Pineda (LRN: 112233445566) has a pending bullying case with no recorded restorative completion.</p>
    </div>
  </section>
</div>
@endsection
