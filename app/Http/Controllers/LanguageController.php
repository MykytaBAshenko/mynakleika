<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;

/**
 * Class LanguageController.
 */
class LanguageController extends Controller
{
    /**
     * @param $locale
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function swap($locale)
    {
        if (array_key_exists($locale, config('locale.languages'))) {
            session()->put('locale', $locale);
        }
        Cache::forget('lang.js');
        return redirect()->back();
    }
}
