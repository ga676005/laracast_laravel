<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    /**
     * Display the email verification notice.
     */
    public function showVerificationNotice(Request $request): View
    {
        $lastSent = $request->session()->get('verification_email_sent_at');
        $remainingSeconds = 0;

        if ($lastSent) {
            $elapsed = now()->timestamp - $lastSent->timestamp;
            $remainingSeconds = (int) max(0, 60 - $elapsed);

            // Clear session if cooldown has expired
            if ($remainingSeconds === 0) {
                $request->session()->forget('verification_email_sent_at');
            }
        }

        return view('auth.verify-email', [
            'remainingSeconds' => $remainingSeconds,
        ]);
    }

    /**
     * Mark the user's email address as verified.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()->route('home')->with('message', 'Email verified successfully!');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request): RedirectResponse
    {
        $request->user()->sendEmailVerificationNotification();

        $request->session()->put('verification_email_sent_at', now());

        return back()->with('message', 'Verification link sent!');
    }
}
