@extends('layouts.app')

@section('title', 'TrackEd | Teacher Dashboard')
@section('page-title', 'Teacher Dashboard')

@section('content')
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
  <h3 class="text-lg font-semibold text-slate-800">System-Based DLL Builder</h3>
  <p class="text-sm text-slate-500">Prepare a Daily Lesson Log for School Head review.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
    <div>
      <label class="block text-sm font-medium text-slate-700">Subject</label>
      <select class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
        <option>Science 9</option>
        <option>English 10</option>
        <option>Mathematics 8</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700">Date</label>
      <input type="date" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" value="2026-06-24" />
    </div>
  </div>

  <div class="mt-4">
    <label class="block text-sm font-medium text-slate-700">Objectives</label>
    <textarea rows="3" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">At the end of the lesson, learners should explain the law of conservation of mass through guided experimentation.</textarea>
  </div>
  <div class="mt-4">
    <label class="block text-sm font-medium text-slate-700">Procedures</label>
    <textarea rows="4" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">1. Review previous topic on chemical reactions. 2. Group activity using vinegar and baking soda setup. 3. Process observations and connect to MELC competency.</textarea>
  </div>

  <button class="mt-5 bg-blue-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-800">
    <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>Run AI Pre-Check
  </button>
</section>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">Student Incident Report Form</h3>
    <div class="mt-4 space-y-4">
      <div>
        <label class="block text-sm font-medium text-slate-700">LRN</label>
        <input type="text" value="112233445566" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" />
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700">Offense</label>
        <select class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
          <option>Bullying - Major</option>
          <option>Class Disruption - Minor</option>
          <option>Tardiness - Minor</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700">Narrative</label>
        <textarea rows="4" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">Learner repeatedly teased a classmate during group activity, resulting in emotional distress. Incident was witnessed by section adviser and documented for guidance intervention.</textarea>
      </div>
      <button class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800">Submit Incident Report</button>
    </div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
      <h3 class="text-lg font-semibold text-slate-800">My Accountability (E-PAR)</h3>
      <p class="text-sm text-slate-500">Assigned equipment requiring digital acknowledgment.</p>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="text-left px-6 py-3 font-semibold">Asset</th>
            <th class="text-left px-6 py-3 font-semibold">Serial No.</th>
            <th class="text-left px-6 py-3 font-semibold">Date Assigned</th>
            <th class="text-left px-6 py-3 font-semibold">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr>
            <td class="px-6 py-4 font-medium">Lenovo ThinkPad Laptop</td>
            <td class="px-6 py-4">PF39A2Q1</td>
            <td class="px-6 py-4">June 03, 2026</td>
            <td class="px-6 py-4"><button class="bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-emerald-500">Acknowledge</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</div>
@endsection
