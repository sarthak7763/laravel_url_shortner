<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Carbon\Carbon;

class ShortUrlResolverController extends Controller
{
    /**
     * Resolve and redirect short URL
     */
    public function resolve($shortCode)
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->firstOrFail();

        // Record the click
        $shortUrl->recordClick();

        // Redirect to original URL
        return redirect($shortUrl->original_url);
    }
}
