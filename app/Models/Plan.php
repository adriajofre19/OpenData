<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Activitat;
use App\Models\Notification;
use App\Models\UserPlan;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'start_date',
        'end_date',
        'id_category',
        'id_user',
    ];

    /**
     * Get the activities associated with the plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities() {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the users associated with the plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the categories associated with the plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the plans associated with the plan.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function plans() {
        return $this->belongsToMany(Plan::class);
    }
    
    /**
     * Retrieve all plans with user and category names.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getPlans() {
        return Plan::join('users', 'plans.id_user', '=', 'users.id')
            ->join('categories', 'plans.id_category', '=', 'categories.id')
            ->select('plans.*', 'users.name as user_name', 'categories.name as category_name')
            ->get();
    }

    /**
     * Retrieve plans by user ID with user and category names.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getPlansById($id) {
        return Plan::join('users', 'plans.id_user', '=', 'users.id')
            ->join('categories', 'plans.id_category', '=', 'categories.id')
            ->where('plans.id_user', $id)
            ->select('plans.*', 'users.name as user_name', 'categories.name as category_name')
            ->get();
    }

    /**
     * Add a new plan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Plan
     */
    public static function addPlan($request) {
        $userId = auth()->id();
        $fileName = $request->file('image')->getClientOriginalName();
        $filePath = public_path('images') . '/' . $fileName;
    
        if (file_exists($filePath)) {
            $imagePath = 'images/' . $fileName;
        } else {
            $request->file('image')->move(public_path('images'), $fileName);
            $imagePath = 'images/' . $fileName;
        }
    
        return Plan::create([
            'title' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'id_category' => $request->id_category,
            'id_user' => $userId,
            'image' => $imagePath, 
        ]);
    }
    
    /**
     * Update a plan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public static function updatePlan($request) {
        $dataToUpdate = [];
    
        if ($request->filled('name')) {
            $dataToUpdate['title'] = $request->name;
        }
    
        if ($request->filled('description')) {
            $dataToUpdate['description'] = $request->description;
        }

        if ($request->filled('start_date')) {
            $dataToUpdate['start_date'] = $request->start_date;
        }

        if ($request->filled('end_date')) {
            $dataToUpdate['end_date'] = $request->end_date;
        }

        if ($request->filled('id_category')) {
            $dataToUpdate['id_category'] = $request->id_category;
        }

        return Plan::where('id', $request->id)->update($dataToUpdate);
    }
    
    /**
     * Delete a plan and associated activities.
     *
     * @param  int  $id
     * @return bool|null
     */
    public static function deletePlan($id) {
        Notification::where('id_plan', $id)->delete();
        UserPlan::where('id_plan', $id)->delete();
        Activitat::where('id_plan', $id)->delete();
        Plan::where('id_category', $id)->update(['id_category' => null]);
        Plan::where('id_user', $id)->update(['id_user' => null]);
        return Plan::where('id', $id)->delete();
    }
}