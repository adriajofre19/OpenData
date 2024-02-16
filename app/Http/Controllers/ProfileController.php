<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Plan;
use App\Models\Activitat;
use App\Models\Category;
use App\Models\User;
use App\Models\Contract;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\UserPlan;
use App\Models\UserTown;
use App\Models\UserCulturalSpace;

class ProfileController extends Controller
{
    /**
     * Render the view for the user profile.
     *
     * @return \Inertia\Response
     */
    public function view(): Response {
        $userId = auth()->id();
        $plans = $this->getPlansById();
        $activities = $this->getActivitiesById();
        $categories = $this->getCategory();
        $contracts = $this->getContracts();
        $nonUser = $this->getAllUsersNonAuthenticated();
        $notifications = $this->getNotifications();
        $sharedPlans = $this->getSharedPlans();
        $user_town = $this->getUser_Town();
        $user_cultural_space = $this->getUser_cultural_space();

        return Inertia::render('Profile' , [
            'userId' => $userId,
            'plans' => $plans,
            'activities' => $activities,
            'categories' => $categories,
            'contracts' => $contracts,
            'users' => $nonUser,
            'notifications' => $notifications,
            'sharedPlans' => $sharedPlans,
            'user_town' => $user_town,
            'user_cultural_space' => $user_cultural_space
        ]);
    }

    /**
     * Retrieve plans for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPlansById() {
        $userId = auth()->id();
        $plans = Plan::getPlansById($userId);
        return $plans;
    }

    /**
     * Retrieve activities for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivitiesById() {
        $userId = auth()->id();
        $activities = Activitat::getActivitiesById($userId);
        return $activities;
    }

    /**
     * Retrieve all categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategory() {
        $categories = Category::getCategories();
        return $categories;
    }

    /**
     * Retrieve all contracts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContracts() {
        $contracts = Contract::getContracts();
        return $contracts;
    }
    
    /**
     * Retrieve activities by plan ID.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivitiesByPlanId($id, Request $request) {
        $activities = Activitat::getActivitiesByPlanId($id);
        return $activities;
    }

    /**
     * Add a new plan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function addPlan(Request $request) {
        $addPlan = Plan::addPlan($request);
    }

    /**
     * Update an existing plan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function updatePlan(Request $request) {
        $updateUser = Plan::updatePlan($request);
    }

    /**
     * Delete a plan.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function deletePlan($id, Request $request) {
        $deleteUser = Plan::deletePlan($id);
    }

    /**
     * Add a new activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function addActivity(Request $request) {
        $addActivity = Activitat::addActivity($request);
    }

    /**
     * Update an existing activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function updateActivity(Request $request) {
        $updateActivity = Activitat::updateActivity($request);
    }

    /**
     * Delete an activity.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function deleteActivity($id, Request $request) {
        $deleteActivity = Activitat::deleteActivity($id);
    }

    /**
     * Generate and add a new API key for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addApiKey(Request $request) {
        $apiKey = bin2hex(random_bytes(16));
        $apiKey = User::addApiKey($apiKey);
        return response()->json(['api_key' => $apiKey], 201);
    }

    /**
     * Check the validity of the provided token and return relevant data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkToken(Request $request) {
        $token = $request->token;
        $user = User::where('api_token', $token)->first();

        if ($user) {
            $userId = auth()->id();
            $plans = Plan::getPlansById($userId);
            $url = url('/show-plans?token=' . $token);

            return response()->json([
                'plans' => $plans,
                'url' => $url
            ]);
        }
        return response()->json(['error' => 'Token inválido'], 401);
    }   

    /**
     * Check the validity of the provided token and return relevant data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkToken2(Request $request) {
        $token = $request->token;
        $user = User::where('api_token', $token)->first();

        if ($user) {
            $userId = auth()->id();
            $comments = Comment::getCommentsByIdUser($userId);
            $url = url('/show-comments?token=' . $token);

            return response()->json([
                'comments' => $comments,
                'url' => $url
            ]);
        }
        return response()->json(['error' => 'Token inválido'], 401);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.view');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Get all non-authenticated users.
     *
     * @return  Collection  A collection of non-authenticated users.
     */
    public function getAllUsersNonAuthenticated() {
        $nonUser = User::getAllUsersNonAuthenticated();
        return $nonUser;
    }

    /**
     * Share a plan by creating a notification.
     *
     * @param   Request  $request  The request containing the plan information.
     *
     * @return  void
     */
    public function sharePlan(Request $request) {
        $notification = Notification::createNotification($request);
    }

    /**
     * Get all notifications.
     *
     * @return  Collection  A collection of notifications.
     */
    public function getNotifications() {
        $notifications = Notification::getNotifications();
        return $notifications;
    }

    /**
     * Accept a notification.
     *
     * @param   int      $id       The ID of the notification to accept.
     * @param   Request  $request  The request containing additional information.
     *
     * @return  void
     */
    public function acceptNotifications($id, Request $request) {
        $notifications = Notification::acceptNotifications($id);
    }

    /**
     * Get all shared plans.
     *
     * @return  Collection  A collection of shared plans.
     */
    public function getSharedPlans() {
        $sharedPlans = UserPlan::getSharedPlans();
        return $sharedPlans;
    }

    /**
     * Delete a notification.
     *
     * @param   int      $id       The ID of the notification to delete.
     * @param   Request  $request  The request containing additional information.
     *
     * @return  void
     */
    public function deleteNotifications($id, Request $request) {
        $deleteNotifications = Notification::deleteNotifications($id);
    }

    /**
     * Get the towns associated with the authenticated user.
     *
     * @return  Collection  A collection of towns associated with the authenticated user.
     */
    public function getUser_Town() {
        $userId = auth()->id();
        $userTown = UserTown::getUserTowns($userId);
        return $userTown;
    }

    /**
     * Get the cultural spaces associated with the authenticated user.
     *
     * @return  Collection  A collection of cultural spaces associated with the authenticated user.
     */
    public function getUser_cultural_space() {
        $userId = auth()->id();
        $user_cultural_space = UserCulturalSpace::getUserCulturalSpaces($userId);
        return $user_cultural_space;
    }
}