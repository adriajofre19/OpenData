<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Activitat;
use App\Models\Category;

class UserPlan extends Model
{
    use HasFactory;

    /**
     * Define the table associated with the UserPlan model.
     *
     * @var string
     */
    protected $table = 'user_plan';

    /**
     * Define the fields that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'id_plan'
    ];

    /**
     * Get shared plans for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of shared plans.
     */
    public static function getSharedPlans() {
        $userId = auth()->id();
    
        $sharedPlans = UserPlan::where('user_plan.id_user', $userId)
            ->join('plans', 'user_plan.id_plan', '=', 'plans.id')
            ->join('categories', 'plans.id_category', '=', 'categories.id')
            ->select('plans.*', 'categories.name as category_name')
            ->get();
    
        foreach ($sharedPlans as $plan) {
            $activities = Activitat::where('id_plan', $plan->id)->get();
    
            foreach ($activities as $activity) {
                $activity->increment('person_count');
            }
        }
    
        return $sharedPlans;
    } 
}