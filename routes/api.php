<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('locale')->group(function () {

    Route::get('/posts', [ApiController::class, 'get_posts']);
    Route::get('/posts/{slug}', [ApiController::class, 'show_post']);

    Route::get('/vacancies', [ApiController::class, 'get_vacancies']);
    Route::get('/vacancies/{id}', [ApiController::class, 'show_vacancies']);


    Route::get('/documents', [ApiController::class, 'get_documents']);

    Route::post('/documents', [ApiController::class, 'documents']);

    Route::get('/documents/filter/{slug}', [ApiController::class, 'show_category_documents']);
    Route::get('/document/{slug}', [ApiController::class, 'show_document']);

    Route::get('/services', [ApiController::class, 'get_catalogs']);
    Route::get('/services/{slug}', [ApiController::class, 'show_catalogs']);


    Route::get('/translations', [ApiController::class, 'translations']);
    Route::get('/teams', [ApiController::class, 'get_team']);
    Route::get('/teams/{id}', [ApiController::class, 'show_team']);

    Route::get('/catalogs', [ApiController::class, 'get_catalogs']);
    Route::get('/catalogs/{slug}', [ApiController::class, 'show_catalogs']);

    Route::get('/banners', [ApiController::class, 'get_banner']);

    Route::get('/contact-info', [ApiController::class, 'get_contact_info']);

    Route::get('/photo', [ApiController::class, 'key']);

    Route::get('/langs', [ApiController::class, 'langs']);

    Route::get('/categories', [ApiController::class, 'get_categories']);
    Route::get('/categories/{slug}', [ApiController::class, 'show_categories']);
    Route::get('/categories/filter/{slug}', [ApiController::class, 'show_categor_product']);

    Route::get('/products', [ApiController::class, 'get_products']);
    Route::get('/product/{slug}', [ApiController::class, 'show_products']);

    Route::get('siteinfo', [ApiController::class, 'getCompany']);
    Route::get('settings', [ApiController::class, 'settings']);
    Route::post('/contacts', [ApiController::class, 'store']);

});
