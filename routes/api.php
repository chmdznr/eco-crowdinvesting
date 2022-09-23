<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // User Alerts
    Route::apiResource('user-alerts', 'UserAlertsApiController', ['except' => ['update']]);

    // Faq Category
    Route::apiResource('faq-categories', 'FaqCategoryApiController');

    // Faq Question
    Route::apiResource('faq-questions', 'FaqQuestionApiController');

    // Content Category
    Route::apiResource('content-categories', 'ContentCategoryApiController');

    // Content Tag
    Route::apiResource('content-tags', 'ContentTagApiController');

    // Content Page
    Route::post('content-pages/media', 'ContentPageApiController@storeMedia')->name('content-pages.storeMedia');
    Route::apiResource('content-pages', 'ContentPageApiController');

    // Time Project
    Route::post('time-projects/media', 'TimeProjectApiController@storeMedia')->name('time-projects.storeMedia');
    Route::apiResource('time-projects', 'TimeProjectApiController');

    // Time Entry
    Route::apiResource('time-entries', 'TimeEntryApiController');

    // Task
    Route::post('tasks/media', 'TaskApiController@storeMedia')->name('tasks.storeMedia');
    Route::apiResource('tasks', 'TaskApiController');

    // Financial Access Type
    Route::apiResource('financial-access-types', 'FinancialAccessTypeApiController');

    // Market Access Type
    Route::apiResource('market-access-types', 'MarketAccessTypeApiController');

    // Project Status
    Route::apiResource('project-statuses', 'ProjectStatusApiController');

    // Type Of Business
    Route::apiResource('type-of-businesses', 'TypeOfBusinessApiController');

    // Enterprise
    Route::post('enterprises/media', 'EnterpriseApiController@storeMedia')->name('enterprises.storeMedia');
    Route::apiResource('enterprises', 'EnterpriseApiController');

    // Project Doc
    Route::post('project-docs/media', 'ProjectDocApiController@storeMedia')->name('project-docs.storeMedia');
    Route::apiResource('project-docs', 'ProjectDocApiController');

    // Enterprise Doc
    Route::post('enterprise-docs/media', 'EnterpriseDocApiController@storeMedia')->name('enterprise-docs.storeMedia');
    Route::apiResource('enterprise-docs', 'EnterpriseDocApiController');
});
