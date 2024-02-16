<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model

{
    use HasFactory;

    /**
     * Define the fields that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Add a favorite town if it doesn't exist.
     *
     * @param string $name The name of the town to add as a favorite.
     * @return void
     */
    public function addFavoritePoblacio($name){
        $town2 = $this->where('name', $name)->first();

        if($town2 === null){
            $this->name = $name;
            $this->save();
        }

    }

    /**
     * Get a town by its name.
     *
     * @param string $name The name of the town.
     * @return Town|null The town object if found, or null if not found.
     */
    public function getIdTownByName($name){
        return $this->where('name', $name)->first();
    }
}