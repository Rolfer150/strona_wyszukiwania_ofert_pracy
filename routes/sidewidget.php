<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferApplicationController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\UserController;
use App\Livewire\EmployerSearch;
use App\Livewire\UserSearch;
use App\Livewire\SalaryCalculator;
use App\Livewire\OfferSearch;
use App\System\System;
use Illuminate\Support\Facades\Route;

Route::get('/system', [System::class, 'index'])->name('system.index');

//Route::get('/offers', [OfferController::class, 'index'])->name('sidewidgets.offer');
Route::get('/offers/{offer:slug}', [OfferController::class, 'show'])->name('offer.show');
Route::get('/company/{company:slug}', [CompanyController::class, 'show'])->name('company.show');

Route::get('/offers', OfferSearch::class)->name('livewire.search');
Route::get('/employers', EmployerSearch::class)->name('livewire.employer');

Route::get('/users', UserSearch::class)->name('livewire.user');
Route::get('/users/{user:slug}', [UserController::class, 'show'])->name('user.show');
//Route::get('/offers/search', [OfferController::class, 'search'])->name('sidewidgets.search');

Route::get('/calculator', SalaryCalculator::class)->name('livewire.salary-calculator');

Route::group(['middleware' => 'verified'], function () {
    Route::group(['prefix' => 'myoffers'], function () {
        Route::controller(OfferController::class)
            ->name('offer.')
            ->middleware(['can:create offer'])
            ->group(function () {
                Route::get('/', 'index')->name('myoffers');
                Route::get('/addoffer', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
            });
        Route::controller(OfferApplicationController::class)
            ->name('offer-application.')
            ->middleware(['can:apply offer'])
            ->group(function () {
                Route::get('/appliedoffers', 'index')->name('index');
                Route::get('/apply/{offer:slug}', 'apply')->name('create');
                Route::post('/apply/store', 'store')->name('store');
                Route::delete('/apply/{offer_application}', 'destroy')->name('destroy');
            });
    });

    Route::group(
        [
            'prefix' => 'favourite',
            'controller' => FavouriteController::class,
            'as' => 'favourite.'
        ],
        function () {
            Route::get('/', 'index')->name('index');
            Route::delete('/{favourite}', 'destroy')->name('destroy');
        }
    );

    Route::group(
        [
            'prefix' => 'notification',
            'controller' => NotificationController::class,
            'as' => 'notification.'
        ],
        function () {
            Route::get('/', 'index')->name('index');
        }
    );

    Route::group(
        [
            'prefix' => 'questionnaire',
            'controller' => QuestionnaireController::class,
            'as' => 'questionnaire.'
        ],
        function () {
            Route::get('/', 'index')->name('index');
            //        Route::get('/create', QuestionnaireForm::class)->name('livewire.questionnaire');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{questionnaire}', 'edit')->name('edit');
            Route::post('/{questionnaire}', 'update')->name('update');
            Route::delete('/{questionnaire}', 'destroy')->name('destroy');
        }
    );
});
