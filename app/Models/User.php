<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get companies this user belongs to
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_users')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get short URLs created by this user
     */
    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }

    /**
     * Check if user has a specific role in a company
     */
    public function hasCompanyRole(Company $company, string $role): bool
    {
        return $this->companies()
            ->where('company_id', $company->id)
            ->wherePivot('role', $role)
            ->exists();
    }

    /**
     * Get user's role in a specific company
     */
    public function getCompanyRole(Company $company): ?string
    {
        $pivot = $this->companies()
            ->where('company_id', $company->id)
            ->first();

        return $pivot?->pivot->role;
    }

    /**
     * Check if user can manage a company (global OR company admin)
     */
    public function canManageCompany(Company $company): bool
    {
        // Super admin can manage any company
        if ($this->hasRole('SuperAdmin')) {
            return true;
        }

        // Company admin can manage their company
        if ($this->hasRole('Admin') && $this->hasCompanyRole($company, 'admin')) {
            return true;
        }

        return false;
    }

    /**
     * Check if user can edit a short URL
     */
    public function canEditShortUrl(ShortUrl $shortUrl, ?Company $company = null): bool
    {
        // SuperAdmin cannot edit (they cannot create either)
        if ($this->hasRole('SuperAdmin')) {
            return false;
        }

        // If company is not provided, get it from user's companies
        if (!$company) {
            $company = $this->companies()->first();
        }

        if (!$company) {
            return false;
        }

        // Company Admin can edit all URLs from their company
        if ($this->hasRole('Admin') && $this->hasCompanyRole($company, 'admin')) {
            return $shortUrl->company_id === $company->id;
        }

        // Company Member can only edit their own URLs
        if ($this->hasRole('Member')) {
            return $shortUrl->company_id === $company->id && $shortUrl->user_id === $this->id;
        }

        return false;
    }

    /**
     * Check if user can delete a short URL
     */
    public function canDeleteShortUrl(ShortUrl $shortUrl, ?Company $company = null): bool
    {
        // SuperAdmin cannot delete (they cannot create either)
        if ($this->hasRole('SuperAdmin')) {
            return false;
        }

        // If company is not provided, get it from user's companies
        if (!$company) {
            $company = $this->companies()->first();
        }

        if (!$company) {
            return false;
        }

        // Company Admin can delete all URLs from their company
        if ($this->hasRole('Admin') && $this->hasCompanyRole($company, 'admin')) {
            return $shortUrl->company_id === $company->id;
        }

        // Company Member can only delete their own URLs
        if ($this->hasRole('Member')) {
            return $shortUrl->company_id === $company->id && $shortUrl->user_id === $this->id;
        }

        return false;
    }
}
