<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class ShortUrlController extends Controller
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
     * Display list of short URLs
     */
    public function index()
    {
        $user = Auth::user();
        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // SuperAdmin can see all short URLs from all companies
        if ($userDet->hasRole('SuperAdmin')) {
            $shortUrls = ShortUrl::latest()->paginate(15);
            $company = null; // No specific company for super admin
        } else {
            $company = $this->getCompany();

            // Company Admin can see all short URLs from their company
            if ($userDet->hasRole('Admin') && $userDet->hasCompanyRole($company, 'admin')) {
                $shortUrls = ShortUrl::where('company_id', $company->id)
                    ->latest()
                    ->paginate(15);
            }
            // Company Member can see only their own short URLs
            elseif ($userDet->hasRole('Member')) {
                $shortUrls = ShortUrl::where('company_id', $company->id)
                    ->where('user_id', $userDet->id)
                    ->latest()
                    ->paginate(15);
            } else {
                abort(403, 'You do not have permission to view short URLs.');
            }
        }


        return view('short-urls.index', compact('company', 'shortUrls', 'user'));
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

        // SuperAdmin cannot create short URLs
        if ($userDet->hasRole('SuperAdmin')) {
            abort(403, 'SuperAdmin cannot create short URLs.');
        } else {
            $company = $this->getCompany();



            // Admin and Member can create
            if (!($userDet->hasRole('Admin') || $userDet->hasRole('Member'))) {
                abort(403, 'You do not have permission to create short URLs.');
            }
        }

        return view('short-urls.create', compact('company'));
    }

    /**
     * Store short URL
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $company = $this->getCompany();

        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // SuperAdmin cannot create short URLs
        if ($userDet->hasRole('SuperAdmin')) {
            abort(403, 'SuperAdmin cannot create short URLs.');
        }

        // Only Admin and Member can create
        if (!($userDet->hasRole('Admin') || $userDet->hasRole('Member'))) {
            abort(403, 'You do not have permission to create short URLs.');
        }

        $validated = $request->validate([
            'original_url' => 'required|url|max:2048',
            'description' => 'nullable|string|max:500',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $shortUrl = ShortUrl::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'original_url' => $validated['original_url'],
            'short_code' => ShortUrl::generateShortCode(),
            'description' => $validated['description'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        return redirect()
            ->route('short-urls.show', $shortUrl)
            ->with('success', 'Short URL created successfully.');
    }

    /**
     * Show short URL details
     */
    public function show(ShortUrl $shortUrl)
    {
        $user = Auth::user();

        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // SuperAdmin cannot create short URLs
        if ($userDet->hasRole('SuperAdmin')) {
            $company = null; // No specific company for super admin
        } else {
            $company = $this->getCompany();

            // Check authorization
            if (!$this->canViewShortUrl($userDet, $shortUrl, $company)) {
                abort(403, 'You do not have permission to view this short URL.');
            }
        }

        return view('short-urls.show', compact('company', 'shortUrl', 'user'));
    }

    /**
     * Show edit form
     */
    public function edit(ShortUrl $shortUrl)
    {
        $user = Auth::user();
        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // SuperAdmin cannot create short URLs
        if ($userDet->hasRole('SuperAdmin')) {
            abort(403, 'SuperAdmin cannot create short URLs.');
        } else {
            $company = $this->getCompany();

            // Check authorization
            if (!$this->canEditShortUrl($userDet, $shortUrl, $company)) {
                abort(403, 'You do not have permission to edit this short URL.');
            }
        }

        return view('short-urls.edit', compact('company', 'shortUrl'));
    }

    /**
     * Update short URL
     */
    public function update(Request $request, ShortUrl $shortUrl)
    {
        $user = Auth::user();
        $company = $this->getCompany();

        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Check authorization
        if (!$this->canEditShortUrl($userDet, $shortUrl, $company)) {
            abort(403, 'You do not have permission to edit this short URL.');
        }

        $validated = $request->validate([
            'original_url' => 'required|url|max:2048',
            'description' => 'nullable|string|max:500',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $shortUrl->update([
            'original_url' => $validated['original_url'],
            'description' => $validated['description'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        return redirect()
            ->route('short-urls.show', $shortUrl)
            ->with('success', 'Short URL updated successfully.');
    }

    /**
     * Delete short URL
     */
    public function destroy(ShortUrl $shortUrl)
    {
        $user = Auth::user();
        $company = $this->getCompany();

        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }

        // Check authorization
        if (!$this->canDeleteShortUrl($userDet, $shortUrl, $company)) {
            abort(403, 'You do not have permission to delete this short URL.');
        }

        $shortUrl->delete();

        return redirect()
            ->route('short-urls.index')
            ->with('success', 'Short URL deleted successfully.');
    }

    /**
     * Check if user can view short URL
     */
    protected function canViewShortUrl(User $user, ShortUrl $shortUrl, Company $company): bool
    {
        // SuperAdmin can view any short URL
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }

        // Company Admin can view all URLs from their company
        if ($user->hasRole('Admin') && $user->hasCompanyRole($company, 'admin')) {
            return $shortUrl->company_id === $company->id;
        }

        // Company Member can only view their own URLs
        if ($user->hasRole('Member')) {
            return $shortUrl->company_id === $company->id && $shortUrl->user_id === $user->id;
        }

        return false;
    }

    /**
     * Check if user can edit short URL
     */
    protected function canEditShortUrl(User $user, ShortUrl $shortUrl, Company $company): bool
    {
        // SuperAdmin cannot edit (cannot create, so no editing)
        if ($user->hasRole('SuperAdmin')) {
            return false;
        }

        // Company Admin can edit all URLs from their company
        if ($user->hasRole('Admin') && $user->hasCompanyRole($company, 'admin')) {
            return $shortUrl->company_id === $company->id;
        }

        // Company Member can only edit their own URLs
        if ($user->hasRole('Member')) {
            return $shortUrl->company_id === $company->id && $shortUrl->user_id === $user->id;
        }

        return false;
    }

    /**
     * Check if user can delete short URL
     */
    protected function canDeleteShortUrl(User $user, ShortUrl $shortUrl, Company $company): bool
    {
        // Same as edit permissions
        return $this->canEditShortUrl($user, $shortUrl, $company);
    }
}
