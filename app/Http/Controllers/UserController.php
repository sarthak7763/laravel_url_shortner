<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Get the current user's company
     */
    protected function getCompany()
    {
        $user = Auth::user();
        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }
        $company = $userDet->companies()->first();

        if (!$company) {
            abort(403, 'No company assigned to this user.');
        }

        return $company;
    }

    /**
     * Display users list for company
     */
    public function index()
    {
        $company = $this->getCompany();

        // Check if user can view company users
        if (!Gate::allows('view-company-users', $company)) {
            abort(403, 'You do not have permission to view users in this company.');
        }

        $users = $company->users()->paginate(10);

        return view('users.index', compact('company', 'users'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $company = $this->getCompany();

        // Check if user can manage company users
        if (!Gate::allows('manage-company-users', $company)) {
            abort(403, 'You do not have permission to add users to this company.');
        }

        $roles = ['admin', 'member'];

        return view('users.create', compact('company', 'roles'));
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        try {
            $company = $this->getCompany();

            // Check if user can manage company users
            if (!Gate::allows('manage-company-users', $company)) {
                abort(403, 'You do not have permission to add users to this company.');
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,member',
            ]);

            DB::beginTransaction();
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Attach user to company with role
            $company->users()->attach($user->id, ['role' => $validated['role']]);
            $user->assignRole(ucfirst($validated['role']));
            DB::commit();
            return redirect()
                ->route('users.index')
                ->with('success', 'User added to company successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while adding the user: ' . $e->getMessage());
        }
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        $company = $this->getCompany();

        // Check if user can view company users
        if (!Gate::allows('view-company-users', $company)) {
            abort(403, 'You do not have permission to view users in this company.');
        }

        // Check if user belongs to company
        if (!$company->users()->where('user_id', $user->id)->exists()) {
            abort(403, 'User does not belong to this company.');
        }

        $userRole = $company->users()
            ->where('user_id', $user->id)
            ->first()
            ->pivot
            ->role;

        return view('users.show', compact('company', 'user', 'userRole'));
    }

    /**
     * Show edit form
     */
    public function edit(User $user)
    {
        $company = $this->getCompany();

        // Check if user can manage company users
        if (!Gate::allows('manage-company-users', $company)) {
            abort(403, 'You do not have permission to edit users in this company.');
        }

        // Check if user belongs to company
        if (!$company->users()->where('user_id', $user->id)->exists()) {
            abort(403, 'User does not belong to this company.');
        }

        $userRole = $company->users()
            ->where('user_id', $user->id)
            ->first()
            ->pivot
            ->role;

        $roles = ['admin', 'member'];

        return view('users.edit', compact('company', 'user', 'userRole', 'roles'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $company = $this->getCompany();

        // Check if user can manage company users
        if (!Gate::allows('manage-company-users', $company)) {
            abort(403, 'You do not have permission to update users in this company.');
        }

        // Check if user belongs to company
        if (!$company->users()->where('user_id', $user->id)->exists()) {
            abort(403, 'User does not belong to this company.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,member',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($validated['password']) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        // Update role on pivot table
        $company->users()->updateExistingPivot($user->id, ['role' => $validated['role']]);

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user from company
     */
    public function destroy(User $user)
    {
        $company = $this->getCompany();

        // Check if user can manage company users
        if (!Gate::allows('manage-company-users', $company)) {
            abort(403, 'You do not have permission to delete users from this company.');
        }

        // Check if user belongs to company
        if (!$company->users()->where('user_id', $user->id)->exists()) {
            abort(403, 'User does not belong to this company.');
        }

        $company->users()->detach($user->id);

        return redirect()
            ->route('users.index')
            ->with('success', 'User removed from company successfully.');
    }
}
