<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the plans associated with the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plans() {
        return $this->belongsToMany(Plan::class);
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getCategories() {
        return self::all();
    }

    /**
     * Delete a category by ID.
     *
     * @param  int  $id
     * @return bool|null
     */
    public static function deleteCategory($id) {
        return Category::where('id', $id)->delete();
    }

    /**
     * Add a new category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Category
     */
    public static function addCategory($request) {
        return Category::create([
            'name' => $request->name,
        ]);
    }

    /**
     * Update an existing category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public static function updateCategory($request) {
        $dataToUpdate = [];

        if ($request->filled('name')) {
            $dataToUpdate['name'] = $request->name;
        }

        return Category::where('id', $request->id)->update($dataToUpdate);
    }
}