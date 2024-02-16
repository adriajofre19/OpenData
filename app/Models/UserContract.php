<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContract extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table="users_contracts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'id_contract',
        'start_date',
        'end_date',
    ];

    /**
     * Create a contract for a user.
     *
     * @param  int  $userId
     * @param  int  $contractId
     * @return \App\Models\UserContract
     */
    public static function createContractForUser($userId, $contractId) {
        $startDate = now();
        $endDate = $startDate->copy()->addDays(30);

        return self::create([
            'id_user' => $userId,
            'id_contract' => $contractId,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }   
}