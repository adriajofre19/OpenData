<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\CulturalSpacesController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckManagerRole;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\Auth\LoginGithubController;

use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [CulturalSpacesController::class, 'welcome'])->name('home');

Route::get('login/github', [LoginGithubController::class, 'login'])->name(name: 'login.github');
Route::get('/auth/github/callback', [LoginGithubController::class, 'callback']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/addplan', [ProfileController::class, 'addPlan'])->name('profile.addPlan');
    Route::get('/profile/updateplan/{id}', [ProfileController::class, 'updatePlan'])->name('profile.updatePlan');
    Route::delete('/profile/deleteplan/{id}', [ProfileController::class, 'deletePlan'])->name('profile.deletePlan');
    Route::post('/profile/addactivity', [ProfileController::class, 'addActivity'])->name('profile.addActivity');
    Route::get('/profile/updateactivity/{id}', [ProfileController::class, 'updateActivity'])->name('profile.updateActivity');
    Route::delete('/profile/deleteactivity/{id}', [ProfileController::class, 'deleteActivity'])->name('profile.deleteActivity');
    Route::get('/profile/getactivities/{id}', [ProfileController::class, 'getActivitiesByPlanId'])->name('profile.getActivity');
    Route::post('/profile/share-plan/{id}', [ProfileController::class, 'sharePlan'])->name('profile.sharePlan');
    Route::post('/profile/accept-notification/{id}', [ProfileController::class, 'acceptNotifications'])->name('profile.acceptNotification');
    Route::post('/profile/delete-notification/{id}', [ProfileController::class, 'deleteNotifications'])->name('profile.deleteNotification');

    Route::get('/profile/getUser_town', [ProfileController::class, 'getUser_Town'])->name('profile.user_town');
    Route::get('/profile/getUser_cultural_space', [ProfileController::class, 'getUser_cultural_space'])->name('profile.user_cultural_space');

    Route::get('/categories/activities', [CulturalSpacesController::class, 'culturalActivities'])->name('culturalactivities');
    Route::get('/categories/activities-2', [CulturalSpacesController::class, 'culturalActivities2'])->name('culturalactivities2');
    Route::get('/getspaceculture/{id}', [CulturalSpacesController::class, 'getSpaceCulture'])->name('culturalspaces.getSpaceCulture');
    Route::get('/getspaceculture-2/{id}', [CulturalSpacesController::class, 'getSpaceCulture2'])->name('culturalspaces.getSpaceCulture2');
    Route::get('/getCommentsById/{id}', [CommentController::class, 'getCommentsById'])->name('culturalspaces.getCommentsById');
    Route::post('/addcomment', [CommentController::class, 'addComment'])->name('culturalspaces.addComment');

    Route::get('/messages/{id}', [TicketsController::class, 'getMessages'])->name('tickets.getMessages');
    Route::post('/addmessage', [TicketsController::class, 'addMessage'])->name('tickets.addMessage');
    Route::get('/getsessionuser', [TicketsController::class, 'getSessionUser'])->name('tickets.getSessionUser');
    Route::get('/setstateone/{id}', [TicketsController::class, 'setStateOne'])->name('tickets.setStateOne');
    Route::get('/usersandmessages', [TicketsController::class, 'getUsersAndMessages'])->name('tickets.getUsersAndMessages');
    Route::get('/usersandmessagesfromadmin', [TicketsController::class, 'getUsersAndMessagesFromAdmin'])->name('tickets.getUsersAndMessagesFromAdmin');
    Route::post('/addfavouritepoblacio/{name}', [CulturalSpacesController::class, 'addFavoritePoblacio'])->name('culturalspaces.addFavorite');
    Route::get('/getIdTownByName/{name}', [CulturalSpacesController::class, 'getIdTownByName'])->name('culturalspaces.getIdTownByName');
    Route::post('/addfavourites/{id}', [CulturalSpacesController::class, 'addFavouriteSpace'])->name('culturalspaces.addFavouriteSpace');
    Route::post('/addfavouritepoblacio/{id_town}/{id_user}', [CulturalSpacesController::class, 'addFavouriteUserTown'])->name('culturalspaces.addFavouritePoblacio');
    Route::post('/addfavouriteculturalspace/{name}', [CulturalSpacesController::class, 'addFavouriteCulturalSpace'])->name('culturalspaces.addFavouriteCulturalSpace');
    Route::get('/getIdCultureSpaceByName/{name}', [CulturalSpacesController::class, 'getIdCultureSpaceByName'])->name('culturalspaces.getIdCultureSpaceByName');
    Route::post('/addfavouriteculturalspace/{id_cultural_space}/{id_user}', [CulturalSpacesController::class, 'addFavouriteCulturalSpaceUser'])->name('culturalspaces.addFavouriteCulturalSpace');
});

