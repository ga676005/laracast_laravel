<x-layout title="Jobs">
    <x-slot:heading>Jobs</x-slot:heading>
    
    <div class="space-y-4">
        @foreach ($jobs as $job)
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-xl font-semibold text-gray-900">
                    <a href="{{ route('jobs.show', $job['id']) }}" class="hover:text-indigo-600">
                        {{ $job['title'] }}
                    </a>
                </h2>
                <p class="text-gray-600">
                    Salary: ${{ number_format($job['salary']['USD']) }} (USD) / {{ number_format($job['salary']['TWD']) }} (TWD)
                </p>
                @if ($job->employer)
                    <p class="text-sm text-gray-500">
                        Employer: {{ $job->employer->name }} @ {{ $job->employer->company }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
</x-layout>

