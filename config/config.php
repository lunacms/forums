<?php

/*
 * You can place your custom package configuration in here.
 */
return [

	/**
	 * Forums Mode
	 *
	 * Set whether the package should operate as a 'single' forum
	 * or as a multi-forum provider.
	 *
	 * Available Modes: 'single', 'multi'.
	 *
	 * In 'single' mode the 'forums' table is ignored and each post
	 * forum fields will be nullable.
	 */
	'mode' => 'single',

	/**
	 * Models Setting.
	 * 
	 * The models that will be used to drive the packages different
	 * functions.
	 * 
	 */
	'models' => [
		'users' => \App\Models\User::class,
        'forums' => \Lunacms\Forums\Forums\Models\Forum::class,
        'comments' => \Lunacms\Forums\Comments\Models\Comment::class,
        'posts' => \Lunacms\Forums\Posts\Models\Post::class,
        'tags' => \Lunacms\Forums\Tags\Models\Tag::class,
	],

	/**
	 * Routes Setting.
	 * 
	 * Set the settings for the packages routes here.
	 * 
	 */
	'routes' => [

		/**
		 * The route prefix for the packages routes.
		 */
		'prefix' => '/forums',

		/**
		 * The prefix for route names for the packages routes.
		 */
		'as' => 'forums.',

		/**
		 * The global middleware for the package.
		 */
		'middleware' => [
			'web',
		],

		/**
		 * Auth Middleware
		 * 
		 * The Auth middleware for the package routes that perform form requests.
		 */
		'auth_middleware' => [
			'auth',
		],
	],

	/**
	 * Model's Morph Map.
	 * 
	 * Register model aliases for polymorphic relations that will be used in the package.
	 * 
	 */
	'morph_map' => [
        'users' => \App\Models\User::class,
        'forums' => \Lunacms\Forums\Forums\Models\Forum::class,
        'forums_comments' => \Lunacms\Forums\Comments\Models\Comment::class,
        'forums_post' => \Lunacms\Forums\Posts\Models\Post::class,
        'forums_tags' => \Lunacms\Forums\Tags\Models\Tag::class,
    ],

	/**
	 * Model's Resource Map.
	 * 
	 * Register models API Resource that will be used to output the related data.
	 * 
	 */
	'resources' => [
		\App\Models\User::class => \Lunacms\Forums\Http\Users\Resources\UserResource::class,
		\Lunacms\Forums\Forums\Models\Forum::class => \Lunacms\Forums\Http\Forums\Resources\ForumResource::class,
		\Lunacms\Forums\Tags\Models\Tag::class => \Lunacms\Forums\Http\Tags\Resources\TagResource::class,
		\Lunacms\Forums\Posts\Models\Post::class => \Lunacms\Forums\Http\Posts\Resources\PostResource::class,
		\Lunacms\Forums\Comments\Models\Comment::class => \Lunacms\Forums\Http\Comments\Resources\CommentResource::class,
	],

	/**
	 * Model's Policies Map.
	 * 
	 * Register policies for models that control who can post, comment, or own forums.
	 *
	 * We got you started with the 'CommentPolicy' to handle reply, update and destroy.
	 * 
	 */
	'policies' => [
		\Lunacms\Forums\Comments\Models\Comment::class => \Lunacms\Forums\Http\Comments\Policies\CommentPolicy::class,
		// \Lunacms\Forums\Forums\Models\Forum::class => \Lunacms\Forums\Http\Forums\Policies\ForumPolicy::class,
		// \Lunacms\Forums\Tags\Models\Tag::class => \Lunacms\Forums\Http\Tags\Policies\TagPolicy::class,
		// \Lunacms\Forums\Posts\Models\Post::class => \Lunacms\Forums\Http\Posts\Policies\PostPolicy::class,
	],
];