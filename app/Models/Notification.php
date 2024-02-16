<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\UserPlan;

class Notification extends Model
{
    use HasFactory;

    /**
     * Define the fields that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'id_plan',
        'user_from',
        'user_to',
        'state',
    ];

    /**
     * Define a relationship with the Plan model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan() {
        return $this->belongsTo(Plan::class, 'id_plan');
    }

    /**
     * Get notifications for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNotifications() {
        $userId = auth()->id();
        return Notification::where('user_to', $userId)
            ->with('plan')
            ->get();
    }

    /**
     * Create notifications for selected users.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function createNotification($request) {
        $userId = auth()->id();
        $selectedUsers = $request->selectedUsers;
        $idPlan = $request->id;
    
        $notifications = [];
    
        foreach ($selectedUsers as $user_to) {
            $notification = new Notification();
            $notification->message = 'Has estat invitat a un plan';
            $notification->id_plan = $idPlan;
            $notification->user_from = $userId;
            $notification->user_to = $user_to;
            $notification->state = 1;
            $notification->save();
    
            $notifications[] = $notification;
        }
    
        return $notifications;
    }

    /**
     * Accept a notification.
     *
     * @param int $id The ID of the notification to accept.
     * @return void
     */
    public static function acceptNotifications($id) {
        $userId = auth()->id();
    
        // Insertar en la tabla user_plan
        UserPlan::create([
            'id_user' => $userId,
            'id_plan' => $id
        ]);
    
        // Eliminar la notificación correspondiente
        Notification::where('id_plan', $id)
                    ->where('user_to', $userId)
                    ->delete();
    }

    /**
     * Delete notifications.
     *
     * @param int $id The ID of the notification to delete.
     * @return void
     */
    public static function deleteNotifications($id) {
        $userId = auth()->id();
        
        // Eliminar la notificación basada en el id del plan y el user_to
        Notification::where('id_plan', $id)
                    ->where('user_to', $userId)
                    ->delete();
    }
}