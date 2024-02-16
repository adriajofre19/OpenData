<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'contract_description',
        'description',
        'price',
    ];

    /**
     * The users that belong to the contract.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class);
    }

     /**
     * Get all contracts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getContracts() {
        return self::all();    
    }

    /**
     * Add a new contract.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Contract
     */
    public static function addContract($request) {
        $duration = stripslashes($request->duration);
        $features = stripslashes($request->features);
        $featuresArray = array_map('trim', explode(',', $features));
    
        return Contract::create([
            'name' => $request->name,
            'type' => $request->type,
            'contract_description' => $request->contract_description,
            'description' => json_encode(['duration' => $duration, 'features' => $featuresArray]),
            'price' => $request->price,
        ]);
    }
    
    /**
     * Update an existing contract.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public static function updateContract($request) {
        $dataToUpdate = [];

        if ($request->filled('name')) {
            $dataToUpdate['name'] = $request->name;
        }

        if ($request->filled('type')) {
            $dataToUpdate['type'] = $request->type;
        }

        if ($request->filled('contract_description')) {
            $dataToUpdate['contract_description'] = $request->contract_description;
        }

        if ($request->filled('details')) {
            $details = $request->details;
            $duration = $details['duration'];
            $features = $details['features'];
            $description = json_encode(['duration' => $duration, 'features' => $features]);
            $dataToUpdate['description'] = $description;
        }

        if ($request->filled('price')) {
            $dataToUpdate['price'] = $request->price;
        }

        Contract::where('id', $request->id)->update($dataToUpdate);
        return $request->id;
    }

    /**
     * Delete a contract.
     *
     * @param  int  $id
     * @return bool|null
     */
    public static function deleteContract($id) {
        return Contract::where('id', $id)->delete();
    }
}