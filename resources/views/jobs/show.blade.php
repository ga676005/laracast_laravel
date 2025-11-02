<x-layout title="{{ $job['title'] }}">
    <x-slot:heading>Job Details</x-slot:heading>
    
    <div class="space-y-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $job['title'] }}</h2>
        </div>
        <div>
            <p class="text-lg text-gray-600">
                <strong>Salary:</strong> 
                ${{ number_format($job['salary']['USD']) }} (USD) / {{ number_format($job['salary']['TWD']) }} (TWD)
            </p>
        </div>
        <div>
            <a href="{{ route('jobs.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to all jobs</a>
        </div>
    </div>
</x-layout>

