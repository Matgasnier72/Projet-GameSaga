<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TriArticleController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ArticleCommentaireController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum']);

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('/commentaires', CommentaireController::class);

    Route::apiResource('/articles', ArticleController::class);
    //Route::get('/articles/{id}/commentaires/{id}', ArticleCommentaireController::class,);
    Route::get('/articles/{id}/commentaires', [ArticleCommentaireController::class, 'getCommentaires'])->name('getCommentaires');
    Route::get('/articles/{idArticle}/commentaires/{idCommentaire}', [ArticleCommentaireController::class, 'getCommentaireByID'])->name('getCommentaireByID');
    Route::get('/articlesTri', [TriArticleController::class, 'ArticleTri'])->name('ArticleTri');
    Route::get('/search', [PostController::class, 'search']);
    Route::apiResource('/image', ImageUploadController::class);
});