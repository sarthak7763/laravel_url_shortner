<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'original_url',
        'short_code',
        'description',
    ];

    /**
     * Get the company that owns the short URL
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the user who created the short URL
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique short code
     */
    public static function generateShortCode()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        do {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while (self::where('short_code', $code)->exists());

        return $code;
    }

    /**
     * Get the full short URL
     */
    public function getShortUrlAttribute()
    {
        return route('short-url.resolve', $this->short_code);
    }

    /**
     * Increment click count
     */
    public function recordClick()
    {
        $this->increment('clicks');
    }
}
