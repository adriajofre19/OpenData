<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Get all messages associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages() {
        return $this->hasMany(Message::class);
    }

    /**
     * Get messages sent or received by a specific user.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMessages($id) {
        return $this->where('user_from', $id)->orWhere('user_to', $id)->get();
    }

    /**
     * Add a new message.
     *
     * @param  int  $user_from
     * @param  int  $user_to
     * @param  string  $message
     * @return void
     */
    public function addMessage($user_from, $user_to, $message) {
        $this->user_from = $user_from;
        $this->user_to = $user_to;
        $this->message = $message;
        $this->save();
    }

    /**
     * Get the ID of the currently authenticated user.
     *
     * @return int|null
     */
    public function getSessionUser() {
        return auth()->user()->id;
    }

    /**
     * Set the state of messages from a specific user to 1.
     *
     * @param  int  $id
     * @return void
     */
    public function setStateOne($id) {
        $this->where('user_from', $id)->update(['state' => 1]);
    }

    /**
     * Get messages from a specific user with state 0 (unread).
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserAndHisMessagesStateZero($id) {
        return $this->where('user_from', $id)->where('state', 0)->get();
    }

    /**
     * Get messages from a admin to user and user to admin.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function geMessagesFromUserToAdminAndAdminToUser($id) {
        return $this->where('user_from', $id)->orWhere('user_to', $id)->get();
    }
}