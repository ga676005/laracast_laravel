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
    return view('jobs.index', ['jobs' => Job::all()]);
})->name('jobs.index');

Route::get('/jobs/{id}', function (string $id) {
    $job = Job::findOrFail((int) $id);

    return view('jobs.show', ['job' => $job]);
})->name('jobs.show');
