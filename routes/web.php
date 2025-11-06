<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/jobs', function () {
    // Eager loading with ->with('employer')->get():
    // - Executes 2 queries: 1 for jobs + 1 for all employers (using WHERE id IN (...))
    // - When the view accesses $job->employer, no additional queries are needed
    //
    // If using Job::all() instead:
    // - Would execute 1 query for jobs + N queries (one per job when accessing $job->employer in the view)
    // - This is the "N+1 query problem": 1 + N = 11 queries for 10 jobs (instead of just 2)
    // - Each access to $job->employer->name triggers a separate database query
    $jobs = Job::with('employer', 'tags')->get();

    return view('jobs.index', ['jobs' => $jobs]);
})->name('jobs.index');

Route::get('/jobs/{id}', function (string $id) {
    // Eager loading: Loads the job and its employer in 2 queries
    // findOrFail automatically returns 404 if job doesn't exist
    $job = Job::with('employer', 'tags')->findOrFail($id);

    return view('jobs.show', ['job' => $job]);
})->name('jobs.show');
