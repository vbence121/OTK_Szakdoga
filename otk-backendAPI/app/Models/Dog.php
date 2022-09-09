<?php

namespace App\Models;

use App\Models\User;
use App\Models\File;
use App\Models\Breed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'breed',
        'hobby',
        'birthdate',
        'user_id',
        'breederName',
        'description',
        'motherName',
        'fatherName',
        'breed_id',
        'registerSernum',
        'herd_book_type_id',
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
        'birthdate' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(File::class,'dog_id','id');
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id', 'id');
    }
}
