@extends('layouts.app')

@section('title', 'TrackEd | Admin Dashboard')

@section('page-title', 'Admin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Personnel Records</p>
            <p class="text-3xl font-bold text-blue-900 mt-2">128</p>
            <p class="text-xs text-slate-400 mt-1">Active staff profiles under supervision.</p>
        </article>
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">LIS Sync Queue</p>
            <p class="text-3xl font-bold text-amber-600 mt-2">4</p>
            <p class="text-xs text-slate-400 mt-1">Pending updates awaiting validation.</p>
        </article>
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Inventory Oversight</p>
            <p class="text-3xl font-bold text-emerald-600 mt-2">96%</p>
            <p class="text-xs text-slate-400 mt-1">Assets cleared for year-end audit.</p>
        </article>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-700 mb-3">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('users.index') }}"
                class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                <i class="fa-solid fa-users-gear mr-2"></i>Manage Personnel
            </a>
            <a href="{{ route('users.lis-sync') }}"
                class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                <i class="fa-solid fa-cloud-arrow-up mr-2"></i>LIS Sync
            </a>
            <a href="{{ route('property-inventory') }}"
                class="bg-emerald-700 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                <i class="fa-solid fa-box-archive mr-2"></i>Inventory Oversight
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-700 mb-3">Role Access Snapshot</h3>
        @php($roles = ['Admin', 'School Head', 'Counselor', 'Teacher'])
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm text-slate-600">
            @foreach ($roles as $role)
                <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                    <p class="font-semibold text-slate-700 mb-2">{{ $role }}</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach (\App\Models\User::permissionsForRole($role) as $perm)
                            <li>{{ $perm }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endsection
