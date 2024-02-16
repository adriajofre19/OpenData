<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTown extends Model
{
    use HasFactory;

    /**
     * Define the fields that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'id_town',
    ];

    /**
     * Define the table associated with the UserTown model.
     *
     * @var string
     */
    protected $table = 'user_town';

    /**
     * Add a favorite town with a fixed user ID.
     *
     * @param int $id The ID of the town to add as a favorite.
     * @return void
     */
    public function addFavorite($id) {
        $this->id_user = 1;
        $this->id_town = $id;
        $this->save();
    }

    /**
     * Add a favorite town for a specific user if it doesn't exist.
     *
     * @param int $id_town The ID of the town to add as a favorite.
     * @param int $id_user The ID of the user.
     * @return void
     */
    public function addFavouriteUserTown($id_town, $id_user) {
        $userTown = UserTown::where('id_town', $id_town)->where('id_user', $id_user)->first();

        if($userTown === null){
            $this->id_user = $id_user;
            $this->id_town = $id_town;
            $this->save();
        }
        
    }

    /**
     * Get towns associated with a specific user.
     *
     * @param int $userId The ID of the user.
     * @return \Illuminate\Database\Eloquent\Collection A collection of towns associated with the user.
     */
    public static function getUserTowns($userId) {
        return UserTown::join('users', 'user_town.id_user', '=', 'users.id')
            ->join('towns', 'user_town.id_town', '=', 'towns.id')
            ->where('users.id', $userId)
            ->select('user_town.*', 'users.name as user_name', 'towns.name as town_name')
            ->get();
    }

    /**
     * Delete a favorite city for a specific user.
     *
     * @param int $id The ID of the city to delete.
     * @param int $userId The ID of the user.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public static function deleteFavouriteCity($id, $userId){
        return UserTown::where('id_town', $id)->where('id_user', $userId)->delete();
    }
}