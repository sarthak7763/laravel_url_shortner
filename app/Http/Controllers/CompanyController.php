<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\CompanyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CompanyController extends Controller
{
    /**
     * Display listing
     */
    public function index()
    {
        $user = Auth::user();

        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Only super admin can see all companies
        if (!$userDet->hasRole('SuperAdmin')) {
            abort(403, 'Only super admin can view all companies.');
        }

        $companies = Company::latest()->paginate(10);

        return view('companies.index', compact('companies'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $user = Auth::user();

        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Only super admin can create companies
        if (!$userDet->hasRole('SuperAdmin')) {
            abort(403, 'Only super admin can create companies.');
        }

        return view('companies.create');
    }

    /**
     * Store company
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Only super admin can create companies
        if (!$userDet->hasRole('SuperAdmin')) {
            abort(403, 'Only super admin can create companies.');
        }

        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'nullable|email',
                'phone' => 'nullable|max:20',
                'website' => 'nullable|url',
                'address' => 'nullable|max:255',
                'admin_name' => 'required|max:255',
                'admin_email' => 'required|email|unique:users,email',
                'admin_password' => 'required|min:8|confirmed',
            ]);

            DB::beginTransaction();
            // Create company
            $company = Company::create($request->only('name', 'email', 'phone', 'website', 'address'));
            $adminData = $request->only('admin_name', 'admin_email', 'admin_password');
            $adminData['password'] = Hash::make($adminData['admin_password']);
            $user = User::create([
                'name' => $adminData['admin_name'],
                'email' => $adminData['admin_email'],
                'password' => $adminData['password'],
            ]);
            // Attach admin to company with role
            $company->users()->attach($user->id, ['role' => 'admin']);

            // Assign global role
            $user->assignRole('Admin');

            DB::commit();

            return redirect()
                ->route('companies.index')
                ->with('success', 'Company created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('companies.index')
                ->with('error', 'Error creating company: ' . $e->getMessage());
        }
    }

    /**
     * View single company
     */
    public function show(Company $company)
    {
        $user = Auth::user();
        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Check if user can view this company
        if (!Gate::allows('view-company-users', $company) && !$userDet->hasRole('SuperAdmin')) {
            abort(403, 'You do not have permission to view this company.');
        }

        $company->load([
            'companyAdmins',
            'companyMembers',
        ]);
        return view('companies.show', compact('company'));
    }

    /**
     * Edit form
     */
    public function edit(Company $company)
    {
        $user = Auth::user();
        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Check if user can manage this company
        if (!Gate::allows('manage-company', $company)) {
            abort(403, 'You do not have permission to edit this company.');
        }

        return view('companies.edit', compact('company'));
    }

    /**
     * Update company
     */
    public function update(Request $request, Company $company)
    {
        $user = Auth::user();
        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Check if user can manage this company
        if (!Gate::allows('manage-company', $company)) {
            abort(403, 'You do not have permission to update this company.');
        }

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|max:20',
            'website' => 'nullable|url',
        ]);

        $company->update($request->all());

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Delete company
     */
    public function destroy(Company $company)
    {
        $user = Auth::user();
        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Only super admin can delete companies
        if (!$userDet->hasRole('SuperAdmin')) {
            abort(403, 'Only super admin can delete companies.');
        }

        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}
