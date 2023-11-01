<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\V1\Notification\NotificationController;
use App\Models\Category\Category;
use App\Models\History\History;
use App\Models\BugImage\BugImage;
use App\Models\Profile\Profile;
use App\Models\Pull\Pull;
use App\Models\Status\Status;
use App\Models\Task\Task;
use App\Models\Bug\Bug;
use App\Models\UserImage\UserImage;
use App\User;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return 'Bem vindo a Esteira de Desenvolvimento';
});

Route::get('login/{provider}', 'V1\Auth\AuthController@redirectToProvider');
Route::get('login/{provider}/callback', 'V1\Auth\AuthController@handleProviderCallback');


Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\Profile', 'as' => Profile::class], static function () {});
/**
 * ####################
 * ### AUTH ROUTES ###
 * ##################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\Auth', 'as' => User::class], static function () {
    Route::post('/register', [
        'uses' => 'AuthController@register',
    ]);
    Route::post('/login', [
        'uses' => 'AuthController@login',
    ]);
    Route::post('/logout', [
        'uses' => 'AuthController@logout',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::post('/refresh', [
        'uses' => 'AuthController@refresh',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
});

/**
 * ########################
 * ### PROFILES ROUTES ###
 * #####################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\Profile', 'as' => Profile::class], static function () {
    Route::post('/profile', [
        'uses' => 'ProfileController@create',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]
    ]);
    Route::get('/profile', [
        'uses' => 'ProfileController@findAll',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::put('/profile/{param}', [
        'uses' => 'ProfileController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]
    ]);
    Route::patch('/profile/{param}', [
        'uses' => 'ProfileController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::delete('/profile/{id}', [
        'uses' => 'ProfileController@delete',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
});


/**
 * ######################
 * ### STATUS ROUTES ###
 * #####################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\Status', 'as' => Status::class], static function () {
    Route::post('/status', [
        'uses' => 'StatusController@create',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]

    ]);
    Route::get('/status', [
        'uses' => 'StatusController@findAll',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::put('/status/{param}', [
        'uses' => 'StatusController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]
    ]);
    Route::get('/status/{id}', [
        'uses' => 'StatusController@findOneBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::patch('/status/{param}', [
        'uses' => 'StatusController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::delete('/status/{id}', [
        'uses' => 'StatusController@delete',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
});


/**
 * #########################
 * ### CATEGORIES ROUTES ###
 * ########################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\Category', 'as' => Category::class], static function () {

    Route::post('/category', [
        'uses' => 'CategoryController@create',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]
    ]);
    Route::get('/categories', [
        'uses' => 'CategoryController@findAll',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/category/{id}', [
        'uses' => 'CategoryController@findOneBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::put('/category/{param}', [
        'uses' => 'CategoryController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]
    ]);
    Route::patch('/category/{param}', [
        'uses' => 'CategoryController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::delete('/category/{id}', [
        'uses' => 'CategoryController@delete',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);

});

/**
 * ###################
 * ### BUGS ROUTES ##
 * #################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\Bug', 'as' => Bug::class], static function () {

    Route::post('/bug', [
        'uses' => 'BugController@create',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]

    ]);
    Route::get('/bugs', [
        'uses' => 'BugController@findAll',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/bugs-dashboard', [
        'uses' => 'BugController@findBugsDash',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/bug/user/{user}', [
        'uses' => 'BugController@findByUser',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/bug/task/{task}', [
        'uses' => 'BugController@findByTask',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/bug/{param}', [
        'uses' => 'BugController@findBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::put('/bug/{param}', [
        'uses' => 'BugController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]
    ]);
    Route::delete('/bug/task/{task}', [
        'uses' => 'BugController@deleteByTask',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::delete('/bug/{id}', [
        'uses' => 'BugController@deleteBug',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
});

/**
 * #####################
 * ### TASKS ROUTES ##
 * ##################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\Task', 'as' => Task::class], static function () {

    Route::post('/task', [
        'uses' => 'TaskController@create',
//        'middleware' => [
//            'auth',
//            'UnauthorizedMiddleware',
//            'ValidateDataMiddleware',
//        ]
    ]);
    Route::get('/tasks', [
        'uses' => 'TaskController@findAllTasks',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/tasks-dashboard', [
        'uses' => 'TaskController@findAllStatus',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/dashboard-line', [
        'uses' => 'TaskController@findAllPeriod',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/task/user/{user}', [
        'uses' => 'TaskController@findByUser',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);

    Route::get('/task/{id}', [
        'uses' => 'TaskController@findById',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::post('/update-task', [
        'uses' => 'TaskController@update',
        'middleware' => [
            'auth'
        ]
    ]);
    Route::put('/task/{param}', [
        'uses' => 'TaskController@editBy',
        'middleware' => [
            'auth'
        ]
    ]);
    Route::delete('/task/{id}', [
        'uses' => 'TaskController@delete',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
});

/**
 * #####################
 * ### HISTORY ROUTES ##
 * ##################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\History', 'as' => History::class], static function () {

    Route::get('/history', [
        'uses' => 'HistoryController@findAll',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/history/task/{task}', [
        'uses' => 'HistoryController@findByTask',
//        'middleware' => [
//            'auth',
//            'UnauthorizedMiddleware',
//        ]
    ]);
});

/**
 * #####################
 * ### USER FILE ROUTES ##
 * ##################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\UserImage', 'as' => UserImage::class], static function () {

    Route::post('/user/image', [
        'uses' => 'UserImageController@uploadImage'
    ]);

    Route::get('/user-image/find/{id}', [
        'uses' => 'UserImageController@getImage',
//        'middleware' => [
//            'auth',
//            'UnauthorizedMiddleware',
//        ]
    ]);
    Route::put('/user/image/{id}', [
        'uses' => 'UserImageController@updateImage'
    ]);
    Route::delete('/user/image/{id}', [
        'uses' => 'UserImageController@deleteImage'
    ]);
});

/**
 * #####################
 * ### BUG FILES ROUTES ##
 * ##################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\BugImage', 'as' => BugImage::class], static function () {

    Route::post('/bug/image', [
        'uses' => 'BugImageController@uploadImage'
    ]);

    Route::get('/image/find/{bug}', [
        'uses' => 'BugImageController@findByBug',
//        'middleware' => [
//            'auth',
//            'UnauthorizedMiddleware',
//        ]
    ]);
    Route::put('/bug/image/{id}', [
        'uses' => 'BugImageController@updateImage'
    ]);
    Route::delete('/bug/image/{id}', [
        'uses' => 'BugImageController@deleteImage'
    ]);
});

/**
 * ####################
 * ### USERS ROUTES ##
 * #################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\User', 'as' => User::class], static function () {

    Route::post('/save-token', [
        'uses' => 'UserController@saveToken',
        'middleware' => [
            'auth',
        ]
    ]);
    Route::post('/send-notification', [
        'uses' => 'UserController@sendNotification',
        'middleware' => [
            'auth',
        ]
    ]);

    Route::post('/user', [
        'uses' => 'UserController@create',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]
    ]);
    Route::get('/users', [
        'uses' => 'UserController@findAll',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::get('/user/{id}', [
        'uses' => 'UserController@findOneBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
        ]
    ]);
    Route::put('/user/{param}', [
        'uses' => 'UserController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware',
        ]
    ]);
    Route::delete('/user/{id}', [
        'uses' => 'TaskController@delete',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware'
        ]
    ]);
});

/**
 * ###################
 * ### PULL ROUTES ##
 * #################
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'V1\Pull', 'as' => Pull::class], static function () {

    Route::post('/pull', [
        'uses' => 'PullController@create',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware'
        ]
    ]);
    Route::get('/pulls', [
        'uses' => 'PullController@findAll',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware'
        ]
    ]);
    Route::get('/pull/{id}', [
        'uses' => 'PullController@findOneBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware'
        ]
    ]);
    Route::get('/pull/status/{statusId}', [
        'uses' => 'PullController@findByStatus',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware'
        ]
    ]);
    Route::get('/pull/user/{user}', [
        'uses' => 'PullController@findByUser',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware'
        ]
    ]);
    Route::put('/pull/{param}', [
        'uses' => 'PullController@editBy',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware',
            'ValidateDataMiddleware'
        ]
    ]);
    Route::delete('/pull/{id}', [
        'uses' => 'PullController@delete',
        'middleware' => [
            'auth',
            'UnauthorizedMiddleware'
        ]
    ]);
});





