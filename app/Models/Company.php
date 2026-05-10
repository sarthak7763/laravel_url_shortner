<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'address',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_users')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function companyUsers()
    {
        return $this->hasMany(CompanyUser::class);
    }

    public function companyAdmins()
    {
        return $this->users()
            ->wherePivot('role', 'admin');
    }

    public function companyMembers()
    {
        return $this->users()
            ->wherePivot('role', 'member');
    }

    /**
     * Get short URLs for this company
     */
    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }
}
