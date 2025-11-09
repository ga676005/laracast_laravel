<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    /**
     * Switch the application locale.
     */
    public function switch(string $locale): RedirectResponse
    {
        $supportedLocales = ['en', 'zh_TW'];

        if (! in_array($locale, $supportedLocales)) {
            $locale = config('app.locale', 'en');
        }

        session()->put('locale', $locale);

        return redirect()->back();
    }
}
