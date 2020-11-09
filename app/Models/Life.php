<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Life extends Model
{
    protected $fillable = [
        'scientific_name',
    ];

    static function rules() {
        return [
            'scientific_name' => 'required|string'
        ];
    }

    public function parameters() {
        return $this->hasOne( Parameters::class, 'life_id', 'id');
    }

}
