<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /** List all users (admin only). */
    public function index(): View
    {
        $users = User::with('school')->orderBy('role')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    /** Show the create-user form (admin only). */
    public function create(): View
    {
        $schools = School::orderBy('name')->get();

        return view('admin.users.create', compact('schools'));
    }

    /** Persist a new user account (admin only). */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users'],
            'password'  => ['required', Password::min(8)->mixedCase()->numbers()],
            'role'      => ['required', 'in:Admin,School Head,Counselor,Teacher'],
            'school_id' => ['nullable', 'exists:schools,id'],
        ]);

        User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => $data['role'],
            'school_id' => $data['school_id'] ?? null,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Account for ' . $data['name'] . ' has been created.');
    }

    /** Show the transfer form for a user (admin only). */
    public function showTransfer(User $user): View
    {
        $schools = School::where('id', '!=', $user->school_id)
            ->orderBy('name')
            ->get();

        return view('admin.users.transfer', compact('user', 'schools'));
    }

    /**
     * Transfer a user to a different school (admin only).
     *
     * Requires the user to have no non-functional assets (clearance).
     * TODO: enforce clearance server-side once assets are persisted in the database
     * (currently tracked in the browser via localStorage).
     */
    public function transfer(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
        ]);

        if ((int) $request->school_id === (int) $user->school_id) {
            return back()->withErrors(['school_id' => 'The user is already assigned to this school.']);
        }

        $user->update([
            'transferred_from' => $user->school_id,
            'transferred_at'   => now(),
            'school_id'        => $request->school_id,
        ]);

        return redirect()->route('users.index')
            ->with('success', $user->name . ' has been transferred successfully.');
    }
}
