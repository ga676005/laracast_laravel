<x-layout title="{{ $job['title'] }}">
    <x-slot:heading>Job Details</x-slot:heading>
    
    @if (session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4">
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    
    <div class="space-y-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $job['title'] }}</h2>
        </div>
        <div>
            <p class="text-lg text-gray-600">
                <strong>Salary:</strong>
                @foreach ($job['salary'] as $currency => $amount)
                    {{ number_format($amount) }} ({{ $currency }})@if (!$loop->last) / @endif
                @endforeach
            </p>
        </div>
        @if ($job->employer)
            <div>
                <p class="text-lg text-gray-600">
                    <strong>Employer:</strong> {{ $job->employer->name }}
                    @if ($job->employer->company)
                        at {{ $job->employer->company }}
                    @endif
                </p>
            </div>
        @endif
        @if ($job->tags->isNotEmpty())
            <div>
                <p class="text-lg text-gray-600 mb-2">
                    <strong>Tags:</strong>
                </p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($job->tags as $tag)
                        <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-800">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
        <div>
            <a href="{{ route('jobs.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to all jobs</a>
        </div>
    </div>
</x-layout>

