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
use App\Models\Message;

class TicketsController extends Controller
{
    /**
     * Render the edit page for tickets.
     *
     * @return \Inertia\Response
     */
    public function edit(): Response {
        return Inertia::render('Tickets');
    }

    /**
     * Add a new category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function addCategory(Request $request) {        
        $model = new Category();
        $model->addCategory($request);        
    }

    /**
     * Retrieve messages from a user to admin and from admin to user.
     *
     * @param  int  $id
     * @return mixed
     */
    public function getMessagesFromUserToAdminAndAdminToUser($id) {
        $model = new Message();
        $messages = $model->getMessagesFromUserToAdminAndAdminToUser($id);
        return $messages;
    }

    /**
     * Retrieve messages by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages($id) {
        $model = new Message();
        $messages = $model->getMessages($id);
        return response()->json($messages);
    }

    /**
     * Add a new message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addMessage(Request $request) {
        $model = new Message();
        $model->addMessage($request->user_from, $request->user_to, $request->message);
        return Redirect::back();
    }

    /**
     * Set the state of a message to one.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setStateOne($id) {
        $model = new Message();
        $model->setStateOne($id);
        return Redirect::back();
    }

    /**
     * Retrieve the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getSessionUser() {
        return Auth::user();
    }

    /**
     * Retrieve a user and his messages with state zero.
     *
     * @param  int  $id
     * @return mixed
     */
    public function getUserAndHisMessagesStateZero($id) {
        $model = new Message();
        $messages = $model->getUserAndHisMessagesStateZero($id);
        return $messages;
    }

    /**
     * Retrieve users and their messages.
     *
     * @return mixed
     */
    public function getUsersAndMessages() {
        $model = new User();
        $users = $model->getUsersAndMessages();
        return $users;
    }

    /**
     * Retrieve users and their messages from admin.
     *
     * @return mixed
     */
    public function getUsersAndMessagesFromAdmin() {
        $model = new User();
        $users = $model->getUsersAndMessagesFromAdmin();
        return $users;
    }
}