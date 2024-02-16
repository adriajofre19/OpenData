<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Activitat;
use App\Models\Plan;
use App\Models\Category;
use App\Models\Role;
use App\Models\Contract;
use App\Models\Message;

class adminpanelController extends Controller
{
    /**
     * Render the admin panel view.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(): Response {
        $user = $this->getUsers();
        $activity = $this->getActivities();
        $roles = $this->getRoles();
        $contracts = $this->getContracts();
        $plans = $this->getPlans();
        $categories =$this->getCategory();
        $result1 = $this->calculateCategoryPercentage();
        $result2 = $this->calculatePlanPercentage();

        return Inertia::render('AdminPanel', [
            'user' => $user,
            'activity' => $activity,
            'roles' => $roles,
            'contracts' => $contracts,
            'plans' => $plans,
            'categories' => $categories,
            'result1' => $result1,
            'result2' => $result2
        ]);
    }

    /**
     * Retrieve users from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers() {
        $users = User::getUsers();
        return $users;   
    } 

    /**
     * Retrieve activities from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivities() {
        $activities = Activitat::getActivities();
        return $activities;
    }

    /**
     * Retrieve roles from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles() {
        $roles = Role::getRoles();
        return $roles;
    }

    /**
     * Retrieve contracts from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContracts() {
        $contracts = Contract::getContracts();
        return $contracts;
    }

    /**
     * Retrieve plans from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPlans() {
        $plans = Plan::getPlans();
        return $plans;
    }

    /**
     * Retrieve categories from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategory() {
        $categories = Category::getCategories();
        return $categories;
    }

    /**
     * Add a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function addUser(Request $request) {
        $addUser = User::addUser($request);
    }

    /**
     * Update an existing user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function updateUser(Request $request) {
        $updateUser = User::updateUser($request);
    }

    /**
     * Delete a user.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function deleteUser($id, Request $request) {
        $deleteUser = User::deleteUser($id);
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
     * Adda new category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function addCategory(Request $request) {
        $addPlan = Category::addCategory($request);
    }

    /**
     * Update an existing category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function updateCategory(Request $request) {
        $updateUser = Category::updateCategory($request);
    }

    /**
     * Delete a category.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function deleteCategory($id, Request $request) {
        $deleteUser = Category::deleteCategory($id);
    }

    /**
     * Add a new contract.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function addContract(Request $request) {
        $addContract = Contract::addContract($request);
    }

    /**
     * Update an existing contract.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function updateContract(Request $request) {
        $updateUser = Contract::updateContract($request);
    }

    /**
     * Delete a contract.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function deleteContract($id, Request $request) {
        $deleteUser = Contract::deleteContract($id);
    }

    /**
     * Retrieve all admin users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersAdmin() {
        $users = User::getAllUsersAdmin();
        return $users;
    }

    /**
     * Retrieve all no admin users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersNoAdmin() {
        $users = User::getAllUsersNoAdmin();
        return $users;
    }

    /**
     * Calculate the percentage for each category.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateCategoryPercentage() {
        DB::select('CALL CalculateCategoryPercentage()');
        $result = DB::table('category_results')->get();
        return response()->json($result);
    }

    /**
     * Calculate the percentage for each plan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculatePlanPercentage() {
        DB::select('CALL CalculatePlanPercentage()');
        $result = DB::table('plan_results')->get();
        return response()->json($result);
    }
}