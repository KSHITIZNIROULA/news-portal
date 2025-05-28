<?php

use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:admin|publisher'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth','role:admin'])->group(function(){
    Route::get('/users/create',[AdminArticleController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users',[AdminArticleController::class, 'storeuser'])->name('admin.users.store');
});

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

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

require __DIR__.'/auth.php';
