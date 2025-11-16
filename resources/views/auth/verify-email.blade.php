<x-layout title="Verify Email">
    <x-slot:heading>Verify Your Email Address</x-slot:heading>

    <div class="mx-auto max-w-md">
        <div class="rounded-lg bg-white px-6 py-8 shadow">
            @if (session('message'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                </div>
            @endif

            <div class="space-y-4">
                <p class="text-sm text-gray-600">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </p>

                <form method="POST" action="{{ route('verification.send') }}" id="verification-form">
                    @csrf
                    <button type="submit" id="resend-button" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span id="button-text">Resend Verification Email</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const form = document.getElementById('verification-form');
            const button = document.getElementById('resend-button');
            const buttonText = document.getElementById('button-text');
            const initialRemainingSeconds = Math.floor({{ $remainingSeconds }});
            const pageLoadTime = Date.now();
            let remainingSeconds = initialRemainingSeconds;

            function getActualRemainingSeconds() {
                const elapsedSinceLoad = Math.floor((Date.now() - pageLoadTime) / 1000);
                return Math.max(0, initialRemainingSeconds - elapsedSinceLoad);
            }

            function updateButton() {
                remainingSeconds = getActualRemainingSeconds();

                if (remainingSeconds > 0) {
                    button.disabled = true;
                    buttonText.textContent = `Resend Verification Email (${remainingSeconds}s)`;
                    setTimeout(updateButton, 1000);
                } else {
                    button.disabled = false;
                    buttonText.textContent = 'Resend Verification Email';
                }
            }

            form.addEventListener('submit', function(e) {
                remainingSeconds = getActualRemainingSeconds();
                if (remainingSeconds > 0) {
                    e.preventDefault();
                    return false;
                }
            });

            // Recalculate when tab becomes visible (user switches back)
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    remainingSeconds = getActualRemainingSeconds();
                    updateButton();
                }
            });

            // Initialize on page load
            updateButton();
        })();
    </script>
</x-layout>
