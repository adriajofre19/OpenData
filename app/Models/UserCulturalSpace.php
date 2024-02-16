<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCulturalSpace extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_cultural_spaces';

    /**
     * Get the cultural spaces associated with a specific user.
     *
     * @param int $userId The ID of the user.
     * @return \Illuminate\Database\Eloquent\Collection A collection of cultural spaces associated with the user.
     */
    public static function getUserCulturalSpaces($userId) {
        return UserCulturalSpace::join('users', 'user_cultural_spaces.id_user', '=', 'users.id')
            ->join('cultural_spaces', 'user_cultural_spaces.id_cultural_space', '=', 'cultural_spaces.id')
            ->where('users.id', $userId)
            ->select('user_cultural_spaces.*', 'users.name as user_name', 'cultural_spaces.name as space_name')
            ->get();
    }

    /**
     * Add a favorite cultural space for a user if it doesn't exist.
     *
     * @param int $id_cultural_space The ID of the cultural space to add as a favorite.
     * @param int $id_user The ID of the user.
     * @return void
     */
    public function addFavouriteCulturalSpaceUser($id_cultural_space, $id_user){
        $userCulturalSpace = UserCulturalSpace::where('id_cultural_space', $id_cultural_space)->where('id_user', $id_user)->first();

        if($userCulturalSpace === null){
            $this->id_cultural_space = $id_cultural_space;
            $this->id_user = $id_user;
            $this->save();
        }
    }
}