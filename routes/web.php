<?php

use Illuminate\Http\Request;
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

    return view('welcome')->withContestants($contestants);
});

Route::get('/vote/{contestant_slug}', function ($contestant_slug) {

    $contestant = \App\Contestant::whereSlug($contestant_slug)->first();

	$votes 		= $contestant->votesCount->votes;

    return view('vote', [
    	'contestant' => $contestant,
    	'votes'		 => $votes,
    ]);
});

Route::post('/vote/verifypayment/{contestant_slug}', function ($contestant_slug, Request $request) {
	$ref = $request->input('reference');

	// Validate posted request
	if (empty($ref) || !is_string($ref)) {
		return response()->json([
			'status' => true
		], 200);
	} else {
		$url = 'https://api.paystack.co/transaction/verify/'.$ref;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt(
		  $ch, CURLOPT_HTTPHEADER, [
		    'Authorization: Bearer sk_test_9127302b2a2077a7418e3ee7f8a99a540f5cde48']
		);

		//send request
		$request = curl_exec($ch);

		//close connection
		curl_close($ch);

		//declare an array that will contain the result 
		$result = array();

		if ($request) {
		  $result = json_decode($request, true);
		}

		if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
			// Increment the vote
		    $contestant 	= \App\Contestant::whereSlug($contestant_slug)->first();
			$votes 			= \App\Votes::whereContestantId($contestant->id)->first();

			$votes->votes 	= $votes->votes+1;
			
			$votes->save();

			return true;
		}else{
			return false;
		}
	}
});
