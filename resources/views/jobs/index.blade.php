<x-layout title="Jobs">
    <x-slot:heading>Jobs</x-slot:heading>
    
    <div class="space-y-4">
        @foreach ($jobs as $job)
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-xl font-semibold text-gray-900">
                    <a href="{{ route('jobs.show', $job->job_listing_id) }}" class="hover:text-indigo-600">
                        {{ $job['title'] }}
                    </a>
                </h2>
                <p class="text-gray-600">
                    Salary:
                    @foreach ($job['salary'] as $currency => $amount)
                        {{ number_format($amount) }} ({{ $currency }})@if (!$loop->last) / @endif
                    @endforeach
                </p>
                @if ($job->employer)
                    <p class="text-sm text-gray-500">
                        Employer: {{ $job->employer->name }} @ {{ $job->employer->company }}
                    </p>
                @endif
                @if ($job->tags->isNotEmpty())
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach ($job->tags as $tag)
                            <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $jobs->links() }}
        {{-- {{ $jobs->links('pagination::simple-tailwind') }} --}}
    </div>
</x-layout>

