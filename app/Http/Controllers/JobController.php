<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Employer;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     */
    public function index(): View
    {
        $jobs = Job::with('employer', 'tags')->paginate(10);

        return view('jobs.index', ['jobs' => $jobs]);
    }

    /**
     * Display the specified job.
     */
    public function show(string $id): View
    {
        $job = Job::with('employer', 'tags')->findOrFail($id);

        return view('jobs.show', ['job' => $job]);
    }

    /**
     * Show the form for creating a new job.
     */
    public function create(): View
    {
        $employers = Employer::orderBy('name')->get();

        return view('jobs.create', ['employers' => $employers]);
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(StoreJobRequest $request): RedirectResponse
    {
        // 看 session 裡有什麼
        // dd(session()->all());

        $validated = $request->validated();

        $job = Job::create([
            'title' => $validated['title'],
            'employer_id' => $validated['employer_id'],
            'salary' => [
                'USD' => (string) $validated['salary_usd'],
                'TWD' => (string) $validated['salary_twd'],
            ],
        ]);

        return redirect()->route('jobs.show', $job->job_listing_id)
            ->with('success', 'Job created successfully!');
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(string $id): View
    {
        $job = Job::findOrFail($id);
        $employers = Employer::orderBy('name')->get();

        return view('jobs.edit', [
            'job' => $job,
            'employers' => $employers,
        ]);
    }

    /**
     * Update the specified job in storage.
     */
    public function update(UpdateJobRequest $request, string $id): RedirectResponse
    {
        $job = Job::findOrFail($id);
        $validated = $request->validated();

        $job->update([
            'title' => $validated['title'],
            'employer_id' => $validated['employer_id'],
            'salary' => [
                'USD' => (string) $validated['salary_usd'],
                'TWD' => (string) $validated['salary_twd'],
            ],
        ]);

        return redirect()->route('jobs.show', $job->job_listing_id)
            ->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Job deleted successfully!');
    }
}
