<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $userDet = User::find($user->id);
        if (is_null($userDet)) {
            abort(403, 'User not found.');
        }
        $companiesCount = Company::count();

        $shortUrlsCount = 0;
        $shortUrlClicks = 0;
        $adminsCount = 0;
        $membersCount = 0;
        $scopeLabel = __('All Companies');

        if ($userDet->hasRole('SuperAdmin')) {
            $shortUrlsCount = ShortUrl::count();
            $shortUrlClicks = ShortUrl::sum('clicks');
            $companyAdminRole = Role::where('name', 'company_admin')->first();
            $companyMemberRole = Role::where('name', 'company_member')->first();
            $adminsCount = $companyAdminRole ? $companyAdminRole->users()->count() : 0;
            $membersCount = $companyMemberRole ? $companyMemberRole->users()->count() : 0;
        } else {
            $company = $userDet->companies()->first();

            if ($company) {
                $scopeLabel = __('Your Company');

                $adminsCount = $company->users()->wherePivot('role', 'admin')->count();
                $membersCount = $company->users()->wherePivot('role', 'member')->count();

                if ($userDet->hasRole('Admin')) {
                    $shortUrlsCount = ShortUrl::where('company_id', $company->id)->count();
                    $shortUrlClicks = ShortUrl::where('company_id', $company->id)->sum('clicks');
                } else {
                    $shortUrlsCount = ShortUrl::where('company_id', $company->id)
                        ->where('user_id', $userDet->id)
                        ->count();
                    $shortUrlClicks = ShortUrl::where('company_id', $company->id)
                        ->where('user_id', $userDet->id)
                        ->sum('clicks');
                }
            }
        }

        return view('dashboard', compact(
            'companiesCount',
            'shortUrlsCount',
            'shortUrlClicks',
            'adminsCount',
            'membersCount',
            'scopeLabel'
        ));
    }
}
