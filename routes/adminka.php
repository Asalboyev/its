<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ApplicationsController,
    TranslationsController,
    TranslationGroupController,
    LangsController,
    ProductController,
    ProductsCategoryController,
    CertificateController,
    PartnerController,
    PostController,
    ServiceController,
    MemberController,
    FeedbackController,
    PostsCategoryController,
    WorkController,
    DocumentController,
    DocumentCategoryController,
    UserController,
    BrandController,
    LogController,
    SiteInfoController,
    VacancyController,
    AdditionalFunctionController,
    HomeController,
    AdvantageCategoryController,
    AdvantageController,
    QuestionController,
    DevelopmentController
};

// autorization routes
Auth::routes(['register' => false]);

// route to login page
Route::get('/admin', [HomeController::class, 'index'])->name('admin');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // posts
    Route::resource('posts', PostController::class);

    // posts categories
    Route::resource('posts_categories', PostsCategoryController::class);

    // langs
    Route::resource('langs', LangsController::class);

    // products
    Route::resource('products', ProductController::class);

    // products categories
    Route::resource('products_categories', ProductsCategoryController::class);

    // products brands
    Route::get('banners', [BrandController::class, 'index'])->name('banners.index');

    Route::get('banners/create', [BrandController::class, 'create'])->name('banners.create');

    Route::post('banners', [BrandController::class, 'store'])->name('banners.store');

    Route::get('banners/{id}/edit', [BrandController::class, 'edit'])->name('banners.edit');

    Route::put('banners/{id}', [BrandController::class, 'update'])->name('banners.update');

    Route::delete('banners/{id}', [BrandController::class, 'destroy'])->name('banners.destroy');

    // certificates
    Route::resource('certificates', CertificateController::class);

    // documents
    Route::resource('documents', DocumentController::class);

    // document categories
    Route::resource('document_categories', DocumentCategoryController::class);

    // feedbacks
    Route::resource('feedbacks', FeedbackController::class);

    // memebers
    Route::resource('members', MemberController::class);

    // partners
    Route::resource('contacts', PartnerController::class);

    // FAQ
    Route::resource('questions', QuestionController::class);

    // services
    Route::resource('services', ServiceController::class);

    // works
    Route::resource('works', WorkController::class);

    // users
    Route::resource('users', UserController::class);

    // applications
    Route::resource('applications', ApplicationsController::class);

    // vacancies
    Route::resource('vacancies', VacancyController::class);

    // logs
    Route::resource('logs', LogController::class);

    // translations
    Route::resource('translations', TranslationsController::class);

    // translation groups
    Route::resource('translation_groups', TranslationGroupController::class);

    // dropzone upload files
    Route::post('/upload_from_dropzone', [HomeController::class, 'upload_from_dropzone']);

    // upload image for CKEditor
    Route::post('upload-image', [HomeController::class, 'uploadImage'])->name('upload-image');

    // site info
    Route::resource('site_infos', SiteInfoController::class);

    // additional functions
    Route::resource('additional_functions', AdditionalFunctionController::class);

    // config page
    Route::get('config/settings', [HomeController::class, 'config'])->name('config');
    Route::post('config/update', [HomeController::class, 'config_update'])->name('config.update');

    // advantages
    Route::resource('advantages', AdvantageController::class);

    // advantage categories
    Route::resource('advantage_categories', AdvantageCategoryController::class);

    // developments
    Route::resource('developments', DevelopmentController::class);
});
