<?php

use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminPublisherController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Publisher\PublisherArticleController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// })->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/', [ArticleController::class, 'index'])->name('articles.index');//temperorily home address
Route::get('/articles',[ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/search', [ArticleController::class, 'search'])->name('articles.search');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:admin|publisher'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    
    
    Route::get('/publishers', [AdminPublisherController::class, 'index'])->name('admin.publishers.index');
    Route::get('/publishers/create', [AdminPublisherController::class, 'create'])->name('admin.publishers.create');
    Route::post('/publishers', [AdminPublisherController::class, 'store'])->name('admin.publishers.store');
    Route::get('/publishers/{user}/edit', [AdminPublisherController::class, 'edit'])->name('admin.publishers.edit');
    Route::put('/publishers/{user}', [AdminPublisherController::class, 'update'])->name('admin.publishers.update');
    Route::delete('/publishers/{user}', [AdminPublisherController::class, 'destroy'])->name('admin.publishers.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/publishers/{publisher}/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::post('/publishers/{publisher}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('subscriptions.unsubscribe');
});

Route::prefix('admin')->middleware(['auth', 'role:admin|publisher'])->group(function () {
    Route::get('/articles', [AdminArticleController::class, 'index'])->name('admin.articles.index');
    Route::get('/articles/create', [AdminArticleController::class, 'create'])->name('admin.articles.create');
    Route::post('/articles', [AdminArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/articles/{article}/edit', [AdminArticleController::class, 'edit'])->name('admin.articles.edit');
    Route::put('/articles/{article}', [AdminArticleController::class, 'update'])->name('admin.articles.update');
    Route::delete('/articles/{article}', [AdminArticleController::class, 'destroy'])->name('admin.articles.destroy');
});

Route::prefix('admin')->middleware(['auth','role:admin'])->group(function(){
    Route::get('/categories',[CategoryController::class,'index'])->name('admin.categories.index');
    Route::get('/categories/create',[CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories',[CategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/categories/{category}',[CategoryController::class,'destroy'])->name('admin.categories.destroy');
});

// Publisher Routes (only for publishers)
Route::prefix('publisher')->middleware(['auth', 'role:publisher'])->group(function () {
    Route::get('/dashboard', [PublisherArticleController::class, 'dashboard'])->name('publisher.articles.dashboard');
    Route::get('/articles/create', [PublisherArticleController::class, 'create'])->name('publisher.articles.create');
    Route::post('/articles', [PublisherArticleController::class, 'store'])->name('publisher.articles.store');
    Route::get('/articles/{article}', [PublisherArticleController::class, 'show'])->name('publisher.articles.show');
    Route::get('/articles/{article}/edit', [PublisherArticleController::class, 'edit'])->name('publisher.articles.edit');
    Route::put('/articles/{article}', [PublisherArticleController::class, 'update'])->name('publisher.articles.update');
    Route::delete('/articles/{article}', [PublisherArticleController::class, 'destroy'])->name('publisher.articles.destroy');
});


require __DIR__.'/auth.php';
