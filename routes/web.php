<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{home?}', function () {
    $contestants = \App\Contestant::all();

    // return view('welcome')->withContestants($contestants);
});

Route::get('/vote/{contestant_slug}', function ($contestant_slug) {

    // $contestant = \App\Contestant::whereSlug($contestant_slug)->first();
// dd($contestant->votes);
    // return view('vote')->withContestant($contestant);
});
