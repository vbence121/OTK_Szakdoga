<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Breed;
use App\Models\EventCategory;
use App\Models\PossibleAwards;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class DogClass extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'birthdate' => 'datetime',
    ];

    public function breeds()
    {
        return $this->hasMany(Breed::class, 'breed_id', 'id');
    }

    public function events()
    {
        return $this->belongsToMany(EventCategory::class, 'registered_dogs');
    }

    public function possibleAwards()
    {
        return $this->belongsToMany(PossibleAwards::class, 'dog_class_possible_awards');
    }
}
