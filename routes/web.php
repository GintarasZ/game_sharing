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

Route::get('/', [App\Http\Controllers\UserController::class, 'index']);

Auth::routes();

Route::post('CityController/fetch', [App\Http\Controllers\CityController::class, 'fetch'])->name('searchlocation.fetch');

Route::post('MainCategoryController/retrieve', [App\Http\Controllers\MainCategoryController::class, 'retrieve'])->name('categories.retrieve');

Route::get('post-classified-ads', [App\Http\Controllers\UserController::class, 'postAd']);

Route::get('/post-classified-ads/{maincategory}/{id}', [App\Http\Controllers\MainCategoryController::class, 'categories']);

Route::post('/postPlaystation3', [App\Http\Controllers\UserController::class, 'postPlaystation3']);

Route::get('UserController/getAds', [App\Http\Controllers\UserController::class, 'getAds'])->name('categories.ads');

Route::get('/viewAds/{mainCategory}/{id}', [App\Http\Controllers\UserController::class, 'viewAds']);

Route::post('/product/search', [App\Http\Controllers\UserController::class, 'searchProduct']);

Route::post('/search/advertisements', [App\Http\Controllers\CityController::class, 'searchAdvertisements']);

Route::get('/product/view/{id}', [App\Http\Controllers\UserController::class, 'viewProduct']);

Route::get('profile/{id}', [App\Http\Controllers\UserController::class, 'profile']);

Route::get('/myAds/{id}', [App\Http\Controllers\UserController::class, 'viewMyAds']);

Route::post('/updateProfile', [App\Http\Controllers\UserController::class, 'updateProfile']);

Route::get('/editAd/{id}', [App\Http\Controllers\UserController::class, 'editAd']);

Route::post('/updateAd{id}', [App\Http\Controllers\UserController::class, 'updateAd']);

Route::post('/deleteAd{id}', [App\Http\Controllers\UserController::class, 'deleteAd']);

Route::get('/uploadGamePage', [App\Http\Controllers\AdminController::class, 'uploadGamePage']);

Route::post('/uploadGame', [App\Http\Controllers\AdminController::class, 'uploadGame']);

Route::post('GameController/fetchGame', [App\Http\Controllers\GameController::class, 'fetchGame'])->name('searchgame.fetchGame');

Route::get('/myGames', [App\Http\Controllers\GameController::class, 'viewMyGames']);

Route::get('/editGame/{id}', [App\Http\Controllers\GameController::class, 'editGame']);

Route::post('/updateGame{id}', [App\Http\Controllers\GameController::class, 'updateGame']);

Route::post('/deleteGame{id}', [App\Http\Controllers\GameController::class, 'deleteGame']);

Route::post('/save-comment/product/view/{id}', [App\Http\Controllers\CommentsController::class, 'saveComment']);

Route::get('/feedback/{id}', [App\Http\Controllers\CommentsController::class, 'viewFeedbackPage']);

Route::post('/commentOnPerson/product/view/{id}', [App\Http\Controllers\CommentsController::class, 'commentOnPerson']);

Route::post('/deleteComment{id}', [App\Http\Controllers\CommentsController::class, 'deleteComment']);

Route::post('/deleteFeedback{id}', [App\Http\Controllers\CommentsController::class, 'deleteFeedback']);

Route::post('/rentForADay/product/view/{id}', [App\Http\Controllers\UserController::class, 'rentForADay']);

Route::post('/rentForThreeDays/product/view/{id}', [App\Http\Controllers\UserController::class, 'rentForThreeDays']);

Route::post('/rentForAWeek/product/view/{id}', [App\Http\Controllers\UserController::class, 'rentForAWeek']);

Route::post('/rentForAMonth/product/view/{id}', [App\Http\Controllers\UserController::class, 'rentForAMonth']);

Route::post('/acceptRent/product/view/{id}/{adId}', [App\Http\Controllers\UserController::class, 'acceptRent']);

Route::post('/endRent/product/view/{id}/{adId}', [App\Http\Controllers\UserController::class, 'endRent']);

Route::get('/howTo', [App\Http\Controllers\HomeController::class, 'howToUse']);
