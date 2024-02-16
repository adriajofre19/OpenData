<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

use App\Models\Plan;
use App\Models\Activitat;
use App\Models\UserContract;
use App\Models\Message;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role',
        'id_contract'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Define the many-to-many relationship with Plan model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plans() {
        return $this->belongsToMany(Plan::class);
    }

    /**
     * Define the many-to-many relationship with Contract model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contracts() {
        return $this->belongsToMany(Contract::class);
    }
    
    /**
     * Define the one-to-one relationship with Role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role() {
        return $this->hasOne(Role::class);
    }

    /**
     * Define the one-to-many relationship with Ticket model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
    
    /**
     * Get all users with their associated contracts and roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllUsers() {
        return User::join('contracts', 'users.id_contract', '=', 'contracts.id')
            ->join('roles', 'users.id_role', '=', 'roles.id')
            ->select('users.*', 'contracts.name as contract_name', 'roles.name as role_name')
            ->get(); 
    }

    /**
     * Get all users with the role of admin.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllUsersAdmin() {
        return User::select('users.*')->where('users.id_role',3)->get();
    }

    public static function getAllUsersNonAuthenticated() {
        $userId = auth()->id();
        return User::where('id', '!=', $userId)->get();
    }

    public static function getAllUsersNoAdmin(){
        return User::select('users.*')->where('users.id_role', '<>',3)->get();
    }

    /**
     * Get all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles() {
        return Role::all();
    }

    /**
     * Add API key to the authenticated user.
     *
     * @param  string  $key
     * @return int
     */
    public static function addApiKey($key) {
        $userId = auth()->id();
        return User::where('id', $userId)->update(['api_token' => $key]);
    }

    /**
     * Delete a user by ID along with associated activities and plans.
     *
     * @param  int  $id
     * @return bool|null
     */
    public static function deleteUser($id) {
        Activitat::where('id_user', $id)->delete();
        Plan::where('id_user', $id)->delete();
        UserContract::where('id_user', $id)->delete();
        Message::where('user_from', $id)->orWhere('user_to', $id)->delete();
        return User::where('id', $id)->delete();
    }

    /**
     * Add a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\User
     */
    public static function addUser($request) {  
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'id_role' => $request->id_role,
            'id_contract' => $request->id_contract     
        ]);
    }

    /**
     * Update an existing user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public static function updateUser($request) {
        $dataToUpdate = [];

        if ($request->filled('name')) {
            $dataToUpdate['name'] = $request->name;
        }

        if ($request->filled('email')) {
            $dataToUpdate['email'] = $request->email;
        }

        if ($request->filled('password')) {
            $dataToUpdate['password'] = \Hash::make($request->password);
        }

        if ($request->filled('id_role')) {
            $dataToUpdate['id_role'] = $request->id_role;
        }

        if ($request->filled('id_contract')) {
            $dataToUpdate['id_contract'] = $request->id_contract;
        }

        return User::where('id', $request->id)->update($dataToUpdate);
    }

    /**
     * Get users along with their message status.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUsersAndMessages() {
        return User::select('users.id', 'users.name', 'users.id_role', DB::raw('(CASE WHEN COUNT(messages.id) > 0 THEN true ELSE false END) as has_messages'))
            ->leftJoin('messages', function ($join) {
                $join->on('users.id', '=', 'messages.user_from')
                    ->where('messages.state', '=', 0);
            })
            ->groupBy('users.id', 'users.name', 'users.id_role' )
            ->where('users.id_role', '<>', 3)
            ->get();
    }

    /**
     * Get users from admin along with their message status.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUsersAndMessagesFromAdmin() {
        return User::select('users.id', 'users.name', 'users.id_role', DB::raw('(CASE WHEN COUNT(messages.id) > 0 THEN true ELSE false END) as has_messages'))
            ->leftJoin('messages', function ($join) {
                $join->on('users.id', '=', 'messages.user_to')
                    ->where('messages.state', '=', 0);
            })
            ->groupBy('users.id', 'users.name', 'users.id_role' )
            ->where('users.id_role', '=', 3)
            ->get();
    }

    /**
     * Get all users with their contracts and roles.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUsers() {
        return User::join('contracts', 'users.id_contract', '=', 'contracts.id')
            ->join('roles', 'users.id_role', '=', 'roles.id')
            ->select('users.*', 'contracts.name as contract_name', 'roles.name as role_name')
            ->get(); 
    }
}