Route::middleware('auth', CheckManagerRole::class)->group(function () {
    Route::post('/profile/addapikey', [ProfileController::class, 'addApiKey'])->name('profile.addapikey');
    Route::get('/check-token/{token}', [ProfileController::class, 'checkToken']);
    Route::get('/check-token-2/{token}', [ProfileController::class, 'checkToken2']);
    Route::get('/show-plans', 'PlanController@showPlans' )->middleware('showJson:plans');
    Route::get('/show-comments', 'CommentController@showComments')->middleware('showJson:comments');
});


Route::middleware(['auth', CheckAdminRole::class])->group(function () {
    Route::get('/adminpanel', [AdminPanelController::class, 'view'])->name('adminpanel.view');
    Route::post('/adminpanel/adduser', [AdminPanelController::class, 'addUser'])->name('adminpanel.addUser');
    Route::get('/adminpanel/updateuser/{id}', [AdminPanelController::class, 'updateUser'])->name('adminpanel.updateUser');
    Route::delete('/adminpanel/deleteuser/{id}', [AdminPanelController::class, 'deleteUser'])->name('adminpanel.deleteUser');
    Route::get('/usersadmin', [AdminPanelController::class, 'getUsersAdmin'])->name('adminpanel.getAllUsersAdmin');
    Route::get('/users', [AdminPanelController::class, 'getUsersNoAdmin'])->name('adminpanel.getAllUsers');
    Route::post('/adminpanel/addactivity', [AdminPanelController::class, 'addActivity'])->name('adminpanel.addActivity');
    Route::get('/adminpanel/updateactivity/{id}', [AdminPanelController::class, 'updateActivity'])->name('adminpanel.updateActivity');
    Route::delete('/adminpanel/deleteactivity/{id}', [AdminPanelController::class, 'deleteActivity'])->name('adminpanel.deleteActivity');
    Route::post('/adminpanel/addplan', [AdminPanelController::class, 'addPlan'])->name('adminpanel.addPlan');
    Route::get('/adminpanel/updateplan/{id}', [AdminPanelController::class, 'updatePlan'])->name('adminpanel.updatePlan');
    Route::delete('/adminpanel/deleteplan/{id}', [AdminPanelController::class, 'deletePlan'])->name('adminpanel.deletePlan');
    Route::post('/adminpanel/addcategory', [AdminPanelController::class, 'addCategory'])->name('adminpanel.addCategory');
    Route::get('/adminpanel/updatecategory/{id}', [AdminPanelController::class, 'updateCategory'])->name('adminpanel.updateCategory');
    Route::delete('/adminpanel/deletecategory/{id}', [AdminPanelController::class, 'deleteCategory'])->name('adminpanel.deleteCategory');
    Route::post('/adminpanel/addcontract', [AdminPanelController::class, 'addContract'])->name('adminpanel.addContract');
    Route::post('/adminpanel/updatecontract/{id}', [AdminPanelController::class, 'updateContract'])->name('adminpanel.updateContract');
    Route::delete('/adminpanel/deletecontract/{id}', [AdminPanelController::class, 'deleteContract'])->name('adminpanel.deleteContract');
    Route::get('/stats', [ProcedureController::class, 'view'])->name('stats.view');
});

require __DIR__ . '/auth.php';