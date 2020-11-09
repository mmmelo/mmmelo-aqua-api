<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    protected $fillable = [
        'ph', 'gh', 'temp',
    ];

    protected $storeFields = [
        'life_id', 'ph', 'gh', 'temp',
    ];

    static function rules() {
        return [
            'life_id' => 'required',
            'ph' => 'required',
            'gh' => 'required',
            'temp' => 'required',
        ];
    }

    public function getStoreFields() {
        return $this->storeFields;
    }

    public function life(){
        return $this->belongsTo( Life::class, 'life_id', 'id');
    }
}
