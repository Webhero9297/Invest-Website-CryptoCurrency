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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1/public'], function () {
    //Portfolio
    Route::get('/portfolios', 'PublicApiController@getLivePortfolioData');
    Route::get('/detailportfolios/{user_id}', 'PublicApiController@detailPortfolioAPI');
    //News
    Route::get('/news', 'PublicApiController@getNews');
    //Home
    Route::get('/toplive', 'PublicApiController@getTopLiveData');
    //Coins
    Route::get('/coindata', 'PublicApiController@getCoinDataByPagePos');
    Route::get('/filtercoindata/{filter}', 'PublicApiController@getSearchDataForFilter');
    Route::get('/specialcoindata/{coinid}', 'PublicApiController@coinLiveData');
    //CoinMatch
    Route::get('/liveorder', 'PublicApiController@viewLiveBiz');
});