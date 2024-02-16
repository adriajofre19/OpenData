<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CulturalSpace extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cultural_spaces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
    ];

    /**
     * Add a favorite cultural space if it doesn't exist.
     *
     * @param   string  $name  The name of the cultural space to add as a favorite.
     * 
     * @return  void
     */
    public function addFavouriteCulturalSpace($name){
        $culturalSpace2 = CulturalSpace::where('name', $name)->first();
        
        if($culturalSpace2 === null){
            $culturalSpace = new CulturalSpace();
            $culturalSpace->name = $name;
            $culturalSpace->save();
        }
    }

    /**
     * Get the ID of a cultural space by its name.
     *
     * @param   string  $name  The name of the cultural space.
     * 
     * @return  int|null        The ID of the cultural space, or null if not found.
     */
    public function getIdCultureSpaceByName($name){
        $culturalSpace = CulturalSpace::where('name', $name)->first();
        return $culturalSpace->id;
    }
}