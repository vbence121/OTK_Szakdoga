<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\BreedGroup;
use App\Models\Dog;
use App\Models\DogClass;

class Breed extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'breed_group_id',
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function breedGroup()
    {
        return $this->belongsTo(BreedGroup::class, 'breed_group_id', 'id');
    }

    public function breed()
    {
        return $this->hasMany(Dog::class, 'breed_id', 'id');
    }

    public function classes()
    {
        return $this->hasMany(DogClass::class, 'breed_id', 'id');
    }
}
