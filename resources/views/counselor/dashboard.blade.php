@extends('layouts.app')

@section('title', 'TrackEd | Counselor Dashboard')

@section('page-title', 'Counselor Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Unresolved Incidents</p>
            <p class="text-3xl font-bold text-rose-600 mt-2" id="counselorUnresolved">0</p>
            <p class="text-xs text-slate-400 mt-1">Cases requiring follow-up.</p>
        </article>
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Resolved Cases</p>
            <p class="text-3xl font-bold text-emerald-600 mt-2" id="counselorResolved">0</p>
            <p class="text-xs text-slate-400 mt-1">Closed incidents this cycle.</p>
        </article>
        <article class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Good Moral Requests</p>
            <p class="text-3xl font-bold text-blue-900 mt-2" id="counselorRequests">0</p>
            <p class="text-xs text-slate-400 mt-1">Learners evaluated for clearance.</p>
        </article>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-700 mb-4">Recent Incident Reports</h3>
        <ul id="counselorIncidentFeed" class="space-y-2 text-sm text-slate-600">
            <li class="text-slate-400 italic">No incidents logged yet.</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-700 mb-4">Guidance Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('student-behavior') }}"
                class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                <i class="fa-solid fa-user-shield mr-2"></i>Open Student Behavior
            </a>
            <button class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold"
                onclick="alert('Case conference scheduled.')">
                <i class="fa-solid fa-calendar-check mr-2"></i>Schedule Case Conference
            </button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const incidents = JSON.parse(localStorage.getItem('tracked_incidents') || '[]');
        const unresolved = incidents.filter(i => !i.resolved).length;
        const resolved = incidents.filter(i => i.resolved).length;

        document.getElementById('counselorUnresolved').textContent = unresolved;
        document.getElementById('counselorResolved').textContent = resolved;
        document.getElementById('counselorRequests').textContent = incidents.length;

        const feed = document.getElementById('counselorIncidentFeed');
        if (incidents.length > 0) {
            feed.innerHTML = '';
            incidents.slice(-5).reverse().forEach(inc => {
                const li = document.createElement('li');
                li.className = 'flex items-start gap-2';
                li.innerHTML =
                    `<span class="mt-0.5 w-2 h-2 rounded-full flex-shrink-0 ${inc.type === 'Major' ? 'bg-rose-500' : 'bg-amber-400'}"></span>
        <span><strong>${inc.lrn}</strong> — ${inc.type} offense &nbsp;<span class="text-slate-400 text-xs">${inc.date || ''}</span></span>`;
                feed.appendChild(li);
            });
        }
    </script>
    =======

    {{-- ── KPI Summary Cards ── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Unresolved Incidents</p>
            <p class="text-3xl font-bold text-rose-600 mt-2" id="counselorUnresolved">3</p>
            <p class="text-xs text-slate-400 mt-1">Cases requiring follow-up.</p>
        </article>
        <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Resolved Cases</p>
            <p class="text-3xl font-bold text-emerald-600 mt-2" id="counselorResolved">12</p>
            <p class="text-xs text-slate-400 mt-1">Closed incidents this cycle.</p>
        </article>
        <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Good Moral Requests</p>
            <p class="text-3xl font-bold text-blue-900 mt-2" id="counselorRequests">5</p>
            <p class="text-xs text-slate-400 mt-1">Learners evaluated for clearance.</p>
        </article>
    </div>

    {{-- ── Split: Pending Cases + Good Moral Generator ── --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Pending Disciplinary Cases --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Pending Disciplinary Cases</h3>
                    <p class="text-sm text-slate-500">Cases requiring restorative intervention records.</p>
                </div>
                <a href="{{ route('student-behavior') }}"
                    class="bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                    Open Module
                </a>
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
                    <tbody id="counselorCaseFeed" class="divide-y divide-slate-100">
                        {{-- Seeded mock rows --}}
                        <tr>
                            <td class="px-6 py-4 font-medium">112233445566</td>
                            <td class="px-6 py-4">Mark Angelo Pineda</td>
                            <td class="px-6 py-4">Bullying (Major)</td>
                            <td class="px-6 py-4">
                                <span class="bg-rose-100 text-rose-700 text-xs font-semibold px-2 py-1 rounded-full">For
                                    Case Conference</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-medium">119988776655</td>
                            <td class="px-6 py-4">Jenica Mae Torres</td>
                            <td class="px-6 py-4">Class Disruption (Minor)</td>
                            <td class="px-6 py-4">
                                <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2 py-1 rounded-full">Needs
                                    Parent Call</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-medium">109944887722</td>
                            <td class="px-6 py-4">Ralph Christian Ramos</td>
                            <td class="px-6 py-4">Cheating (Major)</td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-rose-100 text-rose-700 text-xs font-semibold px-2 py-1 rounded-full">Restorative
                                    Session Pending</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Good Moral Certificate Generator --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-slate-800">Good Moral Certificate Generator</h3>
            <p class="text-sm text-slate-500 mt-1">Validate learner standing before PDF generation.</p>

            <label class="mt-5 block text-sm font-medium text-slate-700">Search Learner by LRN</label>
            <div class="mt-2 flex gap-2">
                <input type="text" id="lrnInput" value="112233445566"
                    class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none"
                    placeholder="12-digit LRN" />
                <button onclick="checkLRN()"
                    class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Search
                </button>
            </div>

            {{-- Cleared result --}}
            <div id="resultCleared" class="hidden mt-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <p class="text-sm font-semibold text-emerald-700"><i class="fa-solid fa-circle-check mr-1"></i> Cleared:
                    Generate PDF</p>
                <p class="text-xs text-emerald-700/80 mt-1" id="clearedMsg">Learner has no unresolved major offense.</p>
                <button
                    class="mt-3 bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Generate Good Moral PDF
                </button>
            </div>

            {{-- Blocked result --}}
            <div id="resultBlocked" class="hidden mt-5 rounded-xl border border-rose-200 bg-rose-50 p-4">
                <p class="text-sm font-semibold text-rose-700"><i class="fa-solid fa-circle-xmark mr-1"></i> Blocked:
                    Unresolved Major Offense</p>
                <p class="text-xs text-rose-700/80 mt-1" id="blockedMsg">Learner has a pending case with no recorded
                    restorative completion.</p>
            </div>

            {{-- Default (pre-search) state --}}
            <div id="resultDefault"
                class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-400 italic">
                Enter an LRN and click Search to check clearance status.
            </div>
        </section>

    </div>

    {{-- ── Guidance Actions ── --}}
    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Guidance Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('student-behavior') }}"
                class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                <i class="fa-solid fa-user-shield mr-2"></i>Open Student Behavior Module
            </a>
            <button class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold"
                onclick="alert('Case conference calendar is coming soon.')">
                <i class="fa-solid fa-calendar-check mr-2"></i>Schedule Case Conference
            </button>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        // Sync KPI counters from localStorage (real incidents logged by teachers)
        const incidents = JSON.parse(localStorage.getItem('tracked_incidents') || '[]');
        if (incidents.length > 0) {
            document.getElementById('counselorUnresolved').textContent = incidents.filter(i => !i.resolved).length;
            document.getElementById('counselorResolved').textContent = incidents.filter(i => i.resolved).length;
            document.getElementById('counselorRequests').textContent = incidents.length;
        }

        // Blocked LRNs mock list (learners with major unresolved offense)
        const blockedLRNs = {
            '112233445566': {
                name: 'Mark Angelo Pineda',
                offense: 'Bullying'
            },
            '109944887722': {
                name: 'Ralph Christian Ramos',
                offense: 'Cheating'
            },
        };

        function checkLRN() {
            const lrn = document.getElementById('lrnInput').value.trim();
            document.getElementById('resultCleared').classList.add('hidden');
            document.getElementById('resultBlocked').classList.add('hidden');
            document.getElementById('resultDefault').classList.add('hidden');

            if (!lrn) {
                document.getElementById('resultDefault').classList.remove('hidden');
                return;
            }

            if (blockedLRNs[lrn]) {
                const b = blockedLRNs[lrn];
                document.getElementById('blockedMsg').textContent =
                    `Learner: ${b.name} (LRN: ${lrn}) has a pending ${b.offense} case with no recorded restorative completion.`;
                document.getElementById('resultBlocked').classList.remove('hidden');
            } else {
                document.getElementById('clearedMsg').textContent =
                    `Learner (LRN: ${lrn}) has no unresolved major offense on record.`;
                document.getElementById('resultCleared').classList.remove('hidden');
            }
        }
    </script>

@endsection
