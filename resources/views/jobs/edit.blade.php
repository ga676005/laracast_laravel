<x-layout :title="__('messages.jobs.create.title')">
    <x-slot:heading>Edit Job</x-slot:heading>

    <form method="POST" action="{{ route('jobs.update', $job->job_listing_id) }}">
        @csrf
        @method('PUT')

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">{{ __('messages.jobs.create.job_information') }}</h2>
                <p class="mt-1 text-sm/6 text-gray-600">{{ __('messages.jobs.create.job_information_description') }}</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-full">
                        <label for="title" class="block text-sm/6 font-medium text-gray-900">{{ __('messages.jobs.create.job_title') }}</label>
                        <div class="mt-2">
                            <input 
                                id="title" 
                                type="text" 
                                name="title" 
                                value="{{ old('title', $job->title) }}"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" 
                                placeholder="{{ __('messages.jobs.create.job_title_placeholder') }}"
                            />
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="employer_id" class="block text-sm/6 font-medium text-gray-900">{{ __('messages.jobs.create.employer') }}</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select 
                                id="employer_id" 
                                name="employer_id" 
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            >
                                <option value="">{{ __('messages.jobs.create.select_employer') }}</option>
                                @foreach ($employers as $employer)
                                    <option value="{{ $employer->employer_id }}" {{ old('employer_id', $job->employer_id) == $employer->employer_id ? 'selected' : '' }}>
                                        {{ $employer->name }}@if($employer->company) - {{ $employer->company }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4">
                                <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                            @error('employer_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="salary_usd" class="block text-sm/6 font-medium text-gray-900">{{ __('messages.jobs.create.salary_usd') }}</label>
                        <div class="mt-2">
                            <input 
                                id="salary_usd" 
                                type="number" 
                                name="salary_usd" 
                                value="{{ old('salary_usd', $job->salary['USD'] ?? '') }}"
                                min="0"
                                step="0.01"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" 
                                placeholder="50000"
                            />
                            @error('salary_usd')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="salary_twd" class="block text-sm/6 font-medium text-gray-900">{{ __('messages.jobs.create.salary_twd') }}</label>
                        <div class="mt-2">
                            <input 
                                id="salary_twd" 
                                type="number" 
                                name="salary_twd" 
                                value="{{ old('salary_twd', $job->salary['TWD'] ?? '') }}"
                                min="0"
                                step="0.01"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" 
                                placeholder="1500000"
                            />
                            @error('salary_twd')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('jobs.show', $job->job_listing_id) }}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus:outline-indigo-600">Update Job</button>
        </div>
    </form>
</x-layout>

