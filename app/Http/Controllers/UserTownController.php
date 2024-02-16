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
use App\Models\User;
use App\Models\Activitat;
use App\Models\Plan;
use App\Models\Category;
use App\Models\Role;
use App\Models\Contract;
use App\Models\Message;
use App\Models\UserTown;

class UserTownController extends Controller
{
    /**
     * View the user profile.
     *
     * @return  Response  The response containing the user profile view.
     */
    public function view() :Response{
        $userId = auth()->id();
        $user_town = $this->getUser_Town();
        $town = $this->get_Town();

        return Inertia::render('Profile', [
            'user_town' => $user_town,
            'userId'=> $userId,
            'town'=> $town
        ]);
    }

    /**
     * Get the towns associated with the authenticated user.
     *
     * @return  Collection  A collection of towns associated with the authenticated user.
     */
    public function getUser_Town() {
        $userId = auth()->id();
        $userTown = UserTown::getUserTowns_id($userId);
        return $userTown;
    }

    /**
     * Get all towns.
     *
     * @return  Collection  A collection of all towns.
     */
    public function get_Town() {
        $town = UserTown::getAllTowns();
        return $town;
    }
}