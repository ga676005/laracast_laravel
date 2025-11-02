<?php

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

$jobs = [
    ['id' => 1, 'title' => 'Senior Software Engineer', 'salary' => '$120,000'],
    ['id' => 2, 'title' => 'Frontend Developer', 'salary' => '$90,000'],
    ['id' => 3, 'title' => 'Backend Developer', 'salary' => '$100,000'],
];

Route::get('/jobs', function () use ($jobs) {
    return view('jobs.index', ['jobs' => $jobs]);
})->name('jobs.index');

Route::get('/jobs/{id}', function (string $id) use ($jobs) {
    $job = collect($jobs)->firstWhere('id', (int) $id);
    
    if (!$job) {
        abort(404);
    }
    
    return view('jobs.show', ['job' => $job]);
})->name('jobs.show');
