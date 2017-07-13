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

    /*
     * @param Request $request
     * @return mixed
     */
Route::middleware('auth:api')->get(/**
 * @param Request $request
 * @return mixed
 */
    '/user', function (Request $request)
    {
        return $request->user();
    });

    /*
     * @param Request $request
     * @return array
     */
Route::get('/topics','TopicsController@index')->middleware('api');

    /*
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
Route::middleware('auth:api')->post('/question/follower', 'QuestionFollowController@follower');

    /*
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
Route::middleware('auth:api')->post('/question/follow', 'QuestionFollowController@followerThisQuestion');

Route::middleware('auth:api')->get('/user/follower/{id}','FollowersController@index');
Route::middleware('auth:api')->post('/user/follow','FollowersController@follow');

Route::middleware('auth:api')->post('/answer/{id}/votes/user','VotesController@users');
Route::middleware('auth:api')->post('/answer/vote','VotesController@vote');
Route::middleware('auth:api')->post('/message/store','MessageController@store');

Route::middleware('auth:api')->get('/answer/{id}/comments','CommentsController@answer');
Route::middleware('auth:api')->get('/question/{id}/comments','CommentsController@question');
Route::middleware('auth:api')->post('/comment','CommentsController@store');
