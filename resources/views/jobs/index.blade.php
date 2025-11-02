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
                <p class="text-gray-600">Salary: {{ $job['salary'] }}</p>
            </div>
        @endforeach
    </div>
</x-layout>

