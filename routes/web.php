<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentPlayerController;
use App\Http\Controllers\TournamentPlayerTransactionController;
use App\Http\Controllers\TournamentTransactionController;
use App\Http\Middleware\Authenticate;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('structures', StructureController::class)
    ->middleware(Authenticate::class);

Route::resource('tournaments', TournamentController::class)
    ->middleware(Authenticate::class);

Route::resource('tournaments.players', TournamentPlayerController::class)
    ->shallow()
    ->middleware(Authenticate::class);

Route::resource('tournaments.players.transactions', TournamentPlayerTransactionController::class)
    ->shallow()
    ->middleware(Authenticate::class);

Route::resource('tournaments.transactions', TournamentTransactionController::class)
    ->shallow()
    ->middleware(Authenticate::class);

Route::resource('players', PlayerController::class)
    ->middleware(Authenticate::class);