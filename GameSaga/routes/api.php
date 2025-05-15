<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TriArticleController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleCommentaireController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::apiResource('/articles', ArticleController::class);
Route::get('/articles/{idArticle}/commentaires/{idCommentaire}', [ArticleCommentaireController::class, 'getCommentaireByID'])->name('getCommentaireByID');
Route::get('/articles/{idArticle}/commentairescount', [ArticleCommentaireController::class, 'countCommentaireArticle'])->name('countCommentaireArticle');
Route::get('/articlesTri', [TriArticleController::class, 'ArticleTri'])->name('ArticleTri');
Route::get('/articles/{id}/commentaires', [ArticleCommentaireController::class, 'getCommentaires'])->name('getCommentaires');
Route::middleware(['auth:sanctum'])->group(callback: function () {

    Route::apiResource('/commentaires', CommentaireController::class);
    //Route::get('/articles/{id}/commentaires/{id}', ArticleCommentaireController::class,);
    Route::apiResource('/images', ImageUploadController::class);
    Route::get('/imagesByArticle/{idArticle}', [ImageUploadController::class, 'getImagesByArticle']);
});
Route::get('/search', [ArticleController::class, 'search']);
Route::get('/getUser', [UserController::class, 'getUser']);
Route::post('/verification', [RegisterController::class, 'verification']);