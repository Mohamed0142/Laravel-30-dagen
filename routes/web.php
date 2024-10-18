<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

//index
Route::get('/jobs', function () {
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

//create
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

//show
Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});

//store
Route::post('/jobs', function () {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
        'employer_id' => ['required'],

    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);

    return redirect('/jobs');
});
//edit
Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});


//update
Route::patch('/jobs/{id}', function ($id) {
  //validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);
    //authorize (on hold..)

    //update the job

    $job = Job::findOrFail($id); //returns null

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    // and persist
    //redirect to the job page
    return redirect('/jobs/' . $job->id);


});

//destroy
Route::delete('/jobs/{id}', function ($id) {
    //authorize on hold..!

    //delete the job
    job::findOrfail($id)->delete();

    //redirect
    return redirect('/jobs');
});


Route::get('/contact', function () {
    return view('contact');
});


