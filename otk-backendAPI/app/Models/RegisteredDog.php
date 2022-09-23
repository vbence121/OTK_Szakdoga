<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ring;

class RegisteredDog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dog_id',
        'event_category_id',
        'user_id',
        'dog_class_id',
        'status',   // pending/approved/declined/paid
        'declined_reason',
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

    public function rings()
    {
        return $this->belongsToMany(Ring::class);
    }
}
