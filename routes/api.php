<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/topics','TopicsController@index');
Route::middleware('auth:api')->post('/question/follower','QuestionsController@follower');
Route::middleware('auth:api')->post('/question/follow','QuestionsController@follow');


Route::middleware('auth:api')->post('/user/follower','FollowersController@follower');
Route::middleware('auth:api')->post('/user/follow','FollowersController@follow');

Route::middleware('auth:api')->post('/answer/votes/user','VotesController@users');
Route::middleware('auth:api')->post('/answer/vote','VotesController@vote');
Route::middleware('auth:api')->post('/message/store','MessageController@store');

Route::middleware('auth:api')->get('answer/{id}/comments','CommentsController@answer');
Route::middleware('auth:api')->get('question/{id}/comments','CommentsController@question');
Route::middleware('auth:api')->post('comment','CommentsController@store');
