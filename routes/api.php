<?php

use Illuminate\Support\Facades\Route;
use Lunacms\Forums\Forums;

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

Route::group([
	'prefix' => config('forums.routes.prefix', '/'),
	'as' => config('forums.routes.as', ''),
	'middleware' => config('forums.routes.middleware', ['web']),
], function () {

	if (Forums::runningSingleMode()) {

	  	/**
	  	 * Posts Group Routes
	  	 */
		Route::group(['prefix' => '/posts/{post}', 'as' => 'posts.'], function () {
	  	
	  		/**
	  		 * Post Comments
	  		 */
		  	Route::apiResource('/comments', \Lunacms\Forums\Http\Posts\Controllers\PostCommentController::class);
	  	});
		
		/**
		 * Posts Routes
		 */
		Route::apiResource('/posts', \Lunacms\Forums\Http\Posts\Controllers\PostController::class);  
	} else {
	  	/**
	  	 * Posts Group Routes
	  	 */
		Route::group(['prefix' => '/posts/{post}', 'as' => 'posts.'], function () {
	  	
	  		/**
	  		 * Post Comments
	  		 */
		  	Route::apiResource('/comments', \Lunacms\Forums\Http\Posts\Controllers\PostCommentController::class)->only('index', 'store');
	  	});
			
		/**
		 * Posts Routes
		 */
		Route::apiResource('/posts', \Lunacms\Forums\Http\Posts\Controllers\PostController::class)->only('update', 'destroy');

		/**
		 * Forum Group Routes
		 */
		Route::group(['prefix' => '/forums/{forum}'], function () {
			
			/**
			 * Posts Routes
			 */
			Route::apiResource('/posts', \Lunacms\Forums\Http\Forums\Controllers\PostController::class)->except('update', 'destroy');  
		});

		/**
		 * Forums Routes
		 */
		Route::apiResource('/forums', \Lunacms\Forums\Http\Forums\Controllers\ForumController::class);
	}

	/**
	 * Tags Routes
	 */
	Route::apiResource('/tags', \Lunacms\Forums\Http\Tags\Controllers\TagController::class);

	/**
	 * Comment Reply Route
	 */
	Route::post('/comments/{comment}/replies', \Lunacms\Forums\Http\Comments\Controllers\CommentReplyController::class)->name('comments.replies.store');
	/**
	 * Comments Resource Routes
	 */
	Route::apiResource('/comments', \Lunacms\Forums\Http\Comments\Controllers\CommentController::class)->only('update', 'destroy');
});
