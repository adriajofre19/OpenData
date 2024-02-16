<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activitat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activitats';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'person_count',
        'id_plan',
        'id_user',
    ];

    /**
     * Get the plan that owns the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan() {
        return $this->belongsTo(Plan::class);
    }

     /**
     * Get the contract that owns the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract() {
        return $this->belongsTo(Contract::class);
    }

     /**
     * Get the ticket that owns the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the activity that owns the activity (self-referential relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get the user that owns the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get all activities with user and plan details.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActivities() {
        return Activitat::join('users', 'activitats.id_user', '=', 'users.id')
            ->join('plans', 'activitats.id_plan', '=', 'plans.id')
            ->select('activitats.*', 'users.name as user_name', 'plans.title as plan_name')
            ->get();
    }

     /**
     * Get activities by plan ID and authenticated user ID.
     *
     * @param  int  $planId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActivitiesByPlanId($planId) {
        $userId = auth()->id();
        return Activitat::where('id_plan', $planId)
            ->where('id_user', $userId)
            ->get();
    }

    /**
     * Get activities by user ID.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActivitiesById($id) {
        return Activitat::where('id_user', $id)->get();
    }

    /**
     * Add a new activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Activitat
     */
    public static function addActivity($request) {
        $userId = auth()->id();
        return Activitat::create([
            'name' => $request->name,
            'description' => $request->description,
            'person_count' => 1,
            'id_plan' => $request->id_plan,
            'id_user' => $userId  
        ]);
    }

     /**
     * Update an existing activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public static function updateActivity($request) {
        $dataToUpdate = [];
    
        if ($request->filled('name')) {
            $dataToUpdate['name'] = $request->name;
        }
    
        if ($request->filled('description')) {
            $dataToUpdate['description'] = $request->description;
        }
    
        if ($request->filled('id_plan')) {
            $dataToUpdate['id_plan'] = $request->id_plan;
        }
    
        return Activitat::where('id', $request->id)->update($dataToUpdate);
    }

    /**
     * Delete an activity by ID.
     *
     * @param  int  $id
     * @return bool|null
     */
    public static function deleteActivity($id) {
        return Activitat::where('id', $id)->delete();
    }
}