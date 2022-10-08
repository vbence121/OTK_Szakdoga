<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DogClass;

class PossibleAward extends Model
{
    use HasFactory;

    public function dogClass()
    {
        return $this->belongsToMany(DogClass::class, 'dog_class_possible_award');
    }
}